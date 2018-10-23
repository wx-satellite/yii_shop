<?php

namespace app\controllers;
use app\modules\admin\models\Article;
class ArticleController extends BaseController{

    public function actionList(){
        return $this->render('list');
    }

    public function actionDetail(){
        $article=$this->checkArticleId();
        //获取内容中第一张图片作为封面
        preg_match_all('/src="(.+?)"/',$article->content,$arr);
        $cover = empty($arr[0])?'暂无封面图':$arr[0][0];
        return $this->render('detail',compact('article','cover'));
    }

    protected function checkArticleId(){
        $article=Article::find()->where(['status'=>1,'id'=>\Yii::$app->request->get('id')])->one();
        if(!$article){
            \Yii::$app->session->setFlash('Error','你想要查看的文章不存在');
            $this->redirect(['article/list']);
            \Yii::$app->end();
        }
        return $article;
    }

    public function actionByTag(){
        return $this->render('list');
    }
}