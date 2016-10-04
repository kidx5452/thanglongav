<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ header['title'] }}</title>
    <meta name="description" content="{{ header['desc'] }}"/>
    <meta name="keyword" content="{{ header['keyword'] }}"/>
    <meta name="robots" content="index, follow"/>
    <meta content='wsi.vn' name='author'/>
    <meta content='index, follow' name='GOOGLEBOT'/>
    <meta content='index, follow' name='yahooBOT'/>
    <meta name="Slurp" content="index,follow"/>
    <meta name="revisit-after" content="1 days"/>
    <meta name="MSNBot" content="index,follow"/>
    <meta http-equiv="Content-Language" content="vi"/>
    <meta name="revisit-after" content="1 days"/>
    <meta property="og:title" content="{{ header['title'] }}"/>
    <meta property="og:url" content="{{ header['canonial'] }}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:image" content="{{ header['image'] }}"/>
    <meta property="og:site_name" content="thanglongav.vn"/>
    <meta property="og:description" content="{{ header['desc'] }}"/>
    <link rel="shortcut icon" href="http://demo.thanglongav.vn/frontend_res/skins/images/logo.png">
    <link rel="canonical" href="{{ header['canonial'] }}"/>
    <link rel="alternate feed" type="application/rss+xml" title="Sitemap" href="http://thanglongav.vn/sitemap"/>

    <link rel="stylesheet" href="/frontend_res/skins/style.css" type="text/css" media="all">
    <link rel="stylesheet" href="/frontend_res/skins/responsive.css" type="text/css" media="all">
    <link rel="stylesheet" href="/frontend_res/skins/font-awesome.css" type="text/css" media="all">
    <link rel="stylesheet" href="/frontend_res/skins/carousel.css" type="text/css" media="all">
    <link rel="stylesheet" href="/frontend_res/skins/menu-clean.css" type="text/css" media="all">
    <link rel="Stylesheet" href="/frontend_res/skins/animate.css" type="text/css" media="all">
    <link href="/frontend_res/skins/royalslider.css" rel="stylesheet">

    <script type="text/javascript" src="/frontend_res/js/jquery.min.js"></script>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script type="text/javascript" src="/frontend_res/js/bootstrap.min.js"></script>


</head>

<body>

<header>
    <div id="hometop" class="header-top">
        <div class="container">
            <ul class="link-top">
                <li><a href="/">THANGLONGAV.VN</a></li>
                <li><a href="/">DAOTAO.THANGLONGAV.VN</a></li>
            </ul>
            <div class="col-share">
                <ul class="social-network social-circle">
                    <li><a href="{{ configs['facebook']['contents'] }}" class="icoFacebook" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="{{ configs['youtube']['contents'] }}" class="icoLinkedin" title="Youtube"><i class="fa fa-youtube-play"></i></a></li>
                    <li><a href="{{ configs['google']['contents'] }}" class="icoGoogle" title="Google +"><i class="fa fa-google-plus"></i></a></li>
                </ul>
            </div>
        </div>
    </div><!--End_header_top-->

    <div class="bghead">
        <div class="container">

            <div class="col-md-2 col-sm-12 col-xs-12">
                <h1 class="logo-tlav">
                    <a href="/"><img src="/frontend_res/skins/images/logo.png" alt=""></a>
                </h1> <!-- /.logo -->
            </div>

            <div class="col-md-10 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="navbar-header">
                        <button class="btn responsive-menu pull-left collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                            Menu
                        </button>
                    </div><!-- /.navbar-header -->
                    <div class="navbar-collapse collapse">
                        {{ topmenu }}
                    </div><!-- /.navbar-collapse -->

                </div>
            </div> <!-- /.col-md-10 -->
        </div><!-- /.container -->
    </div>
