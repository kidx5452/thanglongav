<section id="box-youtube-net">
    <div class="container">
        <div class="heading-box"><span>{{ object.name }}</span></div>
        <div class="slide-videos owl-theme">
            {% for item in object.listarticle %}
                <article class="module-videos">
                    <div class="article-thumb videos-icon">
                        <figure><a class="wmBox" href="{{ item.getlink() }}" data-popup=""><img title="{{ item.name }}" src="/{{ item.avatar }}" alt=""/></a></figure>
                    </div>
                    <div class="article-videos">
                        <p class="article-date">{{ item.captions }}</p>
                        <h3><a href="{{ item.getlink() }}" title="{{ item.name }}">{{ item.name }}</a></h3>
                    </div>
                </article><!--End-->
            {% endfor %}

        </div>
    </div>
</section><!--End-box-youtube-net-->