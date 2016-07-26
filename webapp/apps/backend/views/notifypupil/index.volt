<div class="row">
    <div class="col-sm-12">
        <a href="{{ backurl }}" class="btn btn-sm btn-success addon-btn m-b-10"><i class="zmdi zmdi-arrow-left"></i> {{ labelkey['general.lbl_back'] }}</a>
        <section class="panel">
            <header class="panel-heading head-border">
                {{ labelkey['notifypupil.lbl_list'] }} <strong class="text-danger">{{ userinfo.username }}</strong>
            </header>
            <div class="panel-body">
                <form method="get" action="" class="form-inline">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="form?userid={{ _GET['id'] }}" class="btn btn-success m-b-10">{{ labelkey['general.btn_addnew'] }}</a>
                        </div>
                        <div class="col-md-6 text-right">
                            <input type="text" name="q" class="form-control" placeholder="{{ labelkey['general.lbl_search'] }}..." value="{{ q }}" />
                            <!--
                            <select class="form-control" name="lang">
                                {% for item in langlist %}
                                    <option {{ _GET['lang']==item['key'] ? 'selected':'' }} value="{{ item['key'] }}">{{ item['name'] }}</option>
                                {% endfor %}
                            </select>
                            -->
                            <select class="form-control" name="status">
                                <option value="3">{{ labelkey['general.lbl_status'] }}</option>
                                <option value="0" {{ _GET['status'] is defined AND _GET['status']==0?'selected':'' }}>{{ labelkey['general.lbl_hide'] }}</option>
                                <option value="1" {{ _GET['status']==1?'selected':'' }}>{{ labelkey['general.lbl_show'] }}</option>
                                <option value="2" {{ _GET['status']==2?'selected':'' }}>{{ labelkey['general.lbl_unread'] }}</option>
                            </select>
                            <input type="hidden" name="id" value="{{ _GET['id'] }}">
                            <button class="btn btn-info" type="submit">{{ labelkey['general.lbl_search'] }}</button>
                        </div>
                    </div>
                </form>

                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ labelkey['general.lbl_title'] }}</th>
                        <th>{{ labelkey['general.lbl_cdate'] }}</th>
                        <th>{{ labelkey['general.lbl_action'] }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    {% for item in listdata %}
                        <tr>
                            <td>{{ item.id }}</td>
                            <td>{{ item.name }}
                                <div><strong>
                                        {% if item.status==0 %}
                                            <span class="label label-inverse">Hide</span>
                                        {% elseif item.status==1 %}
                                            <span class="label label-success">Show</span>
                                        {% elseif item.status==2 %}
                                            <span class="label label-primary">Unread</span>
                                        {% endif %}
                                    </strong></div>
                            </td>
                            <td>{{ date('d-m-Y',item.datecreate) }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a class="btn btn-default" title="{{ labelkey['general.btn_edit'] }}" href="form?id={{ item.id }}&userid={{ _GET['id'] }}&back=1"><i class="zmdi zmdi-edit"></i></a>
                                    <a class="btn btn-default" onclick="return confirm('{{ labelkey['general.lbl_sure'] }}');" title="{{ labelkey['general.btn_delete'] }}" href="delete?id={{ item.id }}"><i class="zmdi zmdi-delete"></i></a>
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