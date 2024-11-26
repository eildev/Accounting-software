<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h6 class="card-title">Money Flow</h6>
            <div class="d-flex justify-content-between">
                {{-- ///Expanse/// --}}
                <div>
                    <div class="form-group primary-color-text mb-2">
                        <select class="form-control primary-color-text" id="monthSelect2">
                            <option disabled selected class="bg-white" value="{{ Carbon\Carbon::now()->format('m') }}">
                                <p class="selected-option">Expanses</p>
                                <i class="fas fa-chevron-down"></i>
                            </option>
                            <option value="1" data-month="1">A</option>
                            <option value="1" data-month="1">B</option>
                            <option value="1" data-month="1">C</option>

                        </select>
                    </div>
                </div>
                {{-- ///Month /// --}}
                <div class="form-group primary-color-text mb-2">
                    <select class="form-control primary-color-text" id="monthSelect2">
                        <option disabled selected class="bg-white" value="{{ Carbon\Carbon::now()->format('m') }}">
                            <p class="selected-option">Month</p>
                            <i class="fas fa-chevron-down"></i>
                        </option>
                        <option value="1" data-month="1">January</option>
                        <option value="2" data-month="2">February</option>
                        <option value="3" data-month="3">March</option>
                        <option value="4" data-month="4">April</option>
                        <option value="5" data-month="5">May</option>
                        <option value="6" data-month="6">June</option>
                        <option value="7" data-month="7">July</option>
                        <option value="8" data-month="8">August</option>
                        <option value="9" data-month="9">September</option>
                        <option value="10" data-month="10">October</option>
                        <option value="11" data-month="11">November</option>
                        <option value="12" data-month="12">December</option>
                    </select>
                </div>

            </div>
        </div>
        <div id="apexArea"></div>
    </div>
</div>
<script>
    $(function() {
        'use strict';

        var colors = {
            primary: "#6571ff",
            secondary: "#7987a1",
            success: "#05a34a",
            info: "#66d1d1",
            warning: "#fbbc06",
            danger: "#ff3366",
            light: "#e9ecef",
            dark: "#060c17",
            muted: "#7987a1",
            gridBorder: "rgba(77, 138, 240, .15)",
            bodyColor: "#b8c3d9",
            cardBg: "#0c1427",
            gradient: "#0056FD"

        }

        var fontFamily = "'Roboto', Helvetica, sans-serif"
        if ($('#apexArea').length) {
            var options = {
                chart: {
                    type: "area",
                    height: 300,
                    parentHeightOffset: 0,
                    foreColor: colors.bodyColor,
                    background: colors.cardBg,
                    toolbar: {
                        show: false
                    },
                    stacked: true,
                },
                theme: {
                    mode: 'dark'
                },
                tooltip: {
                    theme: 'dark'
                },
                colors: [colors.gradient, colors.info],
                stroke: {
                    curve: "smooth",
                    width: 3
                },
                dataLabels: {
                    enabled: false
                },
                series: [{
                        name: 'Total Views',
                        data: generateDayWiseTimeSeries(0, 18)
                    },
                    //   {
                    //     name: 'Unique Views',
                    //     data: generateDayWiseTimeSeries(1, 18)
                    //   }
                ],
                // markers: {
                //   size: 5,
                //   strokeWidth: 3,
                //   hover: {
                //     size: 7
                //   }
                // },
                xaxis: {
                    type: "datetime",
                    axisBorder: {
                        color: colors.gridBorder,
                    },
                    axisTicks: {
                        color: colors.gridBorder,
                    },
                },
                yaxis: {
                    opposite: false,
                    title: {
                        text: "Views",
                        offsetX: -45,
                    },
                    labels: {
                        align: 'left',
                        offsetX: -10,
                    },
                    tickAmount: 4,
                    min: 0,
                    tooltip: {
                        enabled: true
                    }
                },
                grid: {
                    padding: {
                        bottom: -4
                    },
                    borderColor: colors.gridBorder,
                    xaxis: {
                        lines: {
                            show: true
                        }
                    }
                },
                tooltip: {
                    x: {
                        format: "dd MMM yyyy"
                    },
                },
                fill: {
                    type: 'solid',
                    opacity: [0.4, 0.25],
                },
                legend: {
                    show: true,
                    position: "top",
                    horizontalAlign: 'center',
                    fontFamily: fontFamily,
                    itemMargin: {
                        horizontal: 8,
                        vertical: 0
                    },
                },
            };

            var chart = new ApexCharts(document.querySelector("#apexArea"), options);
            chart.render();

            function generateDayWiseTimeSeries(s, count) {
                var values = [
                    [4, 3, 10, 9, 29, 19, 25, 9, 12, 7, 19, 5, 13, 9, 17, 2, 7, 5],
                    [2, 3, 8, 7, 22, 16, 23, 7, 11, 5, 12, 5, 10, 4, 15, 2, 6, 2]
                ];
                var i = 0;
                var series = [];
                var x = new Date("11 Nov 2012").getTime();
                while (i < count) {
                    series.push([x, values[s][i]]);
                    x += 86400000;
                    i++;
                }
                return series;
            }
        }
    });
</script>
