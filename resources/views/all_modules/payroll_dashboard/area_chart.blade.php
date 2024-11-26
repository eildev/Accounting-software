<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h6 class="card-title">Area chart</h6>
            <div>
                <div class="form-group primary-color-text mb-2">
                    <select class="form-control primary-color-text" id="yearSelectArea">
                        <option disabled selected class="bg-white" value="{{ Carbon\Carbon::now()->format('Y') }}">
                            <p class="selected-option">Select Year</p>
                            <i class="fas fa-chevron-down"></i>
                        </option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                        <option value="2028">2028</option>
                        <option value="2029">2029</option>
                        <option value="2030">2030</option>
                        <option value="2031">2031</option>
                        <option value="2032">2032</option>
                    </select>
                </div>
            </div>

        </div>
        <div id="apexLine2">
            <!-- The dynamic data will be displayed here -->
        </div>
    </div>
</div>
</div>

<script>
    $(document).ready(function() {
        // Trigger AJAX request when a new year is selected
        $('#yearSelectArea').on('change', function() {
            var selectedYear = $(this).val(); // Get the selected year

            // Make an AJAX request to fetch data for the selected year
            $.ajax({
                url: "{{ url('fetch-yearly-data') }}", // Use url() helper for the correct path
                type: 'GET',
                data: {
                    year: selectedYear
                },
                success: function(response) {
                    // Extract months and totals from the response
                    var months = response.months;
                    var totals = response.totals;

                    // Update the chart with the new data
                    updateChart(months, totals);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        });
var apexLineChart;

function updateChart(months, totals) {
    var colors = {
        primary: "#6571ff",
        success: "#05a34a",
        info: "#66d1d1",
        gridBorder: "rgba(77, 138, 240, .15)",
        bodyColor: "#b8c3d9",
        cardBg: "#0c1427"
    };

    var allMonths = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];

    var monthlyTotals = new Array(12).fill(0);
    months.forEach(function(month, index) {
        monthlyTotals[month - 1] = totals[index];
    });

    var lineChartOptions = {
        chart: {
            type: "line",
            height: '320',
            foreColor: colors.bodyColor,
            background: colors.cardBg,
            toolbar: {
                show: false
            },
        },
        series: [{
            name: "Monthly Net Salary",
            data: monthlyTotals
        }],
        xaxis: {
            categories: allMonths,
            axisBorder: {
                color: colors.gridBorder,
            },
            axisTicks: {
                color: colors.gridBorder,
            },
        },
    };

    if (apexLineChart) {
        apexLineChart.updateOptions(lineChartOptions);
    } else {
        apexLineChart = new ApexCharts(document.querySelector("#apexLine2"), lineChartOptions);
        apexLineChart.render();
    }
}
var currentYear = new Date().getFullYear();
    $('#yearSelectArea').val(currentYear); // Select the current year in the dropdown
    $.ajax({
        url: "{{ url('fetch-yearly-data') }}", // Use url() helper for the correct path
        type: 'GET',
        data: {
            year: currentYear
        },
        success: function(response) {
            // Extract months and totals from the response
            var months = response.months;
            var totals = response.totals;

            // Update the chart with the new data
            updateChart(months, totals);
        },
        error: function(xhr, status, error) {
            console.error('Error fetching data:', error);
        }
    });
    });
    // $(document).ready(function() {
    //     var colors = {
    //         primary: "#6571ff",
    //         secondary: "#7987a1",
    //         success: "#05a34a",
    //         info: "#66d1d1",
    //         warning: "#fbbc06",
    //         danger: "#ff3366",
    //         light: "#e9ecef",
    //         dark: "#060c17",
    //         muted: "#7987a1",
    //         gridBorder: "rgba(77, 138, 240, .15)",
    //         bodyColor: "#b8c3d9",
    //         cardBg: "#0c1427"
    //     };

    //     var fontFamily = "'Roboto', Helvetica, sans-serif";

    //     var lineChartOptions = {
    //         chart: {
    //             type: "line",
    //             height: '320',
    //             parentHeightOffset: 0,
    //             foreColor: colors.bodyColor,
    //             background: colors.cardBg,
    //             toolbar: {
    //                 show: false
    //             },
    //         },
    //         theme: {
    //             mode: 'dark'
    //         },
    //         tooltip: {
    //             theme: 'dark'
    //         },
    //         colors: [colors.success, colors.info, colors.primary],
    //         grid: {
    //             padding: {
    //                 bottom: -4
    //             },
    //             borderColor: colors.gridBorder,
    //             xaxis: {
    //                 lines: {
    //                     show: true
    //                 }
    //             }
    //         },
    //         series: [{
    //                 name: "Monthly Sale",
    //                 data: [1200, 1400, 1600, 1800, 2000, 2200, 2400, 2600, 2800]
    //             },

    //         ],
    //         xaxis: {
    //             type: "category", // No need for datetime here
    //             categories: [
    //                 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
    //                 'September'
    //             ],
    //             lines: {
    //                 show: true
    //             },
    //             axisBorder: {
    //                 color: colors.gridBorder,
    //             },
    //             axisTicks: {
    //                 color: colors.gridBorder,
    //             },
    //         },
    //         markers: {
    //             size: 0,
    //         },
    //         legend: {
    //             show: true,
    //             position: "top",
    //             horizontalAlign: 'center',
    //             fontFamily: fontFamily,
    //             itemMargin: {
    //                 horizontal: 8,
    //                 vertical: 0
    //             },
    //         },
    //         stroke: {
    //             width: 3,
    //             curve: "smooth",
    //             lineCap: "round"
    //         },
    //     };

    //     var apexLineChart = new ApexCharts(document.querySelector("#apexLine2"), lineChartOptions);
    //     apexLineChart.render();
    // });
</script>
