<section id="tlav-daotao">
    <div class="heading-special"><h2>Ưu thế vượt trội</h2></div>
    <div class="container">
        <div class="row">
            <div class="box-uuthe">
                {% for item in object.uuthe %}
                <div class="col-md-6 col-sm-6">
                    <div class="block-ud wow bounceInLeft" data-wow-delay="0s">
                        <figure><img src="/frontend_res/skins/images/ico1.png" alt=""/></figure>
                        <h3>{{ item.name }}</h3>
                    </div>
                    <div class="list-dot wow fadeIn" data-wow-delay="0.4s">
                        {{ item.content }}
                    </div>
                </div>
                {% endfor %}
            </div><!--End-uuthe-->
        </div>
    </div>

    <div class="box-dtts">
        <h3>đối tượng tuyển sinh</h3>
        <div class="container">
            <ul>
                {% for key,item in object.tuyensinh %}
                <li class="wow bounceIn" data-wow-delay="0.2s">
                    <span>{{ key+1 }}</span>
                    <p class="sapo">{{ item.name }}</p>
                </li>
                {% endfor %}
            </ul>
        </div>
    </div><!--End-box-dtts-->

    <div class="nghanh-dt">
        <h4>CÁC NGÀNH ĐÀO TẠO</h4>
        <div class="container">
            <div class="row">
                <div class="pddt">
                    {% for item in object.nganhdaotao %}
                    <div class="col-md-6 col-sm-6 wow bounceInLeft" data-wow-delay="0.2s">
                        <figure><img src="/{{ item.avatar }}" alt=""></figure>
                        <span><a href="{{ item.getlink() }}">{{ item.name }}</a></span>
                    </div>
                    {% endfor %}
                </div>
            </div>
        </div>
    </div><!--End-nghanh-dt-->

    <div class="box-skill">
        <h2>Thăng Long Av</h2>
        <span>Được học các kỹ năng thực tế</span>
        <div class="container">
            <ul class="list-content row">
                {% for item in object.kynang %}
                <li class="col-md-4 col-sm-4 col-xs-12 wow fadeIn" data-wow-delay="0.2s">
                    <h3>{{ item.name }}</h3>
                    <p class="sapo">{{ item.captions }}</p>
                </li>
                {% endfor %}
            </ul><!--End-->
        </div>
    </div><!--End-box-skill-->

    <div class="teacher-slide">
        <h5>KIẾN THỨC VÀ KINH NGHIỆM THỰC TẾ TỪ GIẢNG VIÊN</h5>
        <div class="container">
            <div id="pd-teacher" class="slide-teacher">
                {% for item in object.giangvien %}
                <div class="pd">
                    <h6><a href="#">{{ item.name }}</a></h6><a href="{{ item.getlink() }}" title="">
                        <figure><img src="/{{ item.avatar }}" alt=""></figure></a>
                    <?php $arr = explode('-', $item->captions) ?>
                    <p>{{ arr[0] }}</p>
                    <p><strong>{{ arr[1] }}</strong></p>
                </div>
                {% endfor %}
            </div>
        </div>
    </div><!-- End teacher-slide -->

</section><!--End-tlav-daotao-->