<?php
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
?>
<div class="breadcrumb-area pt-95 pb-95 bg-img" style="background-image:url(assets/img/banner/banner-2.jpg);">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <h2>Checkout Order</h2>
            <ul>
                <li><a href="<?php echo \yii\helpers\Url::to(['index/index']);?>">主页</a></li>
                <li class="active">确认订单</li>
            </ul>
        </div>
    </div>
</div>
<!-- shopping-cart-area start -->
<div class="checkout-area pt-95 pb-70">
    <div class="container">
        <h3 class="page-title">订单详情</h3>
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
            <div class="col-lg-12">
                <div class="checkout-wrapper">
                    <div id="faq" class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>1</span> <a data-toggle="collapse" data-parent="#faq" aria-expanded="true" class href="#payment-1">确认订单</a></h5>
                            </div>
                            <div id="payment-1" class="panel-collapse collapse show">
                                <?php $form=ActiveForm::begin([
                                    'fieldConfig'=>[
                                        'template'=>'<div class="col-lg-6 col-md-6"><div class="billing-info">{label}{input}</div><span style="color:red;">{error}</span></div>'
                                    ]
                                ]);?>
                                <div class="panel-body">
                                    <div class="billing-information-wrapper">


                                            <?php echo $form->field($model,'receiver')->label('收货人')
                                                    ->textInput([
                                                        'value'=>$user['last_name'].$user['first_name']
                                                    ]);?>


                                            <?php echo $form->field($model,'tel')->label('联系电话')
                                                ->textInput([
                                                    'value'=>$user['phone']
                                                ]);?>
                                        <?php echo $form->field($model,'address')->label('收货地址')
                                            ->textInput([
                                                'value'=>$user['address']
                                            ]);?>


                                        <div class="row" style="padding-left: 14px;">
                                            <script>
                                                $(function(){
                                                    $('#post_type').change(function(){
                                                        post_price = parseFloat($(this).find('option:selected').attr('data-price'));
                                                        $('#post_price').text(post_price.toFixed(2));
                                                        goods_price = parseFloat($('#goods_price').text());
                                                        $('#sum').text((post_price+goods_price).toFixed(2));
                                                    });
                                                });
                                            </script>

                                            <div class="col-lg-6 col-md-6">
                                                <div class="billing-info">
                                                    <label>配送方式</label>
                                                    <select name="Order[post_type]" style="border:1px solid #eaeaea;padding:10px;" id="post_type">
                                                        <?php foreach(\Yii::$app->params['post_type'] as $k=>$post_type):?>
                                                            <?php if(1===(int)$k) $post_price=$post_type['price'];?>
                                                            <option value="<?php echo $k;?>" data-price="<?php echo $post_type['price'];?>"><?php echo $post_type['name'];?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="padding-left: 14px;">

                                            <div class="col-lg-6 col-md-6">
                                                <div class="billing-info">
                                                    <label>支付方式</label>
                                                    <select name="Order[pay_type]" style="border:1px solid #eaeaea;padding:10px;">
                                                        <?php foreach(\Yii::$app->params['pay_type'] as $k=>$pay_type):?>
                                                            <option value="<?php echo $k;?>"><?php echo $pay_type;?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="order-review-wrapper">
                                        <div class="order-review">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th class="width-1">商品名称</th>
                                                        <th class="width-2">商品价格</th>
                                                        <th class="width-3">商品数量</th>
                                                        <th class="width-4">总价</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php $sum=0;?>
                                                    <?php foreach($cart as $c):?>
                                                    <tr>
                                                        <td>
                                                            <div class="o-pro-dec">
                                                                <p><?php echo $c['name'];?></p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="o-pro-price">
                                                                <p>RMB:&nbsp;&nbsp;<?php echo sprintf('%.2f',$c['current_price']);?></p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="o-pro-qty">
                                                                <p><?php echo $c['count'];?></p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="o-pro-subtotal">
                                                                <?php $sum+=$c['count']*$c['current_price'];?>
                                                                <p>RMB:&nbsp;&nbsp;<?php echo sprintf('%.2f',$c['count']*$c['current_price']);?></p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach;?>
                                                    </tbody>
                                                    <tfoot>
                                                    <tr>
                                                        <td colspan="3">商品总价： </td>
                                                        <td colspan="1">RMB:<span id="goods_price">&nbsp;&nbsp;<?php echo sprintf('%.2f',$sum);?></span></td>
                                                    </tr>
                                                    <tr class="tr-f">
                                                        <td colspan="3">配送费：</td>
                                                        <td colspan="1">RMB:&nbsp;&nbsp;<span id="post_price"><?php echo sprintf('%.2f',$post_price);?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">总支付：</td>
                                                        <td colspan="1">RMB:&nbsp;&nbsp;<span id="sum"><?php echo sprintf('%.2f',$sum+$post_price);?></span></td>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                            <div class="billing-back-btn">
                                                        <span>
                                                            商品不对？
                                                            <a href="<?php echo \yii\helpers\Url::to(['cart/detail']);?>"> 编辑购物车</a>
                                                        </span>
                                                <div class="billing-btn">
                                                    <button type="submit">确认下单</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php ActiveForm::end();?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

