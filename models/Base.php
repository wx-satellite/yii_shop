<?php


namespace app\models;

use app\common\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
class Base extends ActiveRecord{

    public function behaviors()
    {
        return [
            [
                'class'=>TimestampBehavior::className(),
                'onCreate'=>['create_time','update_time'],
                'onUpdate'=>['update_time'],
                'value'=>function(){
                    return date('Y-m-d H:i:s');
                }
            ],
        ];
    }
}