<section id="news-cate">
    <div class="heading-catagories">
        <h2>Bản quyền video</h2>
    </div><!--End-->
    <div class="container">
        <div class="row">
            <div class="sidebar-left col-md-9 col-sm-8 col-xs-12">

                <div class="bg-news">
                    <article class="thumbnail-music-view">

                        <div class="row">
                            <div class="col-md-4">
                                <figure><img src="/{{ object.data.avatar }}" alt=""></figure>
                                <div class="list-music-info">
                                    <ul>
                                        <li>
									  <span class="bold">
										<span class="shape"><i class="fa fa-calendar"></i></span>Phát hành:
									  </span> {{ date("d-m-Y",object.data.date_publish) }}
                                        </li>
                                        <li>
									  <span class="bold">
										<span class="shape"><i class="fa fa-clock-o"></i></span>Thời gian:
									  </span> {{ object.data.duration }}
                                        </li>
                                        <li>
									  <span class="bold">
										<span class="shape"><i class="fa fa-users"></i></span>Nhà sản xuất:
									  </span> {{ object.data.manufacture }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="title-music">{{ object.data.name }}</div>
                                <div class="contents-music">
                                    {{ object.data.content }}
                                </div>
                                {#<div class="button-wrap">
                                    <a href="#">
                                        <div class="def-button" data-toggle="modal" data-target="#idbuy"><div class="price">{{ object.data.price }}$</div> Mua ngay</div>
                                    </a>
                                </div>#}
                                <div class="block_timer_share">
                                    <div class="block_timer pull-left"><strong>CHIA SẺ</strong></div>
                                    <div class="pull-right">
                                        <a class="tooltip-top" href="#" title="Share Facebook"><img alt="" src="/frontend_res/skins/images/ico-facebook.png"></a>
                                        <a class="tooltip-top" href="#" title="Share Twitter"><img alt="" src="/frontend_res/skins/images/ico-twitter.png"></a>
                                        <a class="tooltip-top" href="#" title="Share G+"><img alt="" src="/frontend_res/skins/images/ico-g.png"></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row clear">
                            <div class="heading-catagories mb-20"><h2>Video khác</h2></div>

                            {% for item in object.relatedpost %}
                                <div class="col-md-3 col-sm-6 col-xs-6 pd10">
                                    <div class="block-music">
                                        <div class="cover-outer-align">
                                            <figure><img src="/{{ item.Article.avatar }}" alt=""/></figure>
                                   <span class="icon-circle-play">
                                       <a class="button" href="#" title=""><i class="fa fa-play"></i></a>
                                   </span>
                                        </div>

                                        <div class="details">
                                            <h3><a href="#" class="title tooltip-top" title="{{ item.Article.name }}">{{ item.Article.name }}
                                                    <span class="paragraph-end"></span></a></h3>
                                            <div class="hide-ns"><a class="subtitle" href="{{ item.Article.getlink() }}" title="{{ item.Article.captions }}">{{ item.Article.captions }}</a>
                                                <span class="paragraph-end"></span></div>
                                        </div>
                                    </div>
                                </div>
                            {% endfor %}

                        </div>
                    </article>

                </div><!--End-->
            </div><!--End-sidebar-left-->

            <div class="sidebar-right col-md-3 col-sm-4 col-xs-12">

                <aside class="c-sidebar">
                    <h2>Tin tức</h2>
                    <ul class="xemnhieu">
                        <figure><img alt="" src="/frontend_res/images/n1.jpg"></figure>
                        {% for item in object.news %}
                            <li><a title=""  href="{{ item.getlink() }}">{{ item.name }}</a></li>
                        {% endfor %}
                    </ul>
                </aside><!--End-->
            </div><!--End-sidebar-right-->

        </div>
    </div>

</section><!--End--> 