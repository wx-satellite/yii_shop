<?php

$this->title='三斤宠物口粮';

?>
<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?= $this->title ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="/assets/img/favicon.png">

    <!-- all css here -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/animate.css">
    <link rel="stylesheet" href="/assets/css/simple-line-icons.css">
    <link rel="stylesheet" href="/assets/css/themify-icons.css">
    <link rel="stylesheet" href="/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/assets/css/slick.css">
    <link rel="stylesheet" href="/assets/css/meanmenu.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/timeline.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
    <script src="/assets/js/vendor/modernizr-2.8.3.min.js"></script>
    <script src="/assets/js/vendor/jquery-1.12.0.min.js"></script>

</head>
<body>
<header class="header-area">
    <div class="header-bottom transparent-bar">
        <div class="container">
            <div class="row">
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-5">
                    <div class="logo pt-39">
                        <a href="index.html"><img alt="" src="/assets/img/logo/logo.png"></a>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-7 d-none d-lg-block">
                    <div class="main-menu text-center">
                        <nav>
                            <ul>
                                <li>
                                    <a href="<?php echo yii\helpers\Url::to(['index/index']);?>">主页</a>
                                </li>
                                <li class="mega-menu-position"><a href="shop-page.html">口粮分类</a>
                                    <ul class="mega-menu">
                                        <?php foreach($this->params['cates'] as $k=>$cate):?>
                                        <li>
                                            <ul>
                                                <li class="mega-menu-title"><?php echo \Yii::$app->getModule('admin')->params['CATEGORY_TYPE'][$k];?></li>
                                                <?php foreach($cate as $c):?>
                                                <li><a href="shop-page.html"><?php echo $c['title'];?></a></li>
                                                <?php endforeach;?>
                                            </ul>
                                        </li>
                                        <?php endforeach;?>
                                        <li>
                                            <ul>
                                                <li><a href="shop-page.html"><img alt="" src="/assets/img/banner/menu-img-4.jpg"></a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="blog-leftsidebar.html">博客</a>
                                    <ul class="submenu">
                                        <li>
                                            <a href="blog.html">blog page</a>
                                        </li>
                                        <li>
                                            <a href="blog-leftsidebar.html">blog left sidebar</a>
                                        </li>
                                        <li>
                                            <a href="blog-details.html">blog details</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="<?php echo \yii\helpers\Url::to(['page/about-us']);?>">关于我们</a></li>
                                <li><a href="<?php echo \yii\helpers\Url::to(['page/contact-us']);?>">联系我们</a></li>
                                <?php if(isset(\Yii::$app->session['user'])):?>
                                    <li><a href="<?php echo \yii\helpers\Url::to(['user/info']);?>" style="color:red;">
                                            <?php echo \Yii::$app->session['user']['username'];?>欢迎登录
                                        </a>，<a href="<?php echo \yii\helpers\Url::to(['login/logout']);?>" >
                                            退出登录
                                        </a></li>
                                <?php else:?>
                                    <li><a href="<?php echo \yii\helpers\Url::to(['login/login']);?>">登录</a></li>
                                <?php endif;?>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-8 col-sm-8 col-7">
                    <div class="search-login-cart-wrapper">
                        <div class="header-search same-style">
                            <button class="search-toggle">
                                <i class="icon-magnifier s-open"></i>
                                <i class="ti-close s-close"></i>
                            </button>
                            <div class="search-content">
                                <form action="#">
                                    <input type="text" placeholder="Search">
                                    <button>
                                        <i class="icon-magnifier"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    <script>
                        $(function(){
                            INFO_URL="<?php echo \yii\helpers\Url::to(['cart/cart-info']);?>"
                            $('#getInfo').click(function(){
                                $.get(INFO_URL,{},function(res){
                                    $('.shopping-cart-content').html(res);
                                },'html');
                            });
                        });
                    </script>
                        <div class="header-cart same-style">
                            <button class="icon-cart" id="getInfo">
                                <i class="icon-handbag"></i>
                                <span class="count-style" id="cart-count"><?php echo $this->params['cart_count'];?></span>
                            </button>
                            <div class="shopping-cart-content">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mobile-menu-area electro-menu d-md-block col-md-12 col-lg-12 col-12 d-lg-none d-xl-none">
                    <div class="mobile-menu">
                        <nav id="mobile-menu-active">
                            <ul class="menu-overflow">
                                <li><a href="#">HOME</a>
                                    <ul>
                                        <li><a href="index.html">home version 1</a></li>
                                        <li><a href="index-2.html">home version 2</a></li>
                                    </ul>
                                </li>
                                <li><a href="#">pages</a>
                                    <ul>
                                        <li>
                                            <a href="about-us.html">about us</a>
                                        </li>
                                        <li>
                                            <a href="shop-page.html">shop page</a>
                                        </li>
                                        <li>
                                            <a href="shop-list.html">shop list</a>
                                        </li>
                                        <li>
                                            <a href="product-details.html">product details</a>
                                        </li>
                                        <li>
                                            <a href="cart.html">cart page</a>
                                        </li>
                                        <li>
                                            <a href="checkout.html">checkout</a>
                                        </li>
                                        <li>
                                            <a href="wishlist.html">wishlist</a>
                                        </li>
                                        <li>
                                            <a href="contact.html">contact us</a>
                                        </li>
                                        <li>
                                            <a href="my-account.html">my account</a>
                                        </li>
                                        <li>
                                            <a href="login-register.html">login / register</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="#">Food</a>
                                    <ul>
                                        <li><a href="#">Dogs Food</a>
                                            <ul>
                                                <li><a href="shop-page.html">Grapes and Raisins</a></li>
                                                <li><a href="shop-page.html">Carrots</a></li>
                                                <li><a href="shop-page.html">Peanut Butter</a></li>
                                                <li><a href="shop-page.html">Salmon fishs</a></li>
                                                <li><a href="shop-page.html">Eggs</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#">Cats Food</a>
                                            <ul>
                                                <li><a href="shop-page.html">Meat</a></li>
                                                <li><a href="shop-page.html">Fish</a></li>
                                                <li><a href="shop-page.html">Eggs</a></li>
                                                <li><a href="shop-page.html">Veggies</a></li>
                                                <li><a href="shop-page.html">Cheese</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#">Fishs Food</a>
                                            <ul>
                                                <li><a href="shop-page.html">Rice</a></li>
                                                <li><a href="shop-page.html">Veggies</a></li>
                                                <li><a href="shop-page.html">Cheese</a></li>
                                                <li><a href="shop-page.html">wheat bran</a></li>
                                                <li><a href="shop-page.html">Cultivation</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="#">blog</a>
                                    <ul>
                                        <li>
                                            <a href="blog.html">blog page</a>
                                        </li>
                                        <li>
                                            <a href="blog-leftsidebar.html">blog left sidebar</a>
                                        </li>
                                        <li>
                                            <a href="blog-details.html">blog details</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="contact.html"> Contact us </a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<?php echo $content;?>

