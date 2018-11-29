<?php

namespace app\modules\admin\controllers;
use app\modules\admin\models\Admin;
use yii\data\Pagination;
use app\modules\admin\servers\RbacServer;
class ManagerController extends CommonController {

    public $mustLogin=['list','add','delete','grant'];

    public function actionList(){
        $query = Admin::find()->orderBy(['create_time'=>SORT_ASC])->where(['status'=>1]);
        $count = $query->count();
        $pager = new Pagination(['totalCount'=>$count,'pageSize'=>\Yii::$app->getModule('admin')->params['pagesize']]);
        $managers = $query->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render('list',compact('managers','pager'));
    }



    public function actionAdd(){
        $model = new Admin();
        if(\Yii::$app->request->isPost){
            $post = \Yii::$app->request->post();
            if($model->addManager($post)){
                //重定向的目的是为了清空表单的数据
                $this->redirect(['manager/add']);
                \Yii::$app->end();
            }
        }
        return $this->render('add',compact('model'));
    }


    public function actionDelete(){
        $id = (int)\Yii::$app->request->get('id');
        if(!$id){
            \Yii::$app->getSession()->setFlash('error','参数错误');
            $this->redirect(['manager/list']);
            \Yii::$app->end();
        }
        $model = new Admin();
        $model->deleteAdminById($id);
        $this->redirect(['manager/list']);
        \Yii::$app->end();
    }
    protected function checkId(){
        $id=$this->get('id');
        $admin=Admin::find()->where(['status'=>1,'id'=>$id])->one();
        if(empty($admin)){
            \Yii::$app->session->setFlash('Error','该管理员不存在～');
            $this->redirect(['manager/list']);
            \Yii::$app->end();
        }
        return $admin;
    }
    //分配角色和权限
    public function actionGrant(){
        $admin=$this->checkId();
        if(\Yii::$app->request->isPost){
            $children=\Yii::$app->request->post('children');
            RbacServer::grant($admin,$children);
        }
        $roles=RbacServer::makeCheckboxValue(\Yii::$app->authManager->getRoles(),null);
        $permissions=RbacServer::makeCheckboxValue(\Yii::$app->authManager->getPermissions(),null);
        list($current_roles,$current_permissions)=RbacServer::getGrantInfo($admin);
        return $this->render('grant',compact('admin','roles','permissions','current_roles','current_permissions'));
    }
}