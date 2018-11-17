<?php


namespace app\controllers;
use app\models\UserProfile;
use app\models\User;
use app\models\Cart;
use app\models\Order;
use app\services\Pay;
use dzer\express\Express;
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
        $user = UserProfile::find()->select('last_name,first_name,address,phone')->where(['uid'=>\Yii::$app->user->id])->one();
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

    //我的订单（除去删除的）
    public function actionMyOrder(){
//        if(!User::checkUserLoginIn()){
//            $this->redirect(['login/login']);
//            \Yii::$app->getSession()->setFlash('Error','请先登录');
//            \Yii::$app->end();
//        }
        $orders = Order::find()
            ->where('status!=:status',[':status'=>Order::DELETE])
            ->andWhere(['uid'=>\Yii::$app->user->id])
            ->orderBy(['create_time'=>SORT_DESC])
            ->all();
        return $this->render('my',compact('orders'));
    }

    //取消订单（只能取消下单未支付的订单）
    public function actionCancel(){
        $order = Order::find()->where(['status'=>Order::NOT_PAY])
            ->andWhere(['uid'=>\Yii::$app->user->id,'id'=>\Yii::$app->request->get('id')])
            ->one();
        if(!$order){
            \Yii::$app->getSession()->setFlash('Error','取消订单，请稍后重试');
            $this->redirect(['order/my-order']);
            \Yii::$app->end();
        }
        try{
            $order->status=Order::CANCEL;
            $order->save(false);
            \Yii::$app->getSession()->setFlash('Success','订单号为：'.$order->orderno.'&nbsp;&nbsp;取消成功');

        }catch(\Exception $e){
            \Yii::$app->getSession()->setFlash('Error','取消订单，请稍后重试');
        }
        $this->redirect(['order/my-order']);
        \Yii::$app->end();
    }

    //确认收货（当订单状态为Order::POST时才能确认收货）
    public function actionReceive(){
        $order = Order::find()->where(['status'=>Order::POST,'id'=>\Yii::$app->request->get('id')])
            ->andWhere(['uid'=>\Yii::$app->user->id])->one();
        if(!$order){
            \Yii::$app->getSession()->setFlash('Error','确认收货失败，请重试');
            $this->redirect(['order/my-order']);
            \Yii::$app->end();
        }
        try{
            $order->status=Order::RECEIVER;
            $order->save(false);
            \Yii::$app->getSession()->setFlash('Success','订单号为：'.$order->orderno.'&nbsp;&nbsp;确认收货成功');
        }catch(\Exception $e){
            \Yii::$app->getSession()->setFlash('Error','确认收货失败，请重试');
        }
        $this->redirect(['order/my-order']);
        \Yii::$app->end();
    }
    //查看物流信息（当订单状态为Order::POST时才能查看物流信息）
    public function actionExpress(){
        $order = Order::find()->where(['status'=>Order::POST,'id'=>\Yii::$app->request->get('id')])
            ->andWhere(['uid'=>\Yii::$app->user->id])->one();
        if(!$order){
            \Yii::$app->getSession()->setFlash('Error','查询物流信息失败');
            $this->redirect(['order/my-order']);
            \Yii::$app->end();
        }
        //注意传入true表示返回数组否则返回对象
        $com='';
        $res= json_decode(Express::search($order->post_number),true);
        if(isset($res['data'])){
            $com=isset($res['com'])?$res['com']:'';
            $com=$this->getExpressName($com);
            $res=$res['data'];
        }else{
            \Yii::$app->getSession()->setFlash('Error','快递单号不正确，请联系客服');
            $this->redirect(['order/my-order']);
            \Yii::$app->end();
        }
        return $this->render('express',compact('res','order','com'));
    }

    //返回快递名称
    protected function getExpressName($com){
        $data=array(
            'shunfeng' => '顺丰',
            'yuantong' => '圆通速递',
            'shentong' => '申通',
            'yunda' => '韵达快运',
            'ems' => 'ems快递',
            'tiantian' => '天天快递',
            'zhaijisong' => '宅急送',
            'quanfengkuaidi' => '全峰快递',
            'zhongtong' => '中通速递',
            'rufengda' => '如风达',
            'debangwuliu' => '德邦物流',
            'huitongkuaidi' => '汇通快运',
            'aae' => 'aae全球专递',
            'anjie' => '安捷快递',
            'anxindakuaixi' => '安信达快递',
            'biaojikuaidi' => '彪记快递',
            'bht' => 'bht',
            'baifudongfang' => '百福东方国际物流',
            'coe' => '中国东方（COE）',
            'changyuwuliu' => '长宇物流',
            'datianwuliu' => '大田物流',
            'dhl' => 'dhl',
            'dpex' => 'dpex',
            'dsukuaidi' => 'd速快递',
            'disifang' => '递四方',
            'fedex' => 'fedex（国外）',
            'feikangda' => '飞康达物流',
            'fenghuangkuaidi' => '凤凰快递',
            'feikuaida' => '飞快达',
            'guotongkuaidi' => '国通快递',
            'ganzhongnengda' => '港中能达物流',
            'guangdongyouzhengwuliu' => '广东邮政物流',
            'gongsuda' => '共速达',
            'hengluwuliu' => '恒路物流',
            'huaxialongwuliu' => '华夏龙物流',
            'haihongwangsong' => '海红',
            'haiwaihuanqiu' => '海外环球',
            'jiayiwuliu' => '佳怡物流',
            'jinguangsudikuaijian' => '京广速递',
            'jixianda' => '急先达',
            'jjwl' => '佳吉物流',
            'jymwl' => '加运美物流',
            'jindawuliu' => '金大物流',
            'jialidatong' => '嘉里大通',
            'jykd' => '晋越快递',
            'kuaijiesudi' => '快捷速递',
            'lianb' => '联邦快递（国内）',
            'lianhaowuliu' => '联昊通物流',
            'longbanwuliu' => '龙邦物流',
            'lijisong' => '立即送',
            'lejiedi' => '乐捷递',
            'minghangkuaidi' => '民航快递',
            'meiguokuaidi' => '美国快递',
            'menduimen' => '门对门',
            'ocs' => 'OCS',
            'peisihuoyunkuaidi' => '配思货运',
            'quanchenkuaidi' => '全晨快递',
            'quanjitong' => '全际通物流',
            'quanritongkuaidi' => '全日通快递',
            'quanyikuaidi' => '全一快递',
            'santaisudi' => '三态速递',
            'shenghuiwuliu' => '盛辉物流',
            'sue' => '速尔物流',
            'shengfeng' => '盛丰物流',
            'saiaodi' => '赛澳递',
            'tiandihuayu' => '天地华宇',
            'tnt' => 'tnt',
            'ups' => 'ups',
            'wanjiawuliu' => '万家物流',
            'wenjiesudi' => '文捷航空速递',
            'wuyuan' => '伍圆',
            'wxwl' => '万象物流',
            'xinbangwuliu' => '新邦物流',
            'xinfengwuliu' => '信丰物流',
            'yafengsudi' => '亚风速递',
            'yibangwuliu' => '一邦速递',
            'youshuwuliu' => '优速物流',
            'youzhengguonei' => '邮政包裹挂号信',
            'youzhengguoji' => '邮政国际包裹挂号信',
            'yuanchengwuliu' => '远成物流',
            'yuanweifeng' => '源伟丰快递',
            'yuanzhijiecheng' => '元智捷诚快递',
            'yuntongkuaidi' => '运通快递',
            'yuefengwuliu' => '越丰物流',
            'yad' => '源安达',
            'yinjiesudi' => '银捷速递',
            'zhongtiekuaiyun' => '中铁快运',
            'zhongyouwuliu' => '中邮物流',
            'zhongxinda' => '忠信达',
            'zhimakaimen' => '芝麻开门'
        );
        return isset($data[$com])?$data[$com]:'';
    }

}