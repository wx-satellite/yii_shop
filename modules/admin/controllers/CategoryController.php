<?php

namespace app\modules\admin\controllers;
use yii\web\Controller;
use app\modules\admin\models\Category;

class CategoryController extends Controller{

    public $layout='main';

    public function actionList(){
        $model = new Category();
        $cates = $model->getTree();
        return $this->render('list',compact('cates'));
    }

    public function actionAdd(){
        $type=['1'=>'狗粮','2'=>'猫粮'];
        $model = new Category();
        $cates = $model->changeCatesArray($model->getTree());
        if(\Yii::$app->request->isPost){
            $post=\Yii::$app->request->post();
            if($model->addCategory($post)){
                $this->redirect(['category/add']);
                \Yii::$app->end();
            }
        }
        return $this->render('add',compact('model','cates','type'));
    }
}