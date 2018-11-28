<?php


namespace app\modules\admin\models;

use yii\db\ActiveRecord;
use app\common\behaviors\TimestampBehavior;

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