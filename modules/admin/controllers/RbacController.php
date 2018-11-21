<?php


namespace app\modules\admin\controllers;


use yii\db\Query;
use yii\data\ActiveDataProvider;
class RbacController extends CommonController{

    public function actionRoleList(){
        $auth=\Yii::$app->authManager;
        $query=(new Query())->from($auth->itemTable)->where(['type'=>1])->orderBy(['created_at'=>SORT_DESC]);
        $data=new ActiveDataProvider([
            'query'=>$query,
            'pagination'=>[
                'pageSize'=>\Yii::$app->getModule('admin')->params['pagesize']
            ],
            'sort'=>['attributes'=>['created_at']]
        ]);
        return $this->render('role-list',compact('data'));
    }

    public function actionCreateRole(){
        $old=[];
        if(\Yii::$app->request->isPost){
            $old=\Yii::$app->request->post();
            if($data=$this->checkRolePost()){
                //创建角色
                $auth=\Yii::$app->authManager;
                $role=$auth->createRole(null);
                $role->description=$data['description'];
                $role->name=$data['name'];
                $role->ruleName=$data['rule_name'];
                $role->data=$data['data'];
                try{
                    \Yii::$app->authManager->add($role);
                    \Yii::$app->session->setFlash('Success','创建角色成功～');
                    $this->redirect(['rbac/role-list']);
                    \Yii::$app->end();

                }catch (\Exception $e){
                    \Yii::$app->session->setFlash('Error',$e->getMessage());
                }

            }
        }
        return $this->render('create-role',compact('old'));
    }


    protected function checkRolePost(){
        $name=$this->post('name');
        $description=$this->post('description');
        if(empty($name)||empty($description)){
            \Yii::$app->session->setFlash('Error','名称或者标识不能为空～');
            return false;
        }
        return [
            'name'=>$name,
            'description'=>$description,
            'rule_name'=>$this->post('rule_name')?:null,
            'data'=>$this->post('data')?:null
        ];
    }
}