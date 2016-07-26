<div class="row">
    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
        <div class="col-md-12">
            <a href="{{ backurl }}" class="btn btn-sm btn-success addon-btn m-b-10"><i class="zmdi zmdi-arrow-left"></i> {{ labelkey['general.lbl_back'] }}</a>
            <section class="panel">
                <header class="panel-heading">
                    {{ labelkey['notifypupil.lbl_addnotify'] }} <a
                            href="/notifypupil/index?id={{ _GET['userid'] }}"><strong
                                class="text-danger">{{ userinfo.username }}</strong></a>
                </header>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['general.lbl_title'] }}</label>
                        <div class="col-md-8"><input type="text" name="name" value="{{ object.name }}"
                                                     class="form-control"
                                                     placeholder="{{ labelkey['category.lbl_name'] }}" required></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['general.lbl_status'] }}</label>
                        <div class="col-md-8">
                            <div class="radio-custom radio-success inline">
                                <input {% if object.status == 0  %}checked="checked"{% endif %}
                                       type="radio" value="0" name="status" id="0">
                                <label for="0">{{ labelkey['general.lbl_hide'] }}</label>
                            </div>
                            <div class="radio-custom radio-success inline">
                                <input {% if object.status == 1  %}checked="checked"{% endif %}
                                       type="radio" value="1" name="status" id="1">
                                <label for="1">{{ labelkey['general.lbl_show'] }}</label>
                            </div>
                            <div class="radio-custom radio-success inline">
                                <input {% if object.status == 2 %}checked="checked"{% endif %} type="radio" value="2"
                                       name="status" id="2">
                                <label for="2">{{ labelkey['general.lbl_unread'] }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['general.lbl_content'] }}</label>
                        <div class="col-md-8"><textarea name="content" class="form-control form_editor">{{ object.content }}</textarea></div>
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