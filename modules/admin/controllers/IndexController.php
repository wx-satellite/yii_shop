<?php


namespace app\modules\admin\controllers;
use yii\web\Controller;
use app\modules\admin\Admin;
class IndexController extends Controller{

    public $layout='main';


    public function actionIndex(){
        return $this->render('index');
    }
}