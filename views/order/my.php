<?php
use app\models\Order;
use yii\bootstrap\Alert;
?>
<div class="breadcrumb-area pt-95 pb-95 bg-img" style="background-image:url(assets/img/banner/banner-2.jpg);">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <h2>MY ORDERS</h2>
            <ul>
                <li><a href="<?php echo \yii\helpers\Url::to(['index/index']);?>">主页</a></li>
                <li class="active">我的订单</li>
            </ul>
        </div>
    </div>
</div>
<!-- shopping-cart-area start -->
<div class="cart-main-area pt-95 pb-100">
    <div class="container">
        <h3 class="page-title">订单列表</h3>
        <?php
        if(\Yii::$app->getSession()->hasFlash('Success')){
            echo Alert::widget([
                'options'=>['class'=>'alert-success'],
                'body'=>\Yii::$app->getSession()->getFlash('Success')
            ]);
        }

        if(\Yii::$app->getSession()->hasFlash('Error')){
            echo Alert::widget([
                'options'=>['class'=>'alert-danger'],
                'body'=>\Yii::$app->getSession()->getFlash('Error')
            ]);
        }
        ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <form action="#">
                    <div class="table-content table-responsive">
                        <table>
                            <thead>
                            <tr>
                                <th>订单编号</th>
                                <th>订单名称</th>
                                <th>收货信息</th>
                                <th>订单价格</th>
                                <th>订单创建时间</th>
                                <th>订单的状态</th>
                                <th>订单的操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($orders as $order):?>
                            <tr>
                                <td style="text-align: center;">
                                    <?php echo $order->orderno;?>
                                </td>
                                <td style="text-align: center;"><?php echo $order->order_name;?></td>
                                <td style="text-align: center;">
                                    <?php $info=unserialize($order->receiver_info);?>
                                    <?php echo '收货人：'.$info['name'].'<br/>'.'联系电话：'.$info['phone'].'<br/>'.'收货地址：'.$info['address'];?>
                                </td>
                                <td style="text-align: center;">

                                        <?php echo
                                            '总价：'.$order->order_total_price.'元<br/>'.'（含运费：'.sprintf('%.2f',$order->order_total_price-$order->goods_total_price).'元）';?>

                                </td>
                                <td style="text-align: center;"><?php echo $order->create_time;?></td>
                                <td style="text-align: center;">
                                    <span style="font-weight: bold;"><?php echo \Yii::$app->params['order_status'][$order->status];?></span>
                                </td>
                                <td class="product-wishlist-cart">
                                    <?php if(Order::NOT_PAY===(int)$order->status){
                                        $url = \yii\helpers\Url::to(['order/pay','id'=>$order->id]);
                                        $delete_url = \yii\helpers\Url::to(['order/cancel','id'=>$order->id]);
                                        echo '<a href="'.$url.'">去支付</a><a style="margin-left:5px;" href="'.$delete_url.'">取消订单</a>';
                                    }elseif(Order::NOT_POST===(int)$order->status){
                                        echo '<a href="javascript:alert(\'退款是不存在的。\')">退款</a>';
                                    }elseif(Order::POST===(int)$order->status){
                                        $exress_url = \yii\helpers\Url::to(['order/express','id'=>$order->id]);
                                        $receive_url= \yii\helpers\Url::to(['order/receive','id'=>$order->id]);
                                        echo '<a  href="'.$exress_url.'">查看物流</a><a style="margin-left:5px;" href="'.$receive_url.'">确认收货</a>';
                                    }elseif(Order::CANCEL===(int)$order->status){
                                        echo '<a href="#">删除订单</a>';
                                    }else{
                                        echo '已签收';
                                    }
                                        ?>
                                </td>
                            </tr>
                           <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

