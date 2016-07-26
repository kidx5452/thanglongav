<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading head-border">
                {{ labelkey['tuition.lbl_list'] }}: <b>{{ user['firstname'] }} {{ user['lastname'] }}</b>
            </header>
            <div class="panel-body">
                <form method="get" action="" class="form-horizontal tasi-form">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="form?uid={{ _GET['uid'] }}" class="btn btn-success m-b-10">{{ labelkey['general.btn_addnew'] }}</a>
                        </div>
                    </div>
                </form>

                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ labelkey['tuition.lbl_name'] }}</th>
                        <th>{{ labelkey['tuition.lbl_price'] }}</th>
                        <th>{{ labelkey['tuition.lbl_status'] }}</th>
                        <th>{{ labelkey['tuition.lbl_expired_date'] }}</th>
                        <th>{{ labelkey['tuition.lbl_start_date'] }}</th>
                        <th>{{ labelkey['tuition.lbl_viewed'] }}</th>
                        <th>{{ labelkey['general.lbl_action'] }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    {% for item in listdata %}
                        <tr>
                            <td>{{ item.id }}</td>
                            <td>{{ item.name }}</td>
                            <td>{{ number_format(item.price) }}</td>
                            <td><strong>{{ item.status==1?'<span class="label label-success">Show</span>':'<span class="label label-inverse">Hide</span>' }}</strong></td>
                            <td>{{ date("d-m-Y",item.expired_date) }}</td>
                            <td>{{ date("d-m-Y",item.start_date) }}</td>
                            <td>{{ item.viewed }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a class="btn btn-default" title="{{ labelkey['general.btn_edit'] }}" href="form?uid={{ _GET['uid'] }}&id={{ item.id }}"><i class="zmdi zmdi-edit"></i></a>
                                    <a class="btn btn-default" onclick="return confirm('{{ labelkey['general.lbl_sure'] }}');" title="{{ labelkey['general.btn_delete'] }}" href="delete?uid={{ _GET['uid'] }}&id={{ item.id }}"><i class="zmdi zmdi-delete"></i></a>
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