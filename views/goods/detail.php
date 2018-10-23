
<div class="breadcrumb-area pt-95 pb-95 bg-img" style="background-image:url(/img/banner/banner-2.jpg);">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <h2>Product Details</h2>
            <ul>
                <li><a href="index.html">主页</a></li>
                <li class="active">商品详情</li>
            </ul>
        </div>
    </div>
</div>
<div class="shop-area pt-95 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="product-details-img">
                    <img id="zoompro" src="<?php echo $goods['picture'].\Yii::$app->getModule('admin')->params['QN_BIG'];?>"
                         data-zoom-image="<?php echo $goods['picture'].\Yii::$app->getModule('admin')->params['QN_BIGGER'];?>" alt="zoom"/>
                    <div id="gallery" class="mt-12 product-dec-slider owl-carousel">
                        <a data-image="<?php echo $goods['picture'].\Yii::$app->getModule('admin')->params['QN_BIG'];?>"
                           data-zoom-image="<?php echo $goods['picture'].\Yii::$app->getModule('admin')->params['QN_BIGGER'];?>">
                            <img src="<?php echo $goods['picture'].\Yii::$app->getModule('admin')->params['QN_SMALL'];?>" alt="">
                        </a>
                        <?php $photos=unserialize($goods['photos']);?>
                        <?php if($photos):?>
                        <?php foreach($photos as $photo):?>
                        <a data-image="<?php echo $photo.\Yii::$app->getModule('admin')->params['QN_BIG'];?>"
                           data-zoom-image="<?php echo $photo.\Yii::$app->getModule('admin')->params['QN_BIGGER'];?>">
                            <img src="<?php echo $photo.\Yii::$app->getModule('admin')->params['QN_SMALL'];?>" alt="">
                        </a>
                        <?php endforeach;?>
                        <?php  endif;?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="product-details-content">
                    <h2><?php echo $goods['name'];?></h2>
                    <div class="product-rating">
                        <span>评分：</span>
                        <i class="ti-star theme-color"></i>
                        <i class="ti-star theme-color"></i>
                        <i class="ti-star theme-color"></i>
                        <i class="ti-star"></i>
                        <i class="ti-star"></i>

                    </div>
                    <div class="product-price">
                        <?php if($goods['is_sale']):?>
                        <span class="new">RMB:<?php echo $goods['sale_price'];?> </span>
                        <span class="old">RMB:<?php echo $goods['price'];?></span>
                        <?php else:?>
                            <span class="new">RMB:<?php echo $goods['price'];?> </span>
                        <?php endif;?>
                    </div>
                    <div class="in-stock">
                        <span><i class="ion-android-checkbox-outline"></i> 库存量</span>
                    </div>
                    <div class="sku">
                        <span>数量：<?php echo $goods['stock'];?></span>
                    </div>
                    <p><?php echo $goods['descr'];?></p>
