<section id="tlav-spdh">
    <div class="heading-box"><span>{{ object['name'] }}</span></div>
    <div class="box-ground">
        <div class="container">
            <ul class="list-ground">
                {% for article in object['articles'] %}
                    <li class="col-md-4 col-sm-4 col-xs-12">
                        <h4><a href="{{ article.getlink() }}">{{ article.name }}</a></h4>
                        <figure class="videos-icon">
                            <a class="wmBox" href="{{ article.getlink() }}">
                                <img src="/{{ article.avatar }}" alt=""/>
                            </a>
                        </figure>

                        <p class="sapo">{{ article.captions }}</p>
                    </li>
                {% endfor %}
            </ul>
        </div>
    </div>

</section><!--End-tlav-spdh-->