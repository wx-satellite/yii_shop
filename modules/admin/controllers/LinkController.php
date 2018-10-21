<?php


namespace app\modules\admin\controllers;
use app\modules\admin\models\Link;
use yii\data\Pagination;
class LinkController extends CommonController{

    public function actionList(){
        $query=Link::find()->where('status!=:status',[':status'=>-1])->orderBy(['create_time'=>SORT_DESC]);
        $count=$query->count();
        $pager=new Pagination(['totalCount'=>$count,'pageSize'=>\Yii::$app->getModule('admin')->params['pagesize']]);
        $links=$query->offset($pager->offset)->limit($pager->limit)->all();
        return $this->render('list',compact('pager','links'));
    }


    //添加链接
    public function actionAdd(){
        $model= new Link();
        if(\Yii::$app->request->isPost){
            $post=\Yii::$app->request->post();
            if($model->addLinks($post)){
                $this->redirect(['link/list']);
                \Yii::$app->end();
            }
        }
        return $this->render('add',compact('model'));
    }






    //编辑链接
    public function actionEdit(){
        $model=$this->getModelById();
        if(\Yii::$app->request->isPost){
            $post=\Yii::$app->request->post();
            if($model->editLink($post)){
                $this->redirect(['link/list']);
                \Yii::$app->end();
            }
        }
        return $this->render('edit',compact('model'));
    }


}