<!--bootstrap picker-->
<link rel="stylesheet" type="text/css" href="/js/bootstrap-datepicker/css/datepicker.css"/>
<link rel="stylesheet" type="text/css" href="/js/bootstrap-timepicker/compiled/timepicker.css"/>
<link rel="stylesheet" type="text/css" href="/js/bootstrap-colorpicker/css/colorpicker.css"/>
<link rel="stylesheet" type="text/css" href="/js/bootstrap-daterangepicker/daterangepicker-bs3.css"/>
<link rel="stylesheet" type="text/css" href="/js/bootstrap-datetimepicker/css/datetimepicker.css"/>

<div class="row">
    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
        <div class="col-lg-6">
            <a href="{{ backurl }}" class="btn btn-sm btn-success addon-btn m-b-10"><i class="zmdi zmdi-arrow-left"></i> {{ labelkey['general.lbl_back'] }}</a>
            <section class="panel">
                <header class="panel-heading">
                    {{ labelkey['tuition.lbl_basicinfo'] }}
                </header>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="username">{{ labelkey['tuition.lbl_name'] }}</label>
                        <div class="col-md-10"><input type="text" name="name" value="{{ object.name }}" class="form-control" placeholder="{{ labelkey['tuition.lbl_name'] }}" required></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="username">{{ labelkey['tuition.lbl_price'] }}</label>
                        <div class="col-md-10"><input type="text" name="price" value="{{ object.price }}" class="form-control" placeholder="{{ labelkey['tuition.lbl_price'] }}" required></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="username">{{ labelkey['tuition.lbl_start_date'] }}</label>
                        <div class="col-md-10"><input type="text" data-date-format="dd-mm-yyyy" class="form-control form-control-inline input-medium default-date-picker" value="{{ object.start_date }}" name="start_date"/></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="username">{{ labelkey['tuition.lbl_expired_date'] }}</label>
                        <div class="col-md-10"><input type="text" data-date-format="dd-mm-yyyy" class="form-control form-control-inline input-medium default-date-picker" value="{{ object.expired_date }}" name="expired_date"/></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['tuition.lbl_status'] }}</label>
                        <div class="col-md-8">
                            <div class="radio-custom radio-success inline">
                                <input {% if object.status == 0 %}checked="checked"{% endif %} type="radio" value="0" name="status" id="0">
                                <label for="0">{{ labelkey['general.lbl_hide'] }}</label>
                            </div>
                            <div class="radio-custom radio-success inline">
                                <input {% if object.status == 1 %}checked="checked"{% endif %} type="radio" value="1" name="status" id="1">
                                <label for="1">{{ labelkey['general.lbl_show'] }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="username">{{ labelkey['tuition.lbl_captions'] }}</label>
                        <div class="col-md-10"><input type="text" name="captions" value="{{ object.captions }}" class="form-control" placeholder="{{ labelkey['tuition.lbl_captions'] }}" required></div>
                    </div>

                </div>
            </section>
        </div>
        <div class="col-lg-12">
            <button type="submit" class="btn btn-info">Save</button>
        </div>
    </form>
</div>

<!--bootstrap picker-->
<script type="text/javascript" src="/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="/js/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="/js/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="/js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>

<!--picker initialization-->
<script src="/js/picker-init.js"></script>
