<!--  summernote -->
<link href="/js/summernote/dist/summernote.css" rel="stylesheet">

<div class="row">
    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
        <div class="col-lg-6">
            <a href="{{ backurl }}" class="btn btn-sm btn-success addon-btn m-b-10"><i class="zmdi zmdi-arrow-left"></i> {{ labelkey['general.lbl_back'] }}</a>
            <section class="panel">
                <header class="panel-heading">
                    {{ labelkey['timetable.lbl_basicinfo'] }}
                </header>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="username">{{ labelkey['timetable.lbl_name'] }}</label>
                        <div class="col-md-10"><input type="text" name="name" value="{{ object.name }}" class="form-control" placeholder="{{ labelkey['timetable.lbl_name'] }}" required></div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['timetable.lbl_status'] }}</label>
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
                        <label class="col-md-2 control-label" for="username">{{ labelkey['timetable.lbl_captions'] }}</label>
                        <div class="col-md-10">
                            <textarea class="summernote" id="summernote" name="content">{{ object.content }}</textarea>
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

<!--summernote-->
<script src="/js/summernote/dist/summernote.min.js"></script>

<script>
    jQuery(document).ready(function () {
        $('.summernote').summernote({
            height: 200,                 // set editor height
            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor
            focus: false                 // set focus to editable area after initializing summernote
        });
    });
</script>
