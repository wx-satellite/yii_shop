<?php


namespace app\modules\admin\models;


class Admin extends Base implements \yii\web\IdentityInterface{

    public static function findIdentity($id)
    {
        return self::find()->where(['status'=>1,'id'=>$id])->one();
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function getId()
    {
        return $this->id;
    }
    public function validateAuthKey($authKey)
    {
        return $this->auth_key===$authKey;
    }


    public $remember_me;
    public $repassword;
    public static function tableName()
    {
        return '{{%admin}}';
    }

    public function rules()
    {
        return [
            ['username','required','message'=>'请填写用户名'],
            ['email','required','message'=>'请填写邮箱'],
            ['password','required','message'=>'请填写密码'],
            ['email','email','message'=>'邮箱格式不正确'],
            ['email','unique','on'=>'register','message'=>'该账号已经存在'],
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
            'change_password'=>['password','repassword'],
            'register'=>['email','password','username']
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
//            $this->saveAdminInfoToSession($admin);
            $lifetime=$this->remember_me?\Yii::$app->getModule('admin')->params['session_life_time']:0;
            \Yii::$app->admin->login($admin,$lifetime?:$lifetime);


            //更新登录时间与登录ip
            $this->updateAdminLoginTimeAndIp($admin);
        }

    }
    protected function saveAdminInfoToSession($admin){
        $lifetime=$this->remember_me?\Yii::$app->getModule('admin')->params['session_life_time']:null;
        $session=\Yii::$app->session;
        setcookie(session_name(),session_id(),$lifetime?time()+$lifetime:$lifetime);
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
        $mailer = \Yii::$app->mailer->compose('seekpassword', ['token' => $token,'url'=>'admin/password/change-password']);
        $mailer->setFrom("15658283276@163.com");
        $mailer->setTo($email);
        $mailer->setSubject("找回密码");
        if ($mailer->send()) {
            //  与 \Yii::$app->session->setFlash('Success','发送邮件成功') 等效
            \Yii::$app->getSession()->setFlash('Success','重置密码邮件发送成功');
            return true;
        }
        \Yii::$app->getSession()->setFlash('Error','重置密码邮件发送失败');
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
            //删除缓存
            \Yii::$app->cache->delete($token);
            return true;
        }
        return false;
    }

    //添加管理员
    public function addManager($post){
        $this->scenario='register';
        if($this->load($post) && $this->validate()){
            $this->password = md5($this->password);
            //默认save会进行验证，由于我们在前面已经执行了$this->validate验证操作，因此不需要再次验证
            if($this->save(false)){
                \Yii::$app->getSession()->setFlash('Success','添加管理员成功');
                return true;
            }
            \Yii::$app->getSession()->setFlash('Error','添加管理员失败');
            return false;
        }
    }

    //删除管理员
    public function deleteAdminById($id){
        //返回影响的记录条数
        $res = self::updateAll(['status'=>-1],'id=:id',[':id'=>$id]);
        if(!$res){
            \Yii::$app->getSession()->setFlash('Error','记录不存在');
            return false;
        }
        \Yii::$app->getSession()->setFlash('Success','删除管理员成功');
        return true;
    }


    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->auth_key=\Yii::$app->security->generateRandomString();
            }
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