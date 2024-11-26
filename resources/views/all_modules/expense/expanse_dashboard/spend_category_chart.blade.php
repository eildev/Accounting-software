<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <!-- Dropdown for selecting the month -->
            <div class="form-group primary-color-text mb-2">
                <h6 class="card-title">Spend by category</h6>
                <select class="form-control primary-color-text" id="categoryMonthSelect">
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
            <!-- Button to view all -->
            <div>
                <button class="btn btn-primary">View All</button>
            </div>
        </div>
        <!-- Donut chart container -->
        <div id="categoryApexDonutChart"></div>
        <div id="chartLegend" class="mt-3 row">

        </div>
    </div>
</div>

<script>
 $(document).ready(function () {
    'use strict';

    const colors = {
        primary: "#6571ff",
        success: "#05a34a",
        warning: "#fbbc06",
        danger: "#ff3366",
        info: "#66d1d1",
        dark: "#060c17",
        light: "#e9ecef",
        cardBg: "#ffffff",
    };

    const fontFamily = "'Roboto', Helvetica, sans-serif";
    let chart = null;

    // Render the donut chart with dynamic data
    function renderDonutChart(data) {
        if (chart) {
            chart.destroy(); // Destroy existing chart
        }
        if ($('#categoryApexDonutChart').length) {
            // Map the categories and sums to the chart data
            const categories = data.categoryPercentages.map(item => item.category);
            const values = data.categoryPercentages.map(item => parseFloat(item.sum));
            const totalAmount = data.totalExpense;

            const options = {
                chart: {
                    height: 300,
                    type: "donut",
                    foreColor: colors.dark,
                    background: colors.cardBg,
                    toolbar: { show: false },
                },
                theme: { mode: 'light' },
                tooltip: { theme: 'light' },
                colors: [colors.primary, colors.success, colors.warning, colors.danger, colors.info],
                legend: { show: false },
                dataLabels: {
                    enabled: true,
                    formatter: (val) => `${Math.round(val)}%`,
                    style: { fontSize: '14px', fontFamily: fontFamily },
                },
                series: values, // Dynamic values for the donut chart
                labels: categories, // Dynamic labels for the categories
                plotOptions: {
                    pie: {
                        donut: {
                            size: '70%',
                            labels: {
                                show: true,
                                // value: {
                                //     show: true,
                                //     fontSize: '20px',
                                //     fontFamily: fontFamily,
                                //     formatter: () => `৳${totalAmount}`,
                                // },
                                total: {
                                    show: true,
                                    label: 'Spend by category',
                                    formatter: () => `৳${totalAmount}`,
                                },
                            },
                        },
                    },
                },
            };

            chart = new ApexCharts(document.querySelector("#categoryApexDonutChart"), options);
            chart.render();

            // Create a custom legend dynamically
            createCustomLegend(data);
        }
    }

    // Create a custom legend for the categories
    function createCustomLegend(data) {
        const legendHTML = data.categoryPercentages.map(item => {
            const color = colors[item.category.toLowerCase()] || colors.primary; // Default to primary color
            return `
                <div class=" col-md-2 align-items-center mb-2  ">
                    <div class="legend-color-box" style="background-color: ${color};"></div>
                    <span> <span style="font-weight:bold">৳${item.sum} </span></br>  ${item.category}</span>
                </div>
            `;
        }).join('');

        document.getElementById('chartLegend').innerHTML = legendHTML;
    }

    // Fetch the data for the selected month
    function fetchMonthlyData(month) {
        $.ajax({
            url: '/get-monthly-expanse-category-data', // Update this URL with your route
            type: 'GET',
            data: { month: month },
            success: function (response) {
                renderDonutChart(response); // Render the chart with the data
            },
            error: function (xhr) {
                console.error('Error fetching data:', xhr);
            }
        });
    }

    // Event listener for month selection
    $('#categoryMonthSelect').on('change', function () {
        const selectedMonth = $(this).val();
        fetchMonthlyData(selectedMonth); // Fetch and render data for selected month
    });

    // Initial load with the current month's data
    const currentMonth = new Date().getMonth() + 1; // JavaScript months are 0-based
    $('#categoryMonthSelect').val(currentMonth); // Set the current month in the dropdown
    fetchMonthlyData(currentMonth); // Trigger data fetch for the current month
});



</script>
