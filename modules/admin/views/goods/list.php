<?php
use yii\bootstrap\Alert;
$this->title='商品列表';
$this->params['breadcrumbs']=[['label'=>'商品列表']];
?>
        <!-- Page Content -->

            <!-- /Page Breadcrumb -->

            <!-- Page Body -->
            <div class="page-body">

                <button type="button" tooltip="添加商品" class="btn btn-sm btn-azure btn-addon" onClick="javascript:window.location.href = '/index.php?r=admin/goods/add'"> <i class="fa fa-plus"></i> 添加商品
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
                                            <th class="text-center">商品的logo</th>
                                            <th class="text-center">商品分类</th>
                                            <th class="text-center">商品名称</th>
                                            <th class="text-center">库存量</th>
                                            <th class="text-center">价格</th>
                                            <th class="text-center">是否促销</th>
                                            <th class="text-center">促销价</th>
                                            <th class="text-center">是否上架</th>
                                            <th class="text-center">操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($goods as $k=>$good):?>
                                        <tr>
                                            <td align="center"><?php echo $k+1;?></td>
                                            <td align="center"><img src="<?php echo $good['picture'].\Yii::$app->getModule('admin')->params['QN_SMALLER'];?>"></td>
                                            <td align="center"><?php echo $good->category->title;?></td>
                                            <td align="center"><a href="<?php echo \yii\helpers\Url::to(['/goods/detail','id'=>$good['id']]);?>"><?php echo $good['name'];?></a></td>
                                            <td align="center"><?php echo $good['stock'];?></td>
                                            <td align="center"><?php echo $good['price'];?></td>
                                            <td align="center"><?php echo \Yii::$app->getModule('admin')->params['IS_SALE'][$good['is_sale']];?></td>
                                            <td align="center"><?php echo $good['sale_price'];?></td>
                                            <td align="center"><?php echo \Yii::$app->getModule('admin')->params['IS_ON_SALE'][$good['is_on_sale']];?></td>
                                            <td align="center">

                                                <?php if(0===(int)$good['is_on_sale']):?>
                                                    <a href="<?php echo \yii\helpers\Url::to(['goods/change-status','id'=>$good['id']]);?>" class="btn btn-palegreen btn-sm shiny"><i class="fa fa-arrow-up"></i>上架</a>
                                                <?php else:?>
                                                    <a href="<?php echo \yii\helpers\Url::to(['goods/change-status','id'=>$good['id']]);?>" class="btn btn-warning btn-sm shiny"><i class="fa fa-arrow-down"></i>下架</a>
                                                <?php endif;?>
                                                <a href="<?php echo \yii\helpers\Url::to(['goods/edit','id'=>$good['id']]);?>" class="btn btn-primary btn-sm shiny">
                                                    <i class="fa fa-edit"></i> 编辑
                                                </a>
                                                <a href="javascript:if(confirm('确认删除该商品吗？')){window.location.href='<?php echo \yii\helpers\Url::to(["goods/delete","id"=>$good['id']]);?>'}"  class="btn btn-danger btn-sm shiny">
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
                                        'prevPageLabel'=>'上一页',
                                        'nextPageLabel'=>'下一页'
                                    ]);?>
                                </div>
                                <div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

