<script src="/js/chart-js/chart.js"></script>
<script src="/js/chart-js/Chart.HorizontalBar.js"></script>
<div>
    <h4>Attitude: {{ object['quarterobj'].name }}</h4>
    <div class="chartJS">
        <canvas id="attitude" height="240" width="100%"></canvas>
    </div>
    <table class="table tbl-data">
        <thead>
        <tr>
            <th></th>
            {% for item in object['listdata'] %}
                <th>{{ item['name'] }}</th>
            {% endfor %}
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ labelkey['reportpupil.lbl_attendance'] }}</td>
            {% for item in object['listdata'] %}
                <td>
                    <input type="hidden" name="rpitem[]" value="1">
                    <input type="hidden" name="name[]" value="{{ item['name'] }}">
                    <input type="hidden" name="datetest[]" value="{{ item['datetest'] }}">
                    <input type="text" onkeyup="redraw(false)" name="attendance[]" value="{{ item['attendance'] }}" class="form-control" placeholder=""></td>
            {% endfor %}
        </tr>
        <tr>
            <td>{{ labelkey['reportpupil.lbl_participation'] }}</td>
            {% for item in object['listdata'] %}
                <td><input type="text" onkeyup="redraw(false)" name="participation[]" value="{{ item['participation'] }}" class="form-control" placeholder=""></td>
            {% endfor %}
        </tr>
        <tr>
            <td>{{ labelkey['reportpupil.lbl_behavior'] }}</td>
            {% for item in object['listdata'] %}
                <td><input type="text" onkeyup="redraw(false)" name="behavior[]" value="{{ item['behavior'] }}" class="form-control" placeholder=""></td>
            {% endfor %}
        </tr>
        <tr>
            <td>{{ labelkey['reportpupil.lbl_diligence'] }}</td>
            {% for item in object['listdata'] %}
                <td><input type="text" onkeyup="redraw(false)" name="diligence[]" value="{{ item['diligence'] }}" class="form-control" placeholder=""></td>
            {% endfor %}
        </tr>
        </tbody>
    </table>
    <div class="form-group">
        <label class="col-md-2" style="padding-left: 23px;">Đánh giá</label>
        <div class="col-md-10">
            <textarea class="form_editor" id="summernote" name="content">{{ object['quarterobj'].attitude_note }}</textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="action_area clearfix col-md-10 col-md-offset-2">
            <button type="submit" name="action" value="attitude" class="btn btn-info">Save</button>
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
        var data1 = [],data2 = [],data3 = [],data4 = [],listdata = [];
        for (var i = 1; i <= length_test; i++) {
            data1.push(parseFloat(get_input_from_td_by_tr(tr_0,i)));
            data2.push(parseFloat(get_input_from_td_by_tr(tr_1,i)));
            data3.push(parseFloat(get_input_from_td_by_tr(tr_2,i)));
            data4.push(parseFloat(get_input_from_td_by_tr(tr_3,i)));
        }

        var attitudedata = {
            labels: [
                {% for item in object['listdata'] %}
                "{{ item['name'] }}",
                {% endfor %}
            ],
            datasets: [
                {
                    label: "{{ labelkey['reportpupil.lbl_attendance'] }}",
                    fillColor: "transparent",
                    strokeColor: "#ff81af",
                    pointColor: "#ff81af",
                    pointStrokeColor: "#ff81af",
                    data: data1
                },
                {
                    label: "{{ labelkey['reportpupil.lbl_participation'] }}",
                    fillColor: "transparent",
                    strokeColor: "#93d5a6",
                    pointColor: "#93d5a6",
                    pointStrokeColor: "#93d5a6",
                    data: data2
                },
                {
                    label: "{{ labelkey['reportpupil.lbl_behavior'] }}",
                    fillColor: "transparent",
                    strokeColor: "#5c9ddc",
                    pointColor: "#5c9ddc",
                    pointStrokeColor: "#5c9ddc",
                    data: data3
                },
                {
                    label: "{{ labelkey['reportpupil.lbl_diligence'] }}",
                    fillColor: "transparent",
                    strokeColor: "#ffb77c",
                    pointColor: "#ffb77c",
                    pointStrokeColor: "#ffb77c",
                    data: data4
                }
            ]
        }
        var attitude_Chart = new Chart(document.getElementById("attitude").getContext("2d")).Line(attitudedata,{animation:false});
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