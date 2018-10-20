<?php
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use yii\helpers\Html;
$this->title='编辑商品';
$this->params['breadcrumbs']=[['label'=>'商品列表','url'=>['/admin/goods/list']],['label'=>'编辑商品']];
?>
<!-- Page Content -->

    <!-- /Page Breadcrumb -->

    <!-- Page Body -->
    <div class="page-body">

        <div class="row">
            <div class="col-lg-12 col-sm-12 col-xs-12">
                <div class="widget">
                    <div class="widget-header bordered-bottom bordered-blue">
                        <span class="widget-caption">编辑商品</span>
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
                                <?php if($model->picture):?>
                                <div class="form-group">
                                    <label for="username" class="col-sm-2 control-label no-padding-right" style="margin-left: -10px;">LOGO预览:</label>
                                   <div class="col-sm-6">
                                    <img src="<?php echo $model->picture.\Yii::$app->getModule('admin')->params['QN_SMALLER'];?>">
                                       <input type="hidden" name="Goods[picture]" value="<?php echo $model->picture;?>"/>
                                       </div>
                                    </div>
                                    <?php endif;?>
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
                            <?php $photos=unserialize($model->photos);?>
                            <?php if($photos):?>
                                <div class="form-group">
                                    <label for="username" class="col-sm-2 control-label no-padding-right" style="margin-left: -10px;">商品相册预览:</label>
                                    <div class="col-sm-6">
                                        <?php foreach($photos as $photo):?>
                                            <div>
                                                <img src="<?php echo $photo.\Yii::$app->getModule('admin')->params['QN_SMALLER'];?>">
                                                <input type="hidden" name="Goods[photos][<?php echo basename($photo);?>]" value="<?php echo $photo;?>"/>
                                                <a href="<?php echo \yii\helpers\Url::to(['goods/delete-photo','key'=>basename($photo),'id'=>$model->id]);?>" style="margin-left:10px;">删除</a>
                                            </div>
                                            <?php endforeach;?>
                                    </div>
                                </div>
                            <?php endif;?>
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
                                    <?php echo Html::submitButton('修改商品',['class'=>'btn btn-default']);?>
                                </div>
                            </div>
                            <?php ActiveForm::end();?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>