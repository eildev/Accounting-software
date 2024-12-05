<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h6 class="card-title">Money Flow</h6>
            <div class="d-flex justify-content-between">
                <div class="form-group primary-color-text mb-2">
                    <select class="form-control primary-color-text" id="moneyFlowMonthSelect">
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
// $(function() {
//     'use strict';

//     var chart = null;

//     function initializeChart() {
//         var options = {
//             chart: {
//                 type: "area",
//                 height: 300,
//             },
//             series: [],
//             xaxis: {
//                 type: "datetime",
//             },
//             yaxis: {
//                 title: {
//                     text: "Expenses ($)",
//                 },
//                 min: 0,
//             },
//             colors: ["#0056FD"],
//         };

//         chart = new ApexCharts(document.querySelector("#apexArea"), options);
//         chart.render();
//     }

//     function loadMonthlyData(month, year) {
//         $.ajax({
//             url: '/expenses-chart-data-money-flow',
//             method: 'GET',
//             data: { month: month, year: year },
//             success: function(response) {
//                 var seriesData = response.map(item => {
//                     return [new Date(item.date).getTime(), item.total_expense];
//                 });

//                 chart.updateSeries([{
//                     name: 'Daily Expenses',
//                     data: seriesData
//                 }]);
//             },
//             error: function(error) {
//                 console.error("Error fetching data:", error);
//             }
//         });
//     }

//     // Initialize chart
//     initializeChart();

//     // Load data for the current month on page load
//     var currentMonth = new Date().getMonth() + 1; // JS months are 0-based
//     var currentYear = new Date().getFullYear();
//     loadMonthlyData(currentMonth, currentYear);

//     // Update data when the user selects a different month/year
//     $('#moneyFlowMonthSelect').on('change', function() {
//         var selectedMonth = $(this).val();
//         loadMonthlyData(selectedMonth, currentYear);
//     });
// });
$(function() {
    'use strict';

    var chart = null;

    // Initialize the chart
    function initializeChart() {
        var options = {
            chart: {
                type: "area",
                height: 300,
            },
            series: [],
            xaxis: {
                categories: [], // This will hold the date values (1, 2, 3, ..., 30)
            },
            yaxis: {
                title: {
                    text: "Expenses ($)",
                },
                min: 0,
            },
            colors: ["#0056FD"],
        };

        chart = new ApexCharts(document.querySelector("#apexArea"), options);
        chart.render();
    }

    // Load monthly expenses data from backend
    function loadMonthlyData(month, year) {
        $.ajax({
            url: '/expenses-chart-data-money-flow',
            method: 'GET',
            data: { month: month, year: year },
            success: function(response) {
                var categories = [];
                var expensesData = [];

                // Prepare data for chart
                response.forEach(function(item) {
                    categories.push(item.date);  // Day numbers (1, 2, 3, ...)
                    expensesData.push(item.total_expense);  // Corresponding expenses
                });

                // Update chart with the fetched data
                chart.updateOptions({
                    xaxis: {
                        categories: categories
                    }
                });

                chart.updateSeries([{
                    name: 'Daily Expenses',
                    data: expensesData
                }]);
            },
            error: function(error) {
                console.error("Error fetching data:", error);
            }
        });
    }

    // Initialize chart
    initializeChart();

    // Load data for the current month
    var currentMonth = new Date().getMonth() + 1; // JS months are 0-based
    var currentYear = new Date().getFullYear();
    loadMonthlyData(currentMonth, currentYear);

    // Update data when the user selects a different month/year
    $('#moneyFlowMonthSelect').on('change', function() {
        var selectedMonth = $(this).val();
        loadMonthlyData(selectedMonth, currentYear);
    });
});

</script>
