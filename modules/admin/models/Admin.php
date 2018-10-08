<?php


namespace app\modules\admin\models;

use yii\db\ActiveRecord;

class Admin extends ActiveRecord{

    public $remember_me;
    public $repassword;
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
            ['password','checkPass','on'=>['login']],
            ['remember_me','boolean'],
            ['repassword','required','message'=>'请重复密码'],
            ['repassword','compare','compareAttribute'=>'password','message'=>'两次密码输入不一致']
        ];
    }
    public function scenarios()
    {
        return [
            'login'=>['email','password','remember_me'],
            'seek'=>['email'],
            'change_password'=>['password','repassword']
        ];
    }

    //校验密码
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
        return true;
    }
    //根据邮箱登录
    public function loginByEmail($post){
        $this->scenario='login';
        if($this->load($post) && $this->validate()){
            return true;
        }
        return false;
    }
    //找回密码
    public function seekPassword($post){
        $this->scenario='seek';
        if($this->load($post)&&$this->validate()){
            $this->sendSeekPasswordEmail($post['Admin']['email']);
        }
        return false;
    }

    //发送重置密码邮件
    protected function sendSeekPasswordEmail($email){
        $token = $this->saveEmailToCache($email);
        $mailer = \Yii::$app->mailer->compose('seekpassword', ['token' => $token]);
        $mailer->setFrom("15658283276@163.com");
        $mailer->setTo($email);
        $mailer->setSubject("找回密码");
        if ($mailer->send()) {
            //  与 \Yii::$app->session->setFlash('Success','发送邮件成功') 等效
            \Yii::$app->getSession()->setFlash('Success','发送邮件成功');
            return true;
        }
        \Yii::$app->getSession()->setFlash('Error','发送邮件失败');
        return false;
    }

    //将邮箱存入缓存
    protected function saveEmailToCache($value){
        //获取token
        $key = $this->getToken($value);
        $cache = \Yii::$app->cache;
        //将token作为键，邮箱值作为值，存入缓存
        $cache->set($key,$value,\Yii::$app->getModule('admin')->params['cache_expire_time']);
        return $key;
    }

    protected function getToken($email){
        $token = md5(md5($email).\Yii::$app->request->userIP).md5(time());
        return $token;
    }

    //修改密码逻辑
    public function changePassword($token,$post){
        $this->scenario='change_password';
        if($this->load($post) && $this->validate()){
            $email = \Yii::$app->cache->get($token);
            if(!$email){
                \Yii::$app->getSession()->setFlash('Error','重置链接已经失效，请重新发送邮件');
                return false;
            }
            self::updateAll(['password'=>md5($this->password)],'email=:email',[':email'=>$email]);
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