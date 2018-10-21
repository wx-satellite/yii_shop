<?php


namespace app\modules\admin\controllers;
use app\modules\admin\models\Tag;
use yii\data\Pagination;
class TagController extends CommonController{




    public function actionList(){
        $query = Tag::find()->where('status!=:status',[':status'=>-1])->orderBy(['create_time'=>SORT_DESC]);
        $count=$query->count();
        $pager = new Pagination(['totalCount'=>$count,'pageSize'=>\Yii::$app->getModule('admin')->params['pagesize']]);
        $tags = $query->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render('list',compact('tags','pager'));
    }


    public function actionAdd(){
        $model=new Tag();
        if(\Yii::$app->request->isPost){
            $post=\Yii::$app->request->post();
            if($model->addTag($post)){
                $this->redirect(['tag/list']);
                \Yii::$app->end();
            }
        }
        return $this->render('add',compact('model'));
    }


    public function actionEdit(){
        $model=$this->getModelById();
        if(\Yii::$app->request->isPost){
            $post=\Yii::$app->request->post();
            if($model->editTag($post)){
                $this->redirect(['tag/list']);
                \Yii::$app->end();
            }
        }
        return $this->render('edit',compact('model'));
    }
}