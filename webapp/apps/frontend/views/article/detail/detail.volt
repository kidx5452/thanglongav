<section id="news-cate">
    <div class="heading-catagories">
        {#<h2>Nội dung chi tiết</h2>#}
    </div><!--End-->
    <div class="container">
        <div class="row">
            <div class="sidebar-left col-md-9 col-sm-8 col-xs-12">

                <div class="bg-news">
                    <article class="thumbnail-news-view">
                        <h1>{{ object.data.name }}</h1>
                        <div class="block_timer_share">
                            <div class="block_timer pull-left"><i class="fa fa-clock-o"></i> {{ date("d/m/Y",object.data.datecreate) }}</div>
                            <div class="block_share pull-right">
                                <a class="tooltip-top" href="#" title="Share Facebook"><img alt="" src="/frontend_res/skins/images/ico-facebook.png"></a>
                                <a class="tooltip-top" href="#" title="Share Twitter"><img alt="" src="/frontend_res/skins/images/ico-twitter.png"></a>
                                <a class="tooltip-top" href="#" title="Share G+"><img alt="" src="/frontend_res/skins/images/ico-g.png"></a>
                                <a class="tooltip-top" href="#" title="Email"><img alt="" src="/frontend_res/skins/images/ico-email.png"></a>
                                <a class="tooltip-top" href="#" title="Print"><img alt="" src="/frontend_res/skins/images/ico-print.png"></a>
                            </div>
                        </div>
                        <div class="post_content">
                            <p><strong>{{ object.data.captions }}</strong></p>
                            {{ object.data.content }}
                        </div>

                        <ul class="other-news-detail">
                            <h2>Tin tức khác</h2>
                            {% for item in object.relatedpost %}
                            <li>
                                <figure><img src="/{{ item.avatar }}" alt=""/></figure>
                                <figcaption><a href="{{ item.getlink() }}" title="">{{ item.name }}</a></figcaption>
                            </li>
                            {% endfor %}
                        </ul>
                    </article>

                </div><!--End-->
            </div><!--End-sidebar-left-->

            <div class="sidebar-right col-md-3 col-sm-4 col-xs-12">

                <aside class="c-sidebar">
                    <h2>Xem nhiều nhất</h2>
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