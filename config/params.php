<?php
require_once '../models/Order.php';
return [
    'adminEmail' => 'admin@example.com',
    'session_expire_time'=>24*60*60,
    'cache_expire_time'=>10*60,
    'cart_expire_time'=>30*24*60*60,
    'pay_type'=>[
        '1'=>'支付宝'
    ],
    'post_type'=>[
        '1'=>['name'=>'包邮','price'=>0.00],
        '2'=>['name'=>'顺丰','price'=>12.00],

    ],
    'order_status'=>[
        \app\models\Order::NOT_PAY=>'未支付',
        \app\models\Order::NOT_POST=>'已支付，准备发货',
        \app\models\Order::POST=>'已发货',
        \app\models\Order::RECEIVER=>'已签收',
        \app\models\Order::CANCEL=>'已取消',
        \app\models\Order::DELETE=>'已删除'
    ]
];
