<?php


namespace app\modules\admin;
use yii\base\Module;

class Admin extends Module{

    public function init(){
        parent::init();
        \Yii::configure($this, require __DIR__ . '/config.php');
    }
}