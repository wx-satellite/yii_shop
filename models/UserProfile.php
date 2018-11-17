<?php

namespace app\models;
use yii\db\ActiveRecord;


class UserProfile extends ActiveRecord{

    public static function tableName(){
        return "{{%user_profile}}";
    }

    public function rules(){
        return [
            ['first_name','string','max'=>30],
            ['last_name','string','max'=>30],
            ['address','string','max'=>255],
            ['phone','checkPhone'],
            ['sex','integer']
        ];
    }

    public function scenarios()
    {
        return [
            'update'=>['first_name','last_name','address','phone','sex']
        ];
    }

    public function checkPhone(){
        if(!$this->hasErrors()){
            //如果填了手机号
            if($this->phone){
                if(!preg_match("/^1[34578]\d{9}$/", $this->phone)){
                    $this->addError('phone','手机号格式不正确');
                    return;
                }
            }
        }
    }

    //更新用户的基本信息
    public function updateUserProfile($post){
        $this->scenario='update';
        if($this->load($post) && $this->validate()){
            //不存在uid说明是第一次填写基本信息属于新增操作
            //存在uid说明是更新操作
            if(!isset($this->uid)){
                $this->uid=\Yii::$app->user->id;
            }
            try{
                $this->save(false);
                \Yii::$app->getSession()->setFlash('Success','更新用户基本信息成功');
                return true;
            }catch(\Exception $e){
                \Yii::$app->getSession()->setFlash('Error','更新用户基本信息失败，请重试');
                return false;
            }
        }

    }
}