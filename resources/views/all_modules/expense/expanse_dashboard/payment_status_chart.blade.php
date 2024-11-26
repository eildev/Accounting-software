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
    {{-- ///////////////////////////////////This Mont and Previous Month Comparison ///////////////////////////////// --}}
    <div class="col-md-12 mt-2">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4>
                            @if ($thisMonth > $lastMonth)
                                <span><img src="{{ asset('uploads/expense/increase.png') }}" height="15px"
                                        alt=""></span>
                            @else
                                <span><img src="{{ asset('uploads/expense/decrease.png') }}" height="15px"
                                        alt=""></span>
                            @endif
                            This Month
                        </h4>
                        <h4 class="mt-2">
                            @if ($thisMonth > $lastMonth)
                                <span>+</span>
                            @else
                                <span>-</span>
                            @endif
                            {{ $thisMonth }}
                        </h4>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4>
                            @if ($thisMonth < $lastMonth)
                                <span><img src="{{ asset('uploads/expense/increase.png') }}" height="15px"
                                        alt=""></span>
                            @else
                                <span><img src="{{ asset('uploads/expense/decrease.png') }}" height="15px"
                                        alt=""></span>
                            @endif
                            Previous Month
                        </h4>
                        <h4 class="mt-2">
                            @if ($thisMonth < $lastMonth)
                                <span>+</span>
                            @else
                                <span>-</span>
                            @endif
                            {{ $lastMonth }}
                        </h4>
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
