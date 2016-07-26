<div class="row">
    <div class="col-md-12">
        <a href="{{ backurl }}">{{ labelkey['general.lbl_back'] }}</a>
        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
            <section class="panel">
                <header class="panel-heading">
                    Select Role Group For <strong class="text-danger">{{ userinfo.username }}</strong>
                </header>
                <div class="panel-body">
                    <div class="clearfix">
                        {% for item in listrole %}
                            <label class="checkbox-custom checkbox-success">
                                <input {{ in_array(item.id,listrole_actived)?'checked':'' }} id="{{ item.id }}" type="checkbox" name="role[]" value="{{ item.id }}">
                                <label for="{{ item.id }}">{{ item.name }}</label>
                            </label>
                        {% endfor %}
                    </div>
                    <button type="submit" class="btn btn-info">Save</button>
                </div>
            </section>
        </form>
    </div>
</div>