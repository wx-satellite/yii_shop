<?php
namespace app\modules\admin\models;
use yii\db\ActiveRecord;
use crazyfd\qiniu\Qiniu;

class Goods extends ActiveRecord{

    const IS_ON_SALE=1;
    const IS_NOT_ON_SALE=0;

    public static function tableName(){
        return "{{%goods}}";
    }


    public function rules()
    {
        return [
            ['cateid','required','message'=>'请选择商品的分类'],
            ['cateid','integer','message'=>'商品分类参数错误'],
            ['name','required','message'=>'请填写商品的名称'],
            ['name','string','max'=>100],
            ['name','unique','message'=>'该商品名称已经存在'],
            ['stock','required','message'=>'请填写商品的库存'],
            ['stock','integer','message'=>'库存格式不正确'],
            ['price','required','message'=>'请填写商品的价格'],
            ['price','double','message'=>'价格格式不准确'],
            ['sale_price','double','message'=>'促销价格式不正确'],
            ['is_sale','checkValue'],
            ['picture','required','message'=>'缺少商品的LOGO']
        ];
    }

    public function scenarios()
    {
        return [
            'create'=>['cateid','name','stock','price','is_sale','sale_price','descr'],
            'update'=>['cateid','name','stock','price','is_sale','sale_price','descr','picture']
        ];
    }

    public function checkValue(){
        if(!in_array($this->is_sale,[0,1])){
            $this->addError('is_sale','参数不正确');
            return;
        }
        if(1===(int)$this->is_sale && !$this->sale_price){
            $this->addError('sale_price','请填写促销价');
            return;
        }

    }

    //设置与Category的关联关系
    public function getCategory(){
        return $this->hasOne(Category::className(),['id'=>'cateid']);
    }

    //删除商品
    public function deleteGoods(){
        try{
            //注意这里不需要删除七牛云上对应的资源，因为是逻辑删除即实际做了更新操作，到时候可能回补充一个回收站的功能
            self::updateAll(['status'=>-1],'id=:id',[':id'=>$this->id]);
            \Yii::$app->getSession()->setFlash('Success','删除商品成功');
            return true;
        }catch(\Exception $e){
            \Yii::$app->getSession()->setFlash('Error','删除商品失败，请稍后重试');
            return false;
        }
    }

    //添加商品
    public function addGoods($post){
        $this->scenario='create';
        if($this->load($post) && $this->validate()){
            try{
                //如果不促销并且没有填写促销价格的话，执行save会报错，原因我在create场景中指明了sale_price
                //字段，因此save操作会插入sale_price的值，由于前端没有填写sale_price这个值，因此save会用null进行插入
                //而数据表goods的设计是sale_price字段不为空，因此会报错
                if(0===(int)$this->is_sale && !$this->sale_price){
                    $this->sale_price=$this->price;
                }
                //只有所有的验证通过之后，在上传图片
                $this->picture=$this->uploadPicture()?:false;
                if(!$this->picture){
                    return false;
                }
                $this->photos=serialize($this->uploadPhotos());
                $this->save(false);
                \Yii::$app->getSession()->setFlash('Success','添加商品成功');
                return true;
            }catch(\Exception $e){
                \Yii::$app->getSession()->setFlash('Error','添加商品失败');
                return false;
            }
        }

    }

