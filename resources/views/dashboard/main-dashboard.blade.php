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
        /* General Table Styling */
        .dashboard_card_title {
            color: #878C90 !important;
        }

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
    </style>
    <div class="row mb-2">
        <div class="col-md-3 mb-2">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <h6 class="mb-2 dashboard_card_title">Assets</h6>
                            <div class="d-flex">
                                <h3 class="me-2 ">{{ number_format($assetValue, 2) }}</h3>
                                {{-- <span class="mt-2">10%</span> --}}
                            </div>
                        </div>
                        <div class="col-4 m-0 p-0  text-end">
                            <img src="{{ asset('assets/images/assets.png') }}" alt="Assets">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <h6 class="mb-2 dashboard_card_title">Liabilities</h6>
                            <div class="d-flex">
                                <h3 class="me-2">{{ number_format($liabilities, 2) }}</h3>
                                {{-- <span class="mt-2">+2.01%</span> --}}
                            </div>
                        </div>
                        <div class="col-4 m-0 p-0  text-end">
                            <img src="{{ asset('assets/images/liabilities.png') }}" alt="liabilities">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <h6 class="mb-2 dashboard_card_title">Income</h6>
                            <div class="d-flex">
                                <h3 class="me-2">{{ number_format($income, 2) }}</h3>
                                {{-- <span class="mt-2">+2.01%</span> --}}
                            </div>
                        </div>
                        <div class="col-4 m-0 p-0  text-end">
                            <img src="{{ asset('assets/images/income.png') }}" alt="income">
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <h6 class="mb-2 dashboard_card_title">Expense</h6>
                            <div class="d-flex">
                                <h3 class="me-2">{{ number_format($expanse, 2) }}</h3>
                                {{-- <span class="mt-2">+2.01%</span> --}}
                            </div>
                        </div>
                        <div class="col-4 m-0 p-0  text-end">
                            <img src="{{ asset('assets/images/expanse.png') }}" alt="expanse">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- ######################## profit vs loss Data chart  ############################## --}}
        <div class="col-md-7 grid-margin stretch-card">
            @include('dashboard.profit-loss')
        </div>
        {{-- ######################## sales-analytics Data chart  ############################## --}}
        <div class="col-md-5 grid-margin stretch-card">
            @include('dashboard.sales-analytics')
        </div>
        {{-- ######################## cash in and out Data chart  ############################## --}}
        <div class="col-md-8 grid-margin stretch-card">
            @include('dashboard.cash-in-out')
        </div>
        {{-- ######################## Purchase  Data chart  ############################## --}}
        <div class="col-md-4 grid-margin stretch-card">
            @include('dashboard.purchase')
        </div>

        {{-- ######################## Data Card  ############################## --}}
        <div class="col-md-7 grid-margin stretch-card">
            @include('dashboard.data-card')
        </div>
        {{-- ######################## Revenue Data chart  ############################## --}}
        <div class="col-md-5 grid-margin stretch-card">
            @include('dashboard.revenue')
        </div>
    </div>
@endsection
