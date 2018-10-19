<?php

namespace app\controllers;
use app\services\Pay;

class PayController extends BaseController{
    public $layout='template';

    public $enableCsrfValidation=false;

    //异步回调（支付宝通过post的方式回调，因此需要关闭yii2默认post方式提交的csrf验证）
    public function actionNotify(){

        if(\Yii::$app->request->isPost){
            $post=\Yii::$app->request->post();
            if(Pay::handleNotify($post)){
                echo 'success';exit;
            }else{
                echo 'fail';exit;
            }
        }
    }

    //同步回调(GET方式)
    public function actionReturn(){
        if(\Yii::$app->request->isGet){
            $get = \Yii::$app->request->get();
            Pay::handleReturn($get);
            $this->redirect(['order/my-order']);
            \Yii::$app->end();
        }

    }
}