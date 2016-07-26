<div class="row">
    <div class="col-md-12">
        <a href="index?userid={{ _GET['userid'] }}" class="btn btn-sm btn-success addon-btn m-b-10"><i class="zmdi zmdi-arrow-left"></i> {{ labelkey['general.lbl_back'] }}</a>
        <section class="panel">
            <header class="panel-heading">Thông tin quý</header>
            <div class="panel-body">
                <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-md-2 control-label">Tên</label>

                            <div class="col-md-8"><input type="text" name="name" value="{{ object.name }}" class="form-control"></div>
                        </div>
                    </div>
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
