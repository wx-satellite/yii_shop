<?php
use yii\bootstrap\Alert;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<div class="breadcrumb-area pt-95 pb-95 bg-img" style="background-image:url(assets/img/banner/banner-2.jpg);">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <h2>My Account</h2>
            <ul>
                <li><a href="index.html">home</a></li>
                <li class="active">My Account</li>
            </ul>
        </div>
    </div>
</div>
<!-- my account start -->
<div class="my-account-area pt-100 pb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="checkout-wrapper">
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
                    <div id="faq" class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>1</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-1">编辑您的帐户信息 </a></h5>
                            </div>
                            <div id="my-account-1" class="panel-collapse collapse show">
                                <div class="panel-body">
                                    <div class="billing-information-wrapper">
                                        <div class="account-info-wrapper">
                                            <h4>我的个人信息</h4>
                                        </div>
                                    <?php $form=ActiveForm::begin([
                                        'fieldConfig'=>[
                                            'template'=>'{label}{input}<div style="color:red;">{error}</div>'
                                        ]
                                    ]);?>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <div class="billing-info">
                                                    <?php echo $form->field($profile,'last_name')->label('姓')->textInput();?>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="billing-info">
                                                    <?php echo $form->field($profile,'first_name')->label('名')->textInput();?>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12">
                                                <div class="billing-info">
                                                    <?php echo $form->field($profile,'address')->label('收货地址')->textInput();?>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="billing-info">
                                                    <?php echo $form->field($profile,'phone')->label('手机号')->textInput();?>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="billing-info">
                                                    <?php echo $form->field($profile,'sex')->label('性别')->dropDownList(['1'=>'男生','2'=>'女生']);?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="billing-back-btn">
                                            <div class="billing-btn">
                                                <?php echo Html::submitButton('修改基本信息');?>
                                            </div>
                                        </div>
                                        <?php ActiveForm::end();?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>2</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-2">修改密码</a></h5>
                            </div>
                            <div id="my-account-2" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="billing-information-wrapper">
                                        <div class="account-info-wrapper">
                                            <h4>修改密码</h4>
                                        </div>
                                        <?php $form=ActiveForm::begin([
                                            'action'=>\yii\helpers\Url::to(['user/change-password']),
                                            'fieldConfig'=>[
                                                'template'=>'{label}{input}<div style="color:red">{error}</div>'
                                            ]
                                        ]);?>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="billing-info">
                                                    <?php echo $form->field($user,'password')->label('新密码')->textInput([
                                                    ]);?>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12">
                                                <div class="billing-info">
                                                    <?php echo $form->field($user,'repassword')->label('重复密码')->textInput([

                                                    ]);?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="billing-back-btn">
                                            <div class="billing-btn">
                                                <?php echo Html::submitButton('修改密码');?>
                                            </div>
                                        </div>
                                        <?php ActiveForm::end();?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>2</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-4">换绑邮箱</a></h5>
                            </div>
                            <div id="my-account-4" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="billing-information-wrapper">
                                        <div class="account-info-wrapper">
                                            <h4>换绑邮箱<span style="color:red;font-size:14px;">（温馨提示：请填写正确的邮箱，在登录或者找回密码场景需要使用）</span></h4>
                                        </div>
                                        <?php $form=ActiveForm::begin([
                                            'action'=>\yii\helpers\Url::to(['user/change-email']),
                                            'fieldConfig'=>[
                                                'template'=>"{label}{input}<div style='color:red;'>{error}</div>"
                                            ]
                                        ]);?>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="billing-info">
                                                    <?php echo $form->field($user,'email')->label('邮箱')->textInput();?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="billing-back-btn">
                                            <div class="billing-btn">
                                               <?php echo Html::submitButton('修改邮箱');?>
                                            </div>
                                        </div>
                                        <?php ActiveForm::end();?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>4</span> <a href="#">我的订单</a></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
