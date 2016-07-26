<div class="row">
    <div class="col-md-12">
        <a href="{{ backurl }}" class="btn btn-sm btn-success addon-btn m-b-10"><i class="zmdi zmdi-arrow-left"></i> {{ labelkey['general.lbl_back'] }}</a>
        <section class="panel">
            <header class="panel-heading">{{ labelkey['general.btn_addnew'] }}</header>
            <div class="panel-body">
                <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="panel-body">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">{{ labelkey['album.lbl_type'] }}</label>
                                    <div class="col-md-8">
                                        <select class="form-control" name="type" id="type">
                                            <option value="photo">Photo</option>
                                            <option {{ _POST['type']=='video' or object.type=='video' ?'selected':'' }} value="video">Video</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">{{ labelkey['album.lbl_name'] }}</label>
                                    <div class="col-md-8"><input type="text" name="name" value="{{ object.name }}" class="form-control"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">{{ labelkey['album.lbl_thumb'] }} (600x400)</label>
                                    <div class="col-md-8">
                                        {% if object.avatar|length >0 %}
                                            <p class="clearfix"><a href="{{ media.host~object.avatar }}" target="_blank"><img width="250" src="{{ media.host~object.avatar }}" alt="Thumb Photo"></a></p>
                                        {% endif %}
                                        <input id="file-0" class="file" type="file" name="avatar">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">{{ labelkey['album.lbl_coveravatar'] }} (1600x333)</label>
                                    <div class="col-md-8">
                                        {% if object.coveravatar|length >0 %}
                                            <p class="clearfix"><a href="{{ media.host~object.coveravatar }}" target="_blank"><img width="250" src="{{ media.host~object.coveravatar }}" alt="Cover Photo"></a></p>
                                        {% endif %}
                                        <input id="file-0" class="file" type="file" name="coveravatar">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">{{ labelkey['album.lbl_status'] }}</label>
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
                                    <label class="col-md-2 control-label" for="username">{{ labelkey['album.lbl_tagclass'] }}</label>
                                    <div class="col-md-3"><input type="text" id="tagclass" class="form-control" autocomplete="off" placeholder="{{ labelkey['album.lbl_tagclass'] }}"></div>
                                    <div class="col-md-7">
                                        <div id="tagclassarea">
                                            {% for item in tagclass %}
                                                <span class="btn btn-success" onclick="$(this).remove()">
                                        {{ item.name }}
                                                    <input type="hidden" name="classid[]" value="{{ item.id }}">
                                    </span>&nbsp;
                                            {% endfor %}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="username">{{ labelkey['album.lbl_taguser'] }}</label>
                                    <div class="col-md-3"><input type="text" id="taguser" class="form-control" autocomplete="off" placeholder="{{ labelkey['album.lbl_taguser'] }}"></div>
                                    <div class="col-md-7">
                                        <div id="taguserarea">
                                            {% for item in taguser %}
                                                <span class="btn btn-success" onclick="$(this).remove()">
                                        {{ item.username }}
                                                    <input type="hidden" name="userid[]" value="{{ item.id }}">
                                    </span>&nbsp;
                                            {% endfor %}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">{{ labelkey['album.lbl_content'] }}</label>
                                    <div class="col-md-8">
                                        <textarea class="form_editor" id="summernote" name="content">{{ object.content }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label"></label>
                                    <div class="col-md-8">
                                        <button type="submit" class="btn btn-info">{{ labelkey['general.btn_save'] }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </section>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        loadTinyMce('form_editor');
    });
</script>
<!--typeahead-->
<script type="text/javascript" src="/js/bootstrap3-typeahead.js"></script>
<script type="text/javascript">
    suggesstion('tagclass', 'tagclassarea', '{{ url('/classobj/getbyname') }}', 'classid[]');
    suggesstion('taguser', 'taguserarea', '{{ url('/user/getbyname') }}', 'userid[]');
    var oID = [];
    var oName = [];
    function suggesstion(idinput, area, getUrl, inputid) {
        $('#' + idinput).typeahead({
            source: function (query, process) {
                return $.get(getUrl, {q: query}, function (data) {
                    var objects = [];
                    $.each(data, function (i, o) {
                        oID[o.name + ' [ID: ' + o.id + ']'] = o.id;
                        oName[o.id] = o.name;
                        objects.push(o.name + ' [ID: ' + o.id + ']');
                    });
                    process(objects);
                });
            },
            updater: function (item) {
                var htmlx = '<span class="btn btn-success" onclick="$(this).remove()">'
                        + oName[oID[item]]
                        + '<input type="hidden" name="' + inputid + '" value="' + oID[item] + '">'
                        + '</span>&nbsp;';
                $('#' + area).append(htmlx);
                $('#' + idinput).val('');
                //return item;
            }
        });
    }
</script>