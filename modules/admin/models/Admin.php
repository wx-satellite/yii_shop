<?php


namespace app\modules\admin\models;

use yii\db\ActiveRecord;

class Admin extends ActiveRecord{

    public $remember_me;
    public static function tableName()
    {
        return '{{%admin}}';
    }

    public function rules()
    {
        return [
            ['email','required','message'=>'请填写邮箱'],
            ['password','required','message'=>'请填写密码'],
            ['email','email','message'=>'邮箱格式不正确'],
//            ['password','checkLength']
            ['password','string','min'=>6,'max'=>32],
            ['password','checkPass'],
            ['remember_me','boolean']
        ];
    }
//    public function scenarios()
//    {
//        return [
//            'login'=>['email','password','remember_me']
//        ];
//    }

    public function checkPass($attr,$params){
        if(!$this->hasErrors()){
            $admin=self::find()
                    ->where('email=:email and password=:password',[':email'=>$this->email,':password'=>md5($this->password)])
                    ->one();
            if(empty($admin)){
                $this->addError('password','用户名或者密码错误');
                return;
            }
            //将用户信息存入session
            $this->saveAdminInfoToSession($admin);
            //更新登录时间与登录ip
            $this->updateAdminLoginTimeAndIp($admin);
        }

    }
    protected function saveAdminInfoToSession($admin){
        $lifetime=$this->remember_me?\Yii::$app->getModule('admin')->params['session_life_time']:0;
        $session=\Yii::$app->session;
        session_set_cookie_params($lifetime);
        $session['admin']=[
            'uid'=>$admin->id,
            'username'=>$admin->username
        ];
    }
    protected function updateAdminLoginTimeAndIp($admin){
        self::updateAll(['last_login_time'=>date('Y-m-d H:i:s'),'loginip'=>ip2long(\Yii::$app->request->userIP)],
            'id=:id',[':id'=>$admin->id]
            );
    }
    public function loginByEmail($post){
        if($this->load($post) && $this->validate()){
            return true;
        }
        return false;
    }
//    public function checkLength($attr,$params){
//        if(strlen($this->$attr)<6){
//            $this->addError($attr,'密码不能少于6位');
//        }
//        if(strlen($this->$attr)>20){
//            $this->addError($attr,'密码不能多于20位');
//        }
//        return true;
//    }





}