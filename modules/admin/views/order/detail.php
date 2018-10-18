<?php
use app\models\Order;
?>
        <!-- Page Content -->
        <div class="page-content">
            <!-- Page Breadcrumb -->
            <div class="page-breadcrumbs">
                <ul class="breadcrumb">
                    <li>
                        <a href="#">系统</a>
                    </li>
                    <li>
                        <a href="<?php echo \yii\helpers\Url::to(['order/list']);?>">订单管理</a>
                    </li>
                    <li class="active">订单详情</li>
                </ul>
            </div>
            <!-- /Page Breadcrumb -->

            <!-- Page Body -->
            <div class="page-body">

                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <div class="widget">
                            <div class="widget-header bordered-bottom bordered-blue">
                                <span class="widget-caption">订单详情</span>
                            </div>
                            <div class="widget-body">
                                <div style="padding: 20px 100px;font-size: 14px;">
                                    <p>订单号：&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $order->orderno;?>（ 订单简介：<?php echo $order->order_name;?> ）</p>
                                    <p>下单用户：&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $order->userInfo->username;?>（ 邮箱：<?php echo $order->userInfo->email;?> ）</p>
                                    <p>支付方式：&nbsp;&nbsp;&nbsp;&nbsp;<?php echo \Yii::$app->params['pay_type'][$order->pay_type];?></p>
                                    <p>配送方式：&nbsp;&nbsp;&nbsp;&nbsp;<?php echo \Yii::$app->params['post_type'][$order->post_type]['name'];?></p>
                                    <?php $info=unserialize($order->receiver_info);?>
                                    <p>收货人：&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $info['name'];?></p>
                                    <p>收货人电话：&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $info['phone'];?></p>
                                    <p>收货人地址：&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $info['address'];?></p>
                                    <p>订单总金额：&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $order->order_total_price;?>（商品总价：<?php echo $order->goods_total_price;?>，配送费：<?php echo sprintf('%.2f',$order->order_total_price-$order->goods_total_price);?>）</p>
                                    <p>订单的状态：&nbsp;&nbsp;&nbsp;&nbsp;<?php
                                        if($order->status==Order::NOT_PAY){
                                            echo '<span style="color:red;">'.\Yii::$app->params['order_status'][$order->status].'</span>';
                                        }elseif($order->status==Order::NOT_POST){
                                            echo '<span style="color:red;">'.\Yii::$app->params['order_status'][$order->status].'</span>';
                                        }elseif($order->status==Order::POST){
                                            echo '<span style="color:red;">'.\Yii::$app->params['order_status'][$order->status].'（订单号：'.$order->post_number.'）</span>';
                                        }elseif($order->status==Order::RECEIVER){
                                            echo '<span style="color:red;">'.\Yii::$app->params['order_status'][$order->status].'（订单号：'.$order->post_number.'）</span>';
                                        }elseif($order->status==Order::CANCEL){
                                            echo '<span style="color:red;">'.\Yii::$app->params['order_status'][$order->status].'</span>';
                                        }elseif($order->status==Order::DELETE){
                                            echo '<span style="color:red;">'.\Yii::$app->params['order_status'][$order->status].'</span>';
                                        }
                                        ?></p>
                                    <p>支付宝交易号：<?php echo $order->trade_no?:'暂无';?></p>
                                    <p>订单的商品信息：&nbsp;&nbsp;&nbsp;&nbsp;
                                        <div>
                                        <?php
                                            foreach($order_detail as $d){
                                                echo '<p style="text-indent: 7em;">'.'商品名称：'.$d['goods_name'].'&nbsp;&nbsp;&nbsp;&nbsp;商品单价：'.$d['goods_price'].'&nbsp;&nbsp;&nbsp;&nbsp;购买数量：'.$d['goods_count'].'</p>';
                                            }
                                        ?>
                                    </div>
                                    </p>
                                    <p>订单的创建时间：&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $order->create_time;?></p>
                                    <p><a href="javascript:window.history.go(-1);">返回</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /Page Body -->
        </div>
