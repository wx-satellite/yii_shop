<?php

namespace app\modules\admin\controllers;
use yii\web\Controller;
use app\modules\admin\models\Admin;
use Yii;
class LoginController extends Controller{

    public $layout=false;

    public function actionLogin(){
        if(isset(Yii::$app->session['admin'])){
            $this->goBack(\yii\helpers\Url::to(['index/index']));
            Yii::$app->end();
        }
        $model = new Admin();
        if(Yii::$app->request->isPost) {
            //登录逻辑处理
            if($model->loginByEmail(Yii::$app->request->post())){
                $this->redirect(['index/index']);
                Yii::$app->end();
            }
        }
        return $this->render('login',compact('model'));

    }


    public function actionLogout(){
        //清除session
        Yii::$app->session->removeAll();
        if(!isset(Yii::$app->session['admin'])){
            $this->redirect(['login/login']);
            Yii::$app->end();
        }
        //若清除session失败跳回原来的地址
        $this->redirect(Yii::$app->request->referrer);
    }
}