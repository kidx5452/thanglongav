<script src="/js/chart-js/chart.js"></script>
<script src="/js/chart-js/Chart.HorizontalBar.js"></script>
<div>
    <h4>Minitest: {{ object['quarterobj'].name }}</h4>
    <div class="chartJS">
        <canvas id="minitest" height="240" width="100%"></canvas>
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
            <td>Điểm</td>
            {% for item in object['listdata'] %}
                <td>
                    <input type="hidden" name="rpitem[]" value="1">
                    <input type="hidden" name="name[]" value="{{ item['name'] }}">
                    <input type="hidden" name="datetest[]" value="{{ item['datetest'] }}">
                    <input type="text" onkeyup="redraw(false)" name="point[]" value="{{ item['point'] }}" class="form-control" placeholder=""></td>
            {% endfor %}
        </tr>
        </tbody>
    </table>
    <div class="form-group">
        <label class="col-md-2" style="padding-left: 23px;">Đánh giá</label>
        <div class="col-md-10">
            <textarea class="form_editor" id="summernote" name="content">{{ object['quarterobj'].minitest_note }}</textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="action_area clearfix col-md-10 col-md-offset-2">
            <button type="submit" name="action" value="minitest" class="btn btn-info">Save</button>
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
        var length_test = $(tr_0).children('td').length - 1;
        var data=[];
        for (var i = 1; i <= length_test; i++) {
            data.push(parseFloat(get_input_from_td_by_tr(tr_0,i)));
        }
        var minitestdata = {
            labels: [
                {% for item in object['listdata'] %}
                "{{ item['name'] }}",
                {% endfor %}
            ],
            datasets: [
                {
                    label: "{{ labelkey['reportpupil.lbl_minitest'] }}",
                    fillColor: "transparent",
                    strokeColor: "#ff81af",
                    pointColor: "#ff81af",
                    pointStrokeColor: "#ff81af",
                    data: data
                }
            ]
        }
        var minitest_Chart = new Chart(document.getElementById("minitest").getContext("2d")).Line(minitestdata,{animation:false});
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