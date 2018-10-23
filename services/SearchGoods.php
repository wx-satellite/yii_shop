<?php

namespace app\services;
use yii\elasticsearch\ActiveRecord;

class SearchGoods extends ActiveRecord{


    public function attributes()
    {
        return ['goods_id','name','descr','is_sale','price','sale_price','picture'];
    }


    public static function  index(){
        return 'yii';
    }


    public static function type(){
        return 'doc';
    }
}