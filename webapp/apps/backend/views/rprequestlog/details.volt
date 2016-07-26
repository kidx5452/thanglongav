<!--bootstrap picker-->
<link rel="stylesheet" type="text/css" href="/js/bootstrap-datepicker/css/datepicker.css"/>
<link rel="stylesheet" type="text/css" href="/js/bootstrap-daterangepicker/daterangepicker-bs3.css"/>

<div class="row">
    <div class="col-sm-12">
        <a href="{{ backurl }}" class="btn btn-sm btn-success addon-btn m-b-10"><i class="zmdi zmdi-arrow-left"></i> {{ labelkey['general.lbl_back'] }}</a>
        <section class="panel">
            <header class="panel-heading head-border">
                {{ labelkey['rprequestlog.lbl_viewdetails'] }} <strong class="text-danger">{{ _GET['username'] }}</strong>
            </header>
            <div class="panel-body">
                <form method="get" action="" class="form-horizontal tasi-form">
                    <div class="row">
                        <div class="col-md-2 text-right">
                            <div class="control-label">{{ labelkey['rprequestlog.lbl_selectdate'] }}</div>
                        </div>
                        <div class="col-md-8">
                            <div class="input-group input-large custom-date-range">
                                <input type="text" data-date-format="dd-mm-yyyy" class="form-control dpd1" name="sdate" value="{{ date('d-m-Y',sdate) }}">
                                <span class="input-group-addon">To</span>
                                <input type="text" data-date-format="dd-mm-yyyy" class="form-control dpd2" name="edate" value="{{ date('d-m-Y',edate) }}">
                            </div>
                        </div>
                        <input type="hidden" name="userid" value="{{ _GET['userid'] }}">
                        <input type="hidden" name="username" value="{{ _GET['username'] }}">
                        <div class="col-md-2"><button class="btn btn-info" type="submit">{{ labelkey['general.lbl_search'] }}</button></div>
                    </div>
                </form>

                <table class="table">
                    <thead>
                    <tr>
                        <th>{{ labelkey['rprequestlog.lbl_link'] }}</th>
                        <th>{{ labelkey['rprequestlog.lbl_logcount'] }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    {% for item in listdata %}
                        <tr>
                            <td><a href="{{ str_replace('http:/','http://',str_replace('//','/',application.baseUrl~item['link'])) }}" target="_blank">{{ item['link'] }}</a></td>
                            <td>{{ item['count'] }}</td>
                        </tr>
                    {% endfor %}

                    </tbody>
                </table>
                {% include "layouts/paging.volt" %}
            </div>
        </section>
    </div>
</div>

<!--bootstrap picker-->
<script type="text/javascript" src="/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="/js/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="/js/bootstrap-daterangepicker/daterangepicker.js"></script>

<script type="text/javascript">
    var checkin = $('.dpd1').datepicker({
        onRender: function(date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
        if (ev.date.valueOf() > checkout.date.valueOf()) {
            var newDate = new Date(ev.date)
            newDate.setDate(newDate.getDate() + 1);
            checkout.setValue(newDate);
        }
        checkin.hide();
        $('.dpd2')[0].focus();
    }).data('datepicker');
    var checkout = $('.dpd2').datepicker({
        onRender: function(date) {
            return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
        checkout.hide();
    }).data('datepicker');
</script>