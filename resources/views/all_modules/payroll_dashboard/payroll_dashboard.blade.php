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
                    <div class="d-flex justify-content-between">
                        <h6 class="card-title">Donut chart</h6>
                        <div>
                            <div class="form-group primary-color-text mb-2">
                                <select class="form-control primary-color-text" id="monthSelect2">
                                    <option disabled selected class="bg-white"
                                        value="{{ Carbon\Carbon::now()->format('m') }}">
                                        <span class="selected-option">Month</span>
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
                    <div id="apexDonut"></div>
                </div>
            </div>
        </div>
    </div> <!-- row -->
    <!-------------------------Bonus----------------------------->
    <div class="row">
        <div class="col-12 col-md-7 col-lg-7  grid-margin primary-color-text stretch-card">
            <div class="card ">
                <div class="card-body secondary-color">
                    <div class="d-flex justify-content-between">
                        <h4>All Bonus</h4>
                        <div>
                            <div class="form-group primary-color-text">

                                <select class="form-control primary-color-text" id="monthSelect">
                                    <option disabled selected class="bg-white"
                                        value="{{ Carbon\Carbon::now()->format('m') }}">
                                        <span class="selected-option">Month</span>
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
                    <div class="d-flex gap-2 justify-content-around mt-3 mb-1 secondary-color">
                        <div class="card-body rounded-3 primary-color " id="festivalClick">
                            <div class="d-flex align-items-center justify-content-between  mb-3">
                                <span class="primary-color-text"><img
                                        src="{{ asset('uploads/payroll_dashboard/bonus_icon/Group000003486.png') }}"
                                        alt="Bonus Iocn" height="60px"></span>
                                <span class="fs-5 me-2"><i class="fas fa-chevron-right"></i></span>
                            </div>
                            <h6 class="mb-2 ">Festival Bonus</h6>
                            <h4 id="festivalBonus">{{ $data['festivalBonusesSum'] }}</h4>
                        </div>

                        <div class="card-body rounded-3 bg-color-white  " id="performanceClick">
                            <div class="d-flex justify-content-between align-items-center  mb-3">
                                <span><img src="{{ asset('uploads/payroll_dashboard/bonus_icon/performance.png') }}"
                                        alt="Bonus Iocn" height="60px"></span>
                                <span class="fs-5 me-2"><i class="fas fa-chevron-right"></i></span>
                            </div>
                            <h6 class="mb-2 ">Performance Bonus</h6>
                            <h4 id="performanceBonus">{{ $data['performanceBonusesSum'] }}</h4>
                        </div>

                        <div class="card-body bg-color-white rounded-3 " id="otherClick">
                            <div class="d-flex justify-content-between align-items-center   mb-3">
                                <span><img src="{{ asset('uploads/payroll_dashboard/bonus_icon/bonus-icon-2.png') }}"
                                        alt="Bonus Iocn" height="60px"></span>
                                <span class="fs-5 me-2"><i class="fas fa-chevron-right"></i></span>
                            </div>
                            <h6 class="mb-2 ">Other Bonus</h6>
                            <h4 id="otherBonus">{{ $data['otherBonusesSum'] }}</h4>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-5 col-lg-5 primary-color-text">
            <div class="card">
                <div class="card-body secondary-color">
                    <div class="d-flex justify-content-between ">
                        <h4 id="nameSelected">Festival Bonus</h4>
                    </div>
                    <div class="row mt-3">
                        {{-- <div class="col-md-4 col-lg-4 text-lign-center">
                            <span>
                                <div class="card">
                                    <div class="card-body">
                                        <div id="apexDonut"></div>
                                    </div>
                                </div>
                            </span>
                        </div> --}}
                        <div class="col-md-12 col-lg-12 px-4">
                            <div class="d-flex fs-5 mb-2 justify-content-between">
                                <span>Successfully Paid</span>
                                <span id="paid">{{ $data['result']['Paid'] }}</span>
                            </div>
                            <div class="d-flex fs-5 mb-2 justify-content-between">
                                <span>Pending</span>
                                <span id="pending">{{ $data['result']['Pending'] }}</span>
                            </div>
                            <div class="d-flex fs-5 mb-2 justify-content-between">
                                <span>Unpaid</span>
                                <span id="unpaid">{{ $data['result']['Unpaid'] }}</span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class=" rounded-1 text-center border-1">
                        <a href="{{ route('employee.bonus') }}" class="text-white"> <button
                                class="btn primary-color px-6">See Other Bonus</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- row -->
    <!-------------------------Bonus End----------------------------->
    <!-------------------------Salary Sheet----------------------------->
    <div class="row bg-color-white" style="margin: 0px 0px 20px 0px">
        <div class="col-md-12  p-3 Payroll-border">
            <div class=" d-flex justify-content-between">
                <h3>Salary Sheet</h3>
                {{-- <button class="btn Payroll-border">See All</button> --}}
            </div>
            <div class="table-container table-responsive">
                <table id="dashboardTable" class="custom-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Job Title</th>
                            <th>Net Salary</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['netSalarys'] as $key => $netSalary)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $netSalary->employee->full_name ?? '' }} </td>
                                <td>{{ $netSalary->employee->designation ?? '-' }} </td>
                                <td>{{ $netSalary->total_net_salary ?? '-' }} </td>
                                <td>{{ Carbon\Carbon::parse($netSalary->pay_period_date)->format('d-F-Y') ?? '-' }}</td>
                                <td>
                                    @if ($netSalary->status === 'pending')
                                        <span class="badge delayed">{{ $netSalary->status }}</span>
                                    @elseif ($netSalary->status === 'approved')
                                        <span class="badge bg-info">{{ $netSalary->status }}</span>
                                    @elseif ($netSalary->status === 'paid')
                                        <span class="badge bg-success">{{ $netSalary->status }}</span>
                                    @elseif ($netSalary->status === 'processing')
                                        <span class="badge bg-delayed">{{ $netSalary->status }}</span>
                                    @else
                                        <span class="badge bg-delayed">{{ $netSalary->status }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                <div class="pagination">
                    <button class="prev-btn mx-2">← Previous</button>
                    <div class="page-numbers"></div>
                    <button class="next-btn mx-2">Next →</button>

                </div>
            </div>

        </div>
    </div>
    <!-------------------------Salary Sheet End----------------------------->
    <!-------------------------Convenience Start----------------------------->
    <div class="row">
        <div class=" col-md-7 col-lg-7  col-12 grid-margin primary-color-text stretch-card">
            <div class="card ">
                <div class="card-body secondary-color">
                    <div class="d-flex justify-content-between">
                        <h4>Conveyance Cost</h4>
                        <div>
                            <div class="form-group primary-color-text">

                                <select class="form-control primary-color-text" id="conveniencemonthSelect">
                                    <option disabled selected class="bg-white"
                                        value="{{ Carbon\Carbon::now()->format('m') }}">
                                        <span class="selected-option">Month</span>
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
                    <div class="d-flex gap-2 justify-content-around mt-3 mb-1  secondary-color">
                        <div class="row ">
                            <div class="col-md-3 col-6 bg-color-white card-border mr-1">
                                <div class="card-body rounded-3" id="transportationClick">
                                    <div class="d-flex align-items-center justify-content-between  mb-3">
                                        <span class="primary-color-text"><img
                                                src="{{ asset('uploads/payroll_dashboard/convenience_icon/move.png') }}"
                                                alt="Movement Iocn" height="60px"></span>
                                        {{-- <span class="fs-5 me-2"><i class="fas fa-chevron-right"></i></span> --}}
                                    </div>
                                    <h6 class="mb-2 ">Movement</h6>
                                    <h4 id="movementCost">{{ $data['movementCostSum'] }}</h4>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 bg-color-white  card-border">
                                <div class="card-body rounded-3 " id="overNightClick">
                                    <div class="d-flex justify-content-between align-items-center  mb-3">
                                        <span><img
                                                src="{{ asset('uploads/payroll_dashboard/convenience_icon/time.png') }}"
                                                alt="Night Iocn" height="60px"></span>
                                        {{-- <span class="fs-5 me-2"><i class="fas fa-chevron-right"></i></span> --}}
                                    </div>
                                    <h6 class="mb-2 ">Over Night</h6>
                                    <h4 id="overNightCost">{{ $data['overNightCostSum'] }}</h4>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 bg-color-white card-border">
                                <div class="card-body  rounded-3 " id="foodClick">
                                    <div class="d-flex justify-content-between align-items-center   mb-3">
                                        <span><img
                                                src="{{ asset('uploads/payroll_dashboard/convenience_icon/food.png') }}"
                                                alt="Food Iocn" height="60px"></span>
                                        {{-- <span class="fs-5 me-2"><i class="fas fa-chevron-right"></i></span> --}}
                                    </div>
                                    <h6 class="mb-2">Food</h6>
                                    <h4 id="foodingCost">{{ $data['foodingCostSum'] }}</h4>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 bg-color-white card-border">
                                <div class="card-body rounded-3 " id="foodClick">
                                    <div class="d-flex justify-content-between align-items-center   mb-3">
                                        <span><img
                                                src="{{ asset('uploads/payroll_dashboard/bonus_icon/bonus-icon-2.png') }}"
                                                alt="Other Iocn" height="60px"></span>
                                        {{-- <span class="fs-5 me-2"><i class="fas fa-chevron-right"></i></span> --}}
                                    </div>
                                    <h6 class="mb-2"> Other</h6>
                                    <h4 id="otherCost">{{ $data['otherCostSum'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <div class=" col-md-5 col-lg-5 col-12 primary-color-text">
            <div class="card">
                <div class="card-body secondary-color">
                    <div class="d-flex justify-content-between mb-2">
                        <h4 class="color-text-black">Conveyance Payment Status</h4>
                    </div>
                    <h4 class="mt-4">{{ $data['convenienceDataSum'] }}</h4>
                    <span class="">
                        <div class="progress mt-3 bg-white">
                            <div class="progress-bar bg-warning" role="progressbar"
                                style="width: {{ $data['conveniencePercentage']['conveniencePending'] }} ; border-top-left-radius: 20px;
                                border-bottom-left-radius: 20px;"
                                aria-valuenow="{{ $data['conveniencePercentage']['conveniencePending'] }}"
                                aria-valuemin="0" aria-valuemax="100">
                            </div>
                            <div class="progress-bar shape-progress bg-primary" role="progressbar"
                                style="width: {{ $data['conveniencePercentage']['conveniencePrecessing'] }}"
                                aria-valuenow="{{ $data['conveniencePercentage']['conveniencePrecessing'] }}"
                                aria-valuemin="0" aria-valuemax="100">
                            </div>
                            <div class="progress-bar " role="progressbar"
                                style="width: {{ $data['conveniencePercentage']['convenienceUnpaid'] }}; background: #9566F2;
"
                                aria-valuenow="{{ $data['conveniencePercentage']['convenienceUnpaid'] }}"
                                aria-valuemin="0" aria-valuemax="100">
                            </div>
                            <div class="progress-bar primary-color" role="progressbar"
                                style="width: {{ $data['conveniencePercentage']['conveniencePaid'] }} "
                                aria-valuenow="{{ $data['conveniencePercentage']['conveniencePaid'] }}" aria-valuemin="0"
                                aria-valuemax="100">
                            </div>
                        </div>
                    </span>
                    <div class="row mt-4" style="padding-top: 24px;
">
                        <div class="col-md-12 d-flex justify-content-between">

                            <div class="fs-5 mt-1 ">
                                <span
                                    style="background-color: #FBBC06;padding: 0px 6px 0px 13px;margin-right: 4px;border-radius: 6px;"></span>
                                <span id="pending"> {{ $data['conveniencePercentage']['conveniencePending'] }}</span>
                                <p class="pt-3">Pending</p>

                            </div>
                            <div class="fs-5 mt-1">
                                <span
                                    style="    background-color: #6571FF;padding: 0px 6px 0px 13px;margin-right: 4px;border-radius: 6px;"></span>
                                <span id="pending">{{ $data['conveniencePercentage']['conveniencePrecessing'] }}</span>
                                <p class="pt-3">Processing</p>
                            </div>
                            <div class="fs-5 mb-2 mt-1">
                                <span
                                    style="    background-color: #9566F2;padding: 0px 6px 0px 13px;margin-right: 4px;border-radius: 6px;"></span>
                                <span id="unpaid">{{ $data['conveniencePercentage']['convenienceUnpaid'] }}</span>
                                <p class="pt-3">Unpaid</p>
                            </div>
                            <div class="fs-5 mt-1">
                                <span
                                    style="    background-color: #1E62E4;padding: 0px 6px 0px 13px;margin-right: 4px;border-radius: 6px;"></span>
                                <span id="paid">{{ $data['conveniencePercentage']['conveniencePaid'] }}</span>
                                <p class="pt-3">Successfully Paid</p>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div> <!-- row -->

    <!---------------------------------Convenience End------------------>
    <script>
        $(document).ready(function() {
            ////////////Bonus show month ways/////////////
            $('#monthSelect').on('change', function() {
                const selectedMonth = $(this).val();
                $.ajax({
                    url: '/get-month-bonus-data',
                    type: 'GET',
                    data: {
                        month: selectedMonth
                    },
                    success: function(response) {
                        // Update the UI with the dynamic data
                        $('#festivalBonus').text(response.festivalBonusesSum);
                        $('#performanceBonus').text(response.performanceBonusesSum);
                        $('#otherBonus').text(response.otherBonusesSum);
                        $('#inputFativalId').val(response.month);

                        console.log(response.month)
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data:', error);
                    }
                });
            });
            // dynamic bonus change
            $('#festivalClick').on('click', function() {
                const month = document.getElementById('monthSelect').value;

                $.ajax({
                    url: '/get-festival-percentage-data',
                    type: 'GET',
                    data: {
                        month: month
                    },
                    success: function(response) {
                        $('#paid').text(response.result.Paid);
                        $('#pending').text(response.result.Pending);
                        $('#unpaid').text(response.result.Unpaid);
                        $('#nameSelected').text("Festival Bonus");
                        $('#festivalClick').addClass('primary-color').removeClass(
                            'bg-color-white');
                        $('#performanceClick').removeClass('primary-color').addClass(
                            'bg-color-white');
                        $('#otherClick').removeClass('primary-color').addClass(
                            'bg-color-white');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data:', error);
                    }
                });
            });
            $('#performanceClick').on('click', function() {
                const month = document.getElementById('monthSelect').value;
                $.ajax({
                    url: '/get-performance-percentage-data',
                    type: 'GET',
                    data: {
                        month: month
                    },
                    success: function(response) {
                        $('#paid').text(response.result.Paid);
                        $('#pending').text(response.result.Pending);
                        $('#unpaid').text(response.result.Unpaid);
                        $('#nameSelected').text("Performance Bonus");
                        $('#performanceClick').addClass('primary-color').removeClass(
                            'bg-color-white');
                        $('#festivalClick').removeClass('primary-color').addClass(
                            'bg-color-white');
                        $('#otherClick').removeClass('primary-color').addClass(
                            'bg-color-white');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data:', error);
                    }
                });
            });
            $('#otherClick').on('click', function() {
                const month = document.getElementById('monthSelect').value;
                $.ajax({
                    url: '/get-other-percentage-data',
                    type: 'GET',
                    data: {
                        month: month
                    },
                    success: function(response) {
                        $('#paid').text(response.result.Paid);
                        $('#pending').text(response.result.Pending);
                        $('#unpaid').text(response.result.Unpaid);
                        $('#nameSelected').text("Other Bonus");
                        $('#festivalClick').removeClass('primary-color').addClass(
                            'bg-color-white');
                        $('#performanceClick').removeClass('primary-color').addClass(
                            'bg-color-white');
                        $('#otherClick').addClass('primary-color').removeClass(
                            'bg-color-white');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data:', error);
                    }
                });
            });
            // End Percentage bonus change
            ////////////Convenience show month ways/////////////
            $('#conveniencemonthSelect').on('change', function() {
                const selectedMonth = $(this).val();
                $.ajax({
                    url: '/get-month-convenience-data',
                    type: 'GET',
                    data: {
                        month: selectedMonth
                    },
                    success: function(response) {
                        // Update the UI with the dynamic data
                        $('#movementCost').text(response.movementCost);
                        $('#overNightCost').text(response.overNightCost);
                        $('#foodingCost').text(response.foodingCost);
                        $('#otherCost').text(response.otherCost);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data:', error);
                    }
                });
            });

            ///////////////////////////// apexDonut Chart////////////////////////////////
            // $(function() {
            //     'use strict';

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
            //     var paySlipsPercentages = @json($data['paySlipsPercentage']);
            //     // console.log( paySlipsPercentages.paySlipPaid);
            //     var fontFamily = "'Roboto', Helvetica, sans-serif";

            //     if ($('#apexDonut').length) {
            //         var options = {
            //             chart: {
            //                 height: 300,
            //                 type: "donut",
            //                 foreColor: colors.bodyColor,
            //                 background: colors.cardBg,
            //                 toolbar: {
            //                     show: false
            //                 },
            //             },
            //             theme: {
            //                 mode: 'dark'
            //             },
            //             tooltip: {
            //                 theme: 'dark'
            //             },
            //             stroke: {
            //                 colors: ['rgba(0,0,0,0)']
            //             },
            //             colors: [colors.primary, colors.warning, colors.danger, colors.info],
            //             legend: {
            //                 show: true,
            //                 position: "top",
            //                 horizontalAlign: 'center',
            //                 fontFamily: fontFamily,
            //                 itemMargin: {
            //                     horizontal: 8,
            //                     vertical: 0
            //                 },
            //             },
            //             dataLabels: {
            //                 enabled: false
            //             },
            //             series: [
            //                 parseFloat(paySlipsPercentages.paySlipPaid),
            //                 parseFloat(paySlipsPercentages.paySlipPending),
            //                 parseFloat(paySlipsPercentages.paySlipUnpaid),
            //                 parseFloat(paySlipsPercentages.paySlipProcessing)
            //                 ],
            //             labels: ['Paid', 'Pending', 'Unpaid', 'Processing']
            //         };

            //         var chart = new ApexCharts(document.querySelector("#apexDonut"), options);
            //         chart.render();
            //     }
            // });


        }); //
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
                        parseFloat(data.paySlipProcessing);

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
                        dataLabels: {
                            enabled: false
                        },
                        series: total > 0 ? [
                            parseFloat(data.paySlipPaid),
                            parseFloat(data.paySlipPending),
                            parseFloat(data.paySlipUnpaid),
                            parseFloat(data.paySlipProcessing)
                        ] : [1],
                        labels: total > 0 ? ['Paid', 'Pending', 'Unpaid', 'Processing'] : ['No Data'],
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

    <script>
        /////////////////////////////////////Area chart////////////////////////////////////
        $(document).ready(function() {
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
                $.plot($('#flotArea'), [{
                        label: 'iPhone',
                        data: [
                            ["2010.Q1", 35],
                            ['2010.Q2', 67],
                            ['2010.Q3', 13],
                            ['2010.Q4', 45]
                        ]
                    },
                    {
                        label: 'iTouch',
                        data: [
                            ['2010.Q1', 32],
                            ['2010.Q2', 49],
                            ['2010.Q3', 25],
                            ['2010.Q4', 57]
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

                    xaxis: {
                        mode: 'categories',
                        tickColor: colors.gridBorder
                    },
                    yaxis: {
                        tickColor: colors.gridBorder
                    },
                    legend: {
                        backgroundColor: colors.cardBg
                    },

                    tooltip: {
                        show: true,
                        content: '%s: %y'
                    },

                    colors: [colors.danger, colors.primary]
                });
            });
        });
    </script>
    <script src="{{ asset('assets') }}/vendors/jquery.flot/jquery.flot.js"></script>
    <script src="{{ asset('assets') }}/vendors/jquery.flot/jquery.flot.resize.js"></script>
    <script src="{{ asset('assets') }}/vendors/jquery.flot/jquery.flot.pie.js"></script>
    <script src="{{ asset('assets') }}/vendors/jquery.flot/jquery.flot.categories.js"></script>
    <!-- End plugin js for this page -->

    <!-- Custom js for this page -->
    <script src="{{ asset('assets') }}/js/jquery.flot-light.js"></script>
@endsection
