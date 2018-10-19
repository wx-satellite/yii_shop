<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\bootstrap\Alert;
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
    <link href="/assets/admin/css/bootstrap.css" rel="stylesheet">
    <link href="/assets/admin/css/font-awesome.css" rel="stylesheet">
    <!--Beyond styles-->
    <link id="beyond-link" href="/assets/admin/css/beyond.css" rel="stylesheet">
    <link href="/assets/admin/css/demo.css" rel="stylesheet">
    <link href="/assets/admin/css/animate.css" rel="stylesheet">
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
        <div class="loginbox-title" style="height: 65px;">重置密码</div>
        <?php

        if(\Yii::$app->getSession()->hasFlash('Error')){
            echo Alert::widget([
                'options'=>['class' => 'alert-danger'],
                'body'=>\Yii::$app->getSession()->getFlash('Error')
            ]);
        }
        ?>

        <?php echo $form->field($model,'password')->passwordInput([
            "class"=>"form-control",
            'placeholder'=>'新密码',
        ]);?>

        <?php echo $form->field($model,'repassword')->passwordInput([
            "class"=>"form-control",
            'placeholder'=>'确认密码',
        ]);?>


        <!--                <input class="form-control" placeholder="password" name="password" type="password">-->

        <div class="loginbox-submit">
            <?= Html::submitButton('重置', ['class' => 'btn btn-primary btn-block','']) ?>
        </div>
    </div>

    <?php ActiveForm::end();?>
</div>





</body><!--Body Ends--></html>
