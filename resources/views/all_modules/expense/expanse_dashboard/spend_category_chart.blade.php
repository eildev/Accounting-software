<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between">

            <div class="form-group primary-color-text mb-2">
                <h6 class="card-title">Money Flow</h6>
                <select class="form-control primary-color-text" id="monthSelect3">
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
            <div>
                <button class="btn">View All</button>
            </div>
        </div>
        <div id="apexDonutChart"></div>
    </div>
</div>
<script>
$(document).ready(function() {
$(function() {
    'use strict';

var colors = {
  primary        : "#6571ff",
  secondary      : "#7987a1",
  success        : "#05a34a",
  info           : "#66d1d1",
  warning        : "#fbbc06",
  danger         : "#ff3366",
  light          : "#e9ecef",
  dark           : "#060c17",
  muted          : "#7987a1",
  gridBorder     : "rgba(77, 138, 240, .15)",
  bodyColor      : "#b8c3d9",
  cardBg         : "#0c1427"
}

var fontFamily = "'Roboto', Helvetica, sans-serif"

if ($('#apexDonutChart').length) {
        var options = {
        chart: {
            height: 300,
            type: "donut",
            foreColor: colors.bodyColor,
            background: colors.cardBg,
            toolbar: {
            show: false,
            type: 'donut',
            },
        },
        theme: {
            mode: 'dark'
        },

        tooltip: {
            theme: 'dark'
        },
        stroke: {
            width: 5,
            colors: ['rgba(0,0,0,0)']
        },
        colors: [colors.primary,colors.warning,colors.danger, colors.info],
        legend: {
            show: true,
            position: "top",
            horizontalAlign: 'center',
            fontFamily: fontFamily,
            itemMargin: {
            horizontal: 8,
            vertical: 0,
           aspectRatio: 2,

            },
        },
        dataLabels: {
            enabled: false
        },
        series: [44, 55, 13, 33]
        };

        var chart = new ApexCharts(document.querySelector("#apexDonutChart"), options);
        chart.render();
    }
    });//
});//
</script>
