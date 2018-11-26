
<div class="breadcrumb-area pt-95 pb-95 bg-img" style="background-image:url(/img/banner/banner-2.jpg);">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <h2>Contact Us</h2>
            <ul>
                <li><a href="<?php echo \yii\helpers\Url::to(['index/index']);?>">首页</a></li>
                <li class="active">联系我们</li>
            </ul>
        </div>
    </div>
</div>
<div class="contact-area pt-100 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-12">
                <div class="contact-info-wrapper text-center mb-30">
                    <div class="contact-info-icon">
                        <i class="ti-location-pin"></i>
                    </div>
                    <div class="contact-info-content">
                        <h4>我们的地址</h4>
                        <p>浙江省杭州市余杭区梦想小镇</p>
                        <p><a href="#">1453085314@qq.com</a></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="contact-info-wrapper text-center mb-30">
                    <div class="contact-info-icon">
                        <i class="ti-mobile"></i>
                    </div>
                    <div class="contact-info-content">
                        <h4>联系方式</h4>
                        <p>电话: 012 345 678</p>
                        <p>传真: 123 456 789</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="contact-info-wrapper text-center mb-30">
                    <div class="contact-info-icon">
                        <i class="ti-email"></i>
                    </div>
                    <div class="contact-info-content">
                        <h4>邮件地址</h4>
                        <p><a href="#">1453085314@qq.com</a></p>
                        <p><a href="#">1453085314@qq.com</a></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="contact-message-wrapper">
                    <h4 class="contact-title">发一封邮件</h4>
                    <div class="contact-message">
                        <form id="contact-form" action="assets/mail.php" method="post">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="contact-form-style mb-20">
                                        <input name="name" placeholder="姓名" type="text">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="contact-form-style mb-20">
                                        <input name="email" placeholder="你的邮件地址" type="email">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="contact-form-style mb-20">
                                        <input name="subject" placeholder="主题" type="text">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="contact-form-style">
                                        <textarea name="message" placeholder="说点什么吧～"></textarea>
                                        <button class="submit btn-style" type="submit">发送</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <p class="form-messege"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="contact-map">
            <div id="map"></div>
        </div>
    </div>
</div>

