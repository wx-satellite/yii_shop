<?php


namespace app\controllers;
use yii\web\Controller;
use app\modules\admin\models\Category;
use app\modules\admin\models\Link;
use app\models\Cart;
class BaseController extends Controller{
    public $layout='template';
    //public function init(){}  控制器对象实例化的时候会调用这个方法，从名字中也可以看出是初始化方法。注意和构造函数的区别

    //$this->view->params[] 等价于 \Yii::$app->view->params[] 这种方式的赋值，可以在模板文件和布局文件中访问
    //而使用$this->render('',compact())这种方式的赋值，只能在模板文件中使用
    //注意在模板文件或者是布局文件中$this不是控制器对象而是视图对象
    public function init()
    {
        $category = new Category();
        if(!$cates=\Yii::$app->cache->get('cates')){

            $cates = $category->getCategorys();
            \Yii::$app->cache->set('cates',$cates,\Yii::$app->params['redis_cache_expire']);
        }
        \Yii::$app->view->params['cates']=$cates;
        $this->getCartGoodsCount();
        $this->getLinks();
    }


    //获取购物车信息，如果用户登陆了就从数据库中取出，反之从cookie中去
    public function getCartGoodsCount(){
        $model = new Cart();
        $carts = $model->getCartInfo();
        $cart_count = 0;
        //如果$carts为空则不会进入循环
        foreach ($carts as $cart){
            $cart_count+=$cart['count'];
        }
        $this->view->params['cart_count']=$cart_count;
    }

    //获取底部友情链接
    public function getLinks(){
        if(!$links=\Yii::$app->cache->get('links')){
            $links = Link::find()->where(['status'=>1])->orderBy(['create_time'=>SORT_DESC])->all();
            $res=[];
            foreach ($links as $link){
                $res[]=$link->toArray();
            }
            $links=$res;
            \Yii::$app->cache->set('links',$links,\Yii::$app->params['redis_cache_expire']);
        }
        $this->view->params['links']=$links;
    }



}