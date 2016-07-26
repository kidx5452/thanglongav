<!--bootstrap picker-->
<link rel="stylesheet" type="text/css" href="/js/bootstrap-datepicker/css/datepicker.css"/>
<link rel="stylesheet" type="text/css" href="/js/bootstrap-timepicker/compiled/timepicker.css"/>
<link rel="stylesheet" type="text/css" href="/js/bootstrap-colorpicker/css/colorpicker.css"/>
<link rel="stylesheet" type="text/css" href="/js/bootstrap-daterangepicker/daterangepicker-bs3.css"/>
<link rel="stylesheet" type="text/css" href="/js/bootstrap-datetimepicker/css/datetimepicker.css"/>

<a href="{{ backurl }}" class="btn btn-sm btn-success addon-btn m-b-10"><i class="zmdi zmdi-arrow-left"></i> {{ labelkey['general.lbl_back'] }}</a>
<div class="row">
    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
        <div class="col-lg-6">
            <section class="panel">
                <header class="panel-heading">
                    {{ labelkey['teacher.lbl_basicinfo'] }}
                </header>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="username">{{ labelkey['teacher.lbl_username'] }}</label>
                        <div class="col-md-10"><input type="text" name="username" value="{{ object.username }}" class="form-control" id="username" placeholder="{{ labelkey['teacher.lbl_username'] }}" required></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="password">{{ labelkey['teacher.lbl_password'] }}</label>
                        <div class="col-md-10"><input type="password" class="form-control" id="password" name="password" placeholder="{{ labelkey['teacher.lbl_password'] }}"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="firstname">{{ labelkey['teacher.lbl_firstname'] }}</label>
                        <div class="col-md-10"><input type="text" name="firstname" value="{{ object.firstname }}" class="form-control" id="firstname" placeholder="{{ labelkey['teacher.lbl_firstname'] }}" required></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="lastname">{{ labelkey['teacher.lbl_lastname'] }}</label>
                        <div class="col-md-10"><input type="text" name="lastname" value="{{ object.lastname }}" class="form-control" id="lastname" placeholder="{{ labelkey['teacher.lbl_lastname'] }}" required></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" l>{{ labelkey['teacher.lbl_avatar'] }}</label>
                        <div class="col-md-10"><input id="file-0" class="file" type="file" name="{{ labelkey['teacher.lbl_avatar'] }}"></div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-lg-6">
            <section class="panel">
                <header class="panel-heading">
                    {{ labelkey['teacher.lbl_moreinfo'] }}
                </header>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="dob">{{ labelkey['teacher.lbl_birthday'] }}</label>
                        <div class="col-md-10"><input type="text" data-date-format="dd-mm-yyyy" class="form-control form-control-inline input-medium default-date-picker" value="{{ object.birthday }}" name="dob"/></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="address">{{ labelkey['teacher.lbl_address'] }}</label>
                        <div class="col-md-10"><input type="text" name="address" value="{{ object.address }}" class="form-control" id="address" placeholder="{{ labelkey['teacher.lbl_address'] }}"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="phone">{{ labelkey['teacher.lbl_phone'] }}</label>
                        <div class="col-md-10"><input type="text" name="phone" value="{{ object.phone }}" class="form-control" id="phone" placeholder="{{ labelkey['teacher.lbl_phone'] }}"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="gender">{{ labelkey['teacher.lbl_gender'] }}</label>
                        <div class="col-md-10">
                            <div class="radio-custom radio-success inline">
                                <input {% if object.gender == 1 %}checked="checked"{% endif  %} type="radio" value="1" name="gender" id="male">
                                <label for="male">{{ labelkey['teacher.lbl_male'] }}</label>
                            </div>
                            <div class="radio-custom radio-success inline">
                                <input {% if object.gender == 2 %}checked="checked"{% endif  %} type="radio" value="2" name="gender" id="female">
                                <label for="female">{{ labelkey['teacher.lbl_female'] }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['teacher.lbl_captions'] }}</label>
                        <div class="col-md-10">
                            <textarea class="form_editor" id="summernote" name="captions">{{ object.captions }}</textarea>
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
<script type="text/javascript" src="/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="/js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>

<!--picker initialization-->
<script src="/js/picker-init.js"></script>

<script type="text/javascript">
    jQuery(document).ready(function () {
        loadTinyMce('form_editor');
    });
</script>