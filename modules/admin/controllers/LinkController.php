<?php


namespace app\modules\admin\controllers;
use app\modules\admin\models\Links;
use yii\data\Pagination;
class LinkController extends CommonController{

    public function actionList(){
        $query=Links::find()->where('status!=:status',[':status'=>-1])->orderBy(['create_time'=>SORT_DESC]);
        $count=$query->count();
        $pager=new Pagination(['totalCount'=>$count,'pageSize'=>\Yii::$app->getModule('admin')->params['pagesize']]);
        $links=$query->offset($pager->offset)->limit($pager->limit)->all();
        return $this->render('list',compact('pager','links'));
    }


    //添加链接
    public function actionAdd(){
        $model= new Links();
        if(\Yii::$app->request->isPost){
            $post=\Yii::$app->request->post();
            if($model->addLinks($post)){
                $this->redirect(['link/list']);
                \Yii::$app->end();
            }
        }
        return $this->render('add',compact('model'));
    }

    //修改链接的状态
    public function actionChangeStatus(){
        $link=$this->getLinkById();
        //if-esle可以考虑使用三元运算符优化
        $link->status=$link->status==0?1:0;
        try{
            $link->save(false);
            \Yii::$app->getSession()->setFlash('Success','更新链接状态成功');
        }catch(\Exception $e){
            \Yii::$app->getSession()->setFlash('Error','更新链接状态失败');
        }
        $this->redirect(['link/list']);
        \Yii::$app->end();
    }

    //删除链接
    public function actionDelete(){
        $link=$this->getLinkById();
        try{
            $link->status=-1;
            $link->save(false);
            \Yii::$app->getSession()->setFlash('Success','删除链接成功');
        }catch(\Exception $e){
            \Yii::$app->getSession()->setFlash('Error','删除链接失败');
        }
        $this->redirect(['link/list']);
        \Yii::$app->end();
    }


    //编辑链接
    public function actionEdit(){
        $model=$this->getLinkById();
        if(\Yii::$app->request->isPost){
            $post=\Yii::$app->request->post();
            if($model->editLink($post)){
                $this->redirect(['link/list']);
                \Yii::$app->end();
            }
        }
        return $this->render('edit',compact('model'));
    }

    //判断传入的id是否合法
    protected function getLinkById(){
        $link=Links::find()->where('status!=:status',[':status'=>-1])
            ->andWhere(['id'=>\Yii::$app->request->get('id')])->one();
        if(!$link){
            \Yii::$app->getSession()->setFlash('Error','参数错误');
            $this->redirect(['link/list']);
            \Yii::$app->end();
        }
        return $link;
    }
}