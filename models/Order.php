<?php

namespace app\models;
use yii\db\ActiveRecord;
use app\modules\admin\models\Goods;
class Order extends ActiveRecord{

    public $receiver;
    public $tel;
    public $address;
    public static function tableName(){
        return "{{%order}}";
    }


    public function rules(){
        return [
            ['receiver','required','message'=>'请填写收货人姓名'],
            ['tel','required','message'=>'请填写收货人的手机号'],
            ['address','required','message'=>'请填写收货地址'],
            ['post_type','required','message'=>'请选择配送方式'],
            ['pay_type','required','message'=>'请选择支付方式'],
            ['post_type','checkPostType'],
            ['pay_type','checkPayType']
        ];
    }

    public function checkPostType(){
        if(!$this->hasErrors()){
            if(!in_array($this->post_type,array_keys(\Yii::$app->params['post_type']))){
                $this->addError('post_type','不支持该配送方式');
                return;
            }
        }

    }

    public function checkPayType(){
        if(!$this->hasErrors()){
            if(!in_array($this->post_type,array_keys(\Yii::$app->params['pay_type']))){
                $this->addError('post_type','不支持该支付方式');
                return;
            }
        }

    }


    public function scenarios()
    {
        return [
            'create'=>['receiver','tel','address','post_type','pay_type']
        ];
    }
    //生成订单号
    protected function build_order_no()
    {
        /* 选择一个随机的方案 */
        mt_srand((double) microtime() * 1000000);
        return date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
    }
    //修改商品的库存
    protected function changeGoodsStock($cart){
        foreach($cart as $c){
            Goods::updateAllCounters(['stock'=>-1*$c['count']],['id'=>$c['id']]);
        }
        return true;
    }
    //删除购物车表的数据
    protected function deleteCart(){
        Cart::updateAll(['status'=>-1],['uid'=>\Yii::$app->session['user']['uid']]);
        return true;
    }
    //检验库存量
    protected function checkStocks($goods_id,$count){
        $goods = Goods::find()->select('stock,name')->where(['id'=>$goods_id])->one();
        if(!$goods){
            \Yii::$app->session->setFlash('Error','下单失败，商品存在异常！');
            return false;
        }
        if($goods->stock<$count){
            \Yii::$app->session->setFlash('Error','商品：'.$goods->name.'，被别人买空了');
            return false;
        }
        return true;
    }
    public function placeOrder($post){
        $this->scenario='create';
        if($this->load($post)&&$this->validate()){
            $cart = (new Cart())->getCartInfo();
            if(!$cart){
                \Yii::$app->session->setFlash('Error','下单失败，你没有选择购买任何商品');
                return false;
            }
            //检验库存量
            foreach($cart as $k){
                if(!$this->checkStocks($k['id'],$k['count'])){
                    return false;
                }
            }
            $this->receiver_info=$this->recombine();
            $this->post_price = \Yii::$app->params['post_type'][$this->post_type]['price'];
            $goods_price=0;
            $goods=[];
            foreach($cart as $c){
                $goods[]=[$c['id'],$c['name'],$c['picture'],$c['current_price'],$c['count']];
                $goods_price+=$c['current_price']*$c['count'];
            }
            $this->goods_total_price=$goods_price;
            $this->order_total_price=$goods_price+$this->post_price;
            $this->orderno=$this->build_order_no();
            $this->uid = \Yii::$app->session['user']['uid'];
            try{
                $trans = \Yii::$app->db->beginTransaction();
                $this->save(false);
                foreach($goods as $k=>$g){
                    $goods[$k][]=$this->id;
                }
                \Yii::$app->db->createCommand()->batchInsert('order_detail',
                    ['goods_id','goods_name','goods_picture','goods_price','goods_count','order_id'],$goods)->execute();
                //修改库存量
                $this->changeGoodsStock($cart);
                //删除购物车数据表中的数据
                $this->deleteCart();
                $trans->commit();
                return $this->id;
            }catch(\Exception $e){
                if(\Yii::$app->db->getTransaction()){
                    $trans->rollBack();
                }
                \Yii::$app->session->setFlash('Error','创建订单失败，请稍后重试。');
                return false;
            }
        }
    }


    protected function recombine(){
        $receiver = $this->receiver;
        unset($this->receiver);
        $phone = $this->tel;
        unset($this->tel);
        $address = $this->address;
        unset($this->address);
        return serialize(['name'=>$receiver,'phone'=>$phone,'address'=>$address]);
    }
}