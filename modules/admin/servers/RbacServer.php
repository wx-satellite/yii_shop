<?php


namespace app\modules\admin\servers;


class RbacServer{

    //构建复选框数据
    public static function makeCheckboxValue($items,$current){
        $res=[];
        foreach ($items as $item){
            if($current->name!=$item->name && \Yii::$app->authManager->canAddChild($current,$item)){
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
}