<!--nestable-->
<link rel="stylesheet" type="text/css" href="/js/nestable/jquery.nestable.css" />
<style>
    .dd{max-width: 100%;}
    .dd-item{margin-top:7px;}
    .dd-handle{height:auto;border:0;background: none;padding:0;margin: 0 5px 10px 0;}
    .typeahead, .tt-query, .tt-hint{height: auto;10px 5px;border-radius:3px;}
</style>

<div class="row">
    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading head-border">
                    {{ labelkey['categoryview.lbl_catdisplay'] }}
                </header>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['general.lbl_lang'] }}</label>
                        <div class="col-md-8">
                            <select id="langSelect" name="" class="form-control">
                                {% for item in langlist %}
                                    <option {{ _GET['lang']==item['key']?'selected':'' }} pos-url="?pos={{ _GET['pos'] ? _GET['pos']:catpos[0]['key'] }}&lang={{ item['key'] }}" value="{{ item['key'] }}">{{ item['name'] }}</option>
                                {% endfor %}
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['categoryview.lbl_position'] }}</label>
                        <div class="col-md-8">
                            <select id="positionSelect" name="" class="form-control">
                                {% for item in catpos %}
                                    <option {{ _GET['pos']==item['key']?'selected':'' }} pos-url="?pos={{ item['key'] }}&lang={{ _GET['lang'] ? _GET['lang']:langlist[0]['key'] }}" value="{{ item['key'] }}">{{ item['name'] }}</option>
                                {% endfor %}
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['categoryview.lbl_catname'] }}</label>
                        <div class="col-md-8">
                            <input type="text" id="name" autocomplete="off" data-provide="typeahead" class="form-control" placeholder="{{ labelkey['categoryview.lbl_catnamedesc'] }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['categoryview.lbl_selectedcat'] }}:</label>
                        <div class="col-md-8">
                            <div class="dd" id="nestable_list">
                                <ol id="suggest" class="dd-list">
                                    {% for item in listdata %}
                                        <li class="dd-item clearfix"><div class="dd-handle pull-left btn"><input type="hidden" name="cat[]" value="{{ item.Category.id }}" /> {{ item.Category.name }}</div><div class="pull-left"><a href="#" onclick="$(this).parent().parent().remove();">(Remove)</a></div></li>
                                    {% endfor %}
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-10 col-md-offset-2">
                            <button class="btn btn-info" type="submit">{{ labelkey['general.btn_save'] }}</button>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </form>
</div>

<!--typeahead-->
<script type="text/javascript" src="/js/bootstrap3-typeahead.js"></script>
<!--nestable -->
<script src="/js/nestable/jquery.nestable.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#positionSelect').change(function () {
            window.location.href = $('#positionSelect :selected').attr('pos-url');
        });
        $('#langSelect').change(function () {
            window.location.href = $('#langSelect :selected').attr('pos-url');
        });

        // activate Nestable
        $('#nestable_list').nestable();

    });
    suggesstion('name','suggest','{{ url('/category/getcategorybyname') }}');
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
                $('#'+area).append('<li class="dd-item clearfix"><div class="dd-handle pull-left btn"><input type="hidden" name="cat[]" value="'+oID[item]+'" /> '+oName[[item]]+'</div><div class="pull-left"><a href="#" onclick="$(this).parent().parent().remove();">(Remove)</a></div></li>');
                return item;
            }
        });
    }


</script>
