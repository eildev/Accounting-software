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

        .primary-color {
            background-color: #1E62E4;
            color: #fff
        }

        .primary-color-text {
            color: #1E62E4
        }

        .secondary-color {
            background-color: #FAFAFA;

        }
        .btn:hover{
        background-color: #1E62E4;
        color: #fff
        }
        .Payroll-border{
            border: 1px solid #EBEFEC
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

.custom-table th,
.custom-table td {
    padding: 12px;
    border: 1px solid #ddd;
}

.custom-table thead {
    background-color: #f5f5f5;
}

.custom-table th {
    font-weight: bold;
}

.custom-table tbody tr:hover {
    background-color: #f9f9f9;
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
    background-color: #ffc107; /* Yellow for delayed */
    color: #000;
}

.badge.paid {
    background-color: #28a745; /* Green for paid */
}

/* Pagination Styling */
.pagination {
    display: flex;
    justify-content: space-between;
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
                        <div class="flot-chart" id="flotArea1"></div>
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
    <!-------------------------Bonus----------------------------->
    <div class="row">
        <div class="col-12 col-md-6 col-lg-6 col-xl-6  grid-margin primary-color-text stretch-card">
            <div class="card ">
                <div class="card-body secondary-color">
                    <div class="d-flex justify-content-between">
                        <h4>All Bonus</h4>
                        <div>
                            <div class="form-group primary-color-text">

                                <select class="form-control primary-color-text" id="monthSelect">
                                    <option disabled selected class="bg-white" value="{{ Carbon\Carbon::now()->format('m') }}">
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
                                <span class="primary-color-text"><img src="{{ asset('uploads/payroll_dashboard/bonus_icon/Group000003486.png') }}"
                                        alt="Bonus Iocn" height="60px"></span>
                                <span class="fs-5 me-2"><i class="fas fa-chevron-right"></i></span>
                            </div>
                            <h6 class="mb-2 ">Festival Bonus</h6>
                            <h4 id="festivalBonus">{{$data['festivalBonusesSum']}}</h4>
                        </div>

                        <div class="card-body rounded-3 bg-white " id="performanceClick">
                            <div class="d-flex justify-content-between align-items-center  mb-3" >
                                <span><img src="{{ asset('uploads/payroll_dashboard/bonus_icon/bonus-icon-2.png') }}"
                                        alt="Bonus Iocn" height="60px"></span>
                                <span class="fs-5 me-2"><i class="fas fa-chevron-right"></i></span>
                            </div>
                            <h6 class="mb-2 ">Performance Bonus</h6>
                            <h4 id="performanceBonus">{{$data['performanceBonusesSum']}}</h4>
                        </div>

                        <div class="card-body bg-white rounded-3 " id="otherClick">
                            <div class="d-flex justify-content-between align-items-center   mb-3" >
                                <span><img src="{{ asset('uploads/payroll_dashboard/bonus_icon/bonus-icon-2.png') }}"
                                        alt="Bonus Iocn" height="60px"></span>
                                <span class="fs-5 me-2"><i class="fas fa-chevron-right"></i></span>
                            </div>
                            <h6 class="mb-2 ">Other Bonus</h6>
                            <h4 id="otherBonus">{{$data['otherBonusesSum']}}</h4>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md 6 col-lg-6 col-xl-6 primary-color-text">
            <div class="card">
                <div class="card-body secondary-color">
                    <div class="d-flex justify-content-between ">
                        <h4 id="nameSelected">Festival Bonus</h4>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-4 col-lg-4 text-lign-center">
                            <span>
                                <div class="card">
                                    <div class="card-body">
                                        <div id="apexDonut"></div>
                                    </div>
                                  </div>
                            </span>
                        </div>
                            <div class="col-md-8 col-lg-8">
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
                        <button class="btn primary-color px-6">See Other Bonus</button>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- row -->
        <!-------------------------Bonus End----------------------------->
        <!-------------------------Recent Payroll----------------------------->
        <div class="row bg-white">
            <div class="col-md-12  p-3 Payroll-border">
               <div class=" d-flex justify-content-between">
                <h3>Recent Payroll</h3>
                <button class="btn Payroll-border">See All</button>
               </div>
               <div class="table-container">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Full Name</th>
                            <th>Position</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>John Doe</td>
                            <td>Software Engineer</td>
                            <td>27/12/2023</td>
                            <td><span class="badge delayed">Delayed</span></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Jane Smith</td>
                            <td>Marketing Specialist</td>
                            <td>25/12/2023</td>
                            <td><span class="badge paid">Paid</span></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Michael Brown</td>
                            <td>Product Manager</td>
                            <td>25/12/2023</td>
                            <td><span class="badge paid">Paid</span></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Emily Davis</td>
                            <td>UI/UX Designer</td>
                            <td>24/12/2023</td>
                            <td><span class="badge delayed">Delayed</span></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Chris Wilson</td>
                            <td>Data Analyst</td>
                            <td>23/12/2023</td>
                            <td><span class="badge paid">Paid</span></td>
                        </tr>
                    </tbody>
                </table>
                <div class="pagination">
                    <button class="prev-btn">← Previous</button>
                    <div class="page-numbers">
                        <button class="page-btn active">1</button>
                        <button class="page-btn">2</button>
                        <button class="page-btn">3</button>
                        <button class="page-btn">4</button>
                        <button class="page-btn">5</button>
                    </div>
                    <button class="next-btn">Next →</button>
                </div>
            </div>

            </div>
        </div>
          <!-------------------------Recent Payroll End----------------------------->
    <script>


        $(document).ready(function() {
                ////////////Bonus show month ways/////////////
        $('#monthSelect').on('change', function () {
            const selectedMonth = $(this).val();
            $.ajax({
                url: '/get-month-bonus-data',
                type: 'GET',
                data: { month: selectedMonth },
                success: function (response) {
                    // Update the UI with the dynamic data
                    $('#festivalBonus').text(response.festivalBonusesSum);
                    $('#performanceBonus').text(response.performanceBonusesSum);
                    $('#otherBonus').text(response.otherBonusesSum);
                    $('#inputFativalId').val(response.month);

                    console.log(response.month)
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        });
        // dynamic bonus change
        $('#festivalClick').on('click', function () {
            const month = document.getElementById('monthSelect').value ;

            $.ajax({
                url: '/get-festival-percentage-data',
                type: 'GET',
                data: { month: month },
                success: function (response) {
                    $('#paid').text(response.result.Paid);
                    $('#pending').text(response.result.Pending);
                    $('#unpaid').text(response.result.Unpaid);
                    $('#nameSelected').text("Festival Bonus");
                    $('#festivalClick').addClass('primary-color').removeClass('bg-white');
                    $('#performanceClick').removeClass('primary-color').addClass('bg-white');
                    $('#otherClick').removeClass('primary-color').addClass('bg-white');
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        });
        $('#performanceClick').on('click', function () {
            const month = document.getElementById('monthSelect').value ;
        $.ajax({
            url: '/get-performance-percentage-data',
            type: 'GET',
            data: { month: month },
            success: function (response) {
                $('#paid').text(response.result.Paid);
                $('#pending').text(response.result.Pending);
                $('#unpaid').text(response.result.Unpaid);
                $('#nameSelected').text("Performance Bonus");
                $('#performanceClick').addClass('primary-color').removeClass('bg-white');
                $('#festivalClick').removeClass('primary-color').addClass('bg-white');
                $('#otherClick').removeClass('primary-color').addClass('bg-white');

            },
            error: function (xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
        });
        $('#otherClick').on('click', function () {
            const month = document.getElementById('monthSelect').value ;
        $.ajax({
            url: '/get-other-percentage-data',
            type: 'GET',
            data: { month: month },
            success: function (response) {
                $('#paid').text(response.result.Paid);
                $('#pending').text(response.result.Pending);
                $('#unpaid').text(response.result.Unpaid);
                $('#nameSelected').text("Other Bonus");
                $('#festivalClick').removeClass('primary-color').addClass('bg-white');
                $('#performanceClick').removeClass('primary-color').addClass('bg-white');
                $('#otherClick').addClass('primary-color').removeClass('bg-white');
            },
            error: function (xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
        });
        // dynamic bonus change
            // Area Chart
            $.plot($('#flotArea1'), [{
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
            //Donut

        });//
    </script>
    <script src="{{ asset('assets') }}/vendors/jquery.flot/jquery.flot.js"></script>
    <script src="{{ asset('assets') }}/vendors/jquery.flot/jquery.flot.resize.js"></script>
    <script src="{{ asset('assets') }}/vendors/jquery.flot/jquery.flot.pie.js"></script>
    <script src="{{ asset('assets') }}/vendors/jquery.flot/jquery.flot.categories.js"></script>
    <!-- End plugin js for this page -->

    <!-- Custom js for this page -->
    <script src="{{ asset('assets') }}/js/jquery.flot-light.js"></script>
@endsection
