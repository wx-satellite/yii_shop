
<div class="breadcrumb-area pt-95 pb-95 bg-img" style="background-image:url(/img/banner/banner-2.jpg);">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <h2>Blog List</h2>
            <ul>
                <li><a href="<?php echo \yii\helpers\Url::to(['index/index']);?>">首页</a></li>
                <li class="active">博客列表页</li>
            </ul>
        </div>
    </div>
</div>
<div class="shop-area pt-100 pb-100">
    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-lg-9 col-md-8">
                <div class="row">
                    <?php if($articles):?>
                    <?php foreach ($articles as $article):?>
                    <div class="col-lg-6 col-md-12">
                        <div class="blog-wrapper mb-30 gray-bg">
                            <div class="blog-img hover-effect">
                                <a href="<?php echo \yii\helpers\Url::to(['article/detail','id'=>$article->id]);?>"><img alt="" src="<?php echo $article->cover;?>"></a>
                            </div>
                            <div class="blog-content">
                                <div class="blog-meta">
                                    <ul>
                                        <li>作者: <span><?php echo $article->author;?></span></li>
                                        <li><?php echo date('Y-m-d',strtotime($article->create_time));?></li>
                                    </ul>
                                </div>
                                <h4><a href="<?php echo \yii\helpers\Url::to(['article/detail','id'=>$article->id]);?>"><?php echo $article->title;?></a></h4>
                            </div>
                        </div>
                    </div>
                    <?php endforeach;?>
                    <?php else:?>
                    <div class="col-lg-6 col-md-12" style="text-align: center;color: red;font-size: 20px;">该标签下暂时没有博客哦～</div>
                    <?php endif;?>
                </div>
                <div class="pagination-style text-center mt-10">

                        <?php echo yii\widgets\LinkPager::widget([
                            'pagination'=>$pager,
                        ]);?>

                </div>
            </div>
            <div class="col-lg-3 col-md-4">
                <div class="shop-sidebar blog-mrg">
                    <div class="shop-widget mt-50">
                        <h4 class="shop-sidebar-title">标签</h4>
                        <div class="shop-list-style mt-20">
                            <ul>
                                <?php unset($tags[''])?>
                                <?php foreach($tags as $k=>$tag):?>
                                <li><a href="<?php echo \yii\helpers\Url::to(['article/list','tag_id'=>$k]);?>"><?php echo $tag;?> </a></li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    </div>
                    <div class="shop-widget mt-50">
                        <h4 class="shop-sidebar-title">最新的博客</h4>
                        <div class="recent-post-wrapper mt-25">
                            <?php foreach($recent_articles as $k=>$article):?>
                            <?php if($k>=5) break;?>
                            <div class="single-recent-post mb-20">
                                <div class="recent-post-img">
                                    <a href="<?php echo \yii\helpers\Url::to(['article/detail','id'=>$article->id]);?>"><img src="<?php echo $article->cover;?>" alt=""></a>
                                </div>
                                <div class="recent-post-content">
                                    <h4><a href="<?php echo \yii\helpers\Url::to(['article/detail','id'=>$article->id]);?>"><?php echo $article->title;?></a></h4>
                                    <span><?php echo $article->create_time;?></span>
                                </div>
                            </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

