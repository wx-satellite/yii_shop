<?php


namespace app\controllers;
use app\modules\admin\models\Goods;
use app\services\SearchGoods;
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
        //获取商品
        list($pager,$goods)=Goods::getGoods();
        return $this->render('list',compact('pager','goods'));
    }


    public function actionSearch(){
        $hightlight=[
            "pre_tags"=>['<span class="highlight">'],
            "post_tags"=>['</span>'],
            "fields"=>[
                "name"=>new \stdClass(),
                'descr'=>new \stdClass()
            ]
        ];
        $key=\Yii::$app->request->get('keyword');
        $res=SearchGoods::find()->query([
            'multi_match'=>[
                'query'=>$key,
                "fields"=>['name','descr']
            ]
        ])->highlight($hightlight)->all();
        return $this->render('search',compact('res'));
    }
}