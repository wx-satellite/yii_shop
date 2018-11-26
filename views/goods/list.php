
<div class="breadcrumb-area pt-95 pb-95 bg-img" style="background-image:url(/img/banner/banner-2.jpg);">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <h2>Shop Page</h2>
            <ul>
                <li><a href="<?php echo \yii\helpers\Url::to(['index/index']);?>">主页</a></li>
                <li class="active">商品列表</li>
            </ul>
        </div>
    </div>
</div>
<div class="shop-area pt-100 pb-100 gray-bg">
    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-lg-9">
                <div class="grid-list-product-wrapper">
                    <div class="product-view product-list">
                        <div class="row">
                            <?php foreach($goods as $good):?>
                            <div class="product-width col-lg-6 col-xl-4 col-md-6 col-sm-6">
                                <div class="product-wrapper mb-10">
                                    <div class="product-img">
                                        <a href="<?php echo \yii\helpers\Url::to(['goods/detail','id'=>$good->id]);?>">
                                            <img src="<?php echo $good->picture;?>" alt="">
                                        </a>
                                    </div>
                                    <div class="product-list-content">
                                        <h4><a href="<?php echo \yii\helpers\Url::to(['goods/detail','id'=>$good->id]);?>"><?php echo $good->name;?></a></h4>
                                        <div class="product-price">
                                            <?php if($good->is_sale):?>
                                            <span class="new">RMB：<?php echo $good->sale_price;?> </span>
                                            <span class="old">RMB：<?php echo $good->price;?></span>
                                            <?php else:?>
                                                <span class="new">RMB：<?php echo $good->price;?> </span>
                                            <?php endif;?>
                                        </div>
                                        <p><?php echo $good->descr;?></p>
                                        <div class="product-list-action">
                                            <div class="product-list-action-left">
                                                <a class="addtocart-btn add_cart" title="Add to cart" href="javascript:void(0);"  data-id="<?php echo $good->id;?>"><i class="ion-bag"></i>添加到购物车</a>
                                            </div>
                                            <div class="product-list-action-right">
                                                <a title="Wishlist" href="javascript:void(0);" onclick="javascript:alert('这功能还没有做呢～')"><i class="ti-heart"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach;?>
                        </div>
                        <script>
                            $(function(){
                                CART_URL = "<?php echo \yii\helpers\Url::to(['cart/add']);?>";
                                _csrf="<?php echo \Yii::$app->request->csrfToken;?>"
                                $('.add_cart').click(function(){
                                    goods_id=$(this).attr('data-id');
                                    $.post(CART_URL,{'Cart[goods_id]':goods_id,'Cart[count]':1,'_csrf':_csrf},function(res){
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
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="shop-sidebar">
                    <div class="shop-widget">
                        <h4 class="shop-sidebar-title">商品搜索</h4>
                        <div class="shop-search mt-25 mb-50">
                            <?php $form=\yii\bootstrap\ActiveForm::begin([
                                    'options'=>['class'=>'shop-search-form']
                            ]);?>
                                <input type="text" name="keyword" placeholder="搜索商品">
                                <button type="submit">
                                    <i class="icon-magnifier"></i>
                                </button>
                            <?php \yii\bootstrap\ActiveForm::end();?>
                        </div>
                    </div>
                    <?php foreach($this->params['cates'] as $k=>$cate):?>
                    <div class="shop-widget mt-50">
                        <h4 class="shop-sidebar-title">
                            <?php echo \Yii::$app->getModule('admin')->params['CATEGORY_TYPE'][$k];?>
                        </h4>
                        <div class="shop-list-style mt-20">
                            <ul>
                                <?php foreach($cate as $c):?>
                                <li><a href="<?php echo \yii\helpers\Url::to(['goods/list','cid'=>$c['id']]);?>"><?php echo $c['title'];?></a></li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    </div>
                    <?php endforeach;?>

                </div>
            </div>
        </div>
    </div>
</div>

