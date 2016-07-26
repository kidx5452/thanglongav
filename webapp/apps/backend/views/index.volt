<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="slick, flat, dashboard, bootstrap, admin, template, theme, responsive, fluid, retina">
    <link rel="shortcut icon" href="javascript:;" type="image/png">

    <title>WSI AdminCP</title>
    <!--google fonts-->
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,600,700&subset=latin,vietnamese' rel='stylesheet' type='text/css'/>

    <!--right slidebar-->
    <link href="/backend_res/css/slidebars.css" rel="stylesheet">

    <!--switchery-->
    <link href="/backend_res/js/switchery/switchery.min.css" rel="stylesheet" type="text/css" media="screen"/>

    <!--bootstrap-fileinput-master-->
    <link rel="stylesheet" type="text/css" href="/backend_res/js/bootstrap-fileinput-master/css/fileinput.css"/>

    <!--common style-->
    <link href="/backend_res/css/style.css" rel="stylesheet">
    <link href="/backend_res/css/style-responsive.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="/backend_res/js/html5shiv.js"></script>
    <script src="/backend_res/js/respond.min.js"></script>
    <![endif]-->
    <script src="/backend_res/js/jquery-1.10.2.min.js"></script>
    <script src="/backend_res/js/jquery-migrate.js"></script>
    <script src="/backend_res/js/bootstrap.min.js"></script>
    <script src='/backend_res/js/tinymce/jquery.tinymce.min.js'></script>
    <script src="/backend_res/js/general.js"></script>
</head>

<body class="sticky-header">

<section>
    <!-- sidebar left start-->
    <div class="sidebar-left">
        <!--responsive view logo start-->
        <div class="logo dark-logo-bg visible-xs-* visible-sm-*">
            <a href="/">
                <!--<i class="fa fa-maxcdn"></i>-->
                <span class="brand-name">WSI.vn</span>
            </a>
        </div>
        <!--responsive view logo end-->

        <div class="sidebar-left-info">
            <!-- visible small devices start-->
            <div class=" search-field"></div>
            <!-- visible small devices end-->

            <!--sidebar nav start-->
            <ul class="nav nav-pills nav-stacked side-navigation">
                <li>
                    <h3 class="navigation-title">Navigation</h3>
                </li>
                {% for item in sidebar %}
                    <li class="{{ item['child'] is not empty?'menu-list':'' }} {% if item['child'] is not empty %} {{ activesidebar==item['controller']?'nav-active':'' }} {% else %} {{ activesidebar==item['controller']?'active':'' }} {% endif %}">
                        <a href="{{ item['controller'] }}"><i class="{{ item['icon'] }}"></i> <span>{{ item['name'] }}</span></a>
                        {% if item['child'] is not empty %}
                            <ul class="child-list">
                                {% for citem in item['child'] %}
                                    <li class="{{ activesidebar==citem['controller']?"active":"" }}"><a class="{{ activesidebar==citem['controller']?"text-info":"" }}" href="{{ citem['controller'] }}">{{ citem['name'] }}</a></li>
                                {% endfor %}
                            </ul>
                        {% endif %}
                    </li>
                {% endfor %}
            </ul>

            <script>
                $(document).ready(function(){
                    var listli = $('.side-navigation li');
                    $.each(listli,function(){
                        var obj = $(this);
                        var childli = $(this).children('ul').find('li');
                        $.each(childli,function(){
                            if($(this).hasClass('active'))  $(obj).addClass('nav-active');
                        });
                    });
                });
            </script>
            <!--sidebar nav end-->


        </div>
    </div>
    <!-- sidebar left end-->

    <!-- body content start-->
    <div class="body-content" style="min-height: 1200px;">

        <!-- header section start-->
        <div class="header-section">

            <!--logo and logo icon start-->
            <div class="logo dark-logo-bg hidden-xs hidden-sm">
                <a href="{{ url("index/index") }}">
                    <!--<i class="fa fa-maxcdn"></i>-->
                    <span class="brand-name">WSI.vn</span>
                </a>
            </div>

            <div class="icon-logo dark-logo-bg hidden-xs hidden-sm">
                <a href="{{ url("index/index") }}">
                    <img src="/backend_res/img/logo-icon.png" alt="">
                    <!--<i class="fa fa-maxcdn"></i>-->
                </a>
            </div>
            <!--logo and logo icon end-->

            <!--toggle button start-->
            <a class="toggle-btn"><i class="fa fa-outdent"></i></a>
            <!--toggle button end-->

            <!--mega menu start-->
            <div id="navbar-collapse-1" class="navbar-collapse collapse yamm mega-menu">
                <ul class="nav navbar-nav">
                    <!-- Classic dropdown -->
                    <li class="dropdown"><a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle"> {{ language_active['name'] }} <b class=" fa fa-angle-down"></b></a>
                        <ul role="menu" class="dropdown-menu language-switch">
                            {% for item in langlist %}
                                <li>
                                    <a href="{{ url("index/changelanguage?lang=")~item['key'] }}&r={{ currenturl|url_encode }}"><span> {{ item['name'] }} </span></a>
                                </li>
                            {% endfor %}
                        </ul>
                    </li>

                </ul>
            </div>
            <!--mega menu end-->
            <div class="notification-wrap">
                <!--right notification start-->
                <div class="right-notification">
                    <ul class="notification-menu">
                        <li>
                            <a href="javascript:;" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                {{ labelkey['general.lbl_hello'] }} <b>{{ uinfo['username'] }}</b>
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu purple pull-right">
                                <li><a href="{{ url("user/form?id=")~uinfo['id'] }}"> {{ labelkey['general.lbl_profile'] }}</a></li>
                                <li><a href="{{ url("security/logout") }}"><i class="fa fa-sign-out pull-right"></i> {{ labelkey['general.lbl_logout'] }}</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!--right notification end-->
            </div>

        </div>
        <!-- header section end-->

        {{ flash.output() }}

        <!--body wrapper start-->
        <div class="wrapper">

            {{ content() }}

        </div>
        <!--body wrapper end-->


        <!--footer section start-->
        <footer>
            2016 &copy; HDBTeam. Developed by Nguyen The Co.
            <div id="loading"><img src="/backend_res/img/loading.gif" alt="Loading" /> Loading... </div>
        </footer>
        <!--footer section end-->

    </div>
    <!-- body content end-->
</section>

<!-- Placed js at the end of the document so the pages load faster -->

<script src="/backend_res/js/modernizr.min.js"></script>

<!--Nice Scroll-->
<script src="/backend_res/js/jquery.nicescroll.js" type="text/javascript"></script>

<!--right slidebar-->
<script src="/backend_res/js/slidebars.min.js"></script>

<!--switchery-->
<script src="/backend_res/js/switchery/switchery.min.js"></script>
<script src="/backend_res/js/switchery/switchery-init.js"></script>

<!--Sparkline Chart-->
<script src="/backend_res/js/sparkline/jquery.sparkline.js"></script>
<script src="/backend_res/js/sparkline/sparkline-init.js"></script>

<!--bootstrap-fileinput-master-->
<script type="text/javascript" src="/backend_res/js/bootstrap-fileinput-master/js/fileinput.js"></script>
<script type="text/javascript" src="/backend_res/js/file-input-init.js"></script>

<!--common scripts for all pages-->
<script src="/backend_res/js/scripts.js"></script>


</body>
</html>
