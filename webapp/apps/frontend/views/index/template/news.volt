<section id="box-news-home">
    <div class="container">
        <div class="row">
            <div class="heading-box"><h2>Thanglong Av</h2><span>{{ object.name }}</span></div>

            <ul class="main_list_news">
                {% for item in object.listarticle %}
                <li class="post_item col-md-6 col-sm-12 wow fadeIn" data-wow-delay="0.2s" >
                    <div class="frame frame_normal_margin">
                        <a href="{{ item.getlink() }}">
                            <img src="/{{ item.avatar }}" class="wp-post-image" alt="">
                        </a>
                    </div>
                    <div class="desc">
                        <h3><a class="title" href="{{ item.getlink() }}">{{ item.name }}</a></h3>
                        <div class="bar"></div>
                        <p class="summary">{{ item.captions }}</p>
                        <p><a href="{{ item.getlink() }}" class="more-link">Chi tiết</a></p>
                    </div>
                </li>
                {% endfor %}
            </ul>


        </div>
    </div>
</section><!--End-news-home--> 