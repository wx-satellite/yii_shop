<?php

namespace app\modules\admin\models;
use yii\db\ActiveRecord;


class Category extends ActiveRecord{

    public static function tableName(){
        return "{{%category}}";
    }

    public function rules()
    {
        return [
            ['title','required','message'=>'请填写分类名称'],
            ['title','string','max'=>30],
            ['title','unique','message'=>'该分类名称已经存在啦'],
            ['pid','required','message'=>'请选择上级分类'],
            ['pid','integer','message'=>'上级分类参数不正确'],
            ['type','required','message'=>'请选择类型'],
            ['type','integer','message'=>'类型参数不正确']
        ];
    }

    public function scenarios(){
        return [
            'create'=>['title','pid','type']
        ];
    }
    public function addCategory($post){
        $this->scenario='create';
        if($this->load($post) && $this->validate()){
            try{
                $this->save(false);
                \Yii::$app->getSession()->setFlash('Success','添加分类成功');
                return true;
            }catch(\Exception $e){
                \Yii::$app->getSession()->setFlash('Error','添加分类失败');
                return false;
            }
        }
    }


    public function getTree(){
        $data = self::find()->where('status=:status',[':status'=>1])->orderBy(['create_time'=>SORT_DESC])->all();
        $data = \yii\helpers\ArrayHelper::toArray($data);
        return $this->makeTree($data);
    }

    //生成树形结构
    protected function makeTree($data,$pid=0,$level=1){
        $res=[];
        foreach ($data as $cate) {
            if($cate['pid']==$pid){
                $cate['level']=$level;
                $res[]=$cate;
                $res=array_merge($res,$this->makeTree($data,$cate['id'],$level+1));
            }
        }
        return $res;
    }

    //将树形的cates转成一维数组
    public function changeCatesArray($cates,$flag=true){
        if($flag){
            $res=[''=>'请选择上级分类','0'=>'顶级分类'];
        }else{
            $res=[''=>'请选择分类'];
        }
        foreach($cates as $cate){
            $res[$cate['id']]=str_repeat('|---',$cate['level']).$cate['title'];
        }
        return $res;
    }
}