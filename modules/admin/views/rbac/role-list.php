<?php
use yii\bootstrap\Alert;
use yii\grid\GridView;
use yii\helpers\Html;
$this->title='角色列表';
$this->params['breadcrumbs']=[['label'=>'角色列表']];
?>

<!-- /Page Breadcrumb -->

<!-- Page Body -->
<div class="page-body">

    <button type="button" tooltip="添加角色" class="btn btn-sm btn-azure btn-addon" onClick="javascript:window.location.href = '<?php echo \yii\helpers\Url::to(['rbac/create-role']);?>'"> <i class="fa fa-plus"></i> 添加角色
    </button>
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="widget">
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
                            'options'=>['class'=>'alert-danger'],
                            'body'=>\Yii::$app->getSession()->getFlash('Error')
                        ]);
                    }
                    ?>
                    <?php echo GridView::widget([
                            'dataProvider'=>$data,
                            'columns'=>[
                                ['class'=>'yii\grid\SerialColumn'],
                               'description:text:名称',
                                'name:text:标识',
                                'rule_name:text:规则名称',
                                [
                                        'attribute'=>'created_at',
                                    'label'=>'创建时间',
                                    'value'=>function($model){
                                        return date('Y-m-d H:i:s',$model['created_at']);
                                    },
                                ],
                                [
                                    'attribute'=>'updated_at',
                                    'label'=>'更新时间',
                                    'value'=>function($model){
                                        return date('Y-m-d H:i:s',$model['updated_at']);
                                    },
                                ],
                                [
                                        'class'=>'\yii\grid\ActionColumn',
                                    'header'=>'操作',
                                    'template'=>'{assign} {update} {delete}',
                                    'buttons'=>[
                                            'assign'=>function($url,$model,$key){
                                                return Html::a('分配权限',['assign-item','name'=>$model['name']]);
                                            },
                                        'update'=>function($url,$model,$key){
                                            return Html::a('更新',['updateitem','name'=>$model['name']]);
                                        },
                                        'delete'=>function($url,$model,$key){
                                            return Html::a('删除',['deleteitem','name'=>$model['name']]);
                                        }
                                    ]
                                ]
                            ],
                        'layout'=>'{items}<div style="margin-top: 10px;">{pager}</div>'
                    ]);?>

                </div>
            </div>
        </div>
    </div>

</div>
