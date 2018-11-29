<?php


namespace app\modules\admin\controllers;
class IndexController extends CommonController {

    public $mustLogin=['index'];

    public function actionIndex(){
        return $this->render('index');
    }

    //    public function actionIndex1(){
    //        return '111';
    //    }
    //
    //    public function actionIndex2(){
    //        return '2222';
    //    }
}