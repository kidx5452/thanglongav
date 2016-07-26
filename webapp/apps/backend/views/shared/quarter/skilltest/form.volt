<script src="/js/chart-js/chart.js"></script>
<script src="/js/chart-js/Chart.HorizontalBar.js"></script>
<div>
    <h4>Skilltest: {{ object['quarterobj'].name }}</h4>

    <div class="chartJS">
        <canvas id="skilltest" height="240" width="100%"></canvas>
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
            <td>{{ labelkey['reportpupil.lbl_reading'] }}</td>
            {% for item in object['listdata'] %}
                <td>
                    <input type="hidden" name="rpitem[]" value="1">
                    <input type="hidden" name="name[]" value="{{ item['name'] }}">
                    <input type="hidden" name="datetest[]" value="{{ item['datetest'] }}">
                    <input type="text" onkeyup="redraw(false)" name="reading[]" value="{{ item['reading'] }}" class="form-control" placeholder="{{ labelkey['reportpupil.lbl_reading'] }}"></td>
            {% endfor %}
        </tr>
        <tr>
            <td>{{ labelkey['reportpupil.lbl_listening'] }}</td>
            {% for item in object['listdata'] %}
                <td><input onkeyup="redraw(false)" type="text" name="listening[]" value="{{ item['listening'] }}" class="form-control" placeholder="{{ labelkey['reportpupil.lbl_listening'] }}"></td>
            {% endfor %}
        </tr>
        <tr>
            <td>{{ labelkey['reportpupil.lbl_writing'] }}</td>
            {% for item in object['listdata'] %}
                <td><input onkeyup="redraw(false)" type="text" name="writing[]" value="{{ item['writing'] }}" class="form-control" placeholder="{{ labelkey['reportpupil.lbl_writing'] }}"></td>
            {% endfor %}
        </tr>
        <tr>
            <td>{{ labelkey['reportpupil.lbl_grammar'] }}</td>
            {% for item in object['listdata'] %}
                <td><input onkeyup="redraw(false)" type="text" name="grammar[]" value="{{ item['grammar'] }}" class="form-control" placeholder="{{ labelkey['reportpupil.lbl_grammar'] }}"></td>
            {% endfor %}
        </tr>

        </tbody>
    </table>
    <div class="form-group">
        <label class="col-md-2" style="padding-left: 23px;">Đánh giá</label>

        <div class="col-md-10">
            <textarea class="form_editor" id="summernote" name="content">{{ object['quarterobj'].skilltest_note }}</textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="action_area clearfix col-md-10 col-md-offset-2">
            <button type="submit" name="action" value="skilltest" class="btn btn-info">Save</button>
        </div>
    </div>

</div>
<script>
    jQuery(document).ready(function () {
        loadTinyMce('form_editor');
    });
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
        var length_test = $(tr_0).children('td').length - 1;
        var listdata = [];
        for (var i = 1; i <= length_test; i++) {
            var object_data = {
                fillColor: "#1976D2",
                strokeColor: "#1976D2",
                data: [get_input_from_td_by_tr(tr_0,i), get_input_from_td_by_tr(tr_1,i), get_input_from_td_by_tr(tr_2,i), get_input_from_td_by_tr(tr_3,i)]
            }
            listdata.push(object_data);
        }
        var barChartData = {
            labels: ["{{ labelkey['reportpupil.lbl_reading'] }}", "{{ labelkey['reportpupil.lbl_listening'] }}", "{{ labelkey['reportpupil.lbl_writing'] }}", "{{ labelkey['reportpupil.lbl_grammar'] }}"],
            datasets: listdata

        }
        var skilltest_Chart = new Chart(document.getElementById("skilltest").getContext("2d")).Bar(barChartData, {
            isFixedWidth: true, animation: false, barWidth: 40,
            onAnimationComplete: function () {
                var ctx = this.chart.ctx;
                ctx.font = this.scale.font;
                ctx.fillStyle = this.scale.textColor;
                ctx.textAlign = "right";
                ctx.textBaseline = "right";

            }
        });
    }

    function get_input_from_td_by_tr(tr, index_td) {
        var td = $(tr).children('td');
        return $(td[index_td]).children("input[type='text']").first().val();
    }
</script>
