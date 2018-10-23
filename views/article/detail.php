
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
                    <div class="shop-widget">
                        <h4 class="shop-sidebar-title">Search Products</h4>
                        <div class="shop-search mt-25 mb-50">
                            <form class="shop-search-form">
                                <input type="text" placeholder="Find a product">
                                <button type="submit">
                                    <i class="icon-magnifier"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="shop-widget mt-50">
                        <h4 class="shop-sidebar-title">Food Category </h4>
                        <div class="shop-list-style mt-20">
                            <ul>
                                <li><a href="#">Canned Food</a></li>
                                <li><a href="#">Dry Food</a></li>
                                <li><a href="#">Food Pouches</a></li>
                                <li><a href="#">Food Toppers</a></li>
                                <li><a href="#">Fresh Food</a></li>
                                <li><a href="#">Frozen Food</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="shop-widget mt-50">
                        <h4 class="shop-sidebar-title">Top Brands </h4>
                        <div class="shop-list-style mt-20">
                            <ul>
                                <li><a href="#">Authority</a></li>
                                <li><a href="#">AvoDerm Natural</a></li>
                                <li><a href="#">Bil-Jac</a></li>
                                <li><a href="#">Blue Buffalo</a></li>
                                <li><a href="#">Castor & Pollux</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="shop-widget mt-50">
                        <h4 class="shop-sidebar-title">Tags </h4>
                        <div class="shop-list-style mt-20">
                            <ul>
                                <li><a href="#">Food </a></li>
                                <li><a href="#">Fish </a></li>
                                <li><a href="#">Dog </a></li>
                                <li><a href="#">Cat  </a></li>
                                <li><a href="#">Pet </a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="shop-widget mt-50">
                        <h4 class="shop-sidebar-title">Health Consideration </h4>
                        <div class="shop-list-style mt-20">
                            <ul>
                                <li><a href="#">Bone Development <span>18</span></a></li>
                                <li><a href="#">Digestive Care <span>22</span></a></li>
                                <li><a href="#">General Health <span>19</span></a></li>
                                <li><a href="#">Hip & Joint  <span>41</span></a></li>
                                <li><a href="#">Immune System  <span>22</span></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="shop-widget mt-50">
                        <h4 class="shop-sidebar-title">Nutritional Option </h4>
                        <div class="shop-list-style mt-20">
                            <ul>
                                <li><a href="#">Grain Free  <span>18</span></a></li>
                                <li><a href="#">Natural <span>22</span></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="shop-widget mt-50">
                        <h4 class="shop-sidebar-title">Recent Post</h4>
                        <div class="recent-post-wrapper mt-25">
                            <div class="single-recent-post mb-20">
                                <div class="recent-post-img">
                                    <a href="#"><img src="/img/blog/blog-s1.jpg" alt=""></a>
                                </div>
                                <div class="recent-post-content">
                                    <h4><a href="#">My Dog, Aren</a></h4>
                                    <span>April 19, 2018 </span>
                                </div>
                            </div>
                            <div class="single-recent-post mb-20">
                                <div class="recent-post-img">
                                    <a href="#"><img src="/img/blog/blog-s2.jpg" alt=""></a>
                                </div>
                                <div class="recent-post-content">
                                    <h4><a href="#">My Dog, Tomy</a></h4>
                                    <span>April 19, 2018 </span>
                                </div>
                            </div>
                            <div class="single-recent-post mb-20">
                                <div class="recent-post-img">
                                    <a href="#"><img src="/img/blog/blog-s3.jpg" alt=""></a>
                                </div>
                                <div class="recent-post-content">
                                    <h4><a href="#">My Dog, Suju</a></h4>
                                    <span>April 19, 2018 </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

