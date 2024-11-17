@extends('master')
@section('admin')

    <style>
        .card-color {
            background-color: #FAFAFA
        }

        .card-body {
            padding: 15px 10px 10px 15px !important
        }

        .card {
            border-radius: 12px
        }

        .growth {
            border-radius: 30px;
            padding: 0px 15px;
            border: 1px solid #bebebe;
        }

        .employe-name {
            font-size: 14px;
            font-weight: bold;
            padding: 15px 0 5px 0px;
            color: #9DA2AE;
        }

        .card-result-color {
            color: #1E62E4;
        }

        @media (min-width: 1200px) {
            .col-xl-5 {
                width: 100%;
            }

            .col-md-12 {
                width: 100%;
            }
        }
    </style>

    <!-------------------------------Main Dashboard Start ------------------------->
    <div class="row">
        <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow-1">
                <div class="col-md-3 grid-margin  stretch-card">
                    <div class="card card-color">
                        <div class="card-body card_body_first">
                            <div class="d-flex justify-content-between align-items-center mb-0">
                                <img width="60px" height="50px"
                                    src="{{ asset('uploads/payroll_dashboard/payroll_icon/Group162507.png') }}"
                                    alt="">
                                <div class="growth">
                                    <span>+10.3%</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-12 col-xl-5">
                                    <P class="employe-name">Total Employee</P>
                                    <h3 class="card-result-color">{{ $data['employeesCount'] }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card card-color">
                        <div class="card-body first">
                            <div class="d-flex justify-content-between align-items-center mb-0">
                                <img width="60px" height="50px"
                                    src="{{ asset('uploads/payroll_dashboard/payroll_icon/Group162508.png') }}"
                                    alt="">
                                <div class="growth">
                                    <span>+10.3%</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-12 col-xl-5">
                                    <P class="employe-name">Total Department</P>
                                    <h3 class="card-result-color">{{ $data['departmentsCount'] }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card card-color">
                        <div class="card-body first">
                            <div class="d-flex justify-content-between align-items-center mb-0">
                                <img width="60px" height="50px"
                                    src="{{ asset('uploads/payroll_dashboard/payroll_icon/Group162509.png') }}"
                                    alt="">
                                <div class="growth">
                                    <span>+0.3%</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-12 col-xl-6">
                                    <P class="employe-name">Total Designation</P>
                                    <h3 class="card-result-color">0</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card card-color">
                        <div class="card-body first">
                            <div class="d-flex justify-content-between align-items-center mb-0">
                                <img width="60px" height="50px"
                                    src="{{ asset('uploads/payroll_dashboard/payroll_icon/Group162510.png') }}"
                                    alt="">
                                <div class="growth">
                                    <span>+0.3%</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-12 col-xl-6">
                                    <P class="employe-name">Total Salary</P>
                                    <h3 class="card-result-color">0</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- row -->
    <!-------------------------------Main Dashboard End ------------------------->
    <div class="row">
        <div class="col-lg-7 col-xl-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Area chart</h6>
                    <div class="flot-chart-wrapper">
                        <div class="flot-chart" id="flotArea"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-xl-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Donut chart</h6>
                    <div id="apexDonut"></div>
                </div>
            </div>
        </div>
    </div> <!-- row -->
    <script>

$(document).ready(function() {
  // Area Chart
  $.plot($('#flotArea'), [
    {
      label: 'iPhone',
      data: [
        [ "2010.Q1", 35 ], [ '2010.Q2', 67 ], [ '2010.Q3', 13 ], [ '2010.Q4', 45 ]
      ]
    },
    {
      label: 'iTouch',
      data: [
        [ '2010.Q1', 32 ], [ '2010.Q2', 49 ], [ '2010.Q3', 25 ], [ '2010.Q4', 57 ]
      ]
    }
  ], {
    series: {
      shadowSize: 0,
      lines: {
        show: true,
        fill: 0.15,
        lineWidth: 1
      }
    },

    grid: {
      color: colors.bodyColor,
      borderColor: colors.gridBorder,
      borderWidth: 1,
      hoverable: true,
      clickable: true
    },

    xaxis: { mode: 'categories', tickColor: colors.gridBorder },
    yaxis: { tickColor: colors.gridBorder },
    legend: { backgroundColor: colors.cardBg },

    tooltip: {
      show: true,
      content: '%s: %y'
    },

    colors: [colors.danger, colors.primary]
  });
})
    </script>
 <script src="{{ asset('assets') }}/vendors/jquery.flot/jquery.flot.js"></script>
 <script src="{{ asset('assets') }}/vendors/jquery.flot/jquery.flot.resize.js"></script>
 <script src="{{ asset('assets') }}/vendors/jquery.flot/jquery.flot.pie.js"></script>
 <script src="{{ asset('assets') }}/vendors/jquery.flot/jquery.flot.categories.js"></script>
   <!-- End plugin js for this page -->

   <!-- Custom js for this page -->
 <script src="{{ asset('assets') }}/assets/js/jquery.flot-light.js"></script>

@endsection
