<!--bootstrap picker-->
<link rel="stylesheet" type="text/css" href="/backend_res/js/bootstrap-datepicker/css/datepicker.css"/>
<link rel="stylesheet" type="text/css" href="/backend_res/js/bootstrap-timepicker/compiled/timepicker.css"/>
<link rel="stylesheet" type="text/css" href="/backend_res/js/bootstrap-daterangepicker/daterangepicker-bs3.css"/>
<link rel="stylesheet" type="text/css" href="/backend_res/js/bootstrap-datetimepicker/css/datetimepicker.css"/>
<div class="row">
    <div class="col-md-12">
        <section class="panel-">
            <a href="{{ url('article/index') }}?catid={{ _GET['catid'] }}" class="btn btn-sm btn-success addon-btn m-b-10"><i class="zmdi zmdi-arrow-left"></i> {{ labelkey['general.lbl_back'] }}</a>
            <header class="panel-heading">{{ labelkey['article.lbl_addnew'] }}</header>
            <div class="panel-body no-pad">
                <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                    <!--tab nav start-->
                    <section class="isolate-tabs">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a data-toggle="tab" href="#tab1">{{ labelkey['article.lbl_info'] }}</a>
                            </li>
                            <li class="">
                                <a data-toggle="tab" href="#tab2">{{ labelkey['article.lbl_category'] }}</a>
                            </li>
                        </ul>
                        <div class="panel-body">
                            <div class="tab-content">
                                <div id="tab1" class="tab-pane active">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Type</label>
                                            <div class="col-md-8">
                                                <select name="types" id="" class="form-control">
                                                    {% for item in object['typesArticle'] %}
                                                        <option {{ item['key']==object['types']?"selected":"" }} value="{{ item['key'] }}">{{ item['name'] }}</option>
                                                    {% endfor %}
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">{{ labelkey['article.lbl_name'] }}</label>
                                            <div class="col-md-8"><input type="text" name="name" value="{{ object['name'] }}" class="form-control"></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Ca sỹ - nhạc sỹ</label>
                                            <div class="col-md-8"><input type="text" name="captions" value="{{ object['captions'] }}" class="form-control"></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label" for="dob">Ngày phát hành</label>
                                            <div class="col-md-10"><input type="text" data-date-format="dd-mm-yyyy" class="form-control form-control-inline input-medium default-date-picker" value="{{ date('d-m-Y',object['date_publish']) }}" name="date_publish"/></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Thời gian</label>
                                            <div class="col-md-8"><input type="text" name="duration" value="{{ object['duration'] }}" class="form-control"></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Số bài hát</label>
                                            <div class="col-md-8"><input type="text" name="countmedia" value="{{ object['countmedia'] }}" class="form-control"></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Nhà sản xuất</label>
                                            <div class="col-md-8"><input type="text" name="manufacture" value="{{ object['manufacture'] }}" class="form-control"></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Giá</label>
                                            <div class="col-md-8"><input type="text" name="price" value="{{ object['price'] }}" class="form-control"></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">{{ labelkey['article.lbl_thumb'] }}</label>
                                            <div class="col-md-8">
                                                {% if object['avatar']|length >0 %}
                                                    <p class="clearfix"><a href="/{{ object['avatar'] }}" target="_blank"><img width="250" src="/{{ object['avatar'] }}" alt="Cover Photo"></a></p>
                                                {% endif %}
                                                <input id="file-0" class="file" type="file" name="avatar" accept="image/*">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Link</label>
                                            <div class="col-md-8"><input type="text" name="cover_video" value="{{ object['cover_video'] }}" class="form-control" placeholder="http://"></div>
                                        </div>
                                        {%  if checkperrmission("news_updatestatus")==1 %}
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">{{ labelkey['article.lbl_status'] }}</label>
                                                <div class="col-md-8">
                                                    <div class="radio-custom radio-success inline">
                                                        <input {{ object['status']==0?"checked":"" }} type="radio" value="0" name="status" id="0">
                                                        <label for="0">{{ labelkey['general.lbl_hide'] }}</label>
                                                    </div>
                                                    <div class="radio-custom radio-success inline">
                                                        <input {{ object['status']==1?"checked":"" }} type="radio" value="1" name="status" id="1">
                                                        <label for="1">{{ labelkey['general.lbl_show'] }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        {% endif %}
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">{{ labelkey['article.lbl_content'] }}</label>
                                            <div class="col-md-8">
                                                <textarea class="form_editor" id="summernote" name="content">{{ object['content'] }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div id="tab2" class="tab-pane">
                                    <div id="category-choose"></div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!--tab nav start-->

                    <div class="action_area">
                        <button type="submit" class="btn btn-info">{{ labelkey['general.btn_save'] }}</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>


<script>
    jQuery(document).ready(function () {
        loadTinyMce('form_editor');
        getAjaxCat();
    });

    function getAjaxCat() {
        $.post("{{ url('/category/getajaxmenu') }}",
                {
                    atid: {{ _GET['id'] ? _GET['id'] : 0  }},
                    catid: '{{ _GET['catid'] }}'
                },
                function (data, status) {
                    $('#category-choose').html(data);
                });
    }
</script>
<!--bootstrap picker-->
<script type="text/javascript" src="/backend_res/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="/backend_res/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="/backend_res/js/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="/backend_res/js/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="/backend_res/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="/backend_res/js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>

<!--picker initialization-->
<script src="/backend_res/js/picker-init.js"></script>