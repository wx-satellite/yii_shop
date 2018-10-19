<?php
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use yii\helpers\Html;
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
                        <a href="<?php echo \yii\helpers\Url::to(['goods/list']);?>">商品列表</a>
                    </li>
                    <li class="active">添加商品</li>
                </ul>
            </div>
            <!-- /Page Breadcrumb -->

            <!-- Page Body -->
            <div class="page-body">

                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <div class="widget">
                            <div class="widget-header bordered-bottom bordered-blue">
                                <span class="widget-caption">添加商品</span>
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
                                        'options'=>['class'=>'form-horizontal','enctype'=>'multipart/form-data'],
                                        'fieldConfig'=>[
                                            'template'=>'<div class="form-group">{label}<div class="col-sm-6">{input}</div>{error}</div>'
                                        ]
                                    ]);?>

                                    <?php echo $form->field($model,'cateid')->label('商品分类',['class'=>'col-sm-2 control-label no-padding-right'])
                                            ->dropDownList($cates);?>
                                    <?php echo $form->field($model,'name')->label('商品名称',['class'=>'col-sm-2 control-label no-padding-right'])
                                        ->textInput();?>
                                    <?php echo $form->field($model,'stock')->label('库存量',['class'=>'col-sm-2 control-label no-padding-right'])
                                        ->textInput();?>
                                    <?php echo $form->field($model,'price')->label('价格',['class'=>'col-sm-2 control-label no-padding-right'])
                                        ->textInput();?>
                                    <?php echo $form->field($model,'picture')->label('商品LOGO',['class'=>'col-sm-2 control-label no-padding-right'])
                                        ->fileInput();?>

                                    <script>
                                        function add_or_delete(obj){
                                            obj = $(obj);
                                            if(obj.text()=='[+]'){
                                                current = obj.parent().parent();
                                                new1 = current.clone();
                                                new1.find('a').text('[-]');
                                                new1.insertAfter(current);
                                            }else{
                                                obj.parent().parent().remove();
                                            }
                                            return false;
                                        }

                                    </script>
                                    <div class="form-group">
                                        <label for="username" class="col-sm-2 control-label no-padding-right" style="margin-left: -10px;">
                                            <a href="javascript:void(0);" onclick="add_or_delete(this)" style="margin-right: 5px;font-weight: bold;color: red;text-decoration: none;">[+]</a>商品相册</label>
                                        <div class="col-sm-6">
                                            <input  type="file" name="Goods[photo][]">
                                        </div>
                                    </div>

                                    <?php echo $form->field($model,'descr')->label('商品描述',['class'=>'col-sm-2 control-label no-padding-right'])
                                        ->textarea();?>
                                        <div class="form-group">
                                            <label for="group_id" class="col-sm-2 control-label no-padding-right" style="margin-left: -10px;">是否促销</label>
                                            <div class="col-sm-6">
                                                <div class="control-group">
                                                    <div class="radio">
                                                        <label>

                                                            <input name="Goods[is_sale]" type="radio"

                                                                   <?php if($model->is_sale==0) echo "checked";?>
                                                                     value="0">
                                                            <span class="text">否 </span>
                                                        </label>
                                                        <label>
                                                            <input name="Goods[is_sale]" type="radio"
                                                                   <?php if($model->is_sale==1) echo "checked";?> class="inverted" value="1">
                                                            <span class="text">是</span>
                                                        </label>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    <?php echo $form->field($model,'sale_price')->label('促销价',['class'=>'col-sm-2 control-label no-padding-right'])
                                        ->textInput();?>

                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <?php echo Html::submitButton('添加商品',['class'=>'btn btn-default']);?>
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
