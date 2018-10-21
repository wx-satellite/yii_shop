<?php
$this->title='添加文章';
$this->params['breadcrumbs']=[['label'=>'文章列表','url'=>'/admin/blog/list'],['label'=>'添加文章']];
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
                                <div id="horizontal-form">
                                    <form class="form-horizontal" role="form" action="" method="post">
                                        <div class="form-group">
                                            <label for="username" class="col-sm-2 control-label no-padding-right">用户名</label>
                                            <div class="col-sm-6" >
                                                <input class="form-control" id="username" placeholder="" name="username" required="" type="text">
                                            </div>
                                            <p class="help-block col-sm-4 red">* 必填</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="username" class="col-sm-2 control-label no-padding-right">内容</label>
                                            <div class="col-sm-8" id="content">
                                               </div>

                                        </div>
                                        <div class="form-group">
                                            <label for="group_id" class="col-sm-2 control-label no-padding-right">用户角色</label>
                                            <div class="col-sm-6">
                                                <select name="group_id" style="width: 100%;">
                                                    <option selected="selected" value="8">测试</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit" class="btn btn-default">保存信息</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /Page Body -->
<?php $this->beginBlock('blog-add');?>
    var E = window.wangEditor
    var editor = new E('#content')
    // 或者 var editor = new E( document.getElementById('editor') )
    editor.create()
<?php $this->endBlock();?>
<?php $this->registerJs($this->blocks['blog-add'],\yii\web\View::POS_END);
