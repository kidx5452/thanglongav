<!--  summernote -->
<link href="/backend_res/js/summernote/dist/summernote.css" rel="stylesheet">

<div class="row">
    <div class="col-md-12">
        <section class="panel-">
            <a href="{{ url('/article/index') }}" class="btn btn-sm btn-success addon-btn m-b-10"><i class="zmdi zmdi-arrow-left"></i> {{ labelkey['general.lbl_back'] }}</a>
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
                                            <label class="col-md-2 control-label">{{ labelkey['article.lbl_name'] }}</label>
                                            <div class="col-md-8"><input type="text" name="name" value="{{ object.name }}" class="form-control"></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">{{ labelkey['article.lbl_descriptions'] }}</label>
                                            <div class="col-md-8"><input type="text" name="captions" value="{{ object.captions }}" class="form-control"></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">{{ labelkey['article.lbl_thumb'] }} (600x400)</label>
                                            <div class="col-md-8">
                                                {% if object.avatar|length >0 %}
                                                    <p class="clearfix"><a href="{{ media.host~object.avatar }}" target="_blank"><img width="250" src="{{ media.host~object.avatar }}" alt="Cover Photo"></a></p>
                                                {% endif %}
                                                <input id="file-0" class="file" type="file" name="avatar" accept="image/*">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">{{ labelkey['article.lbl_coveravatar'] }} (120x100, 1600x1067)</label>
                                            <div class="col-md-8">
                                                {% if object.coveravatar|length >0 %}
                                                    <p class="clearfix"><a href="{{ media.host~object.coveravatar }}" target="_blank"><img width="250" src="{{ media.host~object.coveravatar }}" alt="Cover Photo"></a></p>
                                                {% endif %}
                                                <input id="file-0" class="file" type="file" name="coveravatar" accept="image/*">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">{{ labelkey['article.lbl_coverphoto'] }} (1600x333)</label>
                                            <div class="col-md-8">
                                                {% if object.coverphoto|length >0 %}
                                                    <p class="clearfix"><a href="{{ media.host~object.coverphoto }}" target="_blank"><img width="500" src="{{ media.host~object.coverphoto }}" alt="Cover Photo"></a></p>
                                                {% endif %}
                                                <input id="file-0" class="file" type="file" name="coverphoto" accept="image/*">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">{{ labelkey['article.lbl_covervideo'] }}</label>
                                            <div class="col-md-8"><input type="text" name="cover_video" value="{{ object.cover_video }}" class="form-control" placeholder="Link youtube - VD: https://www.youtube.com/watch?v=X8P-0GKTycs"></div>
                                        </div>
                                        {%  if checkperrmission("news_updatestatus")==1 %}
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">{{ labelkey['article.lbl_status'] }}</label>
                                                <div class="col-md-8">
                                                    <div class="radio-custom radio-success inline">
                                                        <input {% if object.status == 0 %}checked="checked"{% endif %} type="radio" value="0" name="status" id="0">
                                                        <label for="0">{{ labelkey['general.lbl_hide'] }}</label>
                                                    </div>
                                                    <div class="radio-custom radio-success inline">
                                                        <input {% if object.status == 1 %}checked="checked"{% endif %} type="radio" value="1" name="status" id="1">
                                                        <label for="1">{{ labelkey['general.lbl_show'] }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        {% endif %}
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">{{ labelkey['article.lbl_content'] }}</label>
                                            <div class="col-md-8">
                                                <textarea class="form_editor" id="summernote" name="content">{{ object.content }}</textarea>
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

<!--summernote-->
<script src="/backend_res/js/summernote/dist/summernote.min.js"></script>

<script>
    jQuery(document).ready(function () {
        loadTinyMce('form_editor');
        getAjaxCat();
    });

    function getAjaxCat() {
        $.post("{{ url('/category/getajaxmenu') }}",
                {
                    atid: {{ _GET['id'] ? _GET['id'] : 0  }}
                },
                function (data, status) {
                    $('#category-choose').html(data);
                });
    }
</script>