</header>
{% if slideshow|length >0  %}

        <div id="gallery-vy" class="royalSlider rsDefault visibleNearby">
            {% for key,item in slideshow %}
                <a class="rsContent" href="{{ item.url }}">
                   {{ item.slidemedia() }}
                </a>
            {% endfor %}
        </div>

        {#<div id="myCarousel" class="carousel slide" data-ride="carousel">

            <ol class="carousel-indicators">
                {% for key,item in slideshow %}
                    <li data-target="#myCarousel" data-slide-to="{{ key }}" class="{{ key==0?"active":"" }}"></li>
                {% endfor %}
            </ol><!-- Indicators -->
            <div class="carousel-inner">
                {% for key,item in slideshow %}
                    <div class="item {{ key==0?'active':'' }}">
                        <a href="{{ item.url }}"><img src="/{{ item.avatar }}" alt=""></a>
                        <div class="container">
                            <div class="carousel-caption">
                                <div class="animated fadeIn wow animated" data-wow-delay="0.5s">
                                    {{ item.captions }}
                                </div>
                            </div><!--/.content -->
                        </div><!--/.container -->
                    </div>
                {% endfor %}
            </div>
            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev"><span class="icon-prev"></span></a>
            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next"><span class="icon-next"></span></a>
        </div><!-- /.carousel -->#}

{% else %}
    <section>
        <div style="height: 100px;width: 100%"></div>
    </section>
{% endif %}

{{ content() }}

<section id="partner">
    <div class="container">
        <div id="slide-partner" class="slide-kh">

            {% for item in list_partner %}
                <div><a href="" title="{{ item.name }}"><img src="{{ media.host~item.avatar }}" alt=""></a></div>
            {% endfor %}
        </div><!-- End slide-partner -->
    </div>
</section><!--End-partner-->

<section id="tlav-contact">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-sm-6 drawer">
                <div class="drawer-item">
                    <div class="drawer-header bg-contact">
                        <div class="overlay"></div>
                        <h1>LIÊN HỆ</h1>
                        <div class="drawer-header-icon"><i class="fa fa-angle-down"></i></div>
                    </div>
                    <div class="drawer-content">
                        <div class="form-contact">
                            <form action="{{ url("index/contact") }}" method="post" class="tlav-form">
                                <p class="col-md-12 field"><input type="text" name="name" value="" size="40" placeholder="Họ tên"></p>
                                <p class="col-md-12 field"><input type="text" name="phone" value="" size="40" placeholder="Số điện thoại"></p>
                                <p class="col-md-12 field"><input type="text" name="email" value="" size="40" placeholder="Email"></p>
                                <p class="col-md-12 field"><textarea name="contents" cols="40" rows="10" placeholder="Nội dung"></textarea></p>
                                <p class="col-md-12 submit-wrap ">
                                    <input type="submit" value="Gửi thông tin" class="btn-gui btn-primary">
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 drawer">
                <div class="drawer-item">
                    <div class="drawer-header bg-join-tlav">
                        <div class="overlay"></div>
                        <h1>Làm việc với tlav</h1>
                        <div class="drawer-header-icon"><i class="fa fa-angle-down"></i></div>
                    </div>
                    <div class="drawer-content">
                        {{ configs['work']['contents'] }}
                    </div>
                </div>
            </div><!-- /#drawer -->
        </div>
    </div>
</section><!--End-tlav-contact-->

<section id="tlav-he">
    <div class="container">
        <div class="row">
            <div class="box-tlav-he">
                <div class="col-md-7 col-sm-6 hotline-f">
                    HOTLINE<br><strong>{{ configs['hotline']['contents'] }}</strong>
                </div>
            </div>
            <div class="box-tlav-he">
                <div class="col-md-5 col-sm-6 email-f">
                    EMAIL<br><strong>{{ configs['email']['contents'] }}</strong>
                </div>
            </div>
        </div>
    </div>
</section><!--End-tlav-he-->

<section id="footer">
    <div class="footer-content">
        <div class="goto-top">
            <a data-scroll href="#hometop" class="arrow-top goup">
                <span>
                    <span class="fa fa-angle-double-up fa-2x"></span>
                    <span class="fa fa-angle-double-up fa-2x"></span>
                    <span class="fa fa-angle-double-up fa-2x"></span>
                    <span class="fa fa-angle-double-up fa-2x"></span>
                    <span class="fa fa-angle-double-up fa-2x"></span>
                </span>
            </a>
        </div>

        <p>
            {{ configs['footer']['contents']|nl2br }}
        </p>
    </div>
</section><!-- End-footer -->

<div class="modal fade" id="idbuy" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dk" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                <h4 class="modal-title" id="myModalLabel">Mua hàng</h4>
                <p>Mời nhập thông tin mua hàng</p>
            </div>
            <div class="modal-body">
                <form class="bv-form">
                    <ul class="form-gui">
                        <li><label>Họ tên</label><input class="input-d" type="text" value="" placeholder="Nguyễn Văn A"></li>
                        <li><label>Email</label><input class="input-d" type="text" value="" placeholder="nguyenvana@gmail.com"></li>
                        <li><label>Số điện thoại</label><input class="input-d" type="text" value="" placeholder="0988xxxxxx"></li>
                        <li><input type="submit" class="btnform" value="Gửi"></li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
</div><!-- End-Modal -->
<script type="text/javascript" src="/frontend_res/js/jquery.smartmenus.js"></script>
<script type="text/javascript" src="/frontend_res/js/owl.carousel.js"></script>
<script type="text/javascript" src="/frontend_res/js/smooth-scroll.js"></script>
<script type="text/javascript" src="/frontend_res/js/wow.min.js"></script>
<script type="text/javascript" src="/frontend_res/js/jquery.royalslider.min.js"></script>
<script type="text/javascript" src="/frontend_res/js/call-option.js"></script>

</body>
</html>