<!--                    <div class="product-details-style shorting-style mt-30">-->
<!--                        <label>color:</label>-->
<!--                        <select>-->
<!--                            <option value=""> Choose an option</option>-->
<!--                            <option value=""> orange</option>-->
<!--                            <option value=""> pink</option>-->
<!--                            <option value=""> yellow</option>-->
<!--                        </select>-->
<!--                    </div>-->
                    <script>
                        $(function(){
                            CART_URL = "<?php echo \yii\helpers\Url::to(['cart/add']);?>"
                            $('#add_cart').click(function(){
                                $.post(CART_URL,$('#form').serialize(),function(res){
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
                    <?php $form=\yii\bootstrap\ActiveForm::begin([
                            'id'=>'form'
                    ]);?>
                    <div class="quality-wrapper mt-30 product-quantity">
                        <label>购买数量:</label>
                        <div class="cart-plus-minus">
                            <input type="hidden" name="Cart[goods_id]" value="<?php echo $goods['id'];?>"/>
                            <input class="cart-plus-minus-box" type="text" name="Cart[count]" value="1" id="count">
                        </div>
                    </div>
                    <div class="product-list-action">
                        <div class="product-list-action-left">
                            <a class="addtocart-btn" href="javascript:void(0);" title="Add to cart" id="add_cart">
                                <i class="ion-bag"></i>
                                加入购物车
                            </a>
                        </div>
                        <div class="product-list-action-right">
                            <a href="#" title="Wishlist">
                                <i class="ti-heart"></i>
                            </a>
                        </div>
                    </div>
                    <?php \yii\bootstrap\ActiveForm::end();?>
<!--                    <div class="social-icon mt-30">-->
<!--                        <ul>-->
<!--                            <li><a href="#"><i class="icon-social-twitter"></i></a></li>-->
<!--                            <li><a href="#"><i class="icon-social-instagram"></i></a></li>-->
<!--                            <li><a href="#"><i class="icon-social-linkedin"></i></a></li>-->
<!--                            <li><a href="#"><i class="icon-social-skype"></i></a></li>-->
<!--                            <li><a href="#"><i class="icon-social-dribbble"></i></a></li>-->
<!--                        </ul>-->
<!--                    </div>-->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="description-review-area pb-100">
    <div class="container">
        <div class="description-review-wrapper gray-bg pt-40">
            <div class="description-review-topbar nav text-center">
                <a class="active" data-toggle="tab" href="#des-details1">商品详情</a>
                <a data-toggle="tab" href="#des-details2">更多信息</a>
                <a data-toggle="tab" href="#des-details3">用户评论（2）</a>
            </div>
            <div class="tab-content description-review-bottom">
                <div id="des-details1" class="tab-pane active">
                    <div class="product-description-wrapper">
                        <p>This stewpot is part of the Scanpan Classic cookware range, which boasts GreenTek non-stick coating which is 100% PFOA free, meaning it's safer for your family and the environment. The heavy-duty, pressure-cast aluminum body has an extra-thick base for quick, even heating and it is compatible with all cooking surfaces (excluding induction). The extraordinarily hard exterior surface is a combination of ceramic and titanium nonstick cooking surface which is impossible to scrape away, even with metal utensils. Patented spring-lock handle stays cool during normal stove top use and the stewpot is also oven safe from up to 260°C. It's also dishwasher safe for easy cleanup. </p>
                        <p>Scanpan is designed and manufactured in Denmark and offers a lifetime warranty.</p>
                        <ul>
                            <li>Key Features:</li>
                            <li>Heavy duty, pressure cast aluminium with extra thick base for quick heat up</li>
                            <li>Ceramic titanium surface with PFOA-free GreenTek non-stick coating</li>
                            <li>Fat-free frying, metal utensils safe</li>
                            <li>Suitable for all stove tops, except induction</li>
                            <li>Guaranteed not to warp</li>
                            <li>Fast and even heat distribution</li>
                            <li>Ovenproof up to 260°C</li>
                            <li>Dishwasher safe - but not recommended</li>
                            <li>Designed and manufactured in Denmark</li>
                        </ul>
                    </div>
                </div>
                <div id="des-details2" class="tab-pane">
                    <div class="product-anotherinfo-wrapper">
                        <ul>
                            <li><span>name:</span> Scanpan Classic Covered</li>
                            <li><span>color:</span> orange , pink , yellow </li>
                            <li><span>size:</span> xl, l , m , sl</li>
                            <li><span>length:</span> 102cm, 110cm , 115cm </li>
                            <li><span>Brand:</span> Nike, Religion, Diesel, Monki </li>
                        </ul>
                    </div>
                </div>
                <div id="des-details3" class="tab-pane">
                    <div class="rattings-wrapper">
                        <div class="sin-rattings">
                            <div class="star-author-all">
                                <div class="product-rating f-left">
                                    <i class="ti-star theme-color"></i>
                                    <i class="ti-star theme-color"></i>
                                    <i class="ti-star theme-color"></i>
                                    <i class="ti-star theme-color"></i>
                                    <i class="ti-star theme-color"></i>
                                    <span>(5)</span>
                                </div>
                                <div class="ratting-author f-right">
                                    <h3>tayeb rayed</h3>
                                    <span>12:24</span>
                                    <span>9 March 2018</span>
                                </div>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Utenim ad minim veniam, quis nost rud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Utenim ad minim veniam, quis nost.</p>
                        </div>
                        <div class="sin-rattings">
                            <div class="star-author-all">
                                <div class="product-rating f-left">
                                    <i class="ti-star theme-color"></i>
                                    <i class="ti-star theme-color"></i>
                                    <i class="ti-star theme-color"></i>
                                    <i class="ti-star theme-color"></i>
                                    <i class="ti-star"></i>
                                    <span>(4)</span>
                                </div>
                                <div class="ratting-author f-right">
                                    <h3>farhana shuvo</h3>
                                    <span>12:24</span>
                                    <span>9 March 2018</span>
                                </div>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Utenim ad minim veniam, quis nost rud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Utenim ad minim veniam, quis nost.</p>
                        </div>
                    </div>
                    <div class="ratting-form-wrapper">
                        <h3>Add your Comments :</h3>
                        <div class="ratting-form">
                            <form action="#">
                                <div class="star-box">
                                    <h2>Rating:</h2>
                                    <div class="product-rating">
                                        <i class="ti-star theme-color"></i>
                                        <i class="ti-star theme-color"></i>
                                        <i class="ti-star theme-color"></i>
                                        <i class="ti-star"></i>
                                        <i class="ti-star"></i>
                                        <span>(3)</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="rating-form-style mb-20">
                                            <input placeholder="Name" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="rating-form-style mb-20">
                                            <input placeholder="Email" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="rating-form-style form-submit">
                                            <textarea name="message" placeholder="Message"></textarea>
                                            <input type="submit" value="add review">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="related-product-area pt-95 pb-80 gray-bg">
    <div class="container">
        <div class="section-title text-center mb-55">
            <h4>Most Populer</h4>
            <h2>Related Products</h2>
        </div>
        <div class="related-product-active owl-carousel">
            <div class="product-wrapper">
                <div class="product-img">
                    <a href="product-details.html">
                        <img src="assets/img/product/product-4.jpg" alt="">
                    </a>
                    <div class="product-action">
                        <a title="Quick View" data-toggle="modal" data-target="#exampleModal" href="#">
                            <i class="ti-plus"></i>
                        </a>
                        <a title="Add To Cart" href="#">
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
                    <h4><a href="product-details.html">Dog Calcium Food</a></h4>
                    <div class="product-price">
                        <span class="new">$20.00 </span>
                        <span class="old">$50.00</span>
                    </div>
                </div>
            </div>
            <div class="product-wrapper">
                <div class="product-img">
                    <a href="product-details.html">
                        <img src="assets/img/product/product-5.jpg" alt="">
                    </a>
                    <div class="product-action">
                        <a title="Quick View" data-toggle="modal" data-target="#exampleModal" href="#">
                            <i class="ti-plus"></i>
                        </a>
                        <a title="Add To Cart" href="#">
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
                    <h4><a href="product-details.html">Cat Buffalo Food</a></h4>
                    <div class="product-price">
                        <span class="new">$22.00 </span>
                    </div>
                </div>
            </div>
            <div class="product-wrapper">
                <div class="product-img">
                    <a href="product-details.html">
                        <img src="assets/img/product/product-6.jpg" alt="">
                    </a>
                    <div class="product-action">
                        <a title="Quick View" data-toggle="modal" data-target="#exampleModal" href="#">
                            <i class="ti-plus"></i>
                        </a>
                        <a title="Add To Cart" href="#">
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
                    <h4><a href="product-details.html">Legacy Dog Food</a></h4>
                    <div class="product-price">
                        <span class="new">$50.00 </span>
                        <span class="old">$70.00</span>
                    </div>
                </div>
            </div>
            <div class="product-wrapper">
                <div class="product-img">
                    <a href="product-details.html">
                        <img src="assets/img/product/product-7.jpg" alt="">
                    </a>
                    <div class="product-action">
                        <a title="Quick View" data-toggle="modal" data-target="#exampleModal" href="#">
                            <i class="ti-plus"></i>
                        </a>
                        <a title="Add To Cart" href="#">
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
                    <h4><a href="product-details.html">Chicken Dry Cat Food</a></h4>
                    <div class="product-price">
                        <span class="new">$60.00 </span>
                    </div>
                </div>
            </div>
            <div class="product-wrapper">
                <div class="product-img">
                    <a href="product-details.html">
                        <img src="assets/img/product/product-8.jpg" alt="">
                    </a>
                    <div class="product-action">
                        <a title="Quick View" data-toggle="modal" data-target="#exampleModal" href="#">
                            <i class="ti-plus"></i>
                        </a>
                        <a title="Add To Cart" href="#">
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
                    <h4><a href="product-details.html">Stomach Dog Food</a></h4>
                    <div class="product-price">
                        <span class="new">$70.00 </span>
                        <span class="old">$90.00</span>
                    </div>
                </div>
            </div>
            <div class="product-wrapper">
                <div class="product-img">
                    <a href="product-details.html">
                        <img src="assets/img/product/product-9.jpg" alt="">
                    </a>
                    <div class="product-action">
                        <a title="Quick View" data-toggle="modal" data-target="#exampleModal" href="#">
                            <i class="ti-plus"></i>
                        </a>
                        <a title="Add To Cart" href="#">
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
                    <h4><a href="product-details.html">Nourish Puppy Food</a></h4>
                    <div class="product-price">
                        <span class="new">$80.00 </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    MAX_STOCK = <?php echo (int)$goods['stock'];?>;
    $('#count').blur(function(){
        value = parseInt($(this).val());

        if(value>MAX_STOCK){
            value=MAX_STOCK
        }
        if(value<1){
            value=1;
        }
        $(this).val(value)
    });
</script>