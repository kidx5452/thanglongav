<section id="tlav-alb-vd">
    <div class="heading-box"><h2>Thanglong Av</h2><span>{{ object['name'] }}</span></div>
    {% if object['selectType']=="audio" %}
        <div class="box-album">
            <div class="container mod-newsflash-adv posts">
                <div class="row">
                    <article class="col-md-3 col-sm-5 item item_num3">
                        <div class="item_content">
                            <div class="item_introtext">
                                <div class="postContent">
                                    <div class="postplay">
                                        <i class="fa fa-headphones fa-5x"></i>
                                    </div>
                                    <figcaption>Bản quyền audio</figcaption>
                                </div>
                            </div>
                    </article>

                    <div class="col-md-9 col-sm-7">
                        <div class="row">
                            {% for item in object['articles'] %}
                                <div class="col-md-3 col-sm-6 col-xs-6 pd10">
                                    <div class="block-music">
                                        <div class="cover-outer-align">
                                            <figure><img src="/{{ item.avatar }}" alt=""/></figure>
                                   <span class="icon-circle-play">
                                       <a class="button" href="{{ item.getlink() }}" title=""><i class="fa fa-play"></i></a>
                                   </span>
                                        </div>

                                        <div class="details">
                                            <h3><a href="{{ item.getlink() }}" class="title tooltip-top"
                                                   title="{{ item.name }}">{{ item.name }}
                                                    <span class="paragraph-end"></span></a></h3>

                                            <div class="hide-ns"><a class="subtitle" href="{{ item.getlink() }}"
                                                                    title="{{ item.captions }}">{{ item.captions }}</a>
                                                <span class="paragraph-end"></span></div>
                                        </div>
                                    </div>
                                </div>
                            {% endfor %}


                        </div>
                    </div>
                    <!-- /.our-listing -->

                </div>
            </div>
        </div>
        <!--End-box-album-->
    {% elseif object['selectType']=="video" %}
        <div class="box-video">
            <div class="container mod-newsflash-adv posts">
                <div class="row">
                    <article class="col-md-3 col-sm-5 item item_num1">
                        <div class="item_content">
                            <div class="item_introtext">
                                <div class="postContent">
                                    <div class="postplay">
                                        <i class="fa fa-play-circle fa-5x"></i>
                                    </div>
                                    <figcaption>Bản quyền video</figcaption>
                                </div>
                            </div>
                    </article>

                    <div class="col-md-9 col-sm-7">
                        <div class="row">
                            {% for item in object['articles'] %}
                                <div class="col-md-3 col-sm-6 col-xs-6 pd10">
                                    <div class="block-music">
                                        <div class="cover-outer-align">
                                            <figure><img src="/{{ item.avatar }}" alt=""/></figure>
                                   <span class="icon-circle-play">
                                       <a class="button" href="{{ item.getlink() }}" title=""><i class="fa fa-play"></i></a>
                                   </span>
                                        </div>

                                        <div class="details">
                                            <h3><a href="{{ item.getlink() }}" class="title tooltip-top"
                                                   title="{{ item.name }}">{{ item.name }}
                                                    <span class="paragraph-end"></span></a></h3>

                                            <div class="hide-ns"><a class="subtitle" href="{{ item.getlink() }}"
                                                                    title="{{ item.captions }}">{{ item.captions }}</a>
                                                <span class="paragraph-end"></span></div>
                                        </div>
                                    </div>
                                </div>
                            {% endfor %}


                        </div>
                    </div>
                    <!-- /.our-listing -->

                </div>
            </div>
        </div>
    {% else %}
        ...
    {% endif %}
    <!--End-box-video-->


    <!--End-daily-->
</section><!--End-tlav-spdh-->