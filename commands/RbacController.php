<?php

namespace app\commands;
use yii\console\Controller;


class RbacController extends Controller{

    public function actionImport(){
        //substr('GoodsazsdcController.php',0,strpos('GoodsazsdcController.php','Controller.php'));
        $dir=dirname(__FILE__).'/../modules/admin/controllers/';
        $files=glob($dir.'*');
        $permissions=[];
        foreach ($files as $file){
            $filename=pathinfo($file,PATHINFO_BASENAME);
            $controller=strtolower(substr($filename,0,strpos($filename,'Controller.php')));
            $permissions[]=$controller.'/*';
            $content=file_get_contents($file);
            preg_match_all('/action(.*?)\(/',$content,$matches);
            foreach ($matches[1] as $match){
                $permissions[]=$controller.'/'.strtolower($match);
            }
        }
        $tran=\Yii::$app->db->beginTransaction();
        $auth=\Yii::$app->authManager;
        try{
           foreach ($permissions as $permission){
               if(!$auth->getPermission($permission)){
                   $p=$auth->createPermission($permission);
                   $p->description=$permission;
                   $auth->add($p);
               }
           }
           $tran->commit();
           echo "import success \n";
        }catch (\Exception $e){
            $tran->rollBack();
            echo "import fail \n";
        }
    }
}