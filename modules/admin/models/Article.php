<?php

namespace app\modules\admin\models;
use crazyfd\qiniu\Qiniu;
use yii\data\Pagination;
class Article extends Base{

    const SHOW=1;
    const HIDDEN=0;
    public $cover=null;
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


    public static function getArticles($pagesize=6){
        $where['status']=1;
        $tag=\Yii::$app->request->get('tag_id','');
        if($tag){
            $where['tag_id']=$tag;
        }
        $query=self::find()->where($where);
        $count=$query->count();
        $pager=new Pagination(['totalCount'=>$count,'pageSize'=>$pagesize]);
        $articles=$query->limit($pager->limit)->offset($pager->offset)->all();
        foreach ($articles as $k=>$article){
            preg_match_all('/src="(.+?)"/',$article->content,$arr);
            $cover = empty($arr[1])?'暂无封面图':$arr[1][0];
            $article->cover=$cover;
            $articles[$k]=$article;
        }
        return [$pager,$articles];
    }


    //获取最新的文章
    public static function getRecentArticles($size=5){
        $articles = self::find()->where(['status'=>1])->orderBy(['create_time'=>SORT_DESC])->limit($size)->all();
        $res=[];
        foreach ($articles as $article){
            preg_match_all('/src="(.+?)"/',$article->content,$arr);
            $cover = empty($arr[1])?'暂无封面图':$arr[1][0];
            $article->cover=$cover;
            $res[]=$article;
        }
        return $res;
    }
}