    //编辑商品
    public function updateGoods($post){
        $this->scenario='update';
        if($this->load($post) && $this->validate()){
            try{
                if(0===(int)$this->is_sale && !$this->sale_price){
                    $this->sale_price=$this->price;
                }
                $picture = $this->uploadPicture();
                //更新场景下，如果用户没有上传logo或者上传logo失败的话，不用报错，更新为原来的值即可
                if(!$picture){
                    $this->clearErrors('picture');
                    $this->picture=$post['Goods']['picture'];
                }else{
                    $this->picture=$picture;
                }
                //更新场景下如果上传了相册，就和原来的值合并，没有上传的话，就更新为原来的值即可
                $photos=$this->uploadPhotos();
                if(!$photos){
                    $photos=isset($post['Goods']['photos'])?serialize($post['Goods']['photos']):serialize([]);
                }else{
                    $photos=isset($post['Goods']['photos'])?serialize(array_merge($photos,$post['Goods']['photos'])):serialize($photos);
                }
                $this->photos=$photos;
                $this->save(false);
                \Yii::$app->getSession()->setFlash('Success','修改商品成功');
                return true;
            }catch(\Exception $e){
                \Yii::$app->getSession()->setFlash('Error','修改商品失败');
                return false;
            }
        }
    }
    public function deleteGoodsPhoto($key){
        $photos=unserialize($this->photos);
        if(!isset($photos[$key])){
            \Yii::$app->getSession()->setFlash('Error','当前商品的相册中不存在这张图片');
            return false;
        }
        $url = $photos[$key];
        unset($photos[$key]);
        try{
            self::updateAll(['photos'=>serialize($photos)],'id=:id',[':id'=>$this->id]);
            $this->deletePicture($key);
            \Yii::$app->getSession()->setFlash('Success','删除相册图片成功');
            return true;
        }catch(\Exception $e){
            \Yii::$app->getSession()->setFlash('Error','删除相册图片失败');
            if($e instanceof \yii\db\Exception ){
                //数据库更新失败,不做操作
            }else{
                //数据库更新成功，但是七牛云的资源删除失败，将数据重新更新回去
                $photos[$key]=$url;
                self::updateAll(['photos'=>serialize($photos)],'id=:id',[':id'=>$this->id]);
            }
            return false;
        }
    }

    //在七牛云上删除指定key的资源
    public function deletePicture($key){
        $qiniu=new Qiniu(\Yii::$app->params['qn_ak'],
            \Yii::$app->params['qn_sk'],
            \Yii::$app->params['qn_domain'],
            \Yii::$app->params['qn_bucket'],
            'east_china'
        );
        try{
            $qiniu->delete($key);
            return true;
        }catch(\Exception $e){
            throw $e;
        }
    }

    //七牛云上传图片(单图片)
    protected function uploadPicture(){
        $error=$_FILES['Goods']['error']['picture'];
        switch($error){
            case 0:
                $qiniu=new Qiniu(\Yii::$app->params['qn_ak'],
                    \Yii::$app->params['qn_sk'],
                    \Yii::$app->params['qn_domain'],
                    \Yii::$app->params['qn_bucket'],
                    'east_china'
                );
                $key=md5(uniqid(mt_rand(),true));
                try{
                    $qiniu->uploadFile($_FILES['Goods']['tmp_name']['picture'],$key);
                    $url='http://'.$qiniu->getLink().$key;
                    return $url;
                }catch(\Exception $e){
                    $this->addError('picture','上传图片至七牛云失败，请稍后重试');
                    return false;
                }
            case 1:
            case 2:
                $this->addError('picture','上传的图片太大了');
                return false;
            case 3:
                $this->addError('picture','上传出错，之后部分文件被上传，请稍后重试');
                return false;
            case 4:
                $this->addError('picture','请上传商品的LOGO');
                return false;
        }
    }

    //七牛云上传商品相册(多图片)
    protected function uploadPhotos(){
        $errors = $_FILES['Goods']['error']['photo'];
        $qiniu=new Qiniu(\Yii::$app->params['qn_ak'],
            \Yii::$app->params['qn_sk'],
            \Yii::$app->params['qn_domain'],
            \Yii::$app->params['qn_bucket'],
            'east_china'
        );
        $photo=[];
        foreach($errors as $k=>$error){
            //相册的上传，出错了不需要报错
            if(0!==$error){
                continue;
            }
            //处理图片
            $key = md5(uniqid(mt_rand(),true));
            try{
                $qiniu->uploadFile($_FILES['Goods']['tmp_name']['photo'][$k],$key);
                $url='http://'.$qiniu->getLink().$key;
                //$key的值是在七牛云上唯一标识某个资源的
                $photo[$key]=$url;
            }catch(\Exception $e){
                continue;
            }

        }
        return $photo;

    }
}