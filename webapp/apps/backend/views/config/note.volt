<form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
    {% for i in 12..15 %}
        <div class="panel col-sm-6">
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-md-2 control-label">Name</label>
                    <div class="col-md-8">
                        <input type="hidden" name="keys[]" value="{{ i }}">
                        <input type="text" name="name[]" value="{{ object[i].name }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Value</label>
                    <div class="col-md-8">
                        <textarea class="form_editor" name="contents[]">{{ object[i].contents }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    {% endfor %}
    {% for i in 0..11 %}
        <div class="panel col-sm-6">
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-md-2 control-label">Name</label>
                    <div class="col-md-8">
                        <input type="hidden" name="keys[]" value="{{ i }}">
                        <input type="text" name="name[]" value="{{ object[i].name }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Value</label>
                    <div class="col-md-8">
                        <textarea class="form_editor" name="contents[]">{{ object[i].contents }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    {% endfor %}
    <div class="form-group">
        <button type="submit" class="btn btn-info">{{ labelkey['general.btn_save'] }}</button>
    </div>
</form>
<script>
    jQuery(document).ready(function () {
        loadTinyMce('form_editor');
    });
</script>