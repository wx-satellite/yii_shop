<?php


namespace  app\modules\admin\controllers;
use app\models\User;
use yii\data\Pagination;
class UserController extends CommonController{

    public $mustLogin=['list'];
    public function actionList(){
        $query=User::find()->orderBy(['create_time'=>SORT_DESC]);
        $count=$query->count();
        $pager = new Pagination(['totalCount'=>$count,'pageSize'=>\Yii::$app->getModule('admin')->params['pagesize']]);
        $users = $query->offset($pager->offset)->limit($pager->limit)->all();
        return $this->render('list',compact('pager','users'));
    }
}