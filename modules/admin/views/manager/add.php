<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\bootstrap\Alert;
?>
<div class="page-content">
    <!-- Page Breadcrumb -->
    <div class="page-breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <a href="#">系统</a>
            </li>
            <li>
                <a href="<?php echo \yii\helpers\Url::to(['manager/list']);?>">管理员列表</a>
            </li>
            <li class="active">添加管理员</li>
        </ul>
    </div>
    <!-- /Page Breadcrumb -->

    <!-- Page Body -->
    <div class="page-body">

        <div class="row">
            <div class="col-lg-12 col-sm-12 col-xs-12">
                <div class="widget">
                    <div class="widget-header bordered-bottom bordered-blue">
                        <span class="widget-caption">添加管理员</span>
                    </div>

                    <div class="widget-body">
                        <?php
                        if(\Yii::$app->getSession()->hasFlash('Success')){
                            echo Alert::widget([
                                'options'=>['class'=>'alert-success'],
                                'body'=>\Yii::$app->getSession()->getFlash('Success')
                            ]);
                        }

                        if(\Yii::$app->getSession()->hasFlash('Error')){
                            echo Alert::widget([
                                'options'=>['class' => 'alert-danger'],
                                'body'=>\Yii::$app->getSession()->getFlash('Error')
                            ]);
                        }

                        ?>
                        <div id="horizontal-form">
                            <?php $form = ActiveForm::begin([
                                'options'=>['class'=>'form-horizontal','role'=>'form'],
                                'fieldConfig'=>[
                                    'template'=>'<div class="form-group">{label}<div class="col-sm-6">{input}</div>{error}</div>'
                                ]

                            ]);?>

                            <?php echo $form->field($model,'email')->label('账号：',['class'=>'col-sm-2 control-label no-padding-right'])
                                    ->textInput(['class'=>'form-control ']);?>
                            <?php echo $form->field($model,'username')->label('用户名：',['class'=>'col-sm-2 control-label no-padding-right'])
                                ->textInput(['class'=>'form-control ']);?>
                            <?php echo $form->field($model,'password')->label('初始密码：',['class'=>'col-sm-2 control-label no-padding-right'])
                                    ->textInput(['class'=>'form-control','value'=>'123456']);?>

                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <?php echo Html::submitButton('添加管理员',['class'=>'btn btn-default']);?>
                                    </div>
                              </div>
                            <?php ActiveForm::end();?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /Page Body -->
</div>