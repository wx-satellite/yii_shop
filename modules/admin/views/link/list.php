<?php
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
                    <li class="active">链接管理</li>
                </ul>
            </div>
            <!-- /Page Breadcrumb -->

            <!-- Page Body -->
            <div class="page-body">

                <button type="button" tooltip="添加链接" class="btn btn-sm btn-azure btn-addon" onClick="javascript:window.location.href = '<?php echo \yii\helpers\Url::to(['link/add']);?>'"> <i class="fa fa-plus"></i>添加友情链接
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
                                            <th class="text-center">链接名称</th>
                                            <th class="text-center">链接地址</th>
                                            <th class="text-center">状态</th>
                                            <th class="text-center">操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($links as $k=>$link):?>
                                        <tr>
                                            <td align="center"><?php echo $k+1;?></td>
                                            <td align="center"><?php echo $link->title;?></td>
                                            <td align="center"><a href="<?php echo $link->links;?>" target="_blank"><?php echo $link->links;?></a></td>
                                            <td align="center">
                                                <?php if(1===(int)$link->status):?>
                                                    前端显示
                                                <?php elseif(0===(int)$link->status):?>
                                                    前端隐藏
                                                <?php endif;?>
                                            </td>
                                            <td align="center">
                                                    <a href="<?php echo \yii\helpers\Url::to(['link/change-status','id'=>$link->id]);?>" class="btn btn-azure btn-sm shiny">修改状态</a>
                                                <a href="<?php echo \yii\helpers\Url::to(['link/edit','id'=>$link->id]);?>" class="btn btn-primary btn-sm shiny">
                                                    <i class="fa fa-edit"></i> 编辑
                                                </a>
                                                <a href="javascript:if(confirm('确认删除吗？')){window.location.href='<?php echo \yii\helpers\Url::to(['link/delete','id'=>$link->id]);?>'}"  class="btn btn-danger btn-sm shiny">
                                                    <i class="fa fa-trash-o"></i> 删除
                                                </a>
                                            </td>
                                        </tr>
                                       <?php endforeach;?>
                                        </tbody>
                                    </table>
                                </div>
                                <div style="margin-top: 10px;">
                                    <?php echo \yii\widgets\LinkPager::widget([
                                        'pagination'=>$pager
                                    ]);?>
                                </div>
                                <div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /Page Body -->
        </div>
        <!-- /Page Content -->
