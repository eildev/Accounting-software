@extends('master')
@section('admin')
    @php
        $mode = App\models\PosSetting::all()->first();
    @endphp

    @if ($mode->dark_mode == 2)
        <style>
            .custom-table th,
            .custom-table td {
                padding: 12px;
                border: 1px solid #0d1525;
            }

            .custom-table thead {
                background-color: #0d1525;
            }

            .Payroll-border {
                border: 1px solid #0d1525
            }

            .card-border {
                border: 1px solid #474849
            }

            .card-border:hover {
                background-color: #1E62E4
            }
        </style>
    @else
        <style>
            .card-color {
                background-color: #FAFAFA
            }

            .secondary-color {
                background-color: #FAFAFA;

            }

            .bg-color-white {
                background-color: #fff;
            }

            .primary-color-text {
                color: #1E62E4
            }
            .card-border:hover {
                background-color: #1E62E4;
                color: #fff;
                border-radius: 10px;
            }
            /* //Salary Sheet table // */
            .custom-table th,
            .custom-table td {
                padding: 12px;
                border: 1px solid #ddd;
            }

            .custom-table thead {
                background-color: #f5f5f5;
            }

            .Payroll-border {
                border: 1px solid #EBEFEC
            }

            /* ///////////Progress///// */
            .progress {
                background-color: #f1f1f1;
            }

            .color-text-black {
                color: #000
            }
        </style>
    @endif
    <style>
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

        .primary-color {
            background-color: #1E62E4;
            color: #fff
        }

        .btn:hover {
            background-color: #1E62E4;
            color: #fff
        }



        @media (min-width: 1200px) {
            .col-xl-5 {
                width: 100%;
            }

            .col-md-12 {
                width: 100%;
            }
        }

        /* General Table Styling */
        .table-container {
            width: 100%;
            margin: 20px auto;
            font-family: Arial, sans-serif;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .custom-table th {
            font-weight: bold;
        }

        /* Badge Styling */
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 5px;
            font-size: 12px;
            color: #fff;
            font-weight: bold;
        }

        .badge.delayed {
            background-color: #ffc107;
            /* Yellow for delayed */
            color: #000;
        }

        .badge.paid {
            background-color: #28a745;
            /* Green for paid */
        }

        /* Pagination Styling */
        .pagination {
            display: flex;
            justify-content: center;

            align-items: center;
            margin: 10px 0;
        }

        .pagination .prev-btn,
        .pagination .next-btn {
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .pagination .page-numbers {
            display: flex;
            gap: 5px;
        }

        .pagination .page-btn {
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
        }

        .pagination .page-btn.active {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
        }


        /* /////////////////////////Progress bar /////////////////////////// */
        .progress {
            height: 20px;
            border-radius: 20px;
            overflow: hidden;
            transition: width 0.5s ease;
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
        <div class="col-lg-7 grid-margin stretch-card">
            @include('all_modules.payroll_dashboard.area_chart')

        <div class="col-lg-5  grid-margin stretch-card">
            @include('all_modules.payroll_dashboard.donut_chart')
        </div>
    </div> <!-- row -->
    <!-------------------------Bonus----------------------------->
    <div class="row">
        <div class="col-md-12">
            @include('all_modules.payroll_dashboard.bonus_data')
        </div>
    </div> <!-- row -->
    <!-------------------------Bonus End----------------------------->
    <!-------------------------Salary Sheet----------------------------->
    <div class="row bg-color-white" style="margin: 0px 0px 20px 0px">
        <div class="col-md-12  p-3 Payroll-border">
            @include('all_modules.payroll_dashboard.salary_sheet_table')
        </div>
    </div>
    <!-------------------------Salary Sheet End----------------------------->
    <!-------------------------Convenience Start----------------------------->
    <div class="row">
       <div class="col-md-12">
        @include('all_modules.payroll_dashboard.conveience_data')
       </div>
    </div> <!-- row -->

    <!---------------------------------Convenience End------------------>

@endsection
