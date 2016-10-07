<!--  summernote -->
<link href="/js/summernote/dist/summernote.css" rel="stylesheet">

<div class="row">
    <div class="col-md-12">
        <a href="index?catid={{ catid }}" class="btn btn-sm btn-success addon-btn m-b-10"><i class="zmdi zmdi-arrow-left"></i> {{ labelkey['general.lbl_back'] }}</a>
        <section class="panel-">
            <div class="panel-body no-pad">
                <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                    <!--tab nav start-->
                    <section class="isolate-tabs">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a data-toggle="tab" href="#tab1">{{ labelkey['articleview.lbl_artposconfig'] }}</a>
                            </li>
                        </ul>
                        <div class="panel-body">
                            <div class="tab-content">
                                <div id="tab1" class="tab-pane active">
                                    <div class="col-md-12">
                                        {#<div class="form-group">
                                            <label class="col-md-2 control-label">{{ labelkey['general.lbl_lang'] }}</label>

                                            <div class="col-md-8">
                                                <select class="form-control" name="lang">
                                                    {% for item in langlist %}
                                                        <option {{ object.lang==item['key']?'selected':'' }} value="{{ item['key'] }}">{{ item['name'] }}</option>
                                                    {% endfor %}
                                                </select>
                                            </div>
                                        </div>#}
                                        <div class="form-group" style="display: none">
                                            <label class="col-md-2 control-label">{{ labelkey['articleview.lbl_position'] }}</label>

                                            <div class="col-md-8">
                                                <select class="form-control" name="poskey">
                                                    {% for item in articlepos %}
                                                        <option {{ object.poskey==item['key']?'selected':'' }} value="{{ item['key'] }}">{{ item['name'] }}</option>
                                                    {% endfor %}
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">URL</label>
                                            <div class="col-md-8">
                                                <input type="text" id="name" value="{{ object.url }}" name="url" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">{{ labelkey['articleview.lbl_captions'] }}</label>
                                            <div class="col-md-8">
                                                <input type="text" name="captions" value="{{ object.captions }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">{{ labelkey['articleview.lbl_sort'] }}</label>
                                            <div class="col-md-8">
                                                <input type="text" name="sorts" value="{{ object.sorts }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Link youtube</label>
                                            <div class="col-md-8">
                                                <input type="text" name="linkyoutube" value="{{ object.linkyoutube }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">{{ labelkey['articleview.lbl_avatar'] }}</label>
                                            <div class="col-md-8">
                                                {% if object.avatar|length >0 %}
                                                    <p class="clearfix"><img class="thumbnail col-md-2" src="{{ media.host~object.avatar }}" alt=""></p>
                                                {% endif %}
                                                <p><input id="file-0" class="file" type="file" name="avatar"></p>
                                            </div>
                                        </div>
                                    </div>

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
<!--typeahead-->
<script type="text/javascript" src="/js/bootstrap3-typeahead.js"></script>
<!--nestable -->
<script src="/js/nestable/jquery.nestable.js"></script>

<script type="text/javascript">
    suggesstion('name','atid','{{ url('/article/getbyname') }}');
    var oID = [];
    var oName = [];
    function suggesstion(idinput,area,getUrl) {
        $('#' + idinput).typeahead({
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
                $('#'+area).val(oID[item]);
                return item;
            }
        });
    }
</script>