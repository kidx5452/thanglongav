<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading head-border">
                {{ labelkey['articleview.lbl_listart'] }}
            </header>
            <div class="panel-body">
                <form method="get" action="" class="form-horizontal tasi-form">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="form?catid={{ catid }}" class="btn btn-success m-b-10">{{ labelkey['general.btn_addnew'] }}</a>
                        </div>
                    </div>
                </form>
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ labelkey['articleview.lbl_avatar'] }}</th>
                        <th>{{ labelkey['articleview.lbl_name'] }}</th>
                        <th>{{ labelkey['articleview.lbl_poskey'] }}</th>
                        <th>{{ labelkey['articleview.lbl_sort'] }}</th>
                        <th>{{ labelkey['articleview.lbl_action'] }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    {% for item in listdata %}
                        <tr>
                            <td>{{ item.id }}</td>
                            <td style="width: 150px">
                                <div >
                                    <img src="{{ media.host~item.avatar }}" alt="" class="thumbnail col-md-12">
                                </div>
                            </td>
                            <td>{{ item.Article.name }}</td>
                            <td>{{ item.poskey }}</td>
                            <td>{{ item.sorts }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a class="btn btn-default" title="{{ labelkey['general.btn_edit'] }}" href="form?id={{ item.id }}"><i class="zmdi zmdi-edit"></i></a>
                                    <a class="btn btn-default" onclick="return confirm('{{ labelkey['general.lbl_sure'] }}');" title="{{ labelkey['general.btn_delete'] }}" href="delete?id={{ item.id }}"><i class="zmdi zmdi-delete"></i></a>
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