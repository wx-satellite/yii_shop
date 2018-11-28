<?php

namespace app\models;
use app\modules\admin\models\Goods;
class Order extends Base{
    const NOT_PAY=0; //订单生成时的默认状态
    const NOT_POST=1;   //订单支付完成但还未发货
    const POST=2; //订单已经发货
    const RECEIVER=3;   //已经收到
    const CANCEL=4; //取消订单
    const DELETE=-1;//删除订单

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
            ['pay_type','checkPayType'],
            ['post_number','required','message'=>'请填写订单号'],
            ['post_number','checkNumber']
        ];
    }
    public function checkNumber(){
        if(!$this->hasErrors()){
            if(!preg_match('/^\d+$/',$this->post_number)){
                $this->addError('post_number','快递单号格式错误');
                return;
            }
        }

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
            'create'=>['receiver','tel','address','post_type','pay_type'],
            'send'=>['post_number']
        ];
    }
    //后台设置发货
    public function postOrder($post){
        $this->scenario='send';
        if($this->load($post) && $this->validate()){
            $this->status=self::POST;
            try{
                $this->save(false);
                return true;
            }catch(\Exception $e){
                \Yii::$app->getSession()->setFlash('Error','设置订单号失败，请重试');
                return false;
            }

        }
    }

    //与用户表关联
    public function getUserInfo(){
        return $this->hasOne(User::className(),['id'=>'uid']);
    }

    public function getOrderDetail(){
        return OrderDetail::find()->select('goods_name,goods_price,goods_count')->where(['status'=>1,'order_id'=>$this->id])->all();
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
        Cart::updateAll(['status'=>-1],['uid'=>\Yii::$app->user->id]);
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
            //运费
            $this->post_price = \Yii::$app->params['post_type'][$this->post_type]['price'];
            $goods_price=0;
            $goods=[];
            $order_name='';
            foreach($cart as $k=>$c){
                $goods[]=[$c['id'],$c['name'],$c['picture'],$c['current_price'],$c['count']];
                $goods_price+=$c['current_price']*$c['count'];
                if($k<=2){
                    $order_name.=$c['name'].',';
                }
            }
            $this->order_name=trim($order_name,',').'等商品';
            $this->goods_total_price=$goods_price;
            $this->order_total_price=$goods_price+$this->post_price;
            $this->orderno=$this->build_order_no();
            $this->uid = \Yii::$app->user->id;
            try{
                $trans = \Yii::$app->db->beginTransaction();
                $this->save(false);
                foreach($goods as $k=>$g){
                    //将订单id存入数组中
                    $goods[$k][]=$this->id;
                }
                \Yii::$app->db->createCommand()->batchInsert('order_detail',
                    ['goods_id','goods_name','goods_picture','goods_price','goods_count','order_id'],$goods)->execute();
                //修改库存量
                $this->changeGoodsStock($cart);
                //删除购物车数据表中的数据
                $this->deleteCart();
                $trans->commit();
                return $this->orderno;
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