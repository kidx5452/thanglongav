<script src="/js/chart-js/chart.js"></script>
<script src="/js/chart-js/Chart.HorizontalBar.js"></script>
<div>
    <h4>Presentation: {{ object['quarterobj'].name }}</h4>
    <div class="chartJS">
        <canvas id="presentation" height="240" width="100%"></canvas>
    </div>
    <table class="table tbl-data">
        <thead>
            <tr>
                <th></th>
                {% for item in object['listdata'] %}
                    <th>{{ item['name'] }} ({{ date("m-Y",item['datetest']) }})</th>
                {% endfor %}
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ labelkey['reportpupil.lbl_organization'] }}</td>
                {% for item in object['listdata'] %}
                    <td>
                        <input type="hidden" name="rpitem[]" value="1">
                        <input type="hidden" name="name[]" value="{{ item['name'] }}">
                        <input type="hidden" name="datetest[]" value="{{ item['datetest'] }}">
                        <input type="text" onkeyup="redraw(false)" name="organization[]" value="{{ item['organization'] }}" class="form-control" placeholder="">
                    </td>
                {% endfor %}
            </tr>
            <tr>
                <td>{{ labelkey['reportpupil.lbl_language_use'] }}</td>
                {% for item in object['listdata'] %}
                    <td>
                        <input type="text" onkeyup="redraw(false)" name="language_use[]" value="{{ item['language_use'] }}" class="form-control" placeholder="">
                    </td>
                {% endfor %}
            </tr>
            <tr>
                <td>{{ labelkey['reportpupil.lbl_pronunciation'] }}</td>
                {% for item in object['listdata'] %}
                    <td>
                        <input type="text" onkeyup="redraw(false)" name="pronunciation[]" value="{{ item['pronunciation'] }}" class="form-control" placeholder="">
                    </td>
                {% endfor %}
            </tr>
            <tr>
                <td>{{ labelkey['reportpupil.lbl_interaction'] }}</td>
                {% for item in object['listdata'] %}
                    <td>
                        <input type="text" onkeyup="redraw(false)" name="interaction[]" value="{{ item['interaction'] }}" class="form-control" placeholder="">
                    </td>
                {% endfor %}
            </tr>
            <tr>
                <td>{{ labelkey['reportpupil.lbl_voice'] }}</td>
                {% for item in object['listdata'] %}
                    <td>
                        <input type="text" onkeyup="redraw(false)" name="voice[]" value="{{ item['voice'] }}" class="form-control" placeholder="">
                    </td>
                {% endfor %}
            </tr>
            <tr>
                <td>{{ labelkey['reportpupil.lbl_body_language'] }}</td>
                {% for item in object['listdata'] %}
                    <td>
                        <input type="text" onkeyup="redraw(false)" name="body_language[]" value="{{ item['body_language'] }}" class="form-control" placeholder="">
                    </td>
                {% endfor %}
            </tr>
            <tr>
                <td>{{ labelkey['reportpupil.lbl_visual_aids'] }}</td>
                {% for item in object['listdata'] %}
                    <td>
                        <input type="text" onkeyup="redraw(false)" name="visual_aids[]" value="{{ item['visual_aids'] }}" class="form-control" placeholder="">
                    </td>
                {% endfor %}
            </tr>
        </tbody>
    </table>
    <div class="form-group">
        <label class="col-md-2" style="padding-left: 23px;">Đánh giá</label>
        <div class="col-md-10">
            <textarea class="form_editor" id="summernote" name="content">{{ object['quarterobj'].presentation_note }}</textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="action_area clearfix col-md-10 col-md-offset-2">
            <button type="submit" name="action" value="presentation" class="btn btn-info">Save</button>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function () {
        loadTinyMce('form_editor');
    });``
</script>

<script>
    (function () {
        var t;
        function size(animate) {
            if (animate == undefined) {
                animate = false;
            }
            clearTimeout(t);
            t = setTimeout(function () {
                $("canvas").each(function (i, el) {
                    $(el).attr({
                        "width": $(el).parent().width(),
                        "height": $(el).parent().outerHeight()
                    });
                });
                redraw(animate);
                var m = 0;
                $(".chartJS").height("");
                $(".chartJS").each(function (i, el) {
                    m = Math.max(m, $(el).height());
                });
                $(".chartJS").height(m);
            }, 30);
        }

        $(window).on('resize', function () {
            size(false);
        });
        size(false);
    }());
    function redraw(animation) {
        var list_tr = $('.tbl-data').children('tbody').children('tr');
        var tr_0 = list_tr[0];
        var tr_1 = list_tr[1];
        var tr_2 = list_tr[2];
        var tr_3 = list_tr[3];
        var tr_4 = list_tr[4];
        var tr_5 = list_tr[5];
        var tr_6 = list_tr[6];
        var length_test = $(tr_0).children('td').length - 1;
        var listdata = [];
        for (var i = 1; i <= length_test; i++) {
            var object_data = {
                fillColor: getRandomColor(),
                data: [get_input_from_td_by_tr(tr_6,i), get_input_from_td_by_tr(tr_5,i), get_input_from_td_by_tr(tr_4,i), get_input_from_td_by_tr(tr_3,i),get_input_from_td_by_tr(tr_2,i),get_input_from_td_by_tr(tr_1,i),get_input_from_td_by_tr(tr_0,i)]
            }
            listdata.push(object_data);
        }
        var presentationdata = {
            labels: ["{{ labelkey['reportpupil.lbl_visual_aids'] }}", "{{ labelkey['reportpupil.lbl_body_language'] }}", "{{ labelkey['reportpupil.lbl_voice'] }}", "{{ labelkey['reportpupil.lbl_interaction'] }}", "{{ labelkey['reportpupil.lbl_pronunciation'] }}", "{{ labelkey['reportpupil.lbl_language_use'] }}", "{{ labelkey['reportpupil.lbl_organization'] }}"],
            datasets: listdata
        }
        var presentation_Chart = new Chart(document.getElementById("presentation").getContext("2d")).HorizontalBar(presentationdata, {isFixedWidth:true,animation:false,
            barWidth:20});
    }

    function get_input_from_td_by_tr(tr, index_td) {
        var td = $(tr).children('td');
        return $(td[index_td]).children("input[type='text']").first().val();
    }
    function getRandomColor() {
        var letters = '0123456789ABCDEF'.split('');
        var color = '#';
        for (var i = 0; i < 6; i++ ) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }
</script>