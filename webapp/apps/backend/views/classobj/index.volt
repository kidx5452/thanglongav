<div class="row">
    <div class="col-sm-12">
        <a class="btn btn-success m-b-10" href="groupform">{{ labelkey['classobj.lbl_addmoregroup'] }}</a>
    </div>
    {% for item in listdata %}
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading ">
                    <strong>{{ item.name }}</strong>
                    <span class="pull-right">
                        <a class="btn btn-xs btn-primary" title="{{ labelkey['general.btn_edit'] }}" href="groupform?id={{ item.id }}">{{ labelkey['general.btn_edit'] }}</a>
                        <a class="btn btn-xs btn-info" title="{{ labelkey['classobj.lbl_addmoreclass'] }}" href="form?groupid={{ item.id }}">{{ labelkey['classobj.lbl_addmoreclass'] }}</a>
                    </span>
                </header>
                <div class="panel-body">
                    <div class="clearfix">
                        {% if item.Classobj|length %}
                        {% for classobj in item.Classobj %}
                            <div class="col-sm-2 g-border panel">
                                <p>Lớp {{ classobj.name }}</p>
                                <p>
                                    <a class="tooltips btn" href="form?id={{ classobj.id }}" title="{{ labelkey['general.btn_edit'] }}"><i class="zmdi zmdi-edit"></i></a>
                                    <a class="tooltips btn" onclick="return confirm('{{ labelkey['general.lbl_sure'] }}');" href="delete?id={{ classobj.id }}" title="{{ labelkey['general.btn_delete'] }}"><i class="zmdi zmdi-delete"></i></a>
                                </p>
                                <p><a href="dailyreport?classid={{ classobj.id }}">{{ labelkey['classobj.lbl_dailyreport'] }}</a></p>
                                <p><a href="monthlyreport?classid={{ classobj.id }}">{{ labelkey['classobj.lbl_monthlyreport'] }}</a></p>
                                <p><a href="quarterreport?classid={{ classobj.id }}">{{ labelkey['classobj.lbl_quarterreport'] }}</a></p>
                                <p><a href="/pupil/index?classid={{ classobj.id }}">{{ labelkey['classobj.lbl_pupillist'] }}</a></p>
                            </div>
                        {% endfor %}
                        {% else %}
                            <p>{{ labelkey['classobj.lbl_noclass'] }}</p>
                        {% endif  %}
                    </div>
                </div>
            </section>
        </div>
    {% endfor %}
    {% include "layouts/paging.volt" %}
</div>