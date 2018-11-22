<?php


namespace app\modules\admin\controllers;

use yii\web\Controller;

class CommonController extends Controller{

    public $layout='main';


    //检测当前用户是否有访问权限
    public function beforeAction($action)
    {
        //先调用一个父类的，如果返回false就没必要继续了
        //注意init中是获取不到\Yii::$app->controller->action
        if(!parent::beforeAction($action)){
            return false;
        }
        $controller=$action->controller->id;
        $action=$action->id;
        if(\Yii::$app->admin->can($controller.'/*')){
            return true;
        }
        if(\Yii::$app->admin->can($controller.'/'.$action)){
            return true;
        }
        if(\Yii::$app->request->isAjax){
            echo json_encode(['errorCode'=>1,'msg'=>'对不起，您没有权限访问～']);exit;
        }else{
            $refer=\Yii::$app->request->referrer;
            echo "<script>alert('对不起，您没有权限访问～');window.location.href='{$refer}';</script>";exit;
        }
    }

    //判断传入的id是否合法
    protected function getModelById(){
        //将类的命名空间赋值给一个变量$class,再通过new $class的方式实例化
        $class = '\app\modules\admin\models\\'.\Yii::$app->controller->id;
        $class = new $class();
        $model=$class->find()->where('status!=:status',[':status'=>-1])
            ->andWhere(['id'=>\Yii::$app->request->get('id')])->one();
        if(!$model){
            \Yii::$app->getSession()->setFlash('Error','参数错误');
            $this->redirect([\Yii::$app->controller->id.'/'.'list']);
            \Yii::$app->end();
        }
        return $model;
    }

    //post参数获取
    public function post($name,$default=''){
        return \Yii::$app->request->post($name,$default);
    }
    //get参数获取
    public function get($name,$default=''){
        return \Yii::$app->request->get($name,$default);
    }

    //修改前端显示状态
    public function actionChangeStatus(){
        $model=$this->getModelById();
        //if-esle可以考虑使用三元运算符优化
        $model->status=$model->status==0?1:0;
        try{
            $model->save(false);
            \Yii::$app->getSession()->setFlash('Success','更新前端显示状态成功');
        }catch(\Exception $e){
            \Yii::$app->getSession()->setFlash('Error','更新前端显示状态失败');
        }
        $this->redirect([\Yii::$app->controller->id.'/'.'list']);
        \Yii::$app->end();
    }

    //删除记录
    public function actionDelete(){
        $model=$this->getModelById();
        try{
            $model->status=-1;
            $model->save(false);
            \Yii::$app->getSession()->setFlash('Success','删除记录成功');
        }catch(\Exception $e){
            \Yii::$app->getSession()->setFlash('Error','删除记录失败');
        }
        $this->redirect([\Yii::$app->controller->id.'/'.'list']);
        \Yii::$app->end();
    }
}