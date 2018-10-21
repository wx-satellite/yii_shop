<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\bootstrap\Alert;
$this->title='添加文章';
$this->params['breadcrumbs']=[['label'=>'文章列表','url'=>['/admin/article/list']],['label'=>'添加文章']];
$this->registerJsFile('/admin/js/wangEditor.min.js');
?>
            <!-- /Page Breadcrumb -->

            <!-- Page Body -->
            <div class="page-body">

                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <div class="widget">
                            <div class="widget-header bordered-bottom bordered-blue">
                                <span class="widget-caption">添加文章</span>
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
                                                    'template'=>'<div class="form-group">{label}<div class="col-sm-6" >{input}</div>{error}</div>'
                                            ]
                                    ]);?>
                                    <?php echo $form->field($model,'tag_id')
                                        ->label('文章所属标签',['class'=>'col-sm-2 control-label no-padding-right'])
                                        ->dropDownList($tags,['class'=>'form-control']);?>
                                    <?php echo $form->field($model,'title')
                                    ->label('文章标题',['class'=>'col-sm-2 control-label no-padding-right'])
                                        ->textInput(['class'=>'form-control']);?>
                                    <?php echo $form->field($model,'author')
                                        ->label('文章作者',['class'=>'col-sm-2 control-label no-padding-right'])
                                        ->textInput(['class'=>'form-control']);?>

                                        <div class="form-group">
                                            <label for="username" style="margin-left:-10px;" class="col-sm-2 control-label no-padding-right">内容</label>
                                            <div class="col-sm-8" id="content1" >
                                                <?php echo $model->content;?>
                                            </div>
                                            <?php if(isset($model->errors['content'])):?>
                                            <p class="col-sm-2" style="color: red;"><?php echo $model->errors['content'][0];?></p>
                                            <?php endif;?>
                                        </div>
                                        <textarea id="content" name="Article[content]" style="display: none;" ><?php echo $model->content;?></textarea>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <?php echo Html::submitButton('添加文章',['class'=>'btn btn-default']);?>
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
<?php $this->beginBlock('blog-add');?>
    var E = window.wangEditor
    var editor = new E('#content1')
    var $text1 = $('#content')
    editor.customConfig.onchange = function (html) {
        // 监控变化，同步更新到 textarea
        console.log(html)
        if('<p><br></p>'==html){
            $text1.val('')
        }else{
            $text1.val(html)
        }
    }
    // 配置服务器端地址
    editor.customConfig.uploadImgServer = '<?php echo \yii\helpers\Url::to(['article/upload']);?>';
    editor.customConfig.uploadFileName = 'image';
    editor.customConfig.uploadImgParams = {
    // 如果版本 <=v3.1.0 ，属性值会自动进行 encode ，此处无需 encode
    // 如果版本 >=v3.1.1 ，属性值不会自动 encode ，如有需要自己手动 encode
    _csrf: '<?php echo \Yii::$app->request->csrfToken;?>'
    }
    editor.customConfig.uploadImgHooks = {
        success: function (xhr, editor, result) {
        // 图片上传并返回结果，图片插入成功之后触发
        // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象，result 是服务器端返回的结果
        },
        fail: function (xhr, editor, result) {
            if(result['errno']!=0){
                alert(result['message'])
            }
        }
    }
    editor.create()
    $('.w-e-text-container').height(450);
<?php $this->endBlock();?>
<?php $this->registerJs($this->blocks['blog-add'],\yii\web\View::POS_END);
