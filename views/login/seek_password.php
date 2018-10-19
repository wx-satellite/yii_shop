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
                            <h4> 找回密码 </h4>
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
                                        'fieldConfig'=>['template'=>'{input}<div style=\'color:red;margin-top:-20px;padding-bottom: 5px;\'>{error}</div>']
                                    ]);?>
                                    <?php echo $form->field($model,'email')->textInput(['placeholder'=>'请输入邮箱']);?>
                                    <div class="button-box">
                                    <?php echo Html::submitButton('发送重置密码邮件');?>
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

