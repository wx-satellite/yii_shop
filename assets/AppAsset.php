<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{


    //资源文件存放的目录（web可访问的目录）
    public $basePath = '@webroot'; //yii2定义的常用路径别名
    //web访问资源文件的url
    public $baseUrl = '@web';

    //设置需要加载的css文件
    public $css = [
        'css/site.css',
    ];

    //设置需要加载的js文件
    public $js = [
    ];

    //设置加载上述css和js时的依赖
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    //jsOptions：设置js加载的选项和cssOptions设置css加载的选项
    /*
     * public $cssOptions=[
     *      'noscript'=>true  ===> <noscript><link href='1.css' rel='stylesheet'/></noscript>
     * ]
     *
     *
     *
     * public $jsOptions=[
     *      'condition'=>'lte IE9',   只有在浏览器小于ie9时加载js
     *      'position'=>\yii\web\view::POS_HEAD   设置js的引入位置在头部
     * ]
     * */



    //按需加载
    /*
     * $this->registerJsFile('',[]) $this是视图对象不是资源包对象
     * $this->registerCssFile('',[])
     * $this->registerJs()
     * $this->registerCss()
     *
     * */



    //额外属性，当资源不放在web目录中时可以使用如下一组属性
    /*
     *  public $sourcePath=''  存放资源的目录
     *  public $publishOptions=['only'=>['css','fonts']]  //只加载目录下的css和js
     * */
}
