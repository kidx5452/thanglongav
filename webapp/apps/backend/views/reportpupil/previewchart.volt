<style>.pupil-evualation{margin-top:30px;}</style>

<div class="row">
    <div class="col-md-12">
        <a href="{{ backurl }}" class="btn btn-sm btn-success addon-btn m-b-10"><i class="zmdi zmdi-arrow-left"></i> {{ labelkey['general.lbl_back'] }}</a>
        <section class="panel">
            <header class="panel-heading">
                <b>1. {{ labelkey['reportpupil.lbl_skilltest'] }}</b>
            </header>
            <div class="panel-body">
                <div class="chartJS">
                    <canvas id="skilltest" height="240" width="100%"></canvas>
                </div>
                <div class="clearfix">
                    {% for item in skilltestdata %}
                        <div class="col-md-3">
                            <div class="col-md-1" style="width: 20px;height: 20px;background-color: {{ item['color'] }};"></div>
                            <div class="col-md-11">{{ item['name'] }}</div>
                        </div>
                    {% endfor %}
                </div>
                <div class="clearfix pupil-evualation well">
                    <p><b>{{ labelkey['reportpupil.lbl_evualation'] }}</b></p>
                    {{ object.skilltest_comment }}
                </div>
            </div>
        </section>
        <section class="panel">
            <header class="panel-heading">
                <b>2. {{ labelkey['reportpupil.lbl_oraltest'] }}</b>
            </header>
            <div class="panel-body">
                <div class="chartJS">
                    <canvas id="oraltest" height="240" width="100%"></canvas>
                </div>
                <div class="clearfix">
                    {% for item in oraltestdata %}
                        <div class="col-md-3">
                            <div class="col-md-1" style="width: 20px;height: 20px;background-color: {{ item['color'] }};"></div>
                            <div class="col-md-11">{{ item['name'] }}</div>
                        </div>

                    {% endfor %}
                </div>
                <div class="clearfix pupil-evualation well">
                    <p><b>{{ labelkey['reportpupil.lbl_evualation'] }}</b></p>
                    {{ object.oraltest_comment }}
                </div>
            </div>
        </section>
        <section class="panel">
            <header class="panel-heading">
                <b>3. {{ labelkey['reportpupil.lbl_attitude'] }}</b>
            </header>
            <div class="panel-body">
                <div class="chartJS">
                    <canvas id="attitude" height="240" width="100%"></canvas>
                </div>
                <div class="clearfix">
                    <div class="col-md-3">
                        <div class="col-md-1" style="width: 20px;height: 20px;background-color: #ff81af;"></div>
                        <div class="col-md-11">{{ labelkey['reportpupil.lbl_attendance'] }}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="col-md-1" style="width: 20px;height: 20px;background-color: #93d5a6;"></div>
                        <div class="col-md-11">{{ labelkey['reportpupil.lbl_participation'] }}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="col-md-1" style="width: 20px;height: 20px;background-color: #5c9ddc;"></div>
                        <div class="col-md-11">{{ labelkey['reportpupil.lbl_behavior'] }}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="col-md-1" style="width: 20px;height: 20px;background-color: #ffb77c;"></div>
                        <div class="col-md-11">{{ labelkey['reportpupil.lbl_diligence'] }}</div>
                    </div>
                </div>
                <div class="clearfix pupil-evualation well">
                    <p><b>{{ labelkey['reportpupil.lbl_evualation'] }}</b></p>
                    {{ object.attitude_comment }}
                </div>
            </div>
        </section>
        <section class="panel">
            <header class="panel-heading">
                <b>4. {{ labelkey['reportpupil.lbl_presentation'] }}</b>
            </header>
            <div class="panel-body">
                <div class="text-center"><b>Average Chart</b></div>
                <div class="chartJS">
                    <canvas id="average" height="240" width="100%"></canvas>
                </div>
                <div class="chartJS">
                    <canvas id="presentation" height="280" width="100%"></canvas>
                </div>
                <div class="clearfix">
                    {% for item in presentationdata %}
                        <div class="col-md-3">
                            <div class="col-md-1" style="width: 20px;height: 20px;background-color: {{ item['color'] }};"></div>
                            <div class="col-md-11">{{ item['name'] }}</div>
                        </div>
                    {% endfor %}
                </div>
                <div class="clearfix pupil-evualation well">
                    <p><b>{{ labelkey['reportpupil.lbl_evualation'] }}</b></p>
                    {{ object.presentation_comment }}
                </div>
            </div>
        </section>
        <section class="panel">
            <header class="panel-heading">
                <b>5. {{ labelkey['reportpupil.lbl_minitest'] }}</b>
            </header>
            <div class="panel-body">
                <div class="chartJS">
                    <canvas id="minitest" height="240" width="100%"></canvas>
                </div>
                <div class="clearfix pupil-evualation well">
                    <p><b>{{ labelkey['reportpupil.lbl_evualation'] }}</b></p>
                    {{ object.minitest_comment }}
                </div>
            </div>
        </section>
    </div>


</div>

