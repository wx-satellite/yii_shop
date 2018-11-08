<?php

use app\assets\AdminAsset;
use yii\widgets\Breadcrumbs;
AdminAsset::register($this);
?>
<?php $this->beginPage();?>
<!DOCTYPE html>
<html lang="<?php echo \Yii::$app->language;?>"><head>
    <meta charset="<?php echo \Yii::$app->charset;?>">
    <title><?php echo $this->title;?>-后台管理</title>
    <?php
        $this->registerMetaTag(['name'=>'description','content'=>'三斤宠物口粮管理后台']);
        $this->registerMetaTag(['name'=>'viewport','content'=>'width=device-width, initial-scale=1.0']);
        $this->registerMetaTag(['http-equiv'=>'X-UA-Compatible','content'=>'IE=edge']);
        $this->registerMetaTag(['http-equiv'=>'Content-Type','content'=>'text/html; charset=UTF-8']);
    ?>

    <!--Basic Styles-->
    <?php $this->head();?>
</head>
<body>
<?php $this->beginBody();?>
<!-- 头部 -->
<div class="navbar">
    <div class="navbar-inner">
        <div class="navbar-container">
            <!-- Navbar Barnd -->
            <div class="navbar-header pull-left">
                <a href="#" class="navbar-brand">
                    <small>
                        <img src="/img/logo/logo.png" alt="">
                    </small>
                </a>
            </div>
            <!-- /Navbar Barnd -->
            <!-- Sidebar Collapse -->
            <div class="sidebar-collapse" id="sidebar-collapse">
                <i class="collapse-icon fa fa-bars"></i>
            </div>
            <!-- /Sidebar Collapse -->
            <!-- Account Area and Settings -->
            <div class="navbar-header pull-right">
                <div class="navbar-account">
                    <ul class="account-area">
                        <li>
                            <a class="login-area dropdown-toggle" data-toggle="dropdown">
                                <div class="avatar" title="View your public profile">
                                    <img src="/admin/images/header.jpg">
                                </div>
                                <section>
                                    <h2><span class="profile"><span>admin</span></span></h2>
                                </section>
                            </a>
                            <!--Login Area Dropdown-->
                            <ul class="pull-right dropdown-menu dropdown-arrow dropdown-login-area">
                                <li class="username"><a>David Stevenson</a></li>
                                <li class="dropdown-footer">
                                    <a href="<?php echo \yii\helpers\Url::to(['login/logout']);?>">
                                        退出登录
                                    </a>
                                </li>
<!--                                <li class="dropdown-footer">-->
<!--                                    <a href="/admin/user/changePwd.html">-->
<!--                                        修改密码-->
<!--                                    </a>-->
<!--                                </li>-->
                            </ul>
                            <!--/Login Area Dropdown-->
                        </li>
                        <!-- /Account Area -->
                        <!--Note: notice that setting div must start right after account area list.
                            no space must be between these elements-->
                        <!-- Settings -->
                    </ul>
                </div>
            </div>
            <!-- /Account Area and Settings -->
        </div>
    </div>
</div>

<!-- /头部 -->

<div class="main-container container-fluid">
    <div class="page-container">
        <!-- Page Sidebar -->
        <div class="page-sidebar" id="sidebar">
            <!-- Page Sidebar Header-->
            <div class="sidebar-header-wrapper">
                <input class="searchinput" type="text">
                <i class="searchicon fa fa-search"></i>
                <div class="searchhelper">Search Reports, Charts, Emails or Notifications</div>
            </div>
            <!-- /Page Sidebar Header -->
            <!-- Sidebar Menu -->
            <ul class="nav sidebar-menu">
                <!--Dashboard-->
                <li>
                    <a href="#" class="menu-dropdown">
                        <i class="menu-icon fa fa-user"></i>
                        <span class="menu-text">管理员管理</span>
                        <i class="menu-expand"></i>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="<?php echo \yii\helpers\Url::to(['manager/list']);?>">
                                    <span class="menu-text">
                                        管理员列表                                    </span>
                                <i class="menu-expand"></i>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="menu-dropdown">
                        <i class="menu-icon fa fa-user"></i>
                        <span class="menu-text">用户管理</span>
                        <i class="menu-expand"></i>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="<?php echo \yii\helpers\Url::to(['user/list']);?>">
                                    <span class="menu-text">
                                        用户列表                                    </span>
                                <i class="menu-expand"></i>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="menu-dropdown">
                        <i class="menu-icon fa fa-tags"></i>
                        <span class="menu-text">分类管理</span>
                        <i class="menu-expand"></i>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="<?php echo \yii\helpers\Url::to(['category/list']);?>">
                                    <span class="menu-text">
                                        分类列表                                    </span>
                                <i class="menu-expand"></i>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="menu-dropdown">
                        <i class="menu-icon fa fa-shopping-cart"></i>
                        <span class="menu-text">商品管理</span>
                        <i class="menu-expand"></i>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="<?php echo \yii\helpers\Url::to(['goods/list']);?>">
                                    <span class="menu-text">
                                        商品列表                                    </span>
                                <i class="menu-expand"></i>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="menu-dropdown">
                        <i class="menu-icon fa  fa-list-alt"></i>
                        <span class="menu-text">订单管理</span>
                        <i class="menu-expand"></i>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="<?php echo \yii\helpers\Url::to(['order/list']);?>">
                                    <span class="menu-text">
                                        订单列表                                   </span>
                                <i class="menu-expand"></i>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="menu-dropdown">
                        <i class="menu-icon fa  fa-book"></i>
                        <span class="menu-text">文章管理</span>
                        <i class="menu-expand"></i>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="<?php echo \yii\helpers\Url::to(['tag/list']);?>">
                                    <span class="menu-text">
                                        标签列表                                   </span>
                                <i class="menu-expand"></i>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo \yii\helpers\Url::to(['article/list']);?>">
                                    <span class="menu-text">
                                        文章列表                                   </span>
                                <i class="menu-expand"></i>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="menu-dropdown">
                        <i class="menu-icon fa  fa-chain"></i>
                        <span class="menu-text">链接管理</span>
                        <i class="menu-expand"></i>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="<?php echo \yii\helpers\Url::to(['link/list']);?>">
                                    <span class="menu-text">
                                        友情链接                                   </span>
                                <i class="menu-expand"></i>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#" class="menu-dropdown">
                        <i class="menu-icon fa fa-gear"></i>
                        <span class="menu-text">系统设置</span>
                        <i class="menu-expand"></i>
                    </a>
                </li>

            </ul>
            <!-- /Sidebar Menu -->
        </div>
        <!-- /Page Sidebar -->
        <!-- Page Content -->
        <div class="page-content">
            <div class="page-breadcrumbs">
                <?php echo Breadcrumbs::widget([
                        'homeLink'=>['label'=>'首页','url'=>['/admin/index/index']],
                        'links'=>isset($this->params['breadcrumbs'])?$this->params['breadcrumbs']:[],
                ]);?>
            </div>
            <?php echo $content;?>
        </div>
    <!-- /Page Content -->
</div>
</div>

<!--Basic Scripts-->




<?php $this->endBody();?>
</body></html>
<?php $this->endPage();?>