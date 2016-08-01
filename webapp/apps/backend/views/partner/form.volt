<!--  summernote -->
<link href="/backend_res/js/summernote/dist/summernote.css" rel="stylesheet">

<div class="row">
    <div class="col-md-12">
        <section class="panel-">
            <a href="{{ url('/partner/index') }}" class="btn btn-sm btn-success addon-btn m-b-10"><i class="zmdi zmdi-arrow-left"></i> {{ labelkey['general.lbl_back'] }}</a>
            <header class="panel-heading">{{ labelkey['partner.lbl_addnew'] }}</header>
            <div class="panel-body no-pad">
                <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                    <!--tab nav start-->
                    <section class="isolate-tabs">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a data-toggle="tab" href="#tab1">{{ labelkey['partner.lbl_info'] }}</a>
                            </li>
                        </ul>
                        <div class="panel-body">
                            <div class="tab-content">
                                <div id="tab1" class="tab-pane active">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">{{ labelkey['partner.lbl_name'] }}</label>
                                            <div class="col-md-8"><input type="text" name="name" value="{{ object.name }}" class="form-control"></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">{{ labelkey['partner.lbl_avatar'] }}</label>
                                            <div class="col-md-8">
                                                {% if object.avatar|length >0 %}
                                                    <p class="clearfix"><a href="{{ media.host~object.avatar }}" target="_blank"><img width="250" src="{{ media.host~object.avatar }}" alt="Cover Photo"></a></p>
                                                {% endif %}
                                                <input id="file-0" class="file" type="file" name="avatar" accept="image/*">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">{{ labelkey['partner.lbl_status'] }}</label>
                                            <div class="col-md-8">
                                                <div class="radio-custom radio-success inline">
                                                    <input {{ object.status is not defined or object.status == 1 ? 'checked' : '' }} type="radio" value="1" name="status" id="1">
                                                    <label for="1">{{ labelkey['general.lbl_show'] }}</label>
                                                </div>

                                                <div class="radio-custom radio-success inline">
                                                    <input {% if object.status == 0 %}checked="checked"{% endif %} type="radio" value="0" name="status" id="0">
                                                    <label for="0">{{ labelkey['general.lbl_hide'] }}</label>
                                                </div>

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