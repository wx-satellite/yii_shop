
        <!-- Page Content -->
        <div class="page-content">
            <!-- Page Breadcrumb -->
            <div class="page-breadcrumbs">
                <ul class="breadcrumb">
                    <li>
                        <a href="#">系统</a>
                    </li>
                    <li class="active">用户管理</li>
                </ul>
            </div>
            <!-- /Page Breadcrumb -->

            <!-- Page Body -->
            <div class="page-body">

                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <div class="widget">
                            <div class="widget-body">
                                <div class="flip-scroll">
                                    <table class="table table-bordered table-hover">
                                        <thead class="">
                                        <tr>
                                            <th class="text-center">编号</th>
                                            <th class="text-center">用户名</th>
                                            <th class="text-center">注册邮箱</th>
                                            <th class="text-center">上次登录时间</th>
                                            <th class="text-center">上次登录IP</th>
                                            <th class="text-center">注册时间</th>
                                            <th class="text-center">状态</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($users as $k=>$user):?>
                                        <tr>
                                            <td align="center"><?php echo $k+1;?></td>
                                            <td align="center"><?php echo $user->username;?></td>
                                            <td align="center"><?php echo $user->email;?></td>
                                            <td align="center"><?php echo $user->last_login_time;?></td>
                                            <td align="center"><?php echo long2ip($user->loginip);?></td>
                                            <td align="center"><?php echo $user->create_time;?></td>
                                            <td align="center">
                                               <?php echo \Yii::$app->getModule('admin')->params['USER_STATUS'][$user->status];?>
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
