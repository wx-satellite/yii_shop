<?php


namespace app\controllers;
use app\models\UserProfile;
use app\models\User;
use app\models\Cart;
use app\models\Order;
use app\services\Pay;

class OrderController extends  BaseController{

    public $layout='template';

    public function actionPay(){
        $order_id = \Yii::$app->request->get('id');
        $order=Order::find()->where(['status'=>Order::NOT_PAY,'id'=>$order_id])->one();
        if(!$order){
            \Yii::$app->getSession()->setFlash('Error','去支付的订单不存在或者已经被支付了');
            $this->redirect(['order/my-order']);
            \Yii::$app->end();
        }
        if($response=Pay::alipay($order->orderno)){
            echo $response;
            \Yii::$app->end();
        }else{
            $this->redirect(['order/my-order']);
            \Yii::$app->end();
        }

    }
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
            if($orderno=$model->placeOrder($post)){
                //支付宝支付
                if($response=Pay::alipay($orderno)){
                    echo $response;
                    \Yii::$app->end();
                }else{
                    $this->redirect(['order/my-order']);
                    \Yii::$app->end();
                }
            }
        }
        return  $this->render('show',compact('user','cart','model'));
    }


    public function actionMyOrder(){
        if(!User::checkUserLoginIn()){
            $this->redirect(['login/login']);
            \Yii::$app->getSession()->setFlash('Error','请先登录');
            \Yii::$app->end();
        }
        $orders = Order::find()->where('status!=:status',[':status'=>-1])->orderBy(['create_time'=>SORT_DESC])->all();
        return $this->render('my',compact('orders'));
    }

}