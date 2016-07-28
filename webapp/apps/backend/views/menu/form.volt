<div class="row">
    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
        <div class="col-md-12">
            <a href="index?cattype={{ viewvar['cattype'] }}" class="btn btn-sm btn-success addon-btn m-b-10"><i class="zmdi zmdi-arrow-left"></i> {{ labelkey['general.lbl_back'] }}</a>
            <section class="panel">
                <header class="panel-heading">
                    {{ labelkey['category.lbl_info'] }}
                </header>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Name</label>
                        <div class="col-md-8"><input type="text" name="name" value="{{ object.name }}" class="form-control" placeholder="{{ labelkey['category.lbl_name'] }}" required></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Url</label>
                        <div class="col-md-8"><input type="text" name="objid" value="{{ object.objid }}" class="form-control" placeholder="{{ labelkey['category.lbl_caption'] }}"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Thứ tự</label>
                        <div class="col-md-8"><input type="text" name="sorts" value="{{ object.sorts }}" class="form-control" placeholder="{{ labelkey['category.lbl_caption'] }}"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['category.lbl_status'] }}</label>
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
                </div>
            </section>
        </div>

        <div class="col-md-12">
            <input type="hidden" name="backurl" value="{{ _GET['back']==1?backurl:0 }}"/>
            <button type="submit" class="btn btn-info">{{ labelkey['general.btn_save'] }}</button>
        </div>
    </form>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        loadTinyMce('form_editor');
    });
</script>
