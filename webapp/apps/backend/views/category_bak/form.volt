<div class="row">
    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
        <div class="col-md-12">
            <a href="{{ backurl }}" class="btn btn-sm btn-success addon-btn m-b-10"><i class="zmdi zmdi-arrow-left"></i> {{ labelkey['general.lbl_back'] }}</a>
            <section class="panel">
                <header class="panel-heading">
                    {{ labelkey['category.lbl_info'] }}
                </header>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['category.lbl_lang'] }}</label>
                        <div class="col-md-8">
                            <select class="form-control" name="lang">
                                {% for item in langlist %}
                                    <option {{ _POST['lang']==item['key'] or object.lang==item['key'] ?'selected':'' }} value="{{ item['key'] }}">{{ item['name'] }}</option>
                                {% endfor %}
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['category.lbl_name'] }}</label>
                        <div class="col-md-8"><input type="text" name="name" value="{{ object.name }}" class="form-control" placeholder="{{ labelkey['category.lbl_name'] }}" required></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['category.lbl_caption'] }}</label>
                        <div class="col-md-8"><input type="text" name="caption" value="{{ object.caption }}" class="form-control" placeholder="{{ labelkey['category.lbl_caption'] }}"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['category.lbl_descriptions'] }}</label>
                        <div class="col-md-8"><input type="text" name="descriptions" value="{{ object.descriptions }}" class="form-control" placeholder="{{ labelkey['category.lbl_descriptions'] }}"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['category.lbl_status'] }}</label>
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
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['category.lbl_parent'] }}</label>
                        <div class="col-md-8">
                            <select class="form-control" name="parentid">
                                {% for item in listdata %}
                                    <option {{ _GET['parentid']==item.id or object.parentid==item.id ? 'selected':'' }} value="{{ item.id }}">{{ item.name }}</option>
                                {% endfor %}
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['category.lbl_avatar'] }}</label>
                        <div class="col-md-8">
                            {% if object.avatar|length >0 %}
                                <p class="clearfix"><a href="{{ media.host~object.avatar }}" target="_blank"><img width="150" src="{{ media.host~object.avatar }}" alt="Avatar"></a></p>
                            {% endif %}
                            <input id="file-0" class="file" type="file" name="avatar" accept="image/*">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['category.lbl_coverphoto'] }}</label>
                        <div class="col-md-8">
                            {% if object.coverphoto|length >0 %}
                                <p class="clearfix"><a href="{{ media.host~object.coverphoto }}" target="_blank"><img width="500" src="{{ media.host~object.coverphoto }}" alt="Cover Photo"></a></p>
                            {% endif %}
                            <input id="file-0" class="file" type="file" name="coverphoto" accept="image/*">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['category.lbl_covervideo'] }}</label>
                        <div class="col-md-8"><input type="text" name="cover_video" value="{{ object.cover_video }}" class="form-control" placeholder="Link youtube - VD: https://www.youtube.com/watch?v=X8P-0GKTycs"></div>
                    </div>
                </div>
            </section>
        </div>

        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    {{ labelkey['category.lbl_moreinfo'] }}
                </header>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['category.lbl_type'] }}</label>
                        <div class="col-md-8">
                            <select class="form-control" name="type" id="cat-type">
                                <option value="single">{{ labelkey['category.lbl_singlecat'] }}</option>
                                <option {{ _POST['type']=='list' or object.type=='list' ?'selected':'' }} value="list">{{ labelkey['category.lbl_listcat'] }}</option>
                                <option {{ _POST['type']=='photo' or object.type=='photo' ?'selected':'' }} value="photo">{{ labelkey['category.lbl_photocat'] }}</option>
                                <option {{ _POST['type']=='video' or object.type=='video' ?'selected':'' }} value="video">{{ labelkey['category.lbl_videocat'] }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" id="content-area" style="display: {{ (_POST['type'] == '' and object.type == '') or _POST['type']=='single' or object.type=='single' ?'block':'none' }}">
                        <label class="col-md-2 control-label">{{ labelkey['category.lbl_content'] }}</label>
                        <div class="col-md-8"><textarea name="content" class="form-control form_editor">{{ object.content }}</textarea></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['category.lbl_layout'] }}</label>
                        <div class="col-md-8">
                            <select class="form-control" name="layout" id="cat-layout">
                                <option value="2col">{{ labelkey['category.lbl_2col'] }}</option>
                                <option {{ _POST['layout']=='3col' or object.layout=='3col' ?'selected':'' }} value="3col">{{ labelkey['category.lbl_3col'] }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" id="rightcontent-area" style="display: {{ _POST['layout']=='3col' or object.layout=='3col' ?'block':'none' }}">
                        <label class="col-md-2 control-label">{{ labelkey['category.lbl_rightcolcontent'] }}</label>
                        <div class="col-md-8"><textarea name="rightcolcontent" class="form-control form_editor">{{ object.rightcolcontent }}</textarea></div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    {{ labelkey['category.lbl_article_config'] }}
                </header>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['category.lbl_pin_article'] }}</label>
                        <div class="col-md-8">
                            <input type="text" value="{{ object.PinArticle.name }}" class="form-control pintop_atid" placeholder="{{ labelkey['category.lbl_pin_article'] }}">
                            <input type="hidden" name="pintop_atid" id="pintop_atid" value="{{ object.pintop_atid }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['category.lbl_left_article'] }}</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control left_atid" placeholder="{{ labelkey['category.lbl_left_article'] }}" value="{{ object.LeftArticle.name }}">
                            <input type="hidden" name="left_atid" id="left_atid" value="{{ object.left_atid }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['category.lbl_center_article'] }}</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control center_atid" placeholder="{{ labelkey['category.lbl_center_article'] }}" value="{{ object.CenterArticle.name }}">
                            <input type="hidden" name="center_atid" id="center_atid" value="{{ object.center_atid }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['category.lbl_right_article'] }}</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control right_atid" placeholder="{{ labelkey['category.lbl_right_article'] }}" value="{{ object.RightArticle.name }}">
                            <input type="hidden" name="right_atid" id="right_atid" value="{{ object.right_atid }}">
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-md-12">
            <input type="hidden" name="backurl" value="{{ _GET['back']==1?backurl:0 }}"/>
            <button type="submit" class="btn btn-info">{{ labelkey['general.btn_save'] }}</button>
        </div>
    </form>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        loadTinyMce('form_editor');

        $('#cat-type').change(function () {
            if($('#cat-type').val()=='single') $('#content-area').show(); else $('#content-area').hide();
        });
        $('#cat-layout').change(function () {
            if($('#cat-layout').val()=='3col') $('#rightcontent-area').show(); else $('#rightcontent-area').hide();
        });

    });
</script>
<!--typeahead-->
<script type="text/javascript" src="/js/bootstrap3-typeahead.js"></script>
<!--nestable -->
<script src="/js/nestable/jquery.nestable.js"></script>

<script type="text/javascript">
    suggesstion('.pintop_atid','#pintop_atid','{{ url('/article/getbyname') }}');
    suggesstion('.left_atid','#left_atid','{{ url('/article/getbyname') }}');
    suggesstion('.center_atid','#center_atid','{{ url('/article/getbyname') }}');
    suggesstion('.right_atid','#right_atid','{{ url('/article/getbyname') }}');
    var oID = [];
    var oName = [];
    function suggesstion(idinput,area,getUrl) {
        $(''+idinput).typeahead({
            source: function (query, process) {
                return $.get(getUrl, {q: query}, function (data) {
                    var objects = [];
                    $.each(data, function (i, o) {
                        oID[o.name + ' [ID: ' + o.id + ']'] = o.id;
                        oName[o.name + ' [ID: ' + o.id + ']'] = o.name;
                        objects.push(o.name + ' [ID: ' + o.id + ']');
                    });
                    process(objects);
                });
            },
            updater: function (item) {
                $(''+area).val(oID[item]);
                return item;
            }
        });
    }
</script>