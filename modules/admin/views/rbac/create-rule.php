<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\bootstrap\Alert;
$this->title='添加规则';
$this->params['breadcrumbs']=[['label'=>'规则列表','url'=>['/admin/rbac/rule-list']],['label'=>'添加规则']];
?>

<!-- /Page Breadcrumb -->

<!-- Page Body -->
<div class="page-body">

    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="widget">
                <div class="widget-header bordered-bottom bordered-blue">
                    <span class="widget-caption">添加规则</span>
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
                            'enableClientScript'=>false,
                            'options'=>['class'=>'form-horizontal','role'=>'form']

                        ]);?>
                        <div class="form-group">
                            <?php echo Html::label('规则类名称：',null,['class'=>'col-sm-2 control-label no-padding-right']);?>
                            <div class="col-sm-6">
                                <?php echo Html::textInput('rule_name',isset($old['description'])?$old['description']:'',['class'=>'form-control ']);?>
                            </div>
                            <p class="help-block col-sm-4 red">* 必填</p>
                        </div>

                        <div class="form-group">
                            <?php echo Html::label('规则数据：',null,['class'=>'col-sm-2 control-label no-padding-right']);?>
                            <div class="col-sm-6">
                                <?php echo Html::textarea('data',isset($old['data'])?$old['data']:'',['class'=>'form-control ']);?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <?php echo Html::submitButton('添加规则',['class'=>'btn btn-default']);?>
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