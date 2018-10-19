<?php

namespace app\modules\admin\controllers;
use yii\web\Controller;
use app\modules\admin\models\Admin;
use Yii;
class PasswordController extends Controller{

    public $layout=false;



    public function actionSeekPassword(){
        $model= new Admin();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if($model->seekPassword($post)){
                //邮件发送成功之后暂时没有操作
            }
        }
        return $this->render('seek',compact('model'));
    }


    public function actionChangePassword(){
        $model = new Admin();
        $token = \Yii::$app->request->get('token');
        if(!$token){
            $this->redirect(['login/login']);
            \Yii::$app->end();
        }
        if(\Yii::$app->request->isPost){
            $post=\Yii::$app->request->post();
            if($model->changePassword($token,$post)){
                //重置密码成功
                $this->redirect(['login/login']);
                \Yii::$app->end();
            }
        }
        return $this->render('password',compact('model'));
    }
}