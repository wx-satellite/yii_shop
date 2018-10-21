<?php

namespace app\assets;

use yii\web\AssetBundle;


class AdminAsset extends AssetBundle{

    //资源文件存放的目录（web可访问的目录）
    public $basePath = '@webroot'; //yii2定义的常用路径别名
    //web访问资源文件的url
    public $baseUrl = '@web';

    //设置需要加载的css文件
    public $css = [
        'admin/css/bootstrap.css',
        'admin/css/font-awesome.css',
        'admin/css/weather-icons.css',
        'admin/css/beyond.css',
        'admin/css/demo.css',
        'admin/css/typicons.css',
        'admin/css/animate.css',
    ];

    //设置需要加载的js文件
    public $js = [
        ['admin/js/jquery_002.js'],
        ['admin/js/bootstrap.js'],
        'admin/js/beyond.js'
    ];

    //设置加载上述css和js时的依赖
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}