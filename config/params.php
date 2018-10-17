<?php

return [
    'adminEmail' => 'admin@example.com',
    'session_expire_time'=>24*60*60,
    'cache_expire_time'=>10*60,
    'cart_expire_time'=>30*24*60*60,
    'pay_type'=>[
        '1'=>'支付宝'
    ],
    'post_type'=>[
        '1'=>['name'=>'自送','price'=>0.00],
        '2'=>['name'=>'申通','price'=>10.00],
        '3'=>['name'=>'顺丰','price'=>12.00],

    ],
    'order_status'=>[
        '0'=>'未支付',
        '1'=>'已支付，准备发货',
        '2'=>'已经发货',
        '3'=>'收货成功'
    ]
];
