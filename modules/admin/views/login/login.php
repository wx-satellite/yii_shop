<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"><!--Head--><head>
    <meta charset="utf-8">
    <title>ThinkPHP5.0</title>
    <meta name="description" content="login page">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!--Basic Styles-->
    <link href="/admin/css/bootstrap.css" rel="stylesheet">
    <link href="/admin/css/font-awesome.css" rel="stylesheet">
    <!--Beyond styles-->
    <link id="beyond-link" href="/admin/css/beyond.css" rel="stylesheet">
    <link href="/admin/css/demo.css" rel="stylesheet">
    <link href="/admin/css/animate.css" rel="stylesheet">
</head>
<!--Head Ends-->
<!--Body-->

<body>
<div class="login-container animated fadeInDown">
    <?php $form=ActiveForm::begin([
        'fieldConfig'=>[
            'template'=>'<div class="loginbox-textbox">{input}{error}</div>',
        ]
    ]);?>
        <div class="loginbox bg-white">
            <div class="loginbox-title" style="height: 65px;">后台登录</div>
                <?php echo $form->field($model,'email')->textInput([
                    'class'=>'form-control',
                    'placeholder'=>"邮箱"
                ]);?>
<!--                <input value="admin" class="form-control" placeholder="username" name="username" type="text">-->


                <?php echo $form->field($model,'password')->passwordInput([
                    "class"=>"form-control",
                    'placeholder'=>'密码',
                ]);?>

            <div class="loginbox-textbox" >
                <div class="checkbox">
                    <?php echo $form->field($model,'remember_me')->checkbox([
                        'template'=>'<label>{input}<span class="text">记住我</span></label><div class="loginbox-forgot" style="float: right">
                        <a href="?r=admin/password/seek-password">忘记密码</a>
                    </div>',
                    ]);?>
                </div>

            </div>
<!--                <input class="form-control" placeholder="password" name="password" type="password">-->

            <div class="loginbox-submit">
                <?= Html::submitButton('登录', ['class' => 'btn btn-primary btn-block','']) ?>
            </div>
        </div>

    <?php ActiveForm::end();?>
</div>





</body><!--Body Ends--></html>
