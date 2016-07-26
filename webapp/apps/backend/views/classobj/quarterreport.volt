<div class="row">
    <div class="col-sm-12">
        <a href="index" class="btn btn-sm btn-success addon-btn m-b-10"><i
                    class="zmdi zmdi-arrow-left"></i> {{ labelkey['general.lbl_back'] }}</a>
        <section class="panel">
            <header class="panel-heading head-border">
                {{ labelkey['classobj.lbl_pupillist'] }}
            </header>
            <div class="panel-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ labelkey['classobj.lbl_pupilname'] }}</th>
                        <th>{{ labelkey['general.lbl_action'] }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    {% for item in classobj.Pupil %}
                        <tr>
                            <td>{{ item.id }}</td>
                            <td><a title="{{ labelkey['general.btn_edit'] }}" href="editquarterreport?id={{ item.id }}&classid={{ _GET['classid'] }}">{{ item.firstname~' '~item.lastname }}</a></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a class="btn btn-default" title="{{ labelkey['general.btn_edit'] }}" href="editquarterreport?id={{ item.id }}&classid={{ _GET['classid'] }}"><i class="zmdi zmdi-edit"></i></a>
                                </div>
                            </td>
                        </tr>
                    {% endfor %}
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>