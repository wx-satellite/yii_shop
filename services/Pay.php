<?php

namespace app\services;
use app\models\User;
use app\models\Order;
require '../vendor/alipay/pagepay/service/AlipayTradeService.php';
require '../vendor/alipay/pagepay/buildermodel/AlipayTradePagePayContentBuilder.php';
class Pay{

    public static function alipay($orderno){
        $order = Order::find()->where(['status'=>Order::NOT_PAY,'orderno'=>$orderno])->one();
        if(!$order){
            \Yii::$app->session->setFlash('Error','待支付的订单--'.$orderno.'，不存在');
            return false;
        }
        if($order->order_total_price<=0){
            \Yii::$app->session->setFlash('Error','订单号为：'.$orderno.'的订单金额错误');
            return false;
        }
        $orderno=$order->orderno;
        $subject = '三斤宠物口粮';
        $amount = $order->order_total_price;
        $body=$order->order_name;
        //因为我是通过require的方式加载文件的，并且又声明了namespace app\services命名空间
        //因此如果要使用加载文件中的类，则需要以\开头使用，表明在公共命名空间
        $payRequestBuilder = new \AlipayTradePagePayContentBuilder();
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setTotalAmount($amount);
        $payRequestBuilder->setOutTradeNo($orderno);
        $config=\Yii::$app->params['alipay'];
        $aop = new \AlipayTradeService($config);
        $response = $aop->pagePay($payRequestBuilder,$config['return_url'],$config['notify_url']);
        return $response;

    }

    public static function handleNotify($post){
        $config=\Yii::$app->params['alipay'];
        $alipaySevice = new \AlipayTradeService($config);
        //校验
        $result = $alipaySevice->check($post);
        if(!$result){
            return false;
        }
        //订单号
        $out_trade_no = $post['out_trade_no'];
        //交易状态
        $status = $post['trade_status'];
        //支付宝交易号
        $trade_no = $post['trade_no'];
        //支付金额
        $amount = $post['total_amount'];
        if('TRADE_SUCCESS'===$status||'TRADE_FINISHED'===$status){

            //查找未支付的订单
            $order = Order::find()->where(['status'=>Order::NOT_PAY,'orderno'=>$out_trade_no])->one();
            if(!$order){
                return false;
            }
            if($order->order_total_price != $amount){
                return false;
            }
            try{
                //更新订单为已支付
                Order::updateAll(['status'=>Order::NOT_POST,'trade_no'=>$trade_no],['orderno'=>$out_trade_no]);
                //发送电子邮件
                self::sendPaySuccessEmail($order);
                return true;
            }catch(\Exception $e){
                return false;
            }
        }
        return false;
    }


    public static function sendPaySuccessEmail($order,$composer='pay_success'){
        $user = User::find()->where(['id'=>$order->uid])->one();
        $mailer = \Yii::$app->mailer->compose($composer,['order'=>$order]);
        $mailer->setFrom('15658283276@163.com');
        $mailer->setTo($user->email);
        $mailer->setSubject('支付结果通知');
        if(!$mailer->send()){
            return false;
        }
        return true;
    }

    public static function handleReturn($get){
        $config=\Yii::$app->params['alipay'];
        $alipaySevice = new \AlipayTradeService($config);
        try{
            unset($get['r']);
            $result = $alipaySevice->check($get);
            if(!$result){
                \Yii::$app->getSession()->setFlash('Error','验证失败');
                return false;
            }
            \Yii::$app->getSession()->setFlash('Success','订单号为：'.$get['out_trade_no'].' 的订单支付成功');
            return true;
        }catch(\Exception $e){
            \Yii::$app->getSession()->setFlash('Error','验证失败');
            return false;
        }

    }


}