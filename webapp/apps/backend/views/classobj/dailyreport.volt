<div class="row">
    <div class="col-lg-12">
        <a href="index" class="btn btn-sm btn-success addon-btn m-b-10"><i
                    class="zmdi zmdi-arrow-left"></i> {{ labelkey['general.lbl_back'] }}</a>
        <!--tab nav start-->
        <section class="isolate-tabs">
            <ul class="nav nav-tabs">
                <li{{ activetab=='attitude' ? ' class="active"' : '' }}>
                    <a data-toggle="tab" href="#attitude">Attitude</a>
                </li>
                <li{{ activetab=='minitest' ? ' class="active"' : '' }}>
                    <a data-toggle="tab" href="#minitest">Mini Test</a>
                </li>
                <li{{ activetab=='notify' ? ' class="active"' : '' }}>
                    <a data-toggle="tab" href="#notify">{{ labelkey['reportpupil.lbl_notify'] }}</a>
                </li>
            </ul>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="attitude" class="tab-pane{{ activetab=='attitude' ? ' active' : '' }}">
                        <p class="text-center"><a class="btn btn-primary" href="viewdailyreport?{{ _GET['id'] ? 'id='~_GET['id']~'&' : '' }}classid={{ _GET['classid'] }}&type=attitude">{{ labelkey['reportpupil.lbl_viewenteredday']~' ('~labelkey['classobj.lbl_form']~' '~classobj.name~')' }}</a></p>
                        <form action="" method="post" class="form-horizontal">
                            <div class="clearfix m-b-10">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">{{ labelkey['reportpupil.lbl_datetest'] }}</label>
                                    <div class="col-md-8"><input type="text" name="datetest" class="form-control" placeholder="dd-mm-yyyy" required></div>
                                </div>
                            </div>
                            <div class="clearfix">
                                {% if _GET['id'] is defined %}
                                    <input type="hidden" name="userid[]" value="{{ pupilobj['id'] }}">
                                        <p class="text-center"><b>{{ pupilobj['firstname']~' '~pupilobj['lastname'] }}</b></p>
                                        <div class="clearfix">
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">{{ labelkey['reportpupil.lbl_attendance'] }}</label>
                                                <div class="col-md-8"><input type="text" name="attendance[]" class="form-control" placeholder="{{ labelkey['reportpupil.lbl_attendance'] }}"></div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">{{ labelkey['reportpupil.lbl_participation'] }}</label>
                                                <div class="col-md-8"><input type="text" name="participation[]" class="form-control" placeholder="{{ labelkey['reportpupil.lbl_participation'] }}"></div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">{{ labelkey['reportpupil.lbl_behavior'] }}</label>
                                                <div class="col-md-8"><input type="text" name="behavior[]" class="form-control" placeholder="{{ labelkey['reportpupil.lbl_behavior'] }}"></div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">{{ labelkey['reportpupil.lbl_diligence'] }}</label>
                                                <div class="col-md-8"><input type="text" name="diligence[]" class="form-control" placeholder="{{ labelkey['reportpupil.lbl_diligence'] }}"></div>
                                            </div>
                                        </div>
                                {% else %}
                                    {% for item in classobj.Pupil %}
                                        <input type="hidden" name="userid[]" value="{{ item.id }}">
                                        <div class="col-sm-4 panel">
                                            <p class="text-center"><b>{{ item.firstname~' '~item.lastname }}</b></p>

                                            <div class="clearfix">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">{{ labelkey['reportpupil.lbl_attendance'] }}</label>
                                                    <div class="col-md-9"><input type="text" name="attendance[]" class="form-control" placeholder="{{ labelkey['reportpupil.lbl_attendance'] }}"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">{{ labelkey['reportpupil.lbl_participation'] }}</label>
                                                    <div class="col-md-9"><input type="text" name="participation[]" class="form-control" placeholder="{{ labelkey['reportpupil.lbl_participation'] }}"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">{{ labelkey['reportpupil.lbl_behavior'] }}</label>
                                                    <div class="col-md-9"><input type="text" name="behavior[]" class="form-control" placeholder="{{ labelkey['reportpupil.lbl_behavior'] }}"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">{{ labelkey['reportpupil.lbl_diligence'] }}</label>
                                                    <div class="col-md-9"><input type="text" name="diligence[]" class="form-control" placeholder="{{ labelkey['reportpupil.lbl_diligence'] }}"></div>
                                                </div>
                                            </div>
                                        </div>
                                    {% endfor %}
                                {% endif %}
                            </div>
                            <div class="action_area text-center">
                                <button type="submit" name="actiontype" value="attitude" class="btn btn-info">Submit</button>
                            </div>
                        </form>

                    </div>
                    <div id="minitest" class="tab-pane{{ activetab=='minitest' ? ' active' : '' }}">
                        <p class="text-center"><a class="btn btn-primary" href="viewdailyreport?classid={{ _GET['classid'] }}&type=minitest">{{ labelkey['reportpupil.lbl_viewenteredday']~' ('~labelkey['classobj.lbl_form']~' '~classobj.name~')' }}</a></p>
                        <form action="" method="post" class="form-horizontal">
                            <div class="clearfix m-b-10">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">{{ labelkey['reportpupil.lbl_datetest'] }}</label>

                                    <div class="col-md-8"><input type="text" name="datetest" class="form-control" placeholder="dd-mm-yyyy" required></div>
                                </div>
                            </div>
                            <div class="clearfix">
                                {% if _GET['id'] is defined %}
                                    <input type="hidden" name="userid[]" value="{{ pupilobj['id'] }}">
                                    <div class="panel">
                                        <p class="text-center"><b>{{ pupilobj['firstname']~' '~pupilobj['lastname'] }}</b></p>
                                        <div class="clearfix">
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">{{ labelkey['reportpupil.lbl_point'] }}</label>
                                                <div class="col-md-8"><input type="text" name="point[]" class="form-control" placeholder="{{ labelkey['reportpupil.lbl_point'] }}"></div>
                                            </div>
                                        </div>
                                    </div>
                                {% else %}
                                    {% for item in classobj.Pupil %}
                                        <input type="hidden" name="userid[]" value="{{ item.id }}">
                                        <div class="col-sm-4 panel">
                                            <p class="text-center"><b>{{ item.firstname~' '~item.lastname }}</b></p>
                                            <div class="clearfix">
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">{{ labelkey['reportpupil.lbl_point'] }}</label>
                                                    <div class="col-md-10"><input type="text" name="point[]" class="form-control" placeholder="{{ labelkey['reportpupil.lbl_point'] }}"></div>
                                                </div>
                                            </div>
                                        </div>
                                    {% endfor %}
                                {% endif %}
                            </div>
                            <div class="action_area text-center">
                                <button type="submit" name="actiontype" value="minitest" class="btn btn-info">Submit</button>
                            </div>
                        </form>
                    </div>
                    <div id="notify" class="tab-pane{{ activetab=='notify' ? ' active' : '' }}">
                        <p class="text-center"><a class="btn btn-primary" href="viewdailyreport?classid={{ _GET['classid'] }}&type=notify">{{ labelkey['reportpupil.lbl_viewenteredday']~' ('~labelkey['classobj.lbl_form']~' '~classobj.name~')' }}</a></p>
                        <form action="" method="post" class="form-horizontal">
                            <!--
                            <div class="clearfix m-b-10">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">{{ labelkey['reportpupil.lbl_datetest'] }}</label>
                                    <div class="col-md-8"><input type="text" name="datetest" class="form-control" placeholder="dd-mm-yyyy" required></div>
                                </div>
                            </div>
                            -->
                            <div class="clearfix">
                                {% if _GET['id'] is defined %}
                                    <input type="hidden" name="userid[]" value="{{ pupilobj['id'] }}">
                                    <div class="panel">
                                        <p class="text-center"><b>{{ pupilobj['firstname']~' '~pupilobj['lastname'] }}</b></p>
                                        <div class="clearfix">
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">{{ labelkey['general.lbl_title'] }}</label>
                                                <div class="col-md-8"><input type="text" name="name[]" value="{{ object.name }}" class="form-control" placeholder="{{ labelkey['category.lbl_name'] }}"></div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">{{ labelkey['general.lbl_content'] }}</label>
                                                <div class="col-md-8"><textarea name="content[]" class="form_editor">{{ object.content }}</textarea></div>
                                            </div>
                                        </div>
                                    </div>
                                {% else %}
                                    {% for item in classobj.Pupil %}
                                        <input type="hidden" name="userid[]" value="{{ item.id }}">
                                        <div class="col-sm-4 panel">
                                            <p class="text-center"><b>{{ item.firstname~' '~item.lastname }}</b></p>

                                            <div class="clearfix">
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">{{ labelkey['general.lbl_title'] }}</label>

                                                    <div class="col-md-10"><input type="text" name="name[]" value="{{ object.name }}" class="form-control" placeholder="{{ labelkey['category.lbl_name'] }}"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">{{ labelkey['general.lbl_content'] }}</label>

                                                    <div class="col-md-10"><textarea name="content[]" class="form_editor">{{ object.content }}</textarea></div>
                                                </div>
                                            </div>
                                        </div>
                                    {% endfor %}
                                {% endif %}

                            </div>
                            <div class="action_area text-center">
                                <button type="submit" name="actiontype" value="notify" class="btn btn-info">Submit</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </section>
        <!--tab nav start-->

    </div>
</div>

<script>
    jQuery(document).ready(function () {
        loadTinyMce('form_editor');
    });
</script>