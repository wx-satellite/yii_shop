<?php


namespace app\controllers;

use yii\web\Controller;
use app\models\User;

class LoginController extends BaseController {

    public $layout='template';


    //账号登录
    public function actionLogin(){
        $model = new User();
        if(\Yii::$app->request->isPost){
            $post = \Yii::$app->request->post();
            if($model->loginUser($post)){
                $this->redirect(['user/info']);
                \Yii::$app->end();
            }
        }
        return $this->render('login',compact('model'));
    }

    //账号退出
    public function actionLogout(){
        \Yii::$app->session->remove('user');
        $this->goBack(\Yii::$app->request->referrer);
        \Yii::$app->end();
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

    //忘记密码
    public function actionSeekPassword(){
        $model = new User();
        if(\Yii::$app->request->isPost){
            $post=\Yii::$app->request->post();
            $model->sendResetPasswordEmail($post);
        }
        return $this->render('seek_password',compact('model'));
    }

    //修改密码
    public function actionChangePassword(){
        $token=\Yii::$app->request->get('token');
        if(!$token || empty(\Yii::$app->cache->get($token))){
            $this->redirect(['index/index']);
            \Yii::$app->end();
        }
        $model =new User();
        if(\Yii::$app->request->isPost){
            $post = \Yii::$app->request->post();
            if($model->changePassword($post,$token)){
                $this->redirect(['login/login']);
                \Yii::$app->end();
            }
        }
        return $this->render('change_password',compact('model'));
    }
}