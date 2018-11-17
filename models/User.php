<?php


namespace app\models;
use yii\db\ActiveRecord;

class User extends ActiveRecord implements \yii\web\IdentityInterface{
    public $remember_me;
    public $repassword;
    public $account;

    public static function findIdentity($id)
    {
        return self::find()->where(['status'=>1,'id'=>$id])->one();
    }

    public  function getId(){
        return $this->id;
    }

    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }
    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }




    public static function tableName()
    {
       return "{{%user}}";
    }

    public function rules()
    {
        return [
            ['username','required','message'=>'请填写用户名'],
            ['email','required','message'=>'请填写邮箱'],
            ['email','email','message'=>'无效邮箱'],
            ['password','required','message'=>'请填写密码'],
            ['password','string','min'=>6],
            ['repassword','required','message'=>'请重复密码'],
            ['repassword','compare','compareAttribute'=>'password','message'=>'两次密码不一致'],
            ['username','unique','message'=>'该用户名已经存在'],
            ['email','unique','on'=>['register','change-email'],'message'=>'该邮箱已经存在'],
            ['account','required','message'=>'请填写用户名或者邮箱'],
            ['password','checkPassword','on'=>'login'],
            ['email','checkEmail','on'=>'seek-password']
        ];
    }

    public function scenarios()
    {
        return [
            'register'=>['username','email','password','repassword'],
            'login'=>['account','password','remember_me'],
            'seek-password'=>['email'],
            'change-password'=>['password','repassword'],
            'change-email'=>['email']
        ];
    }
    public static function checkUserLoginIn(){
        if(\Yii::$app->user->isGuest){
            return false;
        }
        return true;
    }
    //声明关联
    public function getProfile(){
        return $this->hasOne(UserProfile::className(),['uid'=>'id']);
    }

    //修改邮箱
    public function changeEmail($post){
        $this->scenario='change-email';
        if($this->load($post)&&$this->validate()){
            try{
                self::updateAll(['email'=>$this->email],'id=:id',[':id'=>\Yii::$app->user->id]);
                \Yii::$app->session->setFlash('Success','修改邮箱成功');
                return true;
            }catch(\Exception $e){
                \Yii::$app->session->setFlash('Error','修改邮箱失败，请重试');
                return false;
            }
        }else{
            \Yii::$app->session->setFlash('Error','修改邮箱失败，请按要求填写邮箱');
            return false;
        }
    }

    //重置密码
    public function changePassword($post,$token){
        $this->scenario='change-password';
        if($token){
            //有token表示通过邮件的方式重置密码
            if($this->load($post) && $this->validate()){
                $email = \Yii::$app->cache->get($token);
                if(!$email){
                    \Yii::$app->getSession()->setFlash('Error','重置链接已经失效，请重新发送');
                    return false;
                }
                try{
                    self::updateAll(['password'=>md5($this->password)],'email=:email',[':email'=>$email]);
                    \Yii::$app->cache->delete($email);
                    \Yii::$app->cache->delete($token);
                    \Yii::$app->getSession()->setFlash('Success','密码重置成功，赶紧登陆吧');
                    return true;
                }catch(\Exception $e){
                    \Yii::$app->getSession()->setFlash('Error','重置密码失败，请重试');
                    return false;
                }
            }
        }else{
            if($this->load($post) && $this->validate()){
                //没有token表示通过个人主页的方式重置密码
                try{
                    self::updateAll(['password'=>md5($this->password)],'id=:id',[':id'=>\Yii::$app->user->id]);
                    \Yii::$app->getSession()->setFlash('Success','重置密码成功');
                    return true;
                }catch(\Exception $e){
                    \Yii::$app->getSession()->setFlash('Error','重置密码失败，请重试');
                    return false;
                }
            }else{
                \Yii::$app->getSession()->setFlash('Error','重置密码失败，请按要求填写密码');
                return false;
            }
        }

    }

    //发送重置密码邮件时，检验邮箱
    public function checkEmail(){
        if(!$this->hasErrors()){
            $user = self::find()->where('email=:email',[':email'=>$this->email])->one();
            if(!$user){
                $this->addError('email','该邮箱尚未注册本平台');
                return;
            }
            if(0===(int)$user->status){
                $this->addError('email','该邮箱对应的账号尚未激活');
                return;
            }
        }

    }
    public function sendResetPasswordEmail($post){
        $this->scenario='seek-password';
        if($this->load($post)&&$this->validate()){
            //邮箱信息正确，发送邮件
            $token = md5(md5($this->email).\Yii::$app->request->userIp).md5(time());
            $cache = \Yii::$app->cache;
            if($cache->get($this->email)){
                \Yii::$app->getSession()->setFlash('Error','重置邮件已经发送，请在十分钟之后重试');
                return false;
            }
            $mailer = \Yii::$app->mailer->compose('seekpassword',['token'=>$token,'url'=>'login/change-password']);
            $mailer->setFrom('15658283276@163.com');
            $mailer->setTo($this->email);
            $mailer->setSubject('重置密码邮件');
            try{
                if(!$mailer->pushMailToRedis()){
                    \Yii::$app->getSession()->setFlash('Error','发送邮件异常，请稍后重试');
                    return false;
                }
                $cache->set($this->email,$this->email,\Yii::$app->params['cache_expire_time']);
                $cache->set($token,$this->email,\Yii::$app->params['cache_expire_time']);
                \Yii::$app->getSession()->setFlash('Success','重置密码邮件已经发送，注意查收');
                return true;
            }catch(\Exception $e){
                \Yii::$app->getSession()->setFlash('Error','发送邮件异常，请稍后重试');
                return false;
            }
        }
    }
    //验证密码
    public function checkPassword(){
        if(!$this->hasErrors()){
            $account=$this->account;
            $user=self::find()->where('username=:username',[':username'=>$account])
                ->orWhere('email=:email',[':email'=>$account])
                ->one();
            if(!$user){
                $this->addError('account','用户名或者邮箱不存在');
                return;
            }
            //本案例中status只有两种状态：0表示未激活1表示激活，不考虑-1删除的状态
            if(0===(int)$user->status){
                $this->addError('account','当前用户名或者邮箱未激活，请查看激活邮件');
                return;
            }
            if($user->password!==md5($this->password)){
                $this->addError('password','用户名或者邮箱或者密码错误');
                return;
            }


            //说明账号和密码正确，将用户信息存入session
//            $this->saveUserInfoToSession($user);

            //使用user组件
            \Yii::$app->user->login($user,(bool)$this->remember_me?\Yii::$app->params['session_expire_time']:0);


            //更新登录时间和ip地址
            $this->updateLoginTimeAndIp($user);
            //将cookie中的购物车信息存入数据库并清空cookie
            $this->cartInfoSaveToDb();
            \Yii::$app->getSession()->setFlash('Success',$user->username.'你好，欢迎回来!');
        }
    }

    //这个函数循环操作了数据库，可以考虑如何优化
    protected  function cartInfoSaveToDb(){
        $cart = isset($_COOKIE['cart'])?unserialize($_COOKIE['cart']):[];
        if(!$cart){
            return true;
        }
        $uid = \Yii::$app->user->id;
        try{
            foreach($cart as $k=>$v){
                $c = Cart::find()->where(['goods_id'=>$k,'uid'=>$uid,'status'=>1])->one();
                if($c){
                    $c->count+=$v;
                    $c->save(false);
                }else{
                    $c=new Cart();
                    $c->goods_id=$k;
                    $c->count=$v;
                    $c->uid=$uid;
                    $c->save(false);
                }
            }
            setcookie('cart',serialize([]),\Yii::$app->params['cart_expire_time'],'/');
            return true;
        }catch(\Exception $e){
            return false;
        }
    }
    protected function saveUserInfoToSession($user){
        $expire_time = (bool)$this->remember_me?\Yii::$app->params['session_expire_time']:0;
        $session=\Yii::$app->session;
        setcookie(session_name(),session_id(),$expire_time?time()+$expire_time:$expire_time,'/');
        $session['user']=[
            'uid'=>$user->id,
            'username'=>$user->username
        ];
    }
    protected function updateLoginTimeAndIp($user){
        self::updateAll(['last_login_time'=>date('Y-m-d H:i:s'),'loginip'=>ip2long(\Yii::$app->request->userIP)],
            'id=:id',[':id'=>$user->id]);
        return true;
    }

    //用户登录
    public function loginUser($post){
        $this->scenario='login';
        if($this->load($post)&&$this->validate()){
            return true;
        }
        return false;
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
            $this->password=md5($this->password);
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