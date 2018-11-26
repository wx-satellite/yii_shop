<?php

namespace app\controllers;
use yii\web\Controller;
use app\models\Cart;

class CartController extends  BaseController {

    public $layout='template';


    public function actionAdd(){
        if(\Yii::$app->request->isAjax){
            $post = \Yii::$app->request->post();
            $model = new Cart();
            $res = $model->addGoodsToCart($post);
            return $this->asJson($res);
        }
    }

    public function  actionDetail(){
        $model = new Cart();
        $carts = $model->getCartInfo();
        return $this->render('detail',compact('carts'));
    }

    public function actionDelete(){
        if(\Yii::$app->request->isAjax){
            $flag = \Yii::$app->request->post('flag');
            $goods_id = \Yii::$app->request->post('id');
            if(!$flag||!in_array($flag,['one','all'])){
                return $this->asJson(['success'=>0,'message'=>'参数错误']);
            }
            if(('one'===(string)$flag &&(int)$goods_id)||'all'===(string)$flag){
                $model=new Cart();
                $res = $model->deleteGoodsFromCart($flag,$goods_id);
                $res=$res?['success'=>1,'message'=>'删除商品成功']:['success'=>0,'message'=>'删除商品失败'];
                return $this->asJson($res);
            }

        }
    }

    //返回购物车简要信息
    public function actionCartInfo(){
        if(\Yii::$app->request->isAjax){
            $model =  new Cart();
            $carts= $model->getCartInfo();
            if($carts){
                $html='<ul>';
                $count=0;
                $sum=0;
                $url=\yii\helpers\Url::to(['cart/detail']);
                foreach($carts as $cart){
                    $html.='<li class="single-shopping-cart"><div class="shopping-cart-img"><a href="'.\yii\helpers\Url::to(['goods/detail','id'=>$cart['id']]).'"><img alt="" src="';
                    $html.=$cart['picture'].\Yii::$app->getModule('admin')->params['QN_SMALL'];
                    $html.='"></a></div><div class="shopping-cart-title" style="margin-left: 20px;"><h4><a href="'.\yii\helpers\Url::to(['goods/detail','id'=>$cart['id']]).'">'.$cart['name']."</a></h4>";
                    $html.='<h6>数量:&nbsp;&nbsp;'.$cart['count'].'</h6>';
                    $html.='<span>单价:&nbsp;&nbsp;'.sprintf('%.2f',$cart['current_price']).'&nbsp;RMB</span>';
                    $html.='</div></li>';
                    $count+=$cart['count'];
                    $sum+=$cart['current_price']*$cart['count'];
                }
                $html.='</ul>';
                $html.='<div class="shopping-cart-total"><h4>总件数 : <span>'.$count.'</span></h4>';
                $html.='<h4>总价 : <span class="shop-total">RMB:&nbsp;&nbsp;'.sprintf('%.2f',$sum).'</span></h4></div>';
                $html.='<div class="shopping-cart-btn"><a href="'.$url.'">查看购物车</a></div>';
                return $html;
            }else{
                return '<div style="text-align: center;padding-bottom: 21px;">购物车暂无商品。</div>';
            }

        }
    }

}