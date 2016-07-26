<div class="row">
    <div class="col-sm-12">
        <a href="{{ backurl }}" class="btn btn-sm btn-success addon-btn m-b-10"><i class="zmdi zmdi-arrow-left"></i> {{ labelkey['general.lbl_back'] }}</a>
        <section class="panel">
            <header class="panel-heading head-border">Danh sách báo cáo quý: <strong class="text-danger">{{ userinfo.username }}</strong>
            </header>
            <div class="panel-body">
                <form method="get" action="" class="form-inline">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="form?userid={{ _GET['userid'] }}" class="btn btn-success m-b-10">{{ labelkey['general.btn_addnew'] }}</a>
                        </div>
                    </div>
                </form>

                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ labelkey['general.lbl_title'] }}</th>
                        <th>{{ labelkey['general.lbl_action'] }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    {% for item in listdata %}
                        <tr>
                            <td>{{ item.id }}</td>
                            <td>{{ item.name }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a class="btn btn-default" title="{{ labelkey['general.btn_edit'] }}" href="form?id={{ item.id }}&userid={{ item.userid }}"><i class="zmdi zmdi-edit"></i></a>
                                    <a class="btn btn-default" onclick="return confirm('{{ labelkey['general.lbl_sure'] }}');" title="{{ labelkey['general.btn_delete'] }}" href="delete?id={{ item.id }}&userid={{ item.userid }}"><i class="zmdi zmdi-delete"></i></a>
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