<footer class="footer-area">
    <div class="footer-top pt-80 pb-50 gray-bg-2">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                    <div class="footer-widget mb-30">
                        <div class="footer-info-wrapper">
                            <div class="footer-logo">
                                <a href="#">
                                    <img src="/assets/img/logo/logo-2.png" alt="">
                                </a>
                            </div>
                            <p>三斤宠物口粮是一家内容分享和宠物口粮贩卖一体化的平台。</p>
                            <p>主要提供不同种类宠物口粮的售卖以及高质量博客的分享。</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                    <div class="footer-widget mb-30 pl-50">
                        <h4 class="footer-title">友情链接</h4>
                        <div class="footer-content">
                            <ul>
                                <?php foreach($this->params['links'] as $link):?>
                                <li><a href="<?php echo $link->links;?>"><?php echo $link->title;?></a></li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-2 col-md-6 col-sm-6">
                    <div class="footer-widget mb-30 pl-70">
                        <h4 class="footer-title">帮助与支持</h4>
                        <div class="footer-content">
                            <ul>
                                <li><a href="#">Faq's </a></li>
                                <li><a href="#">Pricing Plans</a></li>
                                <li><a href="#">Order Traking</a></li>
                                <li><a href="#">Returns </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                    <div class="footer-widget">
                        <div class="newsletter-wrapper">
                            <p>订阅我们的站内最新消息，一有新动态，我们会通过邮件的方式发送给你。</p>
                            <div class="newsletter-style">
                                <div id="mc_embed_signup" class="subscribe-form">
                                    <form action="#" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                                        <div id="mc_embed_signup_scroll" class="mc-form">
                                            <input type="email" value="" name="EMAIL" class="email" placeholder="你的邮箱" required>
                                            <div class="clear"><input type="submit" value="SEND" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom gray-bg-3 pt-17 pb-15">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="copyright text-center">
                        <p>Copyright © <a href="http://www.17sucai.com/">Marten</a> All Right Reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="/assets/js/popper.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>
<script src="/assets/js/jquery.counterup.min.js"></script>
<script src="/assets/js/waypoints.min.js"></script>
<script src="/assets/js/elevetezoom.js"></script>
<script src="/assets/js/ajax-mail.js"></script>
<script src="/assets/js/owl.carousel.min.js"></script>
<script src="/assets/js/plugins.js"></script>
<script src="/assets/js/main.js"></script>
</body>
</html>

