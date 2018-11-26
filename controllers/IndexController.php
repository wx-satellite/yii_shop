<?php


namespace app\controllers;
use app\modules\admin\models\Goods;
use app\modules\admin\models\Article;
class IndexController extends BaseController {



    public $layout='template';
    public function actionIndex(){
        $goods = Goods::find()
            ->where(['status'=>1,'is_on_sale'=>1])
            ->orderBy(['create_time'=>SORT_DESC])
            ->all();
        $articles=Article::getRecentArticles(3);
        return $this->render('index',compact('goods','articles'));
    }

    public function actionError(){
        var_dump(\Yii::$app->errorHandler->exception);
    }

}