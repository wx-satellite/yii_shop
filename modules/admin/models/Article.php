<?php

namespace app\modules\admin\models;
use yii\db\ActiveRecord;
use crazyfd\qiniu\Qiniu;

class Article extends ActiveRecord{

    const SHOW=1;
    const HIDDEN=0;
    public static  function tableName()
    {
        return "{{%article}}";
    }


    public function rules(){
        return [
            ['tag_id','required','message'=>'请选择所属标签'],
            ['tag_id','integer','message'=>'标签参数错误'],
            ['title','required','message'=>'请填写文章标题'],
            ['title','string','max'=>50],
            ['author','required','message'=>'请填写作者'],
            ['author','string','max'=>30],
            ['content','required','message'=>'请填写文章内容'],
        ];
    }

    public function scenarios()
    {
        return [
            'create'=>['tag_id','title','content','author'],
            'update'=>['tag_id','title','content','author'],
        ];
    }

    public function getTag(){
        return $this->hasOne(Tag::className(),['id'=>'tag_id']);
    }


    public function addArticle($post){
        $this->scenario='create';
        if($this->load($post)&&$this->validate()){
            try{
                $this->save(false);
                \Yii::$app->getSession()->setFlash('Success','添加文章成功');
                return true;
            }catch (\Exception $e){
                \Yii::$app->getSession()->setFlash('Error','添加文章失败，请重试');
                return false;
            }
        }

    }
    public function editArticle($post){
        $this->scenario='update';
        if($this->load($post)&&$this->validate()){
            try{
                $this->save(false);
                \Yii::$app->getSession()->setFlash('Success','修改文章成功');
                return true;
            }catch (\Exception $e){
                \Yii::$app->getSession()->setFlash('Error','修改文章失败，请重试');
                return false;
            }
        }

    }

    public static  function uploadImage(){
        switch($_FILES['image']['error']){
            case 0:
                $qiniu=new Qiniu(
                    \Yii::$app->params['qn_ak'],
                    \Yii::$app->params['qn_sk'],
                    \Yii::$app->params['qn_domain'],
                    \Yii::$app->params['qn_bucket'],
                    'east_china'
                );
                $key=md5(uniqid(mt_rand(),true));
                try{
                    $qiniu->uploadFile($_FILES['image']['tmp_name'],$key);
                    $url='http://'.$qiniu->getLink().$key;
                    return ['errno'=>0,'data'=>[$url]];
                }catch(\Exception $e) {
                    return ['errno'=>1,'message'=>'上传失败'];
                }
            case 1:
            case 2:
            case 3:
            case 4:
                return ['errno'=>1,'message'=>'上传失败'];
        }
    }
}