<?php

namespace app\modules\admin\models;
class Link extends Base{


    public static function tableName()
    {
        return "{{%links}}";
    }


    public function rules()
    {
        return [
            ['title','required','message'=>'请填写链接名称'],
            ['title','unique','message'=>'该链接名称已经存在了'],
            ['title','string','max'=>30],
            ['links','required','message'=>'请填写链接地址'],
            ['links','url','message'=>'链接格式不正确']
        ];
    }

    public function scenarios()
    {
        return [
            'create'=>['title','links'],
            'update'=>['title','links']
        ];
    }

    public function addLinks($post){
        $this->scenario='create';
        if($this->load($post) && $this->validate()){
            try{
                $this->save(false);
                \Yii::$app->getSession()->setFlash('Success','添加链接成功');
                return true;
            }catch(\Exception $e){
                \Yii::$app->getSession()->setFlash('Error','添加链接失败');
                return false;
            }
        }
    }


    public function editLink($post){
        $this->scenario='update';
        if($this->load($post) && $this->validate()){
            try{
                $this->save(false);
                \Yii::$app->getSession()->setFlash('Success','修改链接成功');
                return true;
            }catch(\Exception $e){
                \Yii::$app->getSession()->setFlash('Error','修改链接失败');
                return false;
            }
        }
    }

}