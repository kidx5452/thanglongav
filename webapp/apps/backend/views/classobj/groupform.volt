<!--  summernote -->
<link href="/js/summernote/dist/summernote.css" rel="stylesheet">

<div class="row">
    <div class="col-md-12">
        <a href="index" class="btn btn-sm btn-success addon-btn m-b-10"><i class="zmdi zmdi-arrow-left"></i> {{ labelkey['general.lbl_back'] }}</a>
        <section class="panel-">
            <header class="panel-heading">{{ labelkey['classobj.lbl_groupinfo'] }}</header>
            <div class="panel-body no-pad">
                <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                    <!--tab nav start-->
                    <section class="isolate-tabs">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a data-toggle="tab" href="#tab1">{{ labelkey['classobj.lbl_groupinfo'] }}</a>
                            </li>
                        </ul>
                        <div class="panel-body">
                            <div class="tab-content">
                                <div id="tab1" class="tab-pane active">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">{{ labelkey['classobj.lbl_group_name'] }}</label>
                                            <div class="col-md-8"><input type="text" name="keycode" value="{{ object.keycode }}" class="form-control" required placeholder="Ví dụ: I"></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">{{ labelkey['classobj.lbl_group_name'] }}</label>
                                            <div class="col-md-8"><input type="text" name="name" value="{{ object.name }}" class="form-control"></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">{{ labelkey['classobj.lbl_group_sort'] }}</label>
                                            <div class="col-md-8"><input type="text" name="sorts" value="{{ object.sorts }}" class="form-control"></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">{{ labelkey['classobj.lbl_descriptions'] }}</label>
                                            <div class="col-md-8">
                                                <textarea class="form_editor" id="summernote" name="captions">{{ object.captions }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </section>
                    <!--tab nav start-->

                    <div class="action_area">
                        <button type="submit" class="btn btn-info">{{ labelkey['general.btn_save'] }}</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
<script>
    jQuery(document).ready(function () {
        loadTinyMce('form_editor');
    });


</script>
