<div class="row">
    <div class="col-sm-12">
        <a href="monthlyreport?classid={{ _GET['classid'] }}" class="btn btn-sm btn-success addon-btn m-b-10"><i
                    class="zmdi zmdi-arrow-left"></i> {{ labelkey['general.lbl_back'] }}</a>
        <section class="panel">
            <header class="panel-heading head-border">
                {{ labelkey['reportpupil.lbl_viewenteredmonth']~' <b>('~labelkey[pointname]~' '~labelkey['classobj.lbl_form']~' '~classobj.name~')</b>'}}
            </header>
            <div class="panel-body">
                {% for item in listdata %}
                    <div><a href="view{{ _GET['type'] }}report?classid={{ _GET['classid'] }}&datetest={{ item['datetest'] }}&backurl={{ currenturl|url_encode }}">{{ item['month'] }}</a> <a class="tooltips btn text-danger" onclick="return confirm('{{ labelkey['general.lbl_sure'] }}');" href="viewmonthlyreport?classid={{ _GET['classid'] }}&type={{ _GET['type'] }}&datetest={{ item['datetest'] }}&delete=1" title="{{ labelkey['general.btn_delete'] }}"><i class="fa fa-times"></i></a></div>
                {% endfor %}
                {% include "layouts/paging.volt" %}
            </div>
        </section>
    </div>
</div>