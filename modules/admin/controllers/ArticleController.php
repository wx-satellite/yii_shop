<?php

namespace app\modules\admin\controllers;


class ArticleController extends CommonController{

    public $layout='main';

    public function actionList(){
        return $this->render('list');
    }

    public function actionAdd(){
        return $this->render('add');
    }
}