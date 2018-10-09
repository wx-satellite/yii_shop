<?php
use yii\bootstrap\Alert;
?>
<div class="page-content">
    <!-- Page Breadcrumb -->
    <div class="page-breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <a href="#">管理员管理</a>
            </li>
            <li class="active">管理员列表</li>
        </ul>
    </div>
    <!-- /Page Breadcrumb -->

    <!-- Page Body -->
    <div class="page-body">

        <button type="button" tooltip="添加用户" class="btn btn-sm btn-azure btn-addon" onClick="javascript:window.location.href = '<?php echo \yii\helpers\Url::to(['manager/add']);?>'"> <i class="fa fa-plus"></i> 添加管理员
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
                        <div class="flip-scroll">
                            <table class="table table-bordered table-hover">
                                <thead class="">
                                <tr>
                                    <th class="text-center">序号</th>
                                    <th class="text-center">管理员账号</th>
                                    <th class="text-center">创建时间</th>
                                    <th class="text-center">上次登录IP</th>
                                    <th class="text-center">上次登录时间</th>
                                    <th class="text-center">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($managers as $k=>$manager):?>
                                <tr>
                                    <td align="center"><?php echo $k+1;?></td>
                                    <td align="center"><?php echo $manager->email;?></td>
                                    <td align="center"><?php echo $manager->create_time;?></td>
                                    <td align="center"><?php echo long2ip($manager->loginip);?></td>
                                    <td align="center"><?php echo $manager->last_login_time;?></td>
                                    <td align="center">
                                        <a href="/admin/user/edit/id/6.html" class="btn btn-primary btn-sm shiny">
                                            <i class="fa fa-edit"></i> 编辑
                                        </a>
                                        <a href="javascript:if(confirm('确认删除吗？')){window.location.href='<?php echo \yii\helpers\Url::to(['manager/delete','id'=>$manager->id]);?>'}" class="btn btn-danger btn-sm shiny">
                                            <i class="fa fa-trash-o"></i> 删除
                                        </a>
                                    </td>
                                </tr>
                               <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                        <div style="margin-top: 10px;">
                        <?php echo yii\widgets\LinkPager::widget([
                            'pagination'=>$pager,
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