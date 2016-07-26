<a href="/userpostition/index" class="btn btn-sm btn-success addon-btn m-b-10"><i class="zmdi zmdi-arrow-left"></i> {{ labelkey['general.lbl_back'] }}</a>
<div class="row">
    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    {{ labelkey['upos.lbl_basicinfo'] }}
                </header>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="captions">{{ labelkey['upos.captions'] }}</label>
                        <div class="col-md-10"><input type="text" name="captions" value="{{ object.captions }}" class="form-control" id="captions" placeholder="{{ labelkey['upos.captions'] }}"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="name">{{ labelkey['upos.name'] }}</label>
                        <div class="col-md-10"><input type="text" name="name" value="{{ object.name }}" class="form-control" id="name" placeholder="{{ labelkey['upos.name'] }}"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="sorts">{{ labelkey['upos.sorts'] }}</label>
                        <div class="col-md-10"><input type="number" required class="form-control" id="sorts" name="sorts" value="{{ object.sorts }}" placeholder="{{ labelkey['upos.sorts'] }}"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['upos.lbl_content'] }}</label>
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
<script>
    jQuery(document).ready(function () {
        loadTinyMce('form_editor');
    });


</script>
