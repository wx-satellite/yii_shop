<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\bootstrap\Alert;
$this->title='分配角色';
$this->params['breadcrumbs']=[['label'=>'管理员列表','url'=>['/admin/manager/list']],['label'=>'分配角色']];
?>

<!-- /Page Breadcrumb -->

<!-- Page Body -->
<div class="page-body">

    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="widget">
                <div class="widget-header bordered-bottom bordered-blue">
                    <span class="widget-caption">分配角色</span>
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
                            <?php echo Html::label('当前管理员：',null,['class'=>'col-sm-2 control-label no-padding-right']);?>
                            <div class="col-sm-6">
                                <div style="margin-top: 7px;"><?php echo $admin->email;?></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php echo Html::label('角色：',null,['class'=>'col-sm-2 control-label no-padding-right']);?>
                            <div class="col-sm-6">
                                <?php if($roles):?>
                                    <?php echo Html::checkboxList('children',$current_roles,$roles,['item'=>function($index, $label, $name, $checked, $value){
                                        $checked=$checked?"checked":"";
                                        $return = '<label style="margin-top: 7px;">';
                                        $return .= '<input type="checkbox" id="' . $name . $value . '" name="' . $name . '" value="' . $value . '" '.$checked.'>';
                                        $return .= '<span class="text">'.$label.'</span>';
                                        $return .= '</label><br/>';
                                        return $return;
                                    }]);?>
                                <?php else:?>
                                    <div style="margin-top: 7px;color: red;">暂无子角色可选</div>
                                <?php endif;?>
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <?php echo Html::submitButton('授权',['class'=>'btn btn-default']);?>
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