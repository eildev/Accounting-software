<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h6 class="card-title">Donut chart</h6>
            <div>
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
        {{-- <div id="apexDonut"></div> --}}
        <div class="row">
         <div id="apexDonut"></div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        'use strict';

        const colors = {
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
        };

        const fontFamily = "'Roboto', Helvetica, sans-serif";
        let chart = null;

        function renderDonutChart(data) {
            if (chart) {
                chart.destroy();
            }
            if ($('#apexDonut').length) {
                const total = parseFloat(data.paySlipPaid) +
                    parseFloat(data.paySlipPending) +
                    parseFloat(data.paySlipUnpaid) +
                    parseFloat(data.paySlipProcessing)+
                    parseFloat(data.paySlipCanceled);

                const options = {
                    chart: {
                        height: 300,
                        type: "donut",
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
                    stroke: {
                        colors: ['rgba(0,0,0,0)']
                    },
                    colors: [colors.primary, colors.warning, colors.danger, colors.info,colors.muted],
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
                    dataLabels: {
                        enabled: false
                    },
                    series: total > 0 ? [
                        parseFloat(data.paySlipPaid),
                        parseFloat(data.paySlipPending),
                        parseFloat(data.paySlipUnpaid),
                        parseFloat(data.paySlipProcessing),
                        parseFloat(data.paySlipCanceled)
                    ] : [1],
                    labels: total > 0 ? ['Paid', 'Pending', 'Unpaid', 'Processing','Canceled'] : ['No Data'],
                };

                chart = new ApexCharts(document.querySelector("#apexDonut"), options);
                chart.render();
            }
        }

        $('#monthSelect2').on('change', function() {
            const selectedMonth = $(this).val();

            $.ajax({
                url: '/get-pay-slips-month-data',
                method: 'GET',
                data: {
                    month: selectedMonth
                },
                success: function(response) {
                    renderDonutChart(response);
                },
                error: function(xhr) {
                    console.error('Error fetching data:', xhr);
                }
            });
        });

        $('#monthSelect2').trigger('change');



    });
</script>
