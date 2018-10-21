<?php
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use yii\helpers\Html;
$this->title='添加标签';
$this->params['breadcrumbs']=[['label'=>'标签列表','url'=>['/admin/tag/list']],['label'=>'添加标签']];

?>
            <!-- /Page Breadcrumb -->

            <!-- Page Body -->
            <div class="page-body">

                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <div class="widget">
                            <div class="widget-header bordered-bottom bordered-blue">
                                <span class="widget-caption">添加标签</span>
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
                                    <?php $form=ActiveForm::begin([
                                            'enableClientScript'=>false,
                                            'options'=>['class'=>'form-horizontal'],
                                            'fieldConfig'=>[
                                                    'template'=>'<div class="form-group">{label}<div class="col-sm-6">{input}</div>{error}</div>'
                                            ]
                                    ]);?>


                                        <?php echo $form->field($model,'name')->label('标签名称',['class'=>'col-sm-2 control-label no-padding-right'])
                                            ->textInput(['class'=>'form-control']);?>

                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <?php echo Html::submitButton('添加标签',['class'=>'btn btn-default']);?>
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
