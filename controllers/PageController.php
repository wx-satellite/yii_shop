<?php

namespace app\controllers;


class PageController extends BaseController {

    public $layout='template';

    //关于我们
    public function actionAboutUs(){
        return $this->render('about');
    }

    //联系我们
    public function actionContactUs(){
        return $this->render('contact');
    }
}