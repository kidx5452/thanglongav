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
                        <label class="col-md-2 control-label">{{ labelkey['category.lbl_name'] }}</label>
                        <div class="col-md-8"><input type="text" name="name" value="{{ object.name }}" class="form-control" placeholder="{{ labelkey['category.lbl_name'] }}" required></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['category.lbl_caption'] }}</label>
                        <div class="col-md-8"><input type="text" name="caption" value="{{ object.caption }}" class="form-control" placeholder="{{ labelkey['category.lbl_caption'] }}"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['category.lbl_descriptions'] }}</label>
                        <div class="col-md-8"><input type="text" name="descriptions" value="{{ object.descriptions }}" class="form-control" placeholder="{{ labelkey['category.lbl_descriptions'] }}"></div>
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
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['category.lbl_avatar'] }}</label>
                        <div class="col-md-8">
                            {% if object.avatar|length >0 %}
                                <p class="clearfix"><a href="{{ media.host~object.avatar }}" target="_blank"><img width="150" src="{{ media.host~object.avatar }}" alt="Avatar"></a></p>
                            {% endif %}
                            <input id="file-0" class="file" type="file" name="avatar" accept="image/*">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['category.lbl_coverphoto'] }}</label>
                        <div class="col-md-8">
                            {% if object.coverphoto|length >0 %}
                                <p class="clearfix"><a href="{{ media.host~object.coverphoto }}" target="_blank"><img width="500" src="{{ media.host~object.coverphoto }}" alt="Cover Photo"></a></p>
                            {% endif %}
                            <input id="file-0" class="file" type="file" name="coverphoto" accept="image/*">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['category.lbl_covervideo'] }}</label>
                        <div class="col-md-8"><input type="text" name="cover_video" value="{{ object.cover_video }}" class="form-control" placeholder="Link youtube - VD: https://www.youtube.com/watch?v=X8P-0GKTycs"></div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    {{ labelkey['category.lbl_moreinfo'] }}
                </header>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['category.lbl_type'] }}</label>
                        <div class="col-md-8">
                            <select class="form-control" name="view_type" id="cat-type">
                                <option value="single">{{ labelkey['category.lbl_singlecat'] }}</option>
                                <option {{ _POST['type']=='list' or object.type=='list' ?'selected':'' }} value="list">{{ labelkey['category.lbl_listcat'] }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" id="rightcontent-area" style="display: {{ _POST['layout']=='3col' or object.layout=='3col' ?'block':'none' }}">
                        <label class="col-md-2 control-label">{{ labelkey['category.lbl_rightcolcontent'] }}</label>
                        <div class="col-md-8"><textarea name="rightcolcontent" class="form-control form_editor">{{ object.rightcolcontent }}</textarea></div>
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
