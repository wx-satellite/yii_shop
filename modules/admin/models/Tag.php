<?php

namespace app\modules\admin\models;
use yii\db\ActiveRecord;


class Tag extends ActiveRecord{
    const SHOW=1;
    const HIDDEN=0;
    public static function tableName()
    {
        return "{{%tag}}";
    }

    public function rules()
    {
        return [
            ['name','required','message'=>'请填写标签名称'],
            ['name','unique','message'=>'该标签名称已经存在'],
            ['name','string','max'=>30]
        ];
    }

    public function scenarios()
    {
        return [
            'create'=>['name'],
            'update'=>['name']
        ];
    }


    public function addTag($post){
        $this->scenario='create';
        if($this->load($post)&&$this->validate()){
            try{
                $this->save(false);
                \Yii::$app->getSession()->setFlash('Success','添加标签成功');
                return true;
            }catch (\Exception $e){
                \Yii::$app->getSession()->setFlash('Error','添加标签失败，请重试');
                return false;
            }
        }
    }

    public function editTag($post){
        $this->scenario='update';
        if($this->load($post)&&$this->validate()){
            try{
                $this->save(false);
                \Yii::$app->getSession()->setFlash('Success','修改标签成功');
                return true;
            }catch (\Exception $e){
                \Yii::$app->getSession()->setFlash('Error','修改标签失败，请重试');
                return false;
            }
        }
    }

    public static function getTags(){
        $res=self::find()->where('status!=:status',[':status'=>-1])
            ->orderBy(['create_time'=>SORT_DESC])->all();
        $arr=[];
        $arr['']='请选择标签';
        foreach ($res as $k){
            $arr[$k['id']]=$k['name'];
        }
        return $arr;
    }
}