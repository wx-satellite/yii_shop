<?php
use yii\bootstrap\ActiveForm;
$this->title='订单发货';
$this->params['breadcrumbs']=[['label'=>'订单列表','url'=>['/admin/order/list']],['label'=>'订单发货']];
?>
        <!-- Page Content -->

            <!-- /Page Breadcrumb -->

            <!-- Page Body -->
            <div class="page-body">

                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <div class="widget">
                            <div class="widget-header bordered-bottom bordered-blue">
                                <span class="widget-caption">订单发货</span>
                            </div>
                            <div class="widget-body">
                                <div id="horizontal-form">
                                    <?php $form=ActiveForm::begin([
                                        'options'=>['class'=>'form-horizontal'],
                                        'fieldConfig'=>[
                                            'template'=>'<div class="form-group">{label}<div class="col-sm-6">{input}</div>{error}</div>'
                                        ]
                                    ]);?>
                                        <?php echo $form->field($model,'post_number')->label('快递单号',['class'=>'col-sm-2 control-label no-padding-right'])
                                            ->textInput(['class'=>'form-control']);?>


                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <?php echo \yii\helpers\Html::submitButton('确认发货',['class'=>'btn btn-default']);?>
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
   
