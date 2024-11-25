<div class="row">
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h6 class="card-title">Payment Status</h6>
            </div>
            <div id="apexPie1"></div>
        </div>

    </div>
</div>
<div class="col-md-12 mt-2">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h3>This Month</h3>
                    <h3  class="mt-2">{{$thisMonth}}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h3>Previous Month</h3>
                    <h3 class="mt-2">{{$lastMonth}}</h3>
                </div>
            </div>
        </div>
    </div>
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
            cardBg: "#0c1427"
        }

        var fontFamily = "'Roboto', Helvetica, sans-serif"


        if ($('#apexPie1').length) {
            var options = {
                chart: {
                    height: 300,
                    type: "pie",
                    foreColor: colors.bodyColor,
                    background: colors.cardBg,
                    toolbar: {
                        show: false
                    },
                },
                theme: {
                    mode: 'dark'
                },
                tooltip: {
                    theme: 'dark'
                },
                colors: [colors.primary, colors.warning, colors.danger, colors.info],
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
                stroke: {
                    colors: ['rgba(0,0,0,0)']
                },
                dataLabels: {
                    enabled: false
                },
                series: [20, 45, 60, 55]
            };

            var chart = new ApexCharts(document.querySelector("#apexPie1"), options);
            chart.render();
        }
    });
</script>
