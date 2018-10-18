<?php
use app\models\Order;
use yii\widgets\LinkPager;
?>
        <!-- Page Content -->
        <div class="page-content">
            <!-- Page Breadcrumb -->
            <div class="page-breadcrumbs">
                <ul class="breadcrumb">
                    <li>
                        <a href="#">系统</a>
                    </li>
                    <li class="active">订单管理</li>
                </ul>
            </div>
            <!-- /Page Breadcrumb -->

            <!-- Page Body -->
            <div class="page-body">
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <div class="widget">
                            <div class="widget-body">
                                <div class="flip-scroll">
                                    <table class="table table-bordered table-hover">
                                        <thead class="">
                                        <tr>
                                            <th class="text-center">订单号</th>
                                            <th class="text-center">订单名称</th>
                                            <th class="text-center">下单人</th>
                                            <th class="text-center">配送信息</th>
                                            <th class="text-center">配送方式</th>
                                            <th class="text-center">订单总价</th>
                                            <th class="text-center">订单状态</th>
                                            <th class="text-center">创建时间</th>
                                            <th class="text-center">操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($orders as $order):?>
                                        <tr>
                                            <td align="center"><?php echo $order->orderno;?></td>
                                            <td align="center"><?php echo $order->order_name;?></td>
                                            <td align="center"><?php echo $order->userInfo->username;?></td>
                                            <td align="center">
                                            <?php
                                            $info=unserialize($order->receiver_info);
                                            echo '收货人：'.$info['name'].'<br>'.'联系电话：'.$info['phone'].'<br>'.'配送地址：'.$info['address'];
                                            ?>
                                            </td>
                                            <td align="center">
                                                <?php echo \Yii::$app->params['post_type'][$order->post_type]['name'];?>
                                            </td>
                                            <td align="center">
                                                <?php echo $order->order_total_price;?>
                                            </td>
                                            <td align="center">
                                                <?php
                                                    if($order->status==Order::NOT_PAY){
                                                        echo '<span style="color:red;">'.\Yii::$app->params['order_status'][$order->status].'</span>';
                                                    }elseif($order->status==Order::NOT_POST){
                                                        echo '<span style="color:red;">'.\Yii::$app->params['order_status'][$order->status].'</span>';
                                                    }elseif($order->status==Order::POST){
                                                        echo '<span style="color:#53a93f;">'.\Yii::$app->params['order_status'][$order->status].'</span>';
                                                    }elseif($order->status==Order::RECEIVER){
                                                        echo '<span style="color:red;">'.\Yii::$app->params['order_status'][$order->status].'</span>';
                                                    }elseif($order->status==Order::CANCEL){
                                                        echo '<span style="color:red;">'.\Yii::$app->params['order_status'][$order->status].'</span>';
                                                    }elseif($order->status==Order::DELETE){
                                                        echo '<span style="color:red;">'.\Yii::$app->params['order_status'][$order->status].'</span>';
                                                    }
                                                ?>
                                            </td>
                                            <td align="center">
                                                <?php echo $order->create_time;?>
                                            </td>
                                            <td align="center">
                                                <?php if(Order::NOT_POST==$order->status):?>
                                                <a href="<?php echo \yii\helpers\Url::to(['order/post','id'=>$order->id]);?>" class="btn  btn-success btn-sm shiny">
                                                    <i class="fa fa-truck"></i> 发货
                                                </a>
                                                <?php endif;?>
                                                <a href="<?php echo \yii\helpers\Url::to(['order/detail','id'=>$order->id]);?>"  class="btn btn-primary btn-sm shiny">
                                                    <i class="fa fa-eye"></i> 查看
                                                </a>
                                            </td>
                                        </tr>
                                       <?php endforeach;?>
                                        </tbody>
                                    </table>
                                </div>
                                <div style="margin-top: 10px;">
                                    <?php echo LinkPager::widget([
                                        'pagination'=>$pager,
                                        'prevPageLabel'=>'上一页',
                                        'nextPageLabel'=>'下一页'
                                    ]);?>
                                </div>
                                <div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /Page Body -->
        </div>
        <!-- /Page Content -->
