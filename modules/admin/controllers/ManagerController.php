<?php

namespace app\modules\admin\controllers;
use yii\web\Controller;
use app\modules\admin\models\Admin;
use yii\data\Pagination;
class ManagerController extends Controller{

    public $layout='main';


    public function actionList(){
        $query = Admin::find()->orderBy(['create_time'=>SORT_ASC])->where(['status'=>1]);
        $count = $query->count();
        $pager = new Pagination(['totalCount'=>$count,'pageSize'=>\Yii::$app->getModule('admin')->params['pagesize']]);
        $managers = $query->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render('list',compact('managers','pager'));
    }



    public function actionAdd(){
        $model = new Admin();
        if(\Yii::$app->request->isPost){
            $post = \Yii::$app->request->post();
            if($model->addManager($post)){
                //重定向的目的是为了清空表单的数据
                $this->redirect(['manager/add']);
                \Yii::$app->end();
            }
        }
        return $this->render('add',compact('model'));
    }


    public function actionDelete(){
        $id = (int)\Yii::$app->request->get('id');
        if(!$id){
            \Yii::$app->getSession()->setFlash('error','参数错误');
            $this->redirect(['manager/list']);
            \Yii::$app->end();
        }
        $model = new Admin();
        $model->deleteAdminById($id);
        $this->redirect(['manager/list']);
        \Yii::$app->end();
    }
}