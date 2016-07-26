<div class="row">
    <div class="col-sm-12">
        <a href="{{ _GET['backurl'] }}" class="btn btn-sm btn-success addon-btn m-b-10"><i
                    class="zmdi zmdi-arrow-left"></i> {{ labelkey['general.lbl_back'] }}</a>
        <section class="panel">
            <header class="panel-heading head-border">
                {{ labelkey['reportpupil.lbl_presentation']~' '~labelkey['classobj.lbl_form']~' '~classobj.name~' <b>('~date('m-Y',_GET['datetest'])~')</b>'}}
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
                                        <label class="col-md-4 control-label">{{ labelkey['reportpupil.lbl_organization'] }}</label>
                                        <div class="col-md-8"><input type="text" value="{{ item.organization }}" name="organization[{{ item.id }}]" class="form-control" placeholder="{{ labelkey['reportpupil.lbl_organization'] }}" required></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">{{ labelkey['reportpupil.lbl_language_use'] }}</label>
                                        <div class="col-md-8"><input type="text" value="{{ item.language_use }}" name="language_use[{{ item.id }}]" class="form-control" placeholder="{{ labelkey['reportpupil.lbl_language_use'] }}" required></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">{{ labelkey['reportpupil.lbl_pronunciation'] }}</label>
                                        <div class="col-md-8"><input type="text" value="{{ item.pronunciation }}" name="pronunciation[{{ item.id }}]" class="form-control" placeholder="{{ labelkey['reportpupil.lbl_pronunciation'] }}" required></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">{{ labelkey['reportpupil.lbl_interaction'] }}</label>
                                        <div class="col-md-8"><input type="text" value="{{ item.interaction }}" name="interaction[{{ item.id }}]" class="form-control" placeholder="{{ labelkey['reportpupil.lbl_interaction'] }}" required></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">{{ labelkey['reportpupil.lbl_voice'] }}</label>
                                        <div class="col-md-8"><input type="text" value="{{ item.voice }}" name="voice[{{ item.id }}]" class="form-control" placeholder="{{ labelkey['reportpupil.lbl_voice'] }}" required></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">{{ labelkey['reportpupil.lbl_body_language'] }}</label>
                                        <div class="col-md-8"><input type="text" value="{{ item.body_language }}" name="body_language[{{ item.id }}]" class="form-control" placeholder="{{ labelkey['reportpupil.lbl_body_language'] }}" required></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">{{ labelkey['reportpupil.lbl_visual_aids'] }}</label>
                                        <div class="col-md-8"><input type="text" value="{{ item.visual_aids }}" name="visual_aids[{{ item.id }}]" class="form-control" placeholder="{{ labelkey['reportpupil.lbl_visual_aids'] }}" required></div>
                                    </div>
                                </div>
                            </div>
                        {% endfor %}
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['general.lbl_status'] }}</label>
                        <div class="col-md-10">
                            <div class="radio-custom radio-success inline">
                                <input {% if item.status == 0 %}checked="checked"{% endif %} type="radio" value="0" name="status" id="0">
                                <label for="0">{{ labelkey['general.lbl_hide'] }}</label>
                            </div>
                            <div class="radio-custom radio-success inline">
                                <input {% if item.status == 1 %}checked="checked"{% endif %} type="radio" value="1" name="status" id="1">
                                <label for="1">{{ labelkey['general.lbl_show'] }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="action_area text-center">
                        <button type="submit" name="actiontype" value="presentationtest" class="btn btn-info">Submit</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>