<!--Chart JS-->
<script src="/js/chart-js/chart.js"></script>
<script src="/js/chart-js/Chart.HorizontalBar.js"></script>
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
        function redraw(animation) {

            var barChartData = {
                labels: ["{{ labelkey['reportpupil.lbl_reading'] }}", "{{ labelkey['reportpupil.lbl_listening'] }}", "{{ labelkey['reportpupil.lbl_writing'] }}", "{{ labelkey['reportpupil.lbl_grammar'] }}"],
                datasets: [
                    {% for item in skilltestdata %}
                    {
                        fillColor: "{{ item['color'] }}",
                        strokeColor: "{{ item['color'] }}",
                        data: [{{ item['reading'] }}, {{ item['listening'] }}, {{ item['writing'] }}, {{ item['grammar'] }}]
                    },
                    {% endfor %}
                ]

            }
            var skilltest_Chart = new Chart(document.getElementById("skilltest").getContext("2d")).Bar(barChartData,{isFixedWidth:true,animation:false,barWidth:40,
                onAnimationComplete: function () {
                    var ctx = this.chart.ctx;
                    ctx.font = this.scale.font;
                    ctx.fillStyle = this.scale.textColor;
                    ctx.textAlign = "right";
                    ctx.textBaseline = "right";

                }
            });

            var oraltestdata = {
                labels: ["{{ labelkey['reportpupil.lbl_comprehension'] }}", "{{ labelkey['reportpupil.lbl_fluency'] }}", "{{ labelkey['reportpupil.lbl_grammar'] }}", "{{ labelkey['reportpupil.lbl_vocabular'] }}", "{{ labelkey['reportpupil.lbl_pronunciation'] }}"],
                datasets: [
                    {% for item in oraltestdata %}
                    {
                        fillColor: "{{ item['color'] }}",
                        strokeColor: "{{ item['color'] }}",
                        data: [{{ item['comprehension'] }}, {{ item['fluency'] }}, {{ item['grammar'] }}, {{ item['vocabular'] }}, {{ item['pronunciation'] }}]
                    },
                    {% endfor %}
                ]

            }
            var oraltest_Chart = new Chart(document.getElementById("oraltest").getContext("2d")).HorizontalBar(oraltestdata,{isFixedWidth:true,animation:false,barWidth:15});

            var attitudedata = {
                labels: [
                    {% for item in attitudedata %}
                    "{{ item['month'] }}",
                    {% endfor %}
                ],
                datasets: [
                    {
                        label: "{{ labelkey['reportpupil.lbl_attendance'] }}",
                        fillColor: "transparent",
                        strokeColor: "#ff81af",
                        pointColor: "#ff81af",
                        pointStrokeColor: "#ff81af",
                        data: [
                            {% for item in attitudedata %}
                            {{ item['attendance'] }},
                            {% endfor %}
                        ]
                    },
                    {
                        label: "{{ labelkey['reportpupil.lbl_participation'] }}",
                        fillColor: "transparent",
                        strokeColor: "#93d5a6",
                        pointColor: "#93d5a6",
                        pointStrokeColor: "#93d5a6",
                        data: [
                            {% for item in attitudedata %}
                            {{ item['participation'] }},
                            {% endfor %}
                        ]
                    },
                    {
                        label: "{{ labelkey['reportpupil.lbl_behavior'] }}",
                        fillColor: "transparent",
                        strokeColor: "#5c9ddc",
                        pointColor: "#5c9ddc",
                        pointStrokeColor: "#5c9ddc",
                        data: [
                            {% for item in attitudedata %}
                            {{ item['behavior'] }},
                            {% endfor %}
                        ]
                    },
                    {
                        label: "{{ labelkey['reportpupil.lbl_diligence'] }}",
                        fillColor: "transparent",
                        strokeColor: "#ffb77c",
                        pointColor: "#ffb77c",
                        pointStrokeColor: "#ffb77c",
                        data: [
                            {% for item in attitudedata %}
                            {{ item['diligence'] }},
                            {% endfor %}
                        ]
                    }
                ]
            }
            var attitude_Chart = new Chart(document.getElementById("attitude").getContext("2d")).Line(attitudedata,{animation:false});

            var averagedata = {
                labels: [
                    {% for item in presentationdata %}
                    "{{ item['name'] }}",
                    {% endfor %}
                ],
                datasets: [
                    {
                        fillColor: "{{ item['color'] }}",
                        strokeColor: "{{ item['color'] }}",
                        data: [
                            {% for item in presentationdata %}
                            "{{ item['average'] }}",
                            {% endfor %}
                        ]
                    }
                ]

            }
            var average_Chart = new Chart(document.getElementById("average").getContext("2d")).Bar(averagedata,{isFixedWidth:true,animation:false,
                barWidth:50});
            var presentdata = {
                labels: ["{{ labelkey['reportpupil.lbl_visual_aids'] }}", "{{ labelkey['reportpupil.lbl_body_language'] }}", "{{ labelkey['reportpupil.lbl_voice'] }}", "{{ labelkey['reportpupil.lbl_interaction'] }}", "{{ labelkey['reportpupil.lbl_pronunciation'] }}",
                    "{{ labelkey['reportpupil.lbl_language_use'] }}", "{{ labelkey['reportpupil.lbl_organization'] }}"
                ],
                datasets: [
                    {% for item in presentationdata %}
                    {
                        fillColor: "{{ item['color'] }}",
                        strokeColor: "{{ item['color'] }}",
                        data: [{{ item['visual_aids'] }}, {{ item['body_language'] }}, {{ item['voice'] }}, {{ item['interaction'] }}, {{ item['pronunciation'] }}, {{ item['language_use'] }}, {{ item['organization'] }}]
                    },
                    {% endfor %}
                ]

            }
            var presentation_Chart = new Chart(document.getElementById("presentation").getContext("2d")).HorizontalBar(presentdata, {isFixedWidth:true,animation:false,
                barWidth:20});


            var minitestdata = {
                labels: [
                    {% for item in minitestdata %}
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
                        data: [
                            {% for item in minitestdata %}
                            {{ item['point'] }},
                            {% endfor %}
                        ]
                    }
                ]
            }
            var minitest_Chart = new Chart(document.getElementById("minitest").getContext("2d")).Line(minitestdata,{animation:false});

        }

        size(false);

    }());
</script>

