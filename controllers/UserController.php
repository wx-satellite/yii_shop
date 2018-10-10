<?php

namespace app\controllers;
use yii\web\Controller;
use app\models\User;
use app\models\UserProfile;

class UserController extends Controller{

    public $layout='template';

    //判断是否登录
    protected function checkIsLogin(){
        if(!isset(\Yii::$app->session['user'])){
            $this->redirect(['login/login']);
            \Yii::$app->end();
        }
    }


    //个人主页
    public function actionInfo(){
        $this->checkIsLogin();
        //根据session中的uid查询到当前用户
        $user=User::find()->where('id=:id',[':id'=>\Yii::$app->session['user']['uid']])->one();
        //如果用户对应的信息存在就返回profile，如果不存在则实例化一个profile
        $profile=$user->profile?:new UserProfile();
        if(\Yii::$app->request->isPost){
            $post = \Yii::$app->request->post();
            if($profile->updateUserProfile($post)){
                $this->redirect(['user/info']);
                \Yii::$app->end();
            }
        }
        $user->password='';
        return $this->render('info',compact('user','profile'));
    }


    //修改密码
    public function actionChangePassword(){
        $this->checkIsLogin();
        $user=User::find()->where('id=:id',[':id'=>\Yii::$app->session['user']['uid']])->one();
        $profile=$user->profile?:new UserProfile();
        if(\Yii::$app->request->isPost){
            $post = \Yii::$app->request->post();
            if($user->changePassword($post,null)){
                $this->redirect(['user/info']);
                \Yii::$app->end();
            }
        }
        return $this->render('info',compact('user','profile'));
    }


    //修改邮箱
    public function actionChangeEmail(){
        $this->checkIsLogin();
        $user=User::find()->where('id=:id',[':id'=>\Yii::$app->session['user']['uid']])->one();
        $profile=$user->profile?:new UserProfile();
        if(\Yii::$app->request->isPost){
            $post = \Yii::$app->request->post();
            if($user->changeEmail($post)){
                $this->redirect(['user/info']);
                \Yii::$app->end();
            }
        }
        return $this->render('info',compact('user','profile'));
    }


}