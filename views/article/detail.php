
<div class="breadcrumb-area pt-95 pb-95 bg-img" style="background-image:url(/img/banner/banner-2.jpg);">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <h2>Blog Details</h2>
            <ul>
                <li><a href="<?php echo yii\helpers\Url::to(['index/index']);?>">首页</a></li>
                <li class="active">博客详情</li>
            </ul>
        </div>
    </div>
</div>
<div class="shop-area pt-100 pb-100">
    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-lg-9 col-md-8">
                <div class="blog-details-wrapper res-mrg-top">
                    <div class="single-blog-wrapper">
                        <div class="blog-details-content">
                            <h2><?php echo $article->title;?></h2>
                            <div class="blog-meta">
                                <ul>
                                    <li>发表时间：<?php echo $article->create_time;?></li>
                                    <li>
                                        评论数：20
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <?php echo $article->content;?>

                        <div class="blog-dec-tags-social">
                            <div class="blog-dec-tags">
                                <ul>
                                    <li><a href="<?php echo \yii\helpers\Url::to(['article/by-tag','id'=>$article->tag->id]);?>">所属标签：<?php echo $article->tag->name;?></a></li>
                                </ul>
                            </div>
                            <div class="blog-dec-social">
                                <span>share :</span>
                                <ul>
                                    <li><a href="#"><i class="icon-social-twitter"></i></a></li>
                                    <li><a href="#"><i class="icon-social-instagram"></i></a></li>
                                    <li><a href="#"><i class="icon-social-dribbble"></i></a></li>
                                    <li><a href="#"><i class="icon-social-linkedin"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="blog-comment-wrapper mt-55">
                        <h4 class="blog-dec-title">comments : 02</h4>
                        <div class="single-comment-wrapper mt-35">
                            <div class="blog-comment-img">
                                <img src="/img/blog/blog-comment1.png" alt="">
                            </div>
                            <div class="blog-comment-content">
                                <h4>Anthony Stephens</h4>
                                <span>October 14, 2018 </span>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolor magna aliqua. Ut enim ad minim veniam, </p>
                                <div class="blog-details-btn">
                                    <a href="blog-details.html">read more</a>
                                </div>
                            </div>
                        </div>
                        <div class="single-comment-wrapper mt-50 ml-125">
                            <div class="blog-comment-img">
                                <img src="/img/blog/blog-comment2.png" alt="">
                            </div>
                            <div class="blog-comment-content">
                                <h4>Anthony Stephens</h4>
                                <span>October 14, 2018 </span>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolor magna aliqua. Ut enim ad minim veniam, </p>
                                <div class="blog-details-btn">
                                    <a href="blog-details.html">read more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="blog-reply-wrapper mt-50">
                        <h4 class="blog-dec-title">post a comment</h4>
                        <form action="#">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="leave-form">
                                        <input type="text" placeholder="Full Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="leave-form">
                                        <input type="email" placeholder="Eail Address ">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="text-leave">
                                        <textarea placeholder="Massage"></textarea>
                                        <input type="submit" value="SEND MASSAGE">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
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

