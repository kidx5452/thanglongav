<script src="/js/chart-js/chart.js"></script>
<script src="/js/chart-js/Chart.HorizontalBar.js"></script>
<div>
    <h4>Oraltest: {{ object['quarterobj'].name }}</h4>
    <div class="chartJS">
        <canvas id="oraltest" height="240" width="100%"></canvas>
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
                <td>{{ labelkey['reportpupil.lbl_pronunciation'] }}</td>
                {% for item in object['listdata'] %}
                    <td class="val">
                        <input type="hidden" name="rpitem[]" value="1">
                        <input type="hidden" name="name[]" value="{{ item['name'] }}">
                        <input type="hidden" name="datetest[]" value="{{ item['datetest'] }}">
                        <input type="text" onkeyup="redraw(false)" name="pronunciation[]" value="{{ item['pronunciation'] }}" class="form-control col-sm-1" placeholder="{{ labelkey['reportpupil.lbl_pronunciation'] }}">
                        <input type="text" name="note_pronunciation[]" value="{{ item['note_pronunciation'] }}" class="form-control" placeholder="Note">
                    </td>
                {% endfor %}
            </tr>
            <tr>
                <td>{{ labelkey['reportpupil.lbl_vocabular'] }}</td>
                {% for item in object['listdata'] %}
                    <td class="val">
                        <input type="text" onkeyup="redraw(false)" name="vocabular[]" value="{{ item['vocabular'] }}" class="form-control col-sm-1" placeholder="{{ labelkey['reportpupil.lbl_vocabular'] }}">
                        <input type="text" name="note_vocabular[]" value="{{ item['note_vocabulary'] }}" class="form-control" placeholder="Note">
                    </td>
                {% endfor %}
            </tr>
            <tr>
                <td>{{ labelkey['reportpupil.lbl_grammar'] }}</td>
                {% for item in object['listdata'] %}
                    <td class="val">
                        <input type="text" onkeyup="redraw(false)" name="grammar[]" value="{{ item['grammar'] }}" class="form-control col-sm-1" placeholder="{{ labelkey['reportpupil.lbl_grammar'] }}">
                        <input type="text" name="note_grammar[]" value="{{ item['note_grammar'] }}" class="form-control" placeholder="Note">
                    </td>
                {% endfor %}
            </tr>
            <tr>
                <td>{{ labelkey['reportpupil.lbl_fluency'] }}</td>
                {% for item in object['listdata'] %}
                    <td class="val">
                        <input type="text" onkeyup="redraw(false)" name="fluency[]" value="{{ item['fluency'] }}" class="form-control col-sm-1" placeholder="{{ labelkey['reportpupil.lbl_fluency'] }}">
                        <input type="text" onkeyup="redraw(false)" name="note_fluency[]" value="{{ item['note_fluency'] }}" class="form-control" placeholder="Note">
                    </td>
                {% endfor %}
            </tr>
            <tr>
                <td>{{ labelkey['reportpupil.lbl_comprehension'] }}</td>
                {% for item in object['listdata'] %}
                    <td class="val">
                        <input type="text" onkeyup="redraw(false)" name="comprehension[]" value="{{ item['comprehension'] }}" class="form-control col-sm-1" placeholder="{{ labelkey['reportpupil.lbl_comprehension'] }}">
                        <input type="text" name="note_comprehension[]" value="{{ item['note_comprehension'] }}" class="form-control" placeholder="Note">
                    </td>
                {% endfor %}
            </tr>
        </tbody>
    </table>
    <div class="form-group">
        <label class="col-md-2" style="padding-left: 23px;">Đánh giá</label>
        <div class="col-md-10">
            <textarea class="form_editor" id="summernote" name="content">{{ object['quarterobj'].oraltest_note }}</textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="action_area clearfix col-md-10 col-md-offset-2">
            <button type="submit" name="action" value="oraltest" class="btn btn-info">Save</button>
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
        var tr_4 = list_tr[4];
        var length_test = $(tr_0).find('.val').length;
        var listdata = [];
        for (var i = 1; i <= length_test; i++) {
            var object_data = {
                fillColor: getRandomColor(),
                data: [get_input_from_td_by_tr(tr_4,i), get_input_from_td_by_tr(tr_3,i), get_input_from_td_by_tr(tr_2,i), get_input_from_td_by_tr(tr_1,i),get_input_from_td_by_tr(tr_0,i)]
            }
            listdata.push(object_data);
        }
        var oraltestdata = {
            labels: ["{{ labelkey['reportpupil.lbl_comprehension'] }}", "{{ labelkey['reportpupil.lbl_fluency'] }}", "{{ labelkey['reportpupil.lbl_grammar'] }}", "{{ labelkey['reportpupil.lbl_vocabular'] }}", "{{ labelkey['reportpupil.lbl_pronunciation'] }}"],
            datasets: listdata
        }
        var oraltest_Chart = new Chart(document.getElementById("oraltest").getContext("2d")).HorizontalBar(oraltestdata,{isFixedWidth:true,animation:false,barWidth:15});
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