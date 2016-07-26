<div class="row">
    <div class="col-sm-12">
        <a href="quarterreport?classid={{ _GET['classid'] }}" class="btn btn-sm btn-success addon-btn m-b-10"><i
                    class="zmdi zmdi-arrow-left"></i> {{ labelkey['general.lbl_back'] }}</a>
        <section class="panel">
            <header class="panel-heading head-border">
                {{ labelkey['classobj.lbl_editquarterreport'] }} <b>{{ object.firstname~' '~object.lastname }}</b>
            </header>
            <div class="panel-body">
                <form class="form-horizontal tasi-form" action="quarterreportdetail" method="get">
                    <input type="hidden" name="id" value="{{ _GET['id'] }}" />
                    <input type="hidden" name="classid" value="{{ _GET['classid'] }}" />
                    <div class="form-group">
                        <label class="col-md-2 control-label">Quarter Name</label>
                        <div class="col-md-9">
                            <select class="form-control" required name="quarterid" id="quarterid" onchange="changepreview()">
                                <option value="">Lựa chọn báo cáo quý</option>
                                {% for item in listquarter %}
                                <option value="{{ item.id }}">{{ item.name }}</option>
                                {% endfor %}
                            </select>
                            <a class="btn" target="_blank" href="/quarter/index?userid={{ _GET['id'] }}">{{ labelkey['reportpupil.lbl_listmanager'] }}</a>
                            | <a class="btn" target="_blank" href="/quarter/form?userid={{ _GET['id'] }}&back=1">{{ labelkey['general.btn_addnew'] }}</a>
                            {% if listquarter|length %}
                            | <a class="btn" id="previewurl" target="_blank" href="{{ application.baseUrl }}reportpupil/viewfull?id={{ listquarter[0].id }}">{{ labelkey['reportpupil.lbl_preview'] }}</a>
                            {% endif %}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Type</label>
                        <div class="col-md-9">
                            <select class="form-control" name="type">
                                <option value="skilltest">Skilltest</option>
                                <option value="oraltest">OralTest</option>
                                <option value="presentation">Presentation</option>
                                <option value="minitest">MiniTest</option>
                                <option value="attitude">Attitude</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['reportpupil.lbl_selectyear'] }}</label>
                        <div class="col-md-9">
                            <select class="form-control" name="year">
                                {% for i in 2016..date("Y") %}
                                    <option{{ i==year ? ' selected="selected"' : '' }} value="{{ i }}">{{ i }}</option>
                                {% endfor %}
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['reportpupil.lbl_selectmonth'] }}</label>
                        <div class="col-md-10">
                        {% for i in 1..12 %}
                            <label class="checkbox-inline">
                                <input{{ in_array(i,month) ? ' checked="checked"' : '' }} type="checkbox" name="month[]" value="{{ i }}" id="month{{ i }}"> {{ labelkey['reportpupil.lbl_month']~' '~i }}
                            </label>
                        {% endfor %}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-2">
                            <button type="submit" name="selectmonth" value="1" class="btn btn-info">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>

<script>
    function changepreview(){
        $('#previewurl').fadeOut('slow').fadeIn('fast');
        $('#previewurl').attr('href','{{ application.baseUrl }}reportpupil/viewfull?id='+$('#quarterid').val());
    }
</script>