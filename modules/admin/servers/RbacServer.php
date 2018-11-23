<?php


namespace app\modules\admin\servers;


class RbacServer{

    //构建复选框数据
    public static function makeCheckboxValue($items,$current){
        $res=[];
        foreach ($items as $item){
            if(!empty($current)&&$current->name!=$item->name && \Yii::$app->authManager->canAddChild($current,$item)){
                $res[$item->name]=$item->description;
            }
            if(empty($current)){
                $res[$item->name]=$item->description;
            }
        }
        return $res;
    }


    //分配权限
    public static function addChildren($children,$current){
        if(empty($children)){
            \Yii::$app->session->setFlash('Error','请至少勾选一个权限～');
            return false;
        }
        $auth=\Yii::$app->authManager;
        $tran=\Yii::$app->db->beginTransaction();
        try{
            //首先删除当前的所有权限
            $auth->removeChildren($current);
            foreach ($children as $k=>$child){
                $item=$auth->getRole($child);
                $item=$item?:$auth->getPermission($child);
                if(empty($item)){
                    \Yii::$app->session->setFlash('Error','权限参数存在错误～');
                    return false;
                }
                $auth->addChild($current,$item);
            }
            $tran->commit();
            \Yii::$app->session->setFlash('Success','添加权限成功～');
            return true;
        }catch (\Exception $e){
            $tran->rollBack();
            \Yii::$app->session->setFlash('Error','添加权限失败～');
            return true;
        }
    }

    //获取当前角色的权限
    public static function getCurrentPermissions($current){
        $auth=\Yii::$app->authManager;
        $permissions=$auth->getChildren($current->name);
        if(empty($permissions)){
            return [[],[]];
        }
        $roles=[];
        $p=[];
        foreach ($permissions as $permission){
            if($permission->type==1){
                $roles[]=$permission->name;
            }else if($permission->type==2){
                $p[]=$permission->name;
            }
        }
        return [$roles,$p];
    }

    //授权
    public static function grant($manager,$children){
        $auth=\Yii::$app->authManager;
        $trans=\Yii::$app->db->beginTransaction();
        try{
            //取消当前所有的授权
            $auth->revokeAll($manager->id);
            //授权
            foreach($children as $child){
                $item=$auth->getRole($child);
                $item=$item?:$auth->getPermission($child);
                if(empty($item)){
                    \Yii::$app->session->setFlash('Error','参数错误～');
                    return false;
                }
                $auth->assign($item,$manager->id);
            }
            $trans->commit();
            \Yii::$app->session->setFlash('Success','授权成功了～');
            return true;
        }catch (\Exception $e){
            $trans->rollBack();
            \Yii::$app->session->setFlash('Error','授权失败了～');
            return false;
        }

    }

    //根据类型获得对应的授权信息
    protected static function getRolesOrPermissionByAid($aid,$type=1){
        $auth=\Yii::$app->authManager;
        $func='getPermissionsByUser';
        if($type==2){
            $func='getRolesByUser';
        }
        $items = $auth->$func($aid);
        $res=[];
        foreach ($items as $item){
            $res[]=$item->name;
        }
        return $res;
    }
    //获取授权信息
    public static function getGrantInfo($admin){
        return [self::getRolesOrPermissionByAid($admin->id,2),self::getRolesOrPermissionByAid($admin->id)];
    }

    //添加规则
    public static function addRule(){
        $rule_name=\Yii::$app->request->post('rule_name');
        $data=\Yii::$app->request->post('data');
        if(empty($rule_name)){
            \Yii::$app->session->setFlash('Error','请填写规则类名称～');
            return false;
        }
        $class='app\\modules\\admin\\rules\\'.$rule_name;
        if(!class_exists($class)){
            \Yii::$app->session->setFlash('Error','该规则类不存在～');
            return false;
        }
        try{
            $rule=new $class();
            \Yii::$app->authManager->add($rule);
            \Yii::$app->session->setFlash('Success','添加规则成功～');
            return true;
        }catch (\Exception $e){
            \Yii::$app->session->setFlash('Error','添加规则失败～');
            return false;
        }
    }
}