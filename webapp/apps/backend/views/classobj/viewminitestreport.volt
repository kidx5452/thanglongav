<div class="row">
    <div class="col-sm-12">
        <a href="{{ _GET['backurl'] }}" class="btn btn-sm btn-success addon-btn m-b-10"><i
                    class="zmdi zmdi-arrow-left"></i> {{ labelkey['general.lbl_back'] }}</a>
        <section class="panel">
            <header class="panel-heading head-border">
                {{ labelkey['reportpupil.lbl_minitest']~' '~labelkey['classobj.lbl_form']~' '~classobj.name~' <b>('~date('d-m-Y',_GET['datetest'])~')</b>'}}
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
                                        <label class="col-md-3 control-label">{{ labelkey['reportpupil.lbl_point'] }}</label>
                                        <div class="col-md-9"><input type="text" value="{{ item.point }}" name="point[{{ item.id }}]" class="form-control" placeholder="{{ labelkey['reportpupil.lbl_point'] }}" required></div>
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
                        <button type="submit" name="actiontype" value="attitude" class="btn btn-info">Submit</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>