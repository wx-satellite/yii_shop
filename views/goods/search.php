
<div class="breadcrumb-area pt-95 pb-95 bg-img" style="background-image:url(/img/banner/banner-2.jpg);">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <h2>Search Result</h2>
            <ul>
                <li><a href="<?php echo yii\helpers\Url::to(['index/index']);?>">首页</a></li>
                <li class="active">搜索结果页</li>
            </ul>
        </div>
    </div>
</div>
<div class="shop-area pt-100 pb-100 gray-bg">
    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-lg-12">
                <div class="shop-topbar-wrapper">
                    <div class="product-sorting-wrapper" style="line-height: 38px;">

                            搜索结果：<span style="color: red;"><?php echo count($res);?>&nbsp;&nbsp;条记录</span>

                    </div>
                    <div class="grid-list-options">
                        <ul class="view-mode">
                            <li  class="active"><a href="#product-grid" data-view="product-grid"><i class="ti-layout-grid4-alt"></i></a></li>
                            <li><a href="#product-list" data-view="product-list"><i class="ti-align-justify"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="grid-list-product-wrapper">
                    <div class="product-view product-grid">
                        <?php if($res):?>
                        <div class="row">
                            <script>
                                $(function(){
                                    CART_URL = "<?php echo \yii\helpers\Url::to(['cart/add']);?>";
                                    $('.add_cart').click(function(){
                                        data={
                                            '_csrf':'<?php echo \Yii::$app->request->getCsrfToken();?>',
                                            'Cart[goods_id]':$(this).attr('data-id'),
                                            'Cart[count]':1
                                        }
                                        $.post(CART_URL,data,function(res){
                                            if(res['success']){
                                                $count = parseInt($('#cart-count').text());
                                                $count+=parseInt(res['count']);
                                                $('#cart-count').text($count);
                                                alert(res['message']);
                                            }else{
                                                alert(res['message']);
                                            }
                                        },'json');
                                    });
                                })
                            </script>
                            <?php foreach ($res as $r):?>
                            <div class="product-width col-lg-6 col-xl-3 col-md-6 col-sm-6">
                                <div class="product-wrapper mb-10">
                                    <div class="product-img">
                                        <a href="<?php echo \yii\helpers\Url::to(['goods/detail','id'=>$r['goods_id']]);?>">
                                            <img src="<?php echo $r['picture'];?>" alt="">
                                        </a>
                                        <div class="product-action">
                                            <a title="Add To Cart" href="javascript:void(0);" class="add_cart" data-id="<?php echo $r['goods_id'];?>">
                                                <i class="ti-shopping-cart"></i>
                                            </a>
                                        </div>
                                        <div class="product-action-wishlist">
                                            <a title="Wishlist" href="#">
                                                <i class="ti-heart"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <h4><a href="<?php echo \yii\helpers\Url::to(['goods/detail','id'=>$r['goods_id']]);?>"><?php echo isset($r['highlight']['name'])?$r['highlight']['name'][0]:$r['name'];?></a></h4>
                                        <div class="product-price">
                                            <?php if($r['is_sale']):?>
                                            <span class="new">RMB：<?php echo $r['sale_price'];?> </span>
                                            <span class="old">RMB：<?php echo $r['price'];?></span>
                                            <?php else:?>
                                                <span class="new">RMB：<?php echo $r['price'];?> </span>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                    <div class="product-list-content">
                                        <h4><a href="#"><?php echo isset($r['highlight']['name'])?$r['highlight']['name'][0]:$r['name'];?></a></h4>
                                        <div class="product-price">
                                            <?php if($r['is_sale']):?>
                                                <span class="new">RMB：<?php echo $r['sale_price'];?> </span>
                                                <span class="old">RMB：<?php echo $r['price'];?></span>
                                            <?php else:?>
                                                <span class="new">RMB：<?php echo $r['price'];?> </span>
                                            <?php endif;?>
                                        </div>
                                        <p><?php echo isset($r['highlight']['descr'])?$r['highlight']['descr'][0]:$r['descr'];?></p>
                                        <div class="product-list-action">
                                            <div class="product-list-action-left">
                                                <a class="addtocart-btn add_cart" title="加入购物车" href="javascript:void(0);" data-id="<?php echo $r['goods_id'];?>"><i class="ion-bag"></i>加入购物车</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach;?>


                        </div>
                        <div class="pagination-style text-center mt-10">
                            <ul>
                                <li>
                                    <a href="#"><i class="icon-arrow-left"></i></a>
                                </li>
                                <li>
                                    <a href="#">1</a>
                                </li>
                                <li>
                                    <a href="#">2</a>
                                </li>
                                <li>
                                    <a class="active" href="#"><i class="icon-arrow-right"></i></a>
                                </li>
                            </ul>
                        </div>
                        <?php else:?>
                            <sapn style="color: red;">对不起，你要搜索的商品不存在</sapn>
                        <?php endif;?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

