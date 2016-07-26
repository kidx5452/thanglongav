<!--bootstrap picker-->
<link rel="stylesheet" type="text/css" href="/js/bootstrap-datepicker/css/datepicker.css"/>
<link rel="stylesheet" type="text/css" href="/js/bootstrap-daterangepicker/daterangepicker-bs3.css"/>

<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading head-border">
                {{ labelkey['rprequestlog.lbl_rprequestlog'] }}
            </header>
            <div class="panel-body">
                <form method="get" action="" class="form-horizontal tasi-form">
                    <div class="alert alert-info text-center">{{ labelkey['rprequestlog.lbl_storagelimit']~' <strong>'~application.rpRequestLogLimit~'</strong> '~labelkey['rprequestlog.lbl_day'] }}</div>
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
                        <div class="col-md-2"><button class="btn btn-info" type="submit">{{ labelkey['general.lbl_search'] }}</button></div>
                    </div>
                </form>
                <p>&nbsp;</p>
                <table class="table">
                    <thead>
                    <tr>
                        <th>{{ labelkey['rprequestlog.lbl_username'] }}</th>
                        <th>{{ labelkey['rprequestlog.lbl_logcount'] }}</th>
                        <th>{{ labelkey['general.lbl_action'] }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    {% for item in listdata %}
                        <tr>
                            <td><a target="_blank" title="{{ labelkey['rprequestlog.lbl_viewdetails'] }} {{ item['username'] }}" href="/rprequestlog/details?userid={{ item['userid'] }}&username={{ item['username'] }}&sdate={{ date('d-m-Y',sdate) }}&edate={{ date('d-m-Y',edate) }}">{{ item['username'] }}</a></td>
                            <td>{{ item['count'] }}</td>
                            <td><a class="btn btn-default no-border" target="_blank" title="{{ labelkey['rprequestlog.lbl_viewdetails'] }} {{ item['username'] }}" href="/rprequestlog/details?userid={{ item['userid'] }}&username={{ item['username'] }}&sdate={{ date('d-m-Y',sdate) }}&edate={{ date('d-m-Y',edate) }}"><i class="zmdi zmdi-search"></i></a></td>
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