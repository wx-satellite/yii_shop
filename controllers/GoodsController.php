<?php


namespace app\controllers;
use app\modules\admin\models\Goods;
class GoodsController extends BaseController{

    public $layout='template';


    public function actionDetail(){
        $goods = Goods::find()->where(['status'=>1,'id'=>\Yii::$app->request->get('id')])->one();
        if(!$goods){
            $this->redirect(['index/index']);
            \Yii::$app->end();
        }
        return $this->render('detail',compact('goods'));
    }


    public function actionList(){
        return $this->render('list');
    }
}