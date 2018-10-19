<?php

namespace app\modules\admin\controllers;
use yii\web\Controller;
use yii\data\Pagination;
use app\models\Order;
class OrderController extends Controller{
    public $layout='main';


    //订单列表
    public function actionList(){
        //取出所有的订单，包括删除的
        $query= Order::find()->orderBy(['create_time'=>SORT_DESC]);
        $count=$query->count();
        $pager = new Pagination(['pageSize'=>\Yii::$app->getModule('admin')->params['pagesize'],'totalCount'=>$count]);
        $orders = $query->offset($pager->offset)->limit($pager->limit)->all();
        return $this->render('list',compact('orders','pager'));
    }


    //订单详情
    public function actionDetail(){
        $order = Order::find()->where(['id'=>\Yii::$app->request->get('id')])->one();
        if(!$order){
            $this->redirect(['order/list']);
            \Yii::$app->end();
        }
        $order_detail=$order->getOrderDetail();
        return $this->render('detail',compact('order','order_detail'));
    }

    //发货
    public function actionPost(){
        $model = Order::find()->where(['id'=>\Yii::$app->request->get('id'),'status'=>Order::NOT_POST])->one();
        if(!$model){
            $this->redirect(['order/list']);
            \Yii::$app->end();
        }
        if(\Yii::$app->request->isPost){
            $post=\Yii::$app->request->post();
            if($model->postOrder($post)){
                $this->sendEmail($model);
                $this->redirect(['order/list']);
                \Yii::$app->end();
            }
        }

        return $this->render('send',compact('model'));
    }

    protected function sendEmail($order,$compose='send'){
        $malier = \Yii::$app->mailer->compose($compose,['order'=>$order]);
        $malier->setTo($order->userInfo->email);
        $malier->setFrom('15658283276@163.com');
        $malier->setSubject('发货通知');
        try{
            $malier->send();
            return true;
        }catch(\Exception $e){
            return false;
        }
    }
}