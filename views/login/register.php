<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\bootstrap\Alert;
?>
<div class="breadcrumb-area pt-95 pb-95 bg-img" style="background-image:url(/img/banner/banner-2.jpg);">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <h2>Login / Register</h2>
            <ul>
                <li><a href="<?php echo \yii\helpers\Url::to(['index/index']);?>">首页</a></li>
                <li class="active">登录 / 注册</li>
            </ul>
        </div>
    </div>
</div>
<div class="login-register-area pt-95 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                <div class="login-register-wrapper">
                    <div class="login-register-tab-list nav">
                        <a class="active" data-toggle="tab" href="#lg2">
                            <h4> 注册 </h4>
                        </a>
                    </div>
                    <div class="tab-content">

                        <div id="lg2" class="tab-pane active">

                            <div class="login-form-container">
                                <?php
                                if(\Yii::$app->getSession()->hasFlash('Success')){
                                    echo Alert::widget([
                                        'options'=>['class'=>'alert-success'],
                                        'body'=>\Yii::$app->getSession()->getFlash('Success')
                                    ]);
                                }

                                if(\Yii::$app->getSession()->hasFlash('Error')){
                                    echo Alert::widget([
                                        'options'=>['class'=>'alert-danger'],
                                        'body'=>\Yii::$app->getSession()->getFlash('Error')
                                    ]);
                                }
                                ?>
                                <div class="login-register-form">
                                    <?php $form=ActiveForm::begin([
                                        'action'=>['login/register'],
                                        'fieldConfig'=>[
                                            'template'=>"{input}<div style='color:red;margin-top:-20px;padding-bottom: 5px;'>{error}</div>"
                                        ]
                                    ]);?>
                                    <?php echo $form->field($model,'username')->textInput(['placeholder'=>'用户名']);?>
                                    <?php echo $form->field($model,'email')->textInput(['placeholder'=>'邮箱']);?>
                                    <?php echo $form->field($model,'password')->passwordInput(['placeholder'=>'密码']);?>
                                    <?php echo $form->field($model,'repassword')->passwordInput(['placeholder'=>'重复密码']);?>
                                    <div class="button-box">
                                        <?php echo Html::submitButton('注册');?>
                                        <a href="<?php echo \yii\helpers\Url::to(['login/login']);?>" style="margin-left: 10px;color:grey;">已有账号，去登陆？</a>
                                    </div>
                                    <?php ActiveForm::end();?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

