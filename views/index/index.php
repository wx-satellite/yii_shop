
<div class="slider-area">
    <div class="slider-active owl-dot-style owl-carousel">
        <div class="single-slider pt-100 pb-100 yellow-bg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-12 col-sm-7">
                        <div class="slider-content slider-animated-1 pt-114">
                            <h3 class="animated">We keep pets for pleasure.</h3>
                            <h1 class="animated">Food & Vitamins <br>For all Pets</h1>
                            <div class="slider-btn">
                                <a class="animated" href="product-details.html">SHOP NOW</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12 col-sm-5">
                        <div class="slider-single-img slider-animated-1">
                            <img class="animated" src="/assets/img/slider/slider-single-img.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="single-slider pt-100 pb-100 yellow-bg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-7 col-12">
                        <div class="slider-content slider-animated-1 pt-114">
                            <h3 class="animated">We keep pets for pleasure.</h3>
                            <h1 class="animated">Food & Vitamins <br>For all Pets</h1>
                            <div class="slider-btn">
                                <a class="animated" href="product-details.html">SHOP NOW</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-5 col-12">
                        <div class="slider-single-img slider-animated-1">
                            <img class="animated" src="/assets/img/slider/slider-single-img-2.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="food-category food-category-col pt-100 pb-60">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="single-food-category cate-padding-1 text-center mb-30">
                    <div class="single-food-hover-2">
                        <img src="/assets/img/product/product-1.jpg" alt="">
                    </div>
                    <div class="single-food-content">
                        <h3>狗粮</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="single-food-category cate-padding-2 text-center mb-30">
                    <div class="single-food-hover-2">
                        <img src="/assets/img/product/product-2.jpg" alt="">
                    </div>
                    <div class="single-food-content">
                        <h3>猫粮</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="single-food-category cate-padding-3 text-center mb-30">
                    <div class="single-food-hover-2">
                        <img src="/assets/img/product/product-3.jpg" alt="">
                    </div>
                    <div class="single-food-content">
                        <h3>鱼粮</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="product-area pt-95 pb-70 gray-bg">
    <div class="container">
        <div class="section-title text-center mb-55">
            <h4>最受欢迎的商品</h4>
            <h2>Recent Products</h2>
        </div>
        <div class="row">
            <?php if($goods):?>
            <?php foreach($goods as $good):?>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                <div class="product-wrapper mb-10">
                    <div class="product-img">
                        <a href="<?php echo \yii\helpers\Url::to(['goods/detail','id'=>$good['id']]);?>">
                            <img src="<?php echo $good['picture'].\Yii::$app->getModule('admin')->params['QN_MIDDLE'];?>" alt="">
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
                        <h4><a href="<?php echo \yii\helpers\Url::to(['goods/detail','id'=>$good['id']]);?>"><?php echo $good['name'];?></a></h4>
                        <div class="product-price">
                            <?php if($good['is_sale']):?>
                            <span class="new">RMB:<?php echo $good['sale_price'];?></span>
                            <span class="old">RMB:<?php echo $good['price'];?></span>
                            <?php else:?>
                                <span class="new">RMB:<?php echo $good['price'];?></span>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
            <?php endif;?>
        </div>
    </div>
</div>
<div class="deal-area bg-img pt-95 pb-100">
    <div class="container">
        <div class="section-title text-center mb-50">
            <h4>Best Product</h4>
            <h2>Deal of the Week</h2>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="deal-img wow fadeInLeft">
                    <a href="#"><img src="/assets/img/banner/banner-2.png" alt=""></a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="deal-content">
                    <h3><a href="#">Name Your Product</a></h3>
                    <div class="deal-pro-price">
                        <span class="deal-old-price">$16.00 </span>
                        <span> $10.00</span>
                    </div>
                    <p>Lorem ipsum dolor sit amet, co adipisicing elit, sed do eiusmod tempor incididunt labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercita ullamco laboris nisi ut aliquip ex ea commodo </p>
                    <div class="timer timer-style">
                        <div data-countdown="2017/10/01"></div>
                    </div>
                    <div class="discount-btn mt-35">
                        <a class="btn-style" href="#">SHOP NOW</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="testimonial-area pt-90 pb-70 bg-img" style="background-image:url(/assets/img/banner/banner-1.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 ml-auto mr-auto">
                <div class="testimonial-wrap">
                    <div class="testimonial-text-slider text-center">
                        <div class="sin-testiText">
                            <p>Lorem ipsum dolor sit amet, co adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercita ullamco laboris nisi ut aliquip ex ea commodo</p>
                        </div>
                        <div class="sin-testiText">
                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or amro porano ja cai tomi tai go amro porano  amro porano ja cai tomi tai go  .... </p>
                        </div>
                        <div class="sin-testiText">
                            <p>Lorem ipsum dolor sit amet, co adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercita ullamco laboris nisi ut aliquip ex ea commodo</p>
                        </div>
                        <div class="sin-testiText">
                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or amro porano ja cai tomi tai go amro porano  amro porano ja cai tomi tai go  .... </p>
                        </div>
                    </div>
                    <div class="testimonial-image-slider text-center">
                        <div class="sin-testiImage">
                            <img src="/assets/img/testi/3.jpg" alt="">
                            <h3>Robiul Islam</h3>
                            <h5>Customer</h5>
                        </div>
                        <div class="sin-testiImage">
                            <img src="/assets/img/testi/4.jpg" alt="">
                            <h3>Robiul Islam</h3>
                            <h5>Customer</h5>
                        </div>
                        <div class="sin-testiImage">
                            <img src="/assets/img/testi/3.jpg" alt="">
                            <h3>F. H. Shuvo</h3>
                            <h5>Developer</h5>
                        </div>
                        <div class="sin-testiImage">
                            <img src="/assets/img/testi/5.jpg" alt="">
                            <h3>T. T. Rayed</h3>
                            <h5>CEO</h5>
                        </div>
                    </div>
                    <div class="testimonial-shap">
                        <img src="/assets/img/icon-img/testi-shap.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="service-area bg-img pt-100 pb-65">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="service-content text-center mb-30 service-color-1">
                    <img src="/assets/img/icon-img/shipping.png" alt="">
                    <h4>免运费</h4>
                    <p>确认订单的时候，选择自送即可免邮费</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="service-content text-center mb-30 service-color-2">
                    <img src="/assets/img/icon-img/support.png" alt="">
                    <h4>在线支持</h4>
                    <p>全天候24小时，营业开张</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="service-content text-center mb-30 service-color-3">
                    <img src="/assets/img/icon-img/money.png" alt="">
                    <h4>售后服务</h4>
                    <p>支持7天无理由退货</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="blog-area pb-70">
    <div class="container">
        <div class="section-title text-center mb-60">
            <h4>Latest News</h4>
            <h2>From Our Blog</h2>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="blog-wrapper mb-30 gray-bg">
                    <div class="blog-img hover-effect">
                        <a href="blog-details.html"><img alt="" src="/assets/img/blog/blog-1.jpg"></a>
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <ul>
                                <li>By: <span>Admin</span></li>
                                <li>Sep 14, 2018</li>
                            </ul>
                        </div>
                        <h4><a href="blog-details.html">Lorem ipsum dolor amet cons adipisicing elit</a></h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="blog-wrapper mb-30 gray-bg">
                    <div class="blog-img hover-effect">
                        <a href="blog-details.html"><img alt="" src="/assets/img/blog/blog-2.jpg"></a>
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <ul>
                                <li>By: <span>Admin</span></li>
                                <li>Sep 14, 2018</li>
                            </ul>
                        </div>
                        <h4><a href="blog-details.html">Lorem ipsum dolor amet cons adipisicing elit</a></h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="blog-wrapper mb-30 gray-bg">
                    <div class="blog-img hover-effect">
                        <a href="blog-details.html"><img alt="" src="/assets/img/blog/blog-3.jpg"></a>
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <ul>
                                <li>By: <span>Admin</span></li>
                                <li>Sep 14, 2018</li>
                            </ul>
                        </div>
                        <h4><a href="blog-details.html">Lorem ipsum dolor amet cons adipisicing elit</a></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

