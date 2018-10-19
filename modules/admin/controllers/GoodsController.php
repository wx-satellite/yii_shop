<?php

namespace app\modules\admin\controllers;
use yii\web\Controller;
use app\modules\admin\models\Goods;
use app\modules\admin\models\Category;
use yii\data\Pagination;
class GoodsController extends Controller{

    public $layout='main';



    //商品列表
    public function actionList(){
        $query = Goods::find()->orderBy(['create_time'=>SORT_DESC])->where('status=:status',[':status'=>1]);
        $count=$query->count();
        $pager = new Pagination(['totalCount'=>$count,'pageSize'=>\Yii::$app->getModule('admin')->params['pagesize']]);
        $goods = $query->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render('list',compact('goods','pager'));
    }

    //添加商品
    public function actionAdd(){
        $model=new Goods();
        if(\Yii::$app->request->isPost){
            $post=\Yii::$app->request->post();
            if($model->addGoods($post)){
                $this->redirect(['goods/list']);
                \Yii::$app->end();
            }
        }
        $cate=new Category();
        $cates=$cate->changeCatesArray($cate->getTree('all'),false);
        return $this->render('add',compact('model','cates'));
    }

    //改变上架状态
    public function actionChangeStatus(){
        $goods=$this->checkGoodsExistsById();
        $is_on_sale=0;
        if(Goods::IS_NOT_ON_SALE===(int)$goods->is_on_sale){
            $is_on_sale=1;
        }
        try{
            Goods::updateAll(['is_on_sale'=>$is_on_sale],'id=:id',[':id'=>$goods->id]);
            \Yii::$app->getSession()->setFlash('Success','修改上架状态成功');
        }catch(\Exception $e){
            \Yii::$app->getSession()->setFlash('Error','修改上架状态失败');
        }
        $this->redirect(['goods/list']);
        \Yii::$app->end();
    }

    //删除商品
    public function actionDelete(){
        $goods=$this->checkGoodsExistsById();
        $goods->deleteGoods();
        $this->redirect(['goods/list']);
        \Yii::$app->end();
    }

    //修改商品
    public function actionEdit(){
        $model=$this->checkGoodsExistsById();
        if(\Yii::$app->request->isPost){
            $post=\Yii::$app->request->post();
            $model->updateGoods($post);
        }
        $cate=new Category();
        $cates=$cate->changeCatesArray($cate->getTree('all'),false);
        return $this->render('edit',compact('model','cates'));
    }

    protected function checkGoodsExistsById(){
        $id = \Yii::$app->request->get('id');
        $goods = Goods::find()->where('id=:id and status!=-1',[':id'=>$id])->one();
        if(empty($goods)){
            \Yii::$app->getSession()->setFlash('Error','非法请求！');
            $this->redirect(['goods/list']);
            \Yii::$app->end();
        }
        return $goods;
    }

    //删除单个相册图片
    public function actionDeletePhoto(){
        $goods = $this->checkGoodsExistsById();
        $key = \Yii::$app->request->get('key');
        $goods->deleteGoodsPhoto($key);
        $this->redirect(['goods/edit','id'=>$goods->id]);
        \Yii::$app->end();

    }
}