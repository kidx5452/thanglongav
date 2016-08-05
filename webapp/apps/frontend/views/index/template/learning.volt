<section id="box-trainning">
    <div class="container">
        {#<div class="bg-while-bot"></div>#}
        <div class="row">
            <div class="heading-box"><h2>Thanglong Av</h2><span>{{ object.name }}</span></div>
            <div class="col-md-6 col-sm-6 box-list">
                {% for item in object.listarticle %}
                    <div class="box-md fr wow bounceInLeft" data-wow-delay="0.2s">
                        <p class="title pull-right">{{ item.name }}</p>

                        <p class="sapo text-right">{{ item.captions }}</p>
                        <figure><img class="fr" src="/{{ item.avatar }}" alt=""/></figure>
                    </div>
                {% endfor %}
            </div>
            <div class="col-md-6 col-sm-6 box-list">
                {% for item in object.listarticle2 %}
                    <div class="box-md wow bounceInRight" data-wow-delay="0.4s">
                        <p class="title pull-left">{{ item.name }}</p>

                        <p class="sapo text-left">{{ item.captions }}</p>
                        <figure><img class="fl" src="/{{ item.avatar }}" alt=""/></figure>
                    </div>
                {% endfor %}
            </div>
        </div>
    </div>

</section><!--End-trainning-->