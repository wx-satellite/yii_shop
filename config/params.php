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
        '1'=>['name'=>'自送','price'=>10.00],
        '2'=>['name'=>'顺丰','price'=>12.00]
    ]
];
