<section id="tlav-spdh">
    <div class="heading-box"><h2>Thanglong Av</h2><span>{{ object['name'] }}</span></div>
    {% for item in object['listchild'] %}
    <div class="box-ground">
        <h3>{{ item['name'] }}</h3>
        <div class="container">
            <ul class="list-ground">
                {% for article in item['listarticle'] %}
                <li class="col-md-4 col-sm-4 col-xs-12">
                    <h4><a href="#">{{ article['name'] }}</a></h4>
                    <figure class="videos-icon"><a class="wmBox" href="#" data-popup="https://www.youtube.com/embed/1t24XAntNCY"><img src="/{{ article['avatar'] }}" alt=""/></a></figure>
                    <p class="sapo">{{ article['captions'] }}</p>
                </li>
                {% endfor %}
            </ul>
            <div class="view-ct"><a href="#">Xem thêm</a></div>
        </div>
    </div><!--End-->
    {% endfor %}

</section><!--End-tlav-spdh-->