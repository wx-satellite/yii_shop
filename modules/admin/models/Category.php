<?php

namespace app\modules\admin\models;


class Category extends Base{


    const TOP_CATEGORY=0;

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


    public function getTree($type){
        $where = ['status'=>1];
        if('all'!==$type){
            $where['type']=$type;
        }
        $data = self::find()->where($where)->orderBy(['create_time'=>SORT_DESC])->all();
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
            $res[$cate['id']]=str_repeat('|---',$cate['level']).$cate['title'].'  <--'.\Yii::$app->getModule('admin')->params['CATEGORY_TYPE'][$cate['type']];
        }
        return $res;
    }

    //获取分类用于前端显示，暂时只获取顶级分类
    public function getCategorys(){
        $cates =  self::find()
            ->where(['status'=>1,'pid'=>self::TOP_CATEGORY])
            ->orderBy(['create_time'=>SORT_DESC])
            ->all();
        $res=[];
        foreach ($cates as $k=>$cate){
            $res[$cate['type']][]=$cate->toArray();
        }
        return $res;
    }
}