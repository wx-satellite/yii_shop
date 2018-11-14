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
                        <a class="active" data-toggle="tab" href="#lg1">
                            <h4> 登录 </h4>
                        </a>

                    </div>
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
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

                                    <div class="row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-3" style="margin-bottom:30px;">
                                            <button class="btn-primary btn-lg btn btn-facebook col-sm-12" style="height: 50px;">QQ登录</button>
                                        </div>
                                        <div class="col-sm-3" style="margin-bottom:30px;">
                                            <button class="btn-success btn-lg btn btn-twitter col-sm-12" style="height: 50px;"> 微信登录</button>
                                        </div>
                                    </div>
                                    <?php $form=ActiveForm::begin([
                                        'fieldConfig'=>['template'=>'{input}<div style=\'color:red;margin-top:-20px;padding-bottom: 5px;\'>{error}</div>']
                                    ]);?>
                                    <?php echo $form->field($model,'account')->textInput(['placeholder'=>'用户名或者邮箱']);?>
                                    <?php echo $form->field($model,'password')->passwordInput(['placeholder'=>'密码']);?>
                                    <div class="button-box">
                                    <?php echo $form->field($model,'remember_me')->label('　记住我')->checkbox([
                                        'template'=>'<div class="login-toggle-btn">{input}{label}<a href="/login/seek-password.html">忘记密码？</a>
                                            </div>'
                                    ]);?>
                                        <?php echo Html::submitButton('登录');?>
                                        <a style="color:grey;margin-left: 10px;" href="<?php echo \yii\helpers\Url::to(['login/register']);?>">还没有账号，去注册一个吧?</a>
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

