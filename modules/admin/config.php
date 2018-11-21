<?php


return [
//
//    'layoutPath'=>'',
    'params' => [
        'session_life_time'=>24*60*60,
        'cache_expire_time'=>10*60,
        'pagesize'=>10,
        //七牛云图片样式
        'QN_SMALL'=>'-small',
        'QN_SMALLER'=>'-samller',
        'QN_MIDDLE'=>'-middle',
        'QN_BIG'=>'-big',
        'QN_BIGGER'=>'-bigger',
        'IS_SALE'=>[
            '0'=>'不促销',
            '1'=>'促销中'
        ],
        'IS_ON_SALE'=>[
            '0'=>'<span style="color:red">下架中</span>',
            '1'=>'<span style="color:green">上架中</span>'
        ],
        'CATEGORY_TYPE'=>[
            '1'=>'狗粮',
            '2'=>'猫粮',
            '3'=>'鱼粮'
        ],
        'USER_STATUS'=>[
            '0'=>'<a href="javascript:void(0);" class="btn btn-yellow">未激活</a>',
            '1'=>'<a href="javascript:void(0);" class="btn btn-palegreen">正常</a>'
        ]
    ],


];