<?php


namespace app\controllers;

use yii\web\Controller;
use app\models\User;

class LoginController extends Controller{

    public $layout='template';


    //账号登录
    public function actionLogin(){
        $model = new User();
        return $this->render('login',compact('model'));
    }


    //账号注册
    public function actionRegister(){
        $model = new User();
        if(\Yii::$app->request->isPost){
            $post = \Yii::$app->request->post();
            if($model->userRegister($post)){
                $this->redirect(['login/login']);
                \Yii::$app->end();
            }
        }
        return $this->render('register',compact('model'));
    }

    //账号激活
    public function actionActive(){
        $token = \Yii::$app->request->get('token');
        if(!$token){
            $this->redirect(['index/index']);
            \Yii::$app->end();
        }
        $email = \Yii::$app->cache->get($token);
        if(!$email){
            $this->redirect(['index/index']);
            \Yii::$app->end();
        }
        $model= new User();
        $model->activeUser($token,$email);
        $this->redirect(['login/login']);
        \Yii::$app->end();
    }
}