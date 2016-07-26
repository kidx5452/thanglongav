<!--bootstrap picker-->
<link rel="stylesheet" type="text/css" href="/js/bootstrap-datepicker/css/datepicker.css"/>
<link rel="stylesheet" type="text/css" href="/js/bootstrap-timepicker/compiled/timepicker.css"/>
<link rel="stylesheet" type="text/css" href="/js/bootstrap-daterangepicker/daterangepicker-bs3.css"/>
<link rel="stylesheet" type="text/css" href="/js/bootstrap-datetimepicker/css/datetimepicker.css"/>

<a href="{{ backurl }}" class="btn btn-sm btn-success addon-btn m-b-10"><i class="zmdi zmdi-arrow-left"></i> {{ labelkey['general.lbl_back'] }}</a>
<div class="row">
    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    {{ labelkey['pupil.lbl_basicinfo'] }}
                </header>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="datecreate"> {{ labelkey['pupil.lbl_generalreport_datecreate'] }}</label>
                        <div class="col-md-10"><input type="text" id="datecreate" data-date-format="dd-mm-yyyy" class="form-control form-control-inline input-medium default-date-picker" value="{{ object.datecreate }}" name="datecreate"/></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="point">{{ labelkey['pupil.lbl_generalreport_point'] }}</label>
                        <div class="col-md-10"><input type="text" name="point" value="{{ object.point }}" class="form-control" id="point" placeholder="Điểm" required></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['pupil.lbl_generalreport_content'] }}</label>
                        <div class="col-md-8">
                            <textarea class="form_editor" id="summernote" name="contents">{{ object.contents }}</textarea>
                        </div>
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
<script type="text/javascript" src="/js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>

<!--picker initialization-->
<script src="/js/picker-init.js"></script>
<script>
    jQuery(document).ready(function () {
        loadTinyMce('form_editor');
    });
</script>
