<?php

namespace app\modules\admin\controllers;
use app\modules\admin\models\Tag;
use app\modules\admin\models\Article;
use yii\data\Pagination;
class ArticleController extends CommonController{

    public $layout='main';

    public function actionList(){
        $query=Article::find()->where('status!=:status',[':status'=>-1])->orderBy(['create_time'=>SORT_DESC]);
        $count=$query->count();
        $pager=new Pagination(['totalCount'=>$count,'pageSize'=>\Yii::$app->getModule('admin')->params['pagesize']]);
        $articles=$query->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render('list',compact('articles','pager'));
    }

    public function actionAdd(){
        $tags =Tag::getTags();
        $model=new Article();
        if(\Yii::$app->request->isPost){
            $post=\Yii::$app->request->post();
            if($model->addArticle($post)){
                $this->redirect(['article/list']);
                \Yii::$app->end();
            }
        }
        return $this->render('add',compact('tags','model'));
    }

    public function actionEdit(){
        $tags =Tag::getTags();
        $model=$this->getModelById();
        if(\Yii::$app->request->isPost){
            $post=\Yii::$app->request->post();
            if($model->editArticle($post)){
                $this->redirect(['article/list']);
                \Yii::$app->end();
            }
        }
        return $this->render('edit',compact('tags','model'));
    }

    //上传图片接口
    public function actionUpload(){
        return $this->asJson(Article::uploadImage());
    }
}