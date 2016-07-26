<div class="row">
    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
        <div class="col-md-12">
            <a href="{{ backurl }}" class="btn btn-sm btn-success addon-btn m-b-10"><i class="zmdi zmdi-arrow-left"></i> {{ labelkey['general.lbl_back'] }}</a>
            <section class="panel">
                <header class="panel-heading">
                    {{ labelkey['reportpupil.lbl_addnotify'] }} <a
                            href="/reportpupil/index?id={{ _GET['userid'] }}"><strong
                                class="text-danger">{{ userinfo.username }}</strong></a>
                </header>
                <div class="panel-body">
                    <!--
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['category.lbl_lang'] }}</label>
                        <div class="col-md-8">
                            <select class="form-control" name="lang">
                                {% for item in langlist %}
                                    <option {{ _POST['lang']==item['key'] or object.lang==item['key'] ?'selected':'' }} value="{{ item['key'] }}">{{ item['name'] }}</option>
                                {% endfor %}
                            </select>
                        </div>
                    </div>
                    -->
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['general.lbl_title'] }}</label>

                        <div class="col-md-8"><input type="text" name="name" value="{{ object.name }}"
                                                     class="form-control"
                                                     placeholder="{{ labelkey['category.lbl_name'] }}" required></div>
                    </div>
                    {% if checkperrmission("pupil_reportupdatestatus")==1 %}
                        <div class="form-group">
                            <label class="col-md-2 control-label">{{ labelkey['general.lbl_status'] }}</label>

                            <div class="col-md-8">
                                <div class="radio-custom radio-success inline">
                                    <input {% if object.status == 1 or object.status == 0 %}checked="checked"{% endif %}
                                           type="radio" value="1" name="status" id="1">
                                    <label for="1">{{ labelkey['general.lbl_hide'] }}</label>
                                </div>
                                <div class="radio-custom radio-success inline">
                                    <input {% if object.status == 2 %}checked="checked"{% endif %} type="radio" value="2"
                                           name="status" id="2">
                                    <label for="2">{{ labelkey['general.lbl_show'] }}</label>
                                </div>
                            </div>
                        </div>
                    {% endif %}
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['general.lbl_content'] }}</label>

                        <div class="col-md-8"><textarea name="content" class="form-control form_editor">{{ object.content }}</textarea></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['reportpupil.lbl_comment'] }}</label>

                        <div class="col-md-8">
                            <section class="isolate-tabs">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab-1" data-toggle="tab" aria-expanded="true">{{ labelkey['reportpupil.lbl_skilltest_comment'] }}</a></li>
                                    <li class=""><a href="#tab-2" data-toggle="tab" aria-expanded="false">{{ labelkey['reportpupil.lbl_oraltest_comment'] }}</a></li>
                                    <li class=""><a href="#tab-3" data-toggle="tab" aria-expanded="false">{{ labelkey['reportpupil.lbl_presentation_comment'] }}</a></li>
                                    <li class=""><a href="#tab-4" data-toggle="tab" aria-expanded="false">{{ labelkey['reportpupil.lbl_attitude_comment'] }}</a></li>
                                    <li class=""><a href="#tab-5" data-toggle="tab" aria-expanded="false">{{ labelkey['reportpupil.lbl_minitest_comment'] }}</a></li>
                                </ul>
                                <div class="panel-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab-1">
                                            <textarea name="skilltest_comment" class="form-control form_editor">{{ object.skilltest_comment }}</textarea>
                                        </div>
                                        <div class="tab-pane" id="tab-2">
                                            <textarea name="oraltest_comment" class="form-control form_editor">{{ object.oraltest_comment }}</textarea>
                                        </div>
                                        <div class="tab-pane" id="tab-3">
                                            <textarea name="presentation_comment" class="form-control form_editor">{{ object.presentation_comment }}</textarea>
                                        </div>
                                        <div class="tab-pane" id="tab-4">
                                            <textarea name="attitude_comment" class="form-control form_editor">{{ object.attitude_comment }}</textarea>
                                        </div>
                                        <div class="tab-pane" id="tab-5">
                                            <textarea name="minitest_comment" class="form-control form_editor">{{ object.minitest_comment }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </section>
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