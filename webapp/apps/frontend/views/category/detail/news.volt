<section id="news-cate">
    <div class="heading-catagories">
        <h2>{{ object['name'] }}</h2>
    </div><!--End-->
    <div class="container">
        <div class="row">
            <div class="sidebar-left col-md-9 col-sm-8 col-xs-12">
                <div class="bg-news">
                    {% for item in object['articles'] %}
                    <div class="thumbnail-news wow animated fadeIn animated animated" data-wow-delay="0.2s">
                        <figure><img src="/{{ item.avatar }}" alt=""></figure>
                        <div class="caption">
                            <h3><a href="{{ item.getlink() }}">{{ item.name }}</a></h3>
                            <p class="date"><i class="fa fa-clock-o"></i> {{ date("d-m-Y",item.datecreate ) }}</p>
                            <p class="summary">{{ item.captions }}</p>
                        </div>
                    </div>
                    {% endfor %}
                </div><!--End-->
            </div><!--End-sidebar-left-->

            <div class="sidebar-right col-md-3 col-sm-4 col-xs-12">

                <aside class="c-sidebar">
                    <h2>Xem nhiều nhất</h2>
                    <ul class="xemnhieu">
                        <figure><img alt="" src="/frontend_res/images/n1.jpg"></figure>
                        <li><a title="" href="#">Tưng bừng khai giảng lớp DIỄN XUẤT khóa 1</a></li>
                        <li><a href="#">Lớp học vui nhộn....cô giáo xì tin ....vui tóa mệt tý không sao ^^ !!!</a></li>
                        <li><a href="#">Năng nổ, nhiệt tình.....Các bạn thử sức bản thân với các nhân vật trong phim...^^</a></li>
                        <li><a href="#">Tự diễn trước ống kính của… chính mình</a></li>
                        <li><a href="#">Các Học viên Hăng say với Buổi học Kỹ thuật Biểu diễn Sân khấu Điện ảnh của Cô Minh Vượng</a></li>
                        <li><a href="#">Những hình ảnh ngộ nghĩnh đáng yêu trong học tập, nhập vai của HV Khóa I</a></li>
                    </ul>
                </aside><!--End-->
            </div><!--End-sidebar-right-->

        </div>
    </div>

</section><!--End-->