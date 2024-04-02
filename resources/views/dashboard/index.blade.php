@extends('layouts.main')
@section('title', 'Dashboard')
@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">@yield('title')</li>
                        </ol>
                    </div>
                    <h4 class="page-title">@yield('title')</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card widget-inline">
                    <div class="card-body p-0">
                        <div class="row g-0">
                            <div class="col-sm-6 col-xl-6">
                                <div class="card shadow-none m-0">
                                    <div class="card-body text-center">
                                        <i class="uil-arrow-to-bottom text-muted" style="font-size: 24px;"></i>
                                        <h3><span>{{ 'Rp. ' . number_format($totalIncome, 0, ',', '.') }}</span></h3>
                                        <p class="text-muted font-15 mb-0">Incomes</p>
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-6 col-xl-6">
                                <div class="card shadow-none m-0 border-start">
                                    <div class="card-body text-center">
                                        <i class="uil-top-arrow-to-top text-muted" style="font-size: 24px;"></i>
                                        <h3><span>{{ 'Rp. ' . number_format($totalSpending, 0, ',', '.') }}</span>
                                        </h3>
                                        <p class="text-muted font-15 mb-0">Spendings</p>
                                    </div>
                                </div>
                            </div>

                        </div> <!-- end row -->
                    </div>
                </div> <!-- end card-box-->
            </div> <!-- end col-->
        </div>
        <!-- end row-->

        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Pie Chart</h4>
                        <div dir="ltr">
                            <div id="simple-pie" class="apex-charts" data-colors="#727cf5,#6c757d,#0acf97,#fa5c7c,#e3eaef">
                            </div>
                        </div>
                    </div>
                    <!-- end card body-->
                </div>
                <!-- end card -->
            </div>
            <!-- end col-->

            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-4">Line Chart</h4>

                        <div dir="ltr">
                            <div class="mt-3 chartjs-chart" style="height: 260px;">
                                <canvas id="line-chart-example" data-colors="#727cf5,#0acf97"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- end card body-->
                </div>
                <!-- end card -->
            </div>
            <!-- end col-->
        </div>
        <!-- end row-->
    </div>

    <!-- third party:js -->
    <script src="assets/js/vendor/apexcharts.min.js"></script>
    <!-- third party end -->

    <!-- third party js -->
    <script src="assets/js/vendor/Chart.bundle.min.js"></script>
    <!-- third party js ends -->

    <!-- demo app -->
    <script>
        (function(d) {
            "use strict";

            function hexToRGB(a, r) {
                var t = parseInt(a.slice(1, 3), 16),
                    e = parseInt(a.slice(3, 5), 16),
                    o = parseInt(a.slice(5, 7), 16);
                return r ? "rgba(" + t + ", " + e + ", " + o + ", " + r + ")" : "rgb(" + t + ", " + e + ", " + o + ")"
            }

            function respChart(r, t, e, o) {
                var n = Chart.controllers.line.prototype.draw;
                Chart.controllers.line.prototype.draw = function() {
                    n.apply(this, arguments);
                    var a = this.chart.chart.ctx,
                        r = a.stroke;
                    a.stroke = function() {
                        a.save(), a.shadowColor = "rgba(0,0,0,0.01)", a.shadowBlur = 20, a.shadowOffsetX = 0, a
                            .shadowOffsetY = 5, r.apply(this, arguments), a.restore()
                    }
                };
                var i = r.get(0).getContext("2d"),
                    c = d(r).parent();
                return function() {
                    var a;
                    switch (r.attr("width", d(c).width()), t) {
                        case "Line":
                            a = new Chart(i, {
                                type: "line",
                                data: e,
                                options: o
                            });
                            break;
                    }
                    return a
                }()
            }

            function initCharts() {
                var chartData = {!! $chartDataJSON !!};
                var charts = [];
                if (0 < d("#line-chart-example").length) {
                    var l = [];
                    l.push(respChart(d("#line-chart-example"), "Line", chartData, {
                        maintainAspectRatio: !1,
                        legend: {
                            display: !1
                        },
                        tooltips: {
                            intersect: !1
                        },
                        hover: {
                            intersect: !0
                        },
                        plugins: {
                            filler: {
                                propagate: !1
                            }
                        },
                        scales: {
                            xAxes: [{
                                reverse: !0,
                                gridLines: {
                                    color: "rgba(0,0,0,0.05)"
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    stepSize: 20
                                },
                                display: !0,
                                borderDash: [5, 5],
                                gridLines: {
                                    color: "rgba(0,0,0,0)",
                                    fontColor: "#fff"
                                }
                            }]
                        }
                    }));
                }
                return l;
            }

            function init() {
                Chart.defaults.global.defaultFontFamily =
                    '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif';
                var charts = initCharts();
                d(window).on("resize", function(a) {
                    d.each(charts, function(a, r) {
                        try {
                            r.destroy()
                        } catch (a) {}
                    }), charts = initCharts()
                })
            }

            d.ChartJs = {
                init: init
            };
            d.ChartJs.Constructor = init;
        })(window.jQuery);

        (function() {
            "use strict";
            window.jQuery.ChartJs.init();
        })();
    </script>
    <!-- end demo js-->

    <!-- demo:js -->
    <script>
        dataColors = $("#simple-pie").data("colors");
        dataColors && (colors = dataColors.split(","));
        var options = {
                chart: {
                    height: 320,
                    type: "pie"
                },
                series: [{{ $totalIncome }}, {{ $totalSpending }}],
                labels: ["Incomes", "Spendings"],
                colors: colors,
                legend: {
                    show: !0,
                    position: "bottom",
                    horizontalAlign: "center",
                    verticalAlign: "middle",
                    floating: !1,
                    fontSize: "14px",
                    offsetX: 0,
                    offsetY: 7
                },
                responsive: [{
                    breakpoint: 600,
                    options: {
                        chart: {
                            height: 240
                        },
                        legend: {
                            show: !1
                        }
                    }
                }]
            },
            chart = new ApexCharts(document.querySelector("#simple-pie"), options);
        chart.render();
    </script>
    <!-- demo end -->
@endsection
