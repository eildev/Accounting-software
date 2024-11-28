<style>
    .expanse-payment {
width: 55%;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <!-- Dropdown for selecting the month -->
                    <div class="form-group primary-color-text mb-2">
                        <h6 class="card-title">Paid Expanse</h6>
                        <select class="form-control expanse-payment custom-select   primary-color-text  border-colro-red w-0" id="paymentMonthSelect">
                            <option disabled selected  value="{{ Carbon\Carbon::now()->format('m') }}">
                                <p class="selected-option">Month <i class="fas fa-chevron-down"></i></p>

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
                        <a href="{{route('expense.view')}}"><button class="btn " style="border: 1px solid #DFDFDF">View All</button></a>
                    </div>
                </div>
                <div id="paymentChart">

                </div>
            </div>

        </div>
    </div>
    {{-- ///////////////////////////////////This Month and Previous Month Comparison ///////////////////////////////// --}}
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

        var fontFamily = "'Roboto', Helvetica, sans-serif";

        // Initial chart options with empty data
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
                enabled: true,
                formatter: function(val, opts) {
                    return opts.w.config.series[opts.seriesIndex] + '%'; // Display the percentage
                },
                style: {
                    fontSize: '14px',
                    fontFamily: fontFamily,
                    fontWeight: 'bold',
                    colors: ['#ffffff'] // White text for percentages
                }
            },
            series: [0, 0, 0, 0], // Default empty data
            // labels: ['Paid', 'Pending', 'Unpaid', 'Processing'], // Labels for the pie chart
            labels: ['Expanse ', ' Conveyance  ', 'Salary ', 'Recurring '], // Labels for the pie chart
            noData: {
                text: 'No Data Available', // Message when no data is present
                align: 'center',
                verticalAlign: 'middle',
                style: {
                    color: colors.bodyColor,
                    fontSize: '16px',
                    fontFamily: fontFamily
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#paymentChart"), options);
        chart.render();

        // Fetch data and update the chart
        function updateChart(month) {
            $.ajax({
                url: '/get-expanse-payment-percentage-data', // Your controller URL
                method: 'GET',
                data: { month: month },
                success: function(response) {
                    console.log(response);  // Check what the response looks like

                    // Check if all the values are zero or data is unavailable
                    // const total = response.expansePaid + response.expansePending + response.expanseUnpaid + response.expanseProcessing;
                    const total = response.expansePaid + response.conviencePaid + response.salaryPaid + response.recurringPaid;

                    if (total === 0) {
                        // Display "No Data" message
                        chart.updateOptions({
                            series: [],
                            noData: {
                                text: 'No Data Available',
                                align: 'center',
                                verticalAlign: 'middle',
                                style: {
                                    color: colors.bodyColor,
                                    fontSize: '16px',
                                    fontFamily: fontFamily
                                }
                            }
                        });
                    } else {
                        // Update chart with actual data
                        chart.updateOptions({
                            // series: [
                            //     response.expansePaid,
                            //     response.expansePending,
                            //     response.expanseUnpaid,
                            //     response.expanseProcessing
                            // ],
                            series: [
                                response.expansePaid,
                                response.conviencePaid,
                                response.salaryPaid,
                                response.recurringPaid
                            ],
                            noData: {
                                text: '' // Clear "No Data" message when data is available
                            }
                        });
                    }
                },
                error: function(xhr) {
                    console.error("Error fetching chart data:", xhr.responseText);
                }
            });
        }

        // Handle month selection
        $('#paymentMonthSelect').on('change', function() {
            var selectedMonth = $(this).val();
            updateChart(selectedMonth);
        });

        // Initial chart update for the current month
        updateChart('{{ Carbon\Carbon::now()->format('m') }}');
    });
</script>



