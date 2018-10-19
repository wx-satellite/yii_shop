<div class="breadcrumb-area pt-95 pb-95 bg-img" style="background-image:url(assets/img/banner/banner-2.jpg);">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <h2>MY EXPRESS</h2>
            <ul>
                <li><a href="<?php echo \yii\helpers\Url::to(['order/my-order']);?>">我的订单</a></li>
                <li class="active">物流信息</li>
            </ul>
        </div>
    </div>
</div>
<!-- shopping-cart-area start -->
<div class="cart-main-area pt-95 pb-100">
    <div class="container">
        <?php if($res):?>
        <h3 class="page-title">订单：<?php echo $order->orderno;?>&nbsp;&nbsp;的物流信息</h3>
        <?php else:?>
            <h3 class="page-title">暂无订单：<?php echo $order->orderno;?>&nbsp;&nbsp;的物流消息</h3>
        <?php endif;?>
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="timeline timeline-line-dotted">
                    <?php if($res):?>
                        <?php $res=array_reverse($res);?>
                        <?php foreach($res as $k=>$v):?>
                    <span class="timeline-label">
                        <span class="label label-primary"><?php echo $v['time'];?></span>
                    </span>
                    <div class="timeline-item">
                        <div class="timeline-point timeline-point-success">
                            <i class="fa fa-money"></i>
                        </div>
                        <div class="timeline-event">
                            <div class="timeline-heading">
                                <h4><?php echo $com;?>&nbsp;&nbsp;物流信息</h4>
                            </div>
                            <div class="timeline-body">
                                <p><?php echo $v['context'];?></p>
                            </div>
                            <div class="timeline-footer">
                                <p class="text-right"><?php echo $v['ftime'];?></p>
                            </div>
                        </div>
                    </div>

                            <?php endforeach;?>
                    <?php endif;?>
                </div>
            </div>


        </div>
</div>
        </div>
    </div>