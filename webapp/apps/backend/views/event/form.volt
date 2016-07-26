<!--bootstrap picker-->
<link rel="stylesheet" type="text/css" href="/js/bootstrap-datepicker/css/datepicker.css"/>
<link rel="stylesheet" type="text/css" href="/js/bootstrap-timepicker/compiled/timepicker.css"/>
<link rel="stylesheet" type="text/css" href="/js/bootstrap-colorpicker/css/colorpicker.css"/>
<link rel="stylesheet" type="text/css" href="/js/bootstrap-daterangepicker/daterangepicker-bs3.css"/>
<link rel="stylesheet" type="text/css" href="/js/bootstrap-datetimepicker/css/datetimepicker.css"/>
<div class="row">
    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
        <div class="col-lg-12">
            <a href="{{ backurl }}" class="btn btn-sm btn-success addon-btn m-b-10"><i class="zmdi zmdi-arrow-left"></i> {{ labelkey['general.lbl_back'] }}</a>
            <section class="panel">
                <header class="panel-heading">
                    {{ labelkey['event.lbl_basicinfo'] }}
                </header>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['general.lbl_lang'] }}</label>
                        <div class="col-md-8">
                            <select class="form-control" name="lang" id="lang">
                                {% for item in langlist %}
                                    <option {{ _POST['lang']==item['key'] or object.lang==item['key'] ?'selected':'' }} value="{{ item['key'] }}">{{ item['name'] }}</option>
                                {% endfor %}
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="username">{{ labelkey['event.lbl_name'] }}</label>
                        <div class="col-md-8"><input type="text" name="name" value="{{ object.name }}" class="form-control" placeholder="{{ labelkey['event.lbl_name'] }}" required></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['event.lbl_descriptions'] }}</label>
                        <div class="col-md-8"><input type="text" name="captions" value="{{ object.captions }}" class="form-control"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['event.lbl_coverphoto'] }} (1600x333)</label>
                        <div class="col-md-8">
                            {% if object.coverphoto|length >0 %}
                                <p class="clearfix"><a href="{{ media.host~object.coverphoto }}" target="_blank"><img width="500" src="{{ media.host~object.coverphoto }}" alt="Cover Photo"></a></p>
                            {% endif %}
                            <input id="file-0" class="file" type="file" name="coverphoto" accept="image/*">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['event.lbl_status'] }}</label>
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
                        <label class="col-md-2 control-label" for="startdate">{{ labelkey['event.lbl_startdate'] }}</label>
                        <div class="col-md-8">
                            <div class="input-group input-large custom-date-range">
                                <input type="text" class="form-control form-control-inline input-medium form_datetime" value="{{ object.startdate }}" name="startdate"/>
                                <span class="input-group-addon">{{ labelkey['event.lbl_enddate'] }}</span>
                                <input type="text" class="form-control form-control-inline input-medium form_datetime" value="{{ object.enddate }}" name="enddate"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['event.lbl_location'] }}</label>
                        <div class="col-md-8"><input type="text" name="location" value="{{ object.location }}" class="form-control"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="username">{{ labelkey['event.lbl_tagclass'] }}</label>

                        <div class="col-md-3"><input type="text" id="tagclass" class="form-control" autocomplete="off" placeholder="{{ labelkey['event.lbl_tagclass'] }}"></div>
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
                        <label class="col-md-2 control-label" for="username">{{ labelkey['event.lbl_taguser'] }}</label>

                        <div class="col-md-3"><input type="text" id="taguser" class="form-control" autocomplete="off" placeholder="{{ labelkey['event.lbl_taguser'] }}"></div>
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
                        <label class="col-md-2 control-label" for="username">{{ labelkey['event.lbl_captions'] }}</label>

                        <div class="col-md-10">
                            <textarea class="summernote" id="summernote" name="content">{{ object.content }}</textarea>
                        </div>
                    </div>

                </div>
            </section>
        </div>
        <div class="col-lg-12">
            <button type="submit" class="btn btn-info">Save</button>
        </div>
    </form>
</div>
<!--bootstrap picker-->
<script type="text/javascript" src="/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="/js/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="/js/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="/js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>

<!--picker initialization-->
<script src="/js/picker-init.js"></script>
<script>
    $(document).ready(function () {
        loadTinyMce('summernote');
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