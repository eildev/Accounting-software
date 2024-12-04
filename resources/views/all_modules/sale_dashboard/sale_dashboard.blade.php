@extends('master')
@section('title', '| Customer Payable Dashboard')
@section('admin')
    <div class="row">
        <div class="col-md-12">
            <div>
                <h3>Export Today’s Sales
                </h3>
                <h5 class="mt-2">Sales Summery
                </h5>
            </div>
        </div>
        <div class="col-12 col-xl-12 stretch-card mt-2">
            <div class="row flex-grow-1">
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card card-color">
                        <div class="card-body card_body_first">
                            <div class="d-flex justify-content-between align-items-center mb-0">
                                <img height="50px" width="50px"
                                    src="{{ asset('uploads/customer_payable_dashboard/TotalSales.png') }}"
                                    alt="Total Sales">
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-12 mt-3">
                                    <h3 class="card-result-color mb-1">1K</h3>
                                    <P class="employe-name">Total Sales
                                    </P>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3  grid-margin stretch-card">
                    <div class="card card-color">
                        <div class="card-body first">
                            <div class="d-flex justify-content-between align-items-center mb-0">
                                <img height="50px" width="50px"
                                    src="{{ asset('uploads/customer_payable_dashboard/TotalOrder.png') }}"
                                    alt="Total Order ">

                            </div>
                            <div class="row">
                                <div class="col-12 col-md-12 mt-3">
                                    <h3 class="card-result-color mb-1">1k</h3>
                                    <P class="employe-name">Total Order </P>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card card-color">
                        <div class="card-body first">
                            <div class="d-flex justify-content-between align-items-center mb-0">
                                <img height="50px" width="50px"
                                    src="{{ asset('uploads/customer_payable_dashboard/ProductSold.png') }}"
                                    alt="Product Sold ">

                            </div>
                            <div class="row">
                                <div class="col-12 col-md-12 mt-3">
                                    <h3 class="card-result-color  mb-1">0</h3>
                                    <P class="employe-name">Product Sold </P>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card card-color">
                        <div class="card-body first">
                            <div class="d-flex justify-content-between align-items-center mb-0">
                                <img height="50px" width="50px"
                                    src="{{ asset('uploads/customer_payable_dashboard/NewCustomers.png') }}"
                                    alt="New Customers">

                            </div>
                            <div class="row">
                                <div class="col-12 col-md-12 mt-3 ">
                                    <h3 class="card-result-color mb-1">0</h3>
                                    <P class="employe-name">New Customers
                                    </P>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    {{-- //Area Chart --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Area chart</h6>
                    <div id="apexArea1"></div>
                </div>
            </div>
        </div>
        {{-- //Total Revenue chart --}}
        <div class="col-md-7 mt-2">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Total Revenue
                    </h6>
                    <div id="apexMixed11"></div>
                </div>
            </div>
        </div>
        <div class="col-md-5 mt-2">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Target vs Reality
                    </h6>
                    <div id="TargetChart"></div>
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

            if ($('#apexArea1').length) {
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
                    colors: [colors.danger, colors.info],
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
                    }, {
                        name: 'Unique Views',
                        data: generateDayWiseTimeSeries(1, 18)
                    }],
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
                        opposite: true,
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

                var chart = new ApexCharts(document.querySelector("#apexArea1"), options);
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

            //mixed


  if ($('#apexMixed11').length) {
    var options = {
      chart: {
        height: 300,
        type: 'bar',
        parentHeightOffset: 0,
        foreColor: colors.bodyColor,
        background: colors.cardBg,
        toolbar: {
          show: false
        },
      },
      colors: [colors.primary, colors.info],
      grid: {
        borderColor: colors.gridBorder,
        padding: {
          bottom: -4
        },
        xaxis: {
          lines: {
            show: true
          }
        }
      },
      plotOptions: {
        bar: {
          columnWidth: '50%'
        }
      },
      dataLabels: {
    enabled: false
},
      series: [
        {
          name: 'Online Sales',
          data: [10000, 15000, 20000, 25000, 30000, 20000, 15000] // Online Sales data
        },
        {
          name: 'Offline Sales',
          data: [8000, 12000, 18000, 22000, 25000, 15000, 10000] // Offline Sales data
        }
      ],
      xaxis: {
        categories: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
        axisBorder: {
          color: colors.gridBorder,
        },
        axisTicks: {
          color: colors.gridBorder,
        },
      },
      yaxis: {
        title: {
          text: "Amount ($)",
          offsetX: -10,
        },
        labels: {
          formatter: function (value) {
            return value.toLocaleString();
          },
        }
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
        onItemClick: {
          toggleDataSeries: true // Ensure clicking toggles series visibility
        },
        onItemHover: {
          highlightDataSeries: true // Highlight the series on hover
        },
      },
      tooltip: {
        shared: true,
        intersect: false,
        y: {
          formatter: function (value) {
            if (typeof value !== "undefined") {
              return "$" + value.toLocaleString();
            }
            return value;
          }
        }
      }
    };

    var chart = new ApexCharts(
      document.querySelector("#apexMixed11"),
      options
    );
    chart.render();
  }
  /////////////////Target Chart /////////////
  if ($('#TargetChart').length) {
      var options = {
        chart: {
          height: 300,
          type: 'bar',
          parentHeightOffset: 0,
          foreColor: colors.bodyColor,
          background: colors.cardBg,
          toolbar: {
            show: false
          },
        },
        colors: [colors.primary, colors.info],
        grid: {
          borderColor: colors.gridBorder,
        },
        plotOptions: {
          bar: {
            columnWidth: '50%',
            endingShape: 'rounded',
          }
        },
        dataLabels: {
          enabled: false, // Disable values inside bars
        },
        series: [
          {
            name: 'Reality Sales',
            data: [7000, 9000, 8000, 12000, 14000, 15000, 17000] // Data for Reality Sales
          },
          {
            name: 'Target Sales',
            data: [10000, 12000, 11000, 15000, 16000, 17000, 20000] // Data for Target Sales
          }
        ],
        xaxis: {
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'], // Months
          axisBorder: {
            color: colors.gridBorder,
          },
          axisTicks: {
            color: colors.gridBorder,
          },
        },
        yaxis: {
          labels: {
            formatter: function (value) {
              return value.toLocaleString(); // Format numbers for readability
            }
          },
          title: {
            text: "Sales ($)"
          },
        },
        legend: {
          show: true,
          position: "top",
          horizontalAlign: 'center',
          fontFamily: fontFamily,
          markers: {
            radius: 12,
          },
          itemMargin: {
            horizontal: 8,
            vertical: 0
          },
        },
        tooltip: {
          shared: true,
          intersect: false,
          y: {
            formatter: function (value) {
              return "$" + value.toLocaleString();
            }
          }
        }
      };

      var chart = new ApexCharts(
        document.querySelector("#TargetChart"),
        options
      );

      chart.render();
    }
        });
    </script>
@endsection
