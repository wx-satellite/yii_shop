<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\bootstrap\Alert;
?>
        <!-- Page Content -->
        <div class="page-content">
            <!-- Page Breadcrumb -->
            <div class="page-breadcrumbs">
                <ul class="breadcrumb">
                    <li>
                        <a href="#">系统</a>
                    </li>
                    <li>
                        <a href="<?php echo \yii\helpers\Url::to(['category/list']);?>">商品分类管理</a>
                    </li>
                    <li class="active">添加分类</li>
                </ul>
            </div>
            <!-- /Page Breadcrumb -->

            <!-- Page Body -->
            <div class="page-body">

                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <div class="widget">
                            <div class="widget-header bordered-bottom bordered-blue">
                                <span class="widget-caption">添加分类</span>
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
                                        'action'=>\yii\helpers\Url::to(['category/add','type'=>$type]),
                                        'fieldConfig'=>[
                                            'template'=>'<div class="form-group">{label}<div class="col-sm-6">{input}</div>{error}</div>'
                                        ]
                                    ]);?>
                                    <?php echo $form->field($model,'type')->label('分类类型',['class'=>'col-sm-2 control-label no-padding-right'])
                                        ->dropDownList($types);?>
                                    <?php echo $form->field($model,'pid')->label('上级分类',['class'=>'col-sm-2 control-label no-padding-right'])
                                            ->dropDownList($cates);?>
                                    <?php echo $form->field($model,'title')->label('分类名称',['class'=>'col-sm-2 control-label no-padding-right'])
                                            ->textInput();?>

                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <?php echo Html::submitButton('添加分类',['class'=>'btn btn-default']);?>
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
        <!-- /Page Content -->
<?php $this->beginBlock('cate-add');?>
URL = "<?php echo \yii\helpers\Url::to(['category/add']);?>"
$(function(){
    $('#category-type').change(function(){
        type = $(this).val();
        window.location.href=URL+'&type='+type;
    });
})
<?php $this->endBlock();?>
<?php $this->registerJs($this->blocks['cate-add'],yii\web\View::POS_END);?>