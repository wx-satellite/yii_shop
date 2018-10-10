<?php

namespace app\controllers;
use yii\web\Controller;


class UserController extends Controller{

    public $layout='template';

    public function actionInfo(){
        return $this->render('info');
    }
}