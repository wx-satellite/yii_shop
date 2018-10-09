<?php


namespace app\models;
use yii\db\ActiveRecord;


class User extends ActiveRecord{

    public $remember_me;
    public $repassword;

    public static function tableName()
    {
       return "{{%user}}";
    }

    public function rules()
    {
        return [
            ['username','required','message'=>'请填写用户名'],
            ['email','required','message'=>'请填写邮箱'],
            ['password','required','message'=>'请填写密码'],
            ['password','string','min'=>6],
            ['repassword','required','message'=>'请重复密码'],
            ['repassword','compare','compareAttribute'=>'password','message'=>'两次密码不一致'],
            ['username','unique','message'=>'该用户名已经存在'],
            ['email','unique','message'=>'该邮箱已经存在']
        ];
    }

    public function scenarios()
    {
       return [
           'register'=>['username','email','password','repassword']
       ];
    }

    //根据邮箱激活用户
    public function activeUser($token,$email){
        if(!self::updateAll(['status'=>1],'email=:email',[':email'=>$email])){
            \Yii::$app->getSession()->setFlash('Error','激活用户失败，请稍后再试');
            return false;
        }
        \Yii::$app->getSession()->setFlash('Success','激活用户成功，赶紧登陆吧');
        //删除缓存
        \Yii::$app->cache->delete($token);
        return true;
    }

    //用户注册
    public function userRegister($post){
        $this->scenario='register';
        if($this->load($post) && $this->validate()){
            if($this->save(false)){
                //记录添加成功，发送邮件激活
                return $this->sendActiveEmail('active',$this->email);
            }
        }
    }

    protected function sendActiveEmail($compose,$email){
        $key = $this->getToken($email);
        if(\Yii::$app->cache->get($key)){
            \Yii::$app->getSession()->setFlash('Error','激活邮件已经发送了，不能重复发送');
            return true;
        }
        return $this->sendEmail($compose,$email,$key);
    }

    //这里需要注意：
    //1.邮件发送成功之后再将token写入缓存，如果先写入缓存再发送邮件会出现bug
    //2.邮件发送异常需要把用户信息删除，方便重新注册重新发送激活邮件
    protected function sendEmail($compose,$email,$token){
        $mailer = \Yii::$app->mailer->compose($compose,['token'=>$token]);
        $mailer->setFrom('15658283276@163.com');
        $mailer->setTo($email);
        $mailer->setSubject('账号激活');
        try{
            if(!$mailer->send()){
                \Yii::$app->getSession()->setFlash('Error','发送激活邮件失败，请重试');
                //删除记录
                self::deleteAll('email=:email',[':email'=>$email]);
                return false;
            }
        }catch(\Exception $e){
            \Yii::$app->getSession()->setFlash('Error','发送邮件异常，请稍后重试');
            self::deleteAll('email=:email',[':email'=>$email]);
            return false;
        }
        //将邮箱写入缓存，用于激活用户
        $this->saveEmailToCache($token,$email);
        //提示信息
        \Yii::$app->getSession()->setFlash('Success','发送激活邮件成功，注意查收');
        return true;

    }

    //将邮箱存入缓存
    protected function saveEmailToCache($key,$value){
        $cache = \Yii::$app->cache;
        //将token作为键，邮箱值作为值，存入缓存
        $cache->set($key,$value,0);
        return $key;
    }

    protected function getToken($email){
        $token = md5($email).md5(\Yii::$app->params['ak']);
        return $token;
    }


}