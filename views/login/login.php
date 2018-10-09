<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\bootstrap\Alert;
?>
<div class="breadcrumb-area pt-95 pb-95 bg-img" style="background-image:url(assets/img/banner/banner-2.jpg);">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <h2>Login / Register</h2>
            <ul>
                <li><a href="index.html">home</a></li>
                <li class="active">Login / Register</li>
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
                                <div class="login-register-form">
                                    <?php $form=ActiveForm::begin([
                                        'fieldConfig'=>['template'=>'{input}{error}']
                                    ]);?>
                                    <?php echo $form->field($model,'username')->textInput(['placeholder'=>'用户名或者邮箱']);?>
                                    <?php echo $form->field($model,'password')->textInput(['placeholder'=>'密码']);?>
                                    <div class="button-box">
                                    <?php echo $form->field($model,'remember_me')->label('　记住我')->checkbox([
                                        'template'=>'<div class="login-toggle-btn">{input}{label}<a href="#">忘记密码？</a>
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

