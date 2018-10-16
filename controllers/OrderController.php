<?php


namespace app\controllers;
use app\models\UserProfile;
use app\models\User;
use app\models\Cart;
use app\models\Order;


class OrderController extends  BaseController{

    public $layout='template';

    public function actionOrderShow(){
        if(!User::checkUserLoginIn()){
            $script="<script>alert('请先登录。');window.location.href='/index.php?r=login/login';</script>";
            echo $script;
            \Yii::$app->end();
        }
        $user = UserProfile::find()->select('last_name,first_name,address,phone')->where(['uid'=>\Yii::$app->session['user']['uid']])->one();
        $cart = (new Cart())->getCartInfo();
        if(!$cart){
            $script="<script>alert('想再来一单吗？那就去首页看看吧。');window.location.href='/index.php?r=index/index';</script>";
            echo $script;
            \Yii::$app->end();
        }
        $model = new Order();
        if(\Yii::$app->request->isPost){
            $post = \Yii::$app->request->post();
            if($order_id=$model->placeOrder($post)){
                //支付宝支付

            }
        }
        return  $this->render('show',compact('user','cart','model'));
    }

}