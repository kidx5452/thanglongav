<section id="tlav-alb-vd">
    <div class="heading-box"><h2>Thanglong Av</h2><span>{{ object.name }}</span></div>

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
                            <a href="/category/detail/{{ object.id }}?type=audio" class="customLink">Xem thêm</a>
                        </div>
                    </div>
                </article>

                <div class="col-md-9 col-sm-7">
                    <div class="row">
                        {% for item in object.audio %}
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
                            <a href="/category/detail/{{ object.id }}?type=video" class="customLink">Xem thêm</a>
                        </div>
                    </div>
                </article>

                <div class="col-md-9 col-sm-7">
                    <div class="row">
                        {% for item in object.video %}
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
    <!--End-box-video-->


    <div class="heading-special">
        <h2>trao đổi bản quyền</h2>
    </div>

    <div class="box-daily">
        <div class="clear-line">
            <div class="container">
                <div class="row">
                    {% for item in object.copyright1 %}
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="feather-dl row">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <figure><img src="/{{ item.avatar }}" alt=""/></figure>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <h3>{{ item.name }}</h3>

                                    <p>{{ item.captions }}</p>

                                    <p>{{ item.content }}</p>
                                </div>
                            </div>
                        </div>
                    {% endfor %}
                </div>
            </div>
        </div>
        <!--End-clear-line-->

        <div class="clear-line none">
            <div class="container">
                <div class="row">
                    {% for item in object.copyright2 %}
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="feather-dl row">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <figure><img src="/{{ item.avatar }}" alt=""/></figure>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <h3>{{ item.name }}</h3>

                                    <p>{{ item.captions }}</p>

                                    <p>{{ item.content }}</p>
                                </div>
                            </div>
                        </div>
                    {% endfor %}
                </div>
            </div>
        </div>
        <!--End-clear-line-->

    </div>
    <!--End-daily-->
</section><!--End-tlav-spdh--> 