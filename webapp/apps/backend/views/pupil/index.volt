<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading head-border">
                {{ labelkey['pupil.lbl_list'] }}
            </header>
            <div class="panel-body">
                <form method="get" action="" class="form-horizontal tasi-form">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="form" class="btn btn-success m-b-10">{{ labelkey['general.btn_addnew'] }}</a>
                            <a href="excel" class="btn btn-success m-b-10"><i class="fa fa-upload"></i> {{ labelkey['general.lbl_uploadexcel'] }}</a>
                        </div>
                        <div class="col-md-6 text-right">
                            <div class="col-sm-6">
                                <div class="col-sm-4">Search by:</div>
                                <div class="col-sm-8">
                                    <select name="sby" id="" class="form-control">
                                        <option {{ _GET['sby']=='fullname_none_utf'?"selected":"" }}  value="fullname_none_utf">Fullname</option>
                                        <option {{ _GET['sby']=='username'?"selected":"" }} value="username">Username</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" name="q" class="form-control" placeholder="{{ labelkey['general.lbl_search'] }}..." value="{{ q }}" />
                            </div>

                        </div>
                    </div>
                </form>

                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ labelkey['pupil.lbl_firstname'] }}</th>
                        <th>{{ labelkey['pupil.lbl_lastname'] }}</th>
                        <th>{{ labelkey['pupil.lbl_birthday'] }}</th>
                        <th>{{ labelkey['pupil.lbl_classobj'] }}</th>
                        <th>{{ labelkey['general.lbl_action'] }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    {% for item in listdata %}
                        <tr>
                            <td>{{ item.id }}</td>
                            <td>{{ item.firstname }}
                            <p><a target="_blank" href="http://wsi.vn/user/loginadmin?username={{ item.username }}&password={{ item.password }}">Login Client</a></p>
                            </td>
                            <td>{{ item.lastname }}</td>
                            <td>{{ date('d-m-Y',item.dob) }}</td>
                            <td>{{ item.Classobj.name }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a class="btn btn-default" title="{{ labelkey['general.btn_edit'] }}" href="form?id={{ item.id }}"><i class="zmdi zmdi-edit"></i></a>
                                    <a class="btn btn-default" onclick="return confirm('{{ labelkey['general.lbl_sure'] }}');" title="{{ labelkey['general.btn_delete'] }}" href="delete?id={{ item.id }}"><i class="zmdi zmdi-delete"></i></a>
                                </div>
                                &nbsp;&nbsp;&nbsp;
                                <div class="btn-group" role="group">
                                    <a class="btn btn-default" title="{{ labelkey['pupil.lbl_notify'] }}" href="/notifypupil/index?id={{ item.id }}"><i class="fa fa-bell"></i></a>
                                    <a class="btn btn-default" title="{{ labelkey['pupil.lbl_tuition'] }}" href="/tuition/index?uid={{ item.id }}"><i class="zmdi zmdi-money"></i></a>
                                    <a class="btn btn-default" title="{{ labelkey['pupil.lbl_timetable'] }}" href="{{ url("timetable/index") }}?uid={{ item.id }}"><i class="zmdi zmdi-calendar"></i></a>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-file-text-o"></i> &nbsp; <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a href="/classobj/dailyreport?id={{ item.id }}&classid={{ item.classid }}">{{ labelkey['pupil.lbl_dailyreport'] }}</a></li>
                                            <li><a href="/classobj/monthlyreport?id={{ item.id }}&classid={{ item.classid }}">{{ labelkey['pupil.lbl_monthlyreport'] }}</a></li>
                                            <li><a href="/classobj/editquarterreport?id={{ item.id }}&classid={{ item.classid }}">{{ labelkey['pupil.lbl_quarterreport'] }}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    {% endfor %}

                    </tbody>
                </table>
                {% include "layouts/paging.volt" %}
            </div>
        </section>
    </div>
</div>