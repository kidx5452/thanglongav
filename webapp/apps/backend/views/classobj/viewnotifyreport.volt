<div class="row">
    <div class="col-sm-12">
        <a href="{{ _GET['backurl'] }}" class="btn btn-sm btn-success addon-btn m-b-10"><i
                    class="zmdi zmdi-arrow-left"></i> {{ labelkey['general.lbl_back'] }}</a>
        <section class="panel">
            <header class="panel-heading head-border">
                {{ labelkey['reportpupil.lbl_notify']~' '~labelkey['classobj.lbl_form']~' '~classobj.name~' <b>('~date('d-m-Y',_GET['datetest'])~')</b>'}}
            </header>
            <div class="panel-body">
                <form action="" method="post" class="form-horizontal">
                    <div class="clearfix">
                        {% for item in listdata %}
                            <input type="hidden" name="id[]" value="{{ item.id }}">
                            <div class="col-sm-4 panel">
                                <p class="text-center"><b>{{ item.User.firstname~' '~item.User.lastname }}</b></p>
                                <div class="clearfix">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">{{ labelkey['general.lbl_title'] }}</label>
                                        <div class="col-md-9"><input type="text" value="{{ item.name }}" name="name[{{ item.id }}]" class="form-control" placeholder="{{ labelkey['general.lbl_title'] }}" required></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">{{ labelkey['general.lbl_status'] }}</label>
                                        <div class="col-md-9">
                                            <div class="radio-custom radio-success inline">
                                                <input {% if item.status == 0 %}checked="checked"{% endif %} type="radio" value="0" name="status[{{ item.id }}]" id="0">
                                                <label for="0">{{ labelkey['general.lbl_hide'] }}</label>
                                            </div>
                                            <div class="radio-custom radio-success inline">
                                                <input {% if item.status == 1 %}checked="checked"{% endif %} type="radio" value="1" name="status[{{ item.id }}]" id="1">
                                                <label for="1">{{ labelkey['general.lbl_show'] }}</label>
                                            </div>
                                            <div class="radio-custom radio-success inline">
                                                <input {% if item.status == 2 %}checked="checked"{% endif %} type="radio" value="2" name="status[{{ item.id }}]" id="2">
                                                <label for="2">{{ labelkey['general.lbl_unread'] }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">{{ labelkey['general.lbl_content'] }}</label>
                                        <div class="col-md-9"><textarea name="content[{{ item.id }}]" class="form_editor">{{ item.content }}</textarea></div>
                                    </div>
                                </div>
                            </div>
                        {% endfor %}
                    </div>
                    <div class="action_area text-center">
                        <button type="submit" name="actiontype" value="notify" class="btn btn-info">Submit</button>
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