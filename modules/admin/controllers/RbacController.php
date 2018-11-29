<?php


namespace app\modules\admin\controllers;


use yii\db\Query;
use yii\data\ActiveDataProvider;
use app\modules\admin\servers\RbacServer;
//角色和权限都是存储在auth_item表中，通过type的值来区分，type=1表示角色，type为2表示权限
class RbacController extends CommonController{
    public $mustLogin=['role-list','create-role','rule-list','create-rule','assign-item'];
    //角色列表
    public function actionRoleList(){
        $auth=\Yii::$app->authManager;
        $query=(new Query())->from($auth->itemTable)->where(['type'=>1])->orderBy(['created_at'=>SORT_DESC]);
        $data=new ActiveDataProvider([
            'query'=>$query,
            'pagination'=>[
                'pageSize'=>\Yii::$app->getModule('admin')->params['pagesize']
            ],
            //gridview中columns中的attribute是用来做排序和搜索的
            'sort'=>['attributes'=>['created_at']]
        ]);
        return $this->render('role-list',compact('data'));
    }

    //创建角色
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

    protected function checkItem(){
        $name=$this->get('name');
        $item=\Yii::$app->authManager->getRole($name);
        if(!$item){
            \Yii::$app->session->setFlash('Error','该角色不存在～');
            \Yii::$app->end();
        }
        return $item;
    }

    //分配权限（可以给当前角色分配权限，也可以分配子角色）
    public function actionAssignItem(){
        $item=$this->checkItem();
        if(\Yii::$app->request->isPost){
            $children=\Yii::$app->request->post('children');
            RbacServer::addChildren($children,$item);
        }
        $auth=\Yii::$app->authManager;
        $roles=$auth->getRoles();
        $permissions=$auth->getPermissions();
        $roles=RbacServer::makeCheckboxValue($roles,$item);
        $permissions=RbacServer::makeCheckboxValue($permissions,$item);
        list($current_roles,$current_permissions)=RbacServer::getCurrentPermissions($item);
        return $this->render('assign-item',compact('item','roles','permissions','current_roles','current_permissions'));
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

    //规则列表
    public function actionRuleList(){
        $query=(new Query())->from(\Yii::$app->authManager->ruleTable)->orderBy(['created_at'=>SORT_DESC]);
        $data=new ActiveDataProvider([
            'query'=>$query,
            'pagination'=>[
                'pageSize'=>\Yii::$app->getModule('admin')->params['pagesize']
            ]
        ]);
        return $this->render('rule-list',compact('data'));
    }

    //创建规则
    public function actionCreateRule(){
        if(\Yii::$app->request->isPost){
            if(RbacServer::addRule()){
                $this->redirect(['rbac/rule-list']);
                \Yii::$app->end();
            }
        }
        return $this->render('create-rule');
    }
}