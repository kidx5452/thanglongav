<section id="tlav-production">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-12">
                <div class="heading"><h2>Thanglong Av</h2><span>{{ object.name }}</span></div>
                <p class="sapo wow fadeIn" data-wow-delay="0.2s">{{ object.caption }}</p>
            </div>
            <div class="col-md-8 col-sm-12">
                <div class="tlav-sx tlav-featured">
                    <ul class="row">
                        {% for item in object.listarticle %}
                            <li class="col-md-4 col-sm-4 wow fadeIn" data-wow-delay="0.2s">
                                <figure>
                                    <a href="{{ item.getlink() }}"><img src="/{{ item.avatar }}" alt=""></a>
                                    {% if item.captions|length>0 %}<span class="sale-off">{{ item.captions }}</span>{% endif %}
                                    <a href="{{ item.getlink() }}" class="tlav-featured-hover"><i class="fa fa-link"></i></a>
                                </figure>
                                <div class="tlav-featured-text">
                                    <h3><a href="{{ item.getlink() }}">{{ item.name }}</a></h3>
                                    <div class="tlav-sx-time">
                                        <time>{{ date("d-m-Y",item.datecreate) }}</time>
                                        <a href="{{ item.getlink() }}" class="btn-cart" data-toggle="modal" data-target="#idbuy"><i class="fa fa-shopping-cart"></i> Mua</a>
                                    </div>
                                </div>
                            </li>
                        {% endfor %}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section><!--End-production-->