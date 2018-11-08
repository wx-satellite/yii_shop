<?php


namespace app\controllers;
use app\modules\admin\models\Goods;
class IndexController extends BaseController {

    public $layout='template';
    public function actionIndex(){

        $goods = Goods::find()
            ->where(['status'=>1,'is_on_sale'=>1])
            ->orderBy(['create_time'=>SORT_DESC])
            ->all();
        return $this->render('index',compact('goods'));
    }

    public function actionError(){
        return 404;
    }
}