<div class="row">
    <div class="col-lg-12">
        <a href="{{ backurl }}" class="btn btn-sm btn-success addon-btn m-b-10"><i
                    class="zmdi zmdi-arrow-left"></i> {{ labelkey['general.lbl_back'] }}</a>
        <form action="" method="post" enctype="multipart/form-data">
            <!--tab nav start-->
            <section class="isolate-tabs">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#home-iso">{{ labelkey['rolegroup.lbl_roleinfo'] }}</a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#about-iso">{{ labelkey['rolegroup.lbl_perlist'] }}</a>
                    </li>
                </ul>
                <div class="panel-body">
                    <div class="tab-content">
                        <div id="home-iso" class="tab-pane active">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>{{ labelkey['rolegroup.lbl_name'] }}</label>
                                    <input type="text" name="name" value="{{ object.name }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>{{ labelkey['rolegroup.lbl_level'] }}</label>
                                    <input type="text" name="level" value="{{ object.level }}" class="form-control">
                                </div>
                            </div>

                        </div>
                        <div id="about-iso" class="tab-pane">
                            <ul>
                                {% for key,item in module %}
                                    <li class="p-5 col-sm-3">
                                        <label style="font-weight: bold;">
                                            <input type="checkbox" value="{{ key }}"
                                                   class="catitem" {{ item['checked'] }} name="permissions[]">
                                            <i class="input-helper"></i>
                                            {{ item['name'] }}
                                        </label>&nbsp;&nbsp;<span style="font-weight: normal;font-size: 11px"><a
                                                    href="javascript:void(0)" onclick="recheck(this)">Check
                                                all</a></span>
                                        <ul class="p-l-25">
                                            {% if item['child'] is defined %}
                                                {% for value in item['child'] %}
                                                    <li class="p-5">
                                                        <label style="">
                                                            <input type="checkbox"
                                                                   value="{{ key }}_{{ value['key'] }}" {{ value['checked'] }}
                                                                   class="catitem" name="permissions[]">
                                                            <i class="input-helper"></i>
                                                            {{ value['name'] }}
                                                        </label>
                                                    </li>
                                                {% endfor %}
                                            {% endif %}
                                        </ul>
                                        {% endfor %}
                                    </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
            <!--tab nav start-->

            <div class="action_area">
                <button type="submit" class="btn btn-info">Submit</button>
            </div>
        </form>
    </div>
</div>
<script>
    function recheck(obj) {
        var checked = $(obj).attr('data-checked');
        if (checked == undefined) checked = 0;
        if (checked == 0) {
            $(obj).parent().next().find('.catitem').attr('checked', 'checked');
            $(obj).attr('data-checked', 1);
        }
        else {
            $(obj).parent().next().find('.catitem').removeAttr('checked');
            $(obj).attr('data-checked', 0);
        }

    }
</script>