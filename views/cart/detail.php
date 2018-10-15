<div class="breadcrumb-area pt-95 pb-95 bg-img" style="background-image:url(assets/img/banner/banner-2.jpg);">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <h2>Cart Page</h2>
            <ul>
                <li><a href="<?php echo \yii\helpers\Url::to(['index/index']);?>">主页</a></li>
                <li class="active">购物车详情页</li>
            </ul>
        </div>
    </div>
</div>
<!-- shopping-cart-area start -->
<div class="cart-main-area pt-95 pb-100">
    <div class="container">
        <h3 class="page-title">购物车列表</h3>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <form action="#">
                    <div class="table-content table-responsive">
                        <table>
                            <thead>
                            <tr>
                                <th>商品缩略图</th>
                                <th>商品名称</th>
                                <th>商品单价</th>
                                <th>商品数量</th>
                                <th>总价</th>
                                <th>删除</th>
                            </tr>
                            </thead>
                            <script>
                                $(function(){
                                    REOMVE_URL="<?php echo \yii\helpers\Url::to(['cart/delete']);?>"
                                    ADD_URL="<?php echo \yii\helpers\Url::to(['cart/add']);?>"
                                    _csrf="<?php echo \Yii::$app->request->csrfToken;?>";

                                    //动态计算商品价格，供改变商品数量的成功回调函数调用
                                    function cal(tr,count){
                                        price=tr.find('td[class=product-price-cart] span').text();
                                        price=parseFloat(price);
                                        sum_price=count*price;
                                        tr.find('td span[class=sum]').text(sum_price.toFixed(2))
                                    }
                                    //动态修改购物车商品总量
                                    function decr(num){
                                        cart_count = $('#cart-count');
                                        cart_count.text(parseInt(cart_count.text())+num)
                                    }
                                    //动态计算商品总价
                                    function sum_prices(){
                                        sum=0;
                                        prices = $('span[class=sum]');
                                        for(var i=0;i<prices.length;i++){
                                            sum+=parseFloat(prices.eq(i).text())
                                        }
                                        $('.cart-sum').text(sum.toFixed(2));
                                    }
                                    $('.removeOne').click(function(){
                                        goods_id = $(this).attr('data-id');
                                        obj=$(this);
                                        if(confirm('确认从购物车中删除该商品吗？')){
                                            $.post(REOMVE_URL,{id:goods_id,_csrf:_csrf,flag:'one'},function(res){
                                                alert(res['message']);
                                                if(res['success']){
                                                    obj.parent().parent().remove();
                                                    if(!$('#cart-info').find('tr').length){
                                                        $('#cart-info').html('<tr><td colspan="6" align="center"><a href="/index.php?r=goods/list">暂无商品，快去购物吧</a></td></tr>');
                                                        $('#cart-button').remove();
                                                    }
                                                    decr(-1*(parseInt(obj.parent().parent().find('input').val())));
                                                    sum_prices();
                                                }
                                            },'json');
                                        }
                                        return false;
                                    });
                                    $('#removeAll').click(function(){
                                        if(confirm('确认清空购物车吗？')) {
                                            $.post(REOMVE_URL + '&flag=all', {
                                                flag: 'all',
                                                _csrf: _csrf
                                            }, function (res) {
                                                alert(res['message']);
                                                window.location.reload();
                                            }, 'json');
                                        }
                                        return false;
                                    })
                                    $('.changecart').click(function(){
                                        obj =$(this);
                                        goods_id = obj.attr('data-id');
                                        input = obj.siblings('input')
                                        if('-'===obj.text()){
                                            if(parseInt(input.val())>=2){
                                                $.post(ADD_URL,{'Cart[goods_id]':goods_id,'Cart[count]':-1,'_csrf':_csrf},function(res){
                                                    if(res['success']){
                                                        val=parseInt(input.val())-1;
                                                        input.val(val);
                                                        cal(obj.parent().parent().parent(),val);
                                                        decr(-1);
                                                        sum_prices();
                                                    }else{
                                                        alert(res['message']);
                                                    }
                                                },'json');
                                            }
                                        }else{
                                            $.post(ADD_URL,{'Cart[goods_id]':goods_id,'Cart[count]':1,'_csrf':_csrf},function(res){
                                                if(res['success']){
                                                    val=parseInt(input.val())+1;
                                                    input.val(val);
                                                    cal(obj.parent().parent().parent(),val);
                                                    decr(1);
                                                    sum_prices();
                                                }else{
                                                    alert(res['message']);
                                                }
                                            },'json');
                                        }
                                    })
                                })

                            </script>
                            <tbody id="cart-info">
                            <?php if($carts):?>
                            <?php $sum=0?>
                            <?php foreach($carts as $cart):?>
                            <tr>
                                <td class="product-thumbnail">
                                    <a href="<?php echo \yii\helpers\Url::to(['goods/detail','id'=>$cart['id']]);?>"><img src="<?php echo $cart['picture'].\Yii::$app->getModule('admin')->params['QN_SMALL'];?>" alt=""></a>
                                </td>
                                <td class="product-name"><a href="<?php echo \yii\helpers\Url::to(['goods/detail','id'=>$cart['id']]);?>"><?php echo $cart['name'];?></a></td>
                                <td class="product-price-cart" style="text-align: center;">RMB:&nbsp;&nbsp;<span style="padding-left: 0px;"><?php echo sprintf('%.2f',$cart['current_price']);?></span></td>
                                <td class="product-quantity">
                                    <div class="change-cart">
                                        <div class="dec changecart" data-id="<?php echo $cart['id'];?>">-</div>
                                        <input class="cart-plus-minus-box" type="text" name="qtybutton" value="<?php echo $cart['count'];?>" disabled>
                                        <div class="inc changecart" data-id="<?php echo $cart['id'];?>">+</div>
                                    </div>
                                </td>
                                <td style="text-align: center;">RMB:&nbsp;&nbsp;<span class="sum" style="padding-left: 0px;"><?php echo sprintf('%.2f',$cart['current_price']*$cart['count']);?></span></td>
                                <td style="text-align: center;"><a href="javascript:void(0);" class="removeOne" data-id="<?php echo $cart['id'];?>"><i class="ti-trash"></i></a></td>
                            </tr>
                            <?php $sum+=$cart['current_price']*$cart['count'];?>
                            <?php endforeach;?>
                            <?php else:?>
                                <tr><td colspan="6" align="center"><a href="/index.php?r=goods/list">暂无商品，快去购物吧</a></td></tr>
                            <?php endif;?>
                            </tbody>
                        </table>
                    </div>
                    <?php if($carts):?>
                    <div class="row" id="cart-button">
                        <div class="col-lg-12">
                            <div class="cart-shiping-update-wrapper">
                                <div class="cart-shiping-update">
                                    <a href="<?php echo \yii\helpers\Url::to(['goods/list']);?>">继续购物</a>
                                    <button id="removeAll">清空购物车</button>
                                </div>
                                <div class="order">
                                    <a href="#">总价：<span style="padding-left: 0px;" class="cart-sum"><?php echo sprintf('%.2f',$sum);?></span>，去付款</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif;?>
                </form>


            </div>
        </div>
    </div>
</div>

