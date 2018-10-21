<?php
use yii\bootstrap\Alert;
use app\modules\admin\models\Tag;
$this->title='标签列表';
$this->params['breadcrumbs']=[['label'=>'标签列表']];

?>

            <!-- Page Body -->
            <div class="page-body">

                <button type="button" tooltip="添加标签" class="btn btn-sm btn-azure btn-addon" onClick="javascript:window.location.href = '<?php echo \yii\helpers\Url::to(['tag/add']);?>'"> <i class="fa fa-plus"></i> 添加标签
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
                                        'options'=>['class' => 'alert-danger'],
                                        'body'=>\Yii::$app->getSession()->getFlash('Error')
                                    ]);
                                }

                                ?>
                                <div class="flip-scroll">
                                    <table class="table table-bordered table-hover">
                                        <thead class="">
                                        <tr>
                                            <th class="text-center">序号</th>
                                            <th class="text-center">标签名称</th>
                                            <th class="text-center">状态</th>
                                            <th class="text-center">操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($tags as $k=>$tag):?>
                                        <tr>
                                            <td align="center"><?php echo $k+1;?></td>
                                            <td align="center"><?php echo $tag['name'];?></td>
                                            <td align="center">
                                                <?php if(Tag::HIDDEN===(int)$tag->status):?>
                                                    前端隐藏
                                                <?php elseif(Tag::SHOW===(int)$tag->status):?>
                                                    前端显示
                                                <?php else:?>
                                                <?php endif;?>
                                            </td>
                                            <td align="center">
                                                <a href="<?php echo \yii\helpers\Url::to(['tag/change-status','id'=>$tag->id]);?>" class="btn btn-azure btn-sm shiny">
                                                    修改状态
                                                </a>
                                                <a href="<?php echo \yii\helpers\Url::to(['tag/edit','id'=>$tag->id]);?>" class="btn btn-primary btn-sm shiny">
                                                    <i class="fa fa-edit"></i> 编辑
                                                </a>
                                                <a href="javascript:if(confirm('确认要删除吗？')){window.location.href='<?php echo \yii\helpers\Url::to(['tag/delete','id'=>$tag->id]);?>'}"  class="btn btn-danger btn-sm shiny">
                                                    <i class="fa fa-trash-o"></i> 删除
                                                </a>
                                            </td>
                                        </tr>
                                     <?php endforeach;?>
                                        </tbody>
                                    </table>
                                </div>
                                <div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /Page Body -->
