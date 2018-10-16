<?php

namespace app\models;

use yii\db\ActiveRecord;
use app\modules\admin\models\Goods;

class Cart extends  ActiveRecord{


    public function rules()
    {
        return [
            ['goods_id','required','message'=>'缺少商品唯一标识'],
            ['goods_id','integer','message'=>'商品唯一标识格式错误'],
            ['count','required','message'=>'缺少购买数量'],
            ['count','integer','message'=>'购买数量格式错误'],
            ['goods_id','checkGoodsId'],
        ];
    }
    public function checkGoodsId(){
        if(!$this->hasErrors()){
            $goods = Goods::find()->where(['status'=>1,'id'=>$this->goods_id])->one();
            if(!$goods){
                $this->addError('goods_id','该商品不存在');
                return;
            }
        }
    }


    public function scenarios()
    {
        return [
            'create'=>['goods_id','count']
        ];
    }

    public static  function tableName(){
        return "{{%cart}}";
    }

    public function deleteGoodsFromCart($flag,$goods_id){
        if(!in_array($flag,['one','all'])){
            return false;
        }
        if(User::checkUserLoginIn()){
            if('one'===$flag){
                try{
                    //删除单条记录
                    self::updateAll(['status'=>-1],['goods_id'=>$goods_id,'uid'=>\Yii::$app->session['user']['uid']]);
                    return true;
                }catch (\Exception $e){
                    return false;
                }
            }elseif('all'===$flag){
                try{
                    //删除单条记录
                    self::updateAll(['status'=>-1],['uid'=>\Yii::$app->session['user']['uid']]);
                    return true;
                }catch (\Exception $e){
                    return false;
                }
            }
        }else{
            $cart = isset($_COOKIE['cart'])?unserialize($_COOKIE['cart']):[];
            if(!$cart){
                return true;
            }
            if('one'===$flag){
                if(isset($cart[$goods_id])){
                    unset($cart[$goods_id]);
                }
            }elseif('all'===$flag){
                $cart=[];
            }
            setcookie('cart',serialize($cart),time()+\Yii::$app->params['cart_expire_time']);
            return true;
        }
    }

    //添加购物车----购物车的结构： $cart[商品ID]=商品购买的数量
    public function addGoodsToCart($post){
        $this->scenario='create';
        if($this->load($post)&&$this->validate()){
            $goods = Goods::find()->where(['status'=>1,'id'=>$this->goods_id])->one();
            if(User::checkUserLoginIn()){
                //如果用户登陆了，将数据添加到数据库
                try{
                    $uid = \Yii::$app->session['user']['uid'];
                    $cart = self::find()->where(['status'=>1,'uid'=>$uid,'goods_id'=>$this->goods_id])->one();
                    if($cart){
                        $cart->count=$this->count+$cart->count;
                        if($cart->count<1) $cart->count=1;
                        if($cart->count>$goods->stock) return ['success'=>0,'message'=>'超过库存量了','count'=>''];
                        $cart->save(false);
                    }else{
                        $this->uid=$uid;
                        if($this->count<1)$this->count=1;
                        if($this->count>$goods->stock) return ['success'=>0,'message'=>'超过库存量了','count'=>''];
                        $this->save(false);
                    }
                    return ['success'=>1,'message'=>'添加购物车成功','count'=>$this->count];
                }catch(\Exception $e){
                    return ['success'=>0,'message'=>'数据库异常，添加购物车失败','count'=>''];
                }
            }else{
                //如果用户未登陆将数据添加到cookie
                $cart = isset($_COOKIE['cart'])?unserialize($_COOKIE['cart']):[];
                if(!$cart){
                    $cart[$this->goods_id]=$this->count;
                }else{
                    if(isset($cart[$this->goods_id])){
                        $cart[$this->goods_id]+=$this->count;
                        if($cart[$this->goods_id]<1)$cart[$this->goods_id]=1;
                        if($cart[$this->goods_id]>$goods->stock) return ['success'=>0,'message'=>'超过库存量了','count'=>''];
                    }else{
                        if($this->count<1)$this->count=1;
                        if($this->count>$goods->stock) return ['success'=>0,'message'=>'超过库存量了','count'=>''];
                        $cart[$this->goods_id]=$this->count;
                    }
                }
                setcookie('cart',serialize($cart),time()+\Yii::$app->params['cart_expire_time']);
                return ['success'=>1,'message'=>'添加购物车成功','count'=>$this->count];
            }
        }else{
            return ['success'=>0,'message'=>'参数不正确或者库存不足','count'=>''];
        }
    }

    //获取购物车详情
    public function getCartInfo(){
        if(User::checkUserLoginIn()){
            //如果用户登陆，从数据库中取出
            $res = self::find()->select('goods_id,count')->where(['status'=>1,'uid'=>\Yii::$app->session['user']['uid']])->all();
            if(!$res){
                return [];
            }else{
                foreach ($res as $c){
                    $cart[$c['goods_id']]=$c['count'];
                }
            }
        }else{
            //未登陆从cookie中取
            $cart = isset($_COOKIE['cart'])?unserialize($_COOKIE['cart']):[];
            if(!$cart){
                return [];
            }
        }
        $res=[];
        $goods=Goods::find()->select('id,name,price,is_sale,sale_price,picture')->where(['in','id',array_keys($cart)])->andWhere(['status'=>1])->all();
        foreach($goods as $g){
            $g = $g->toArray();
            $g['count']=$cart[$g['id']];
            //如果在促销就是促销价，否则就是商品价
            $g['current_price']=$g['is_sale']?$g['sale_price']:$g['price'];
            $res[]=$g;
        }
        return $res;
    }
}