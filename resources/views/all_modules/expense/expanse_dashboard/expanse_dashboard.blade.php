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
                            <p class="mb-2">Total Catagory</p>
                            <div class="d-flex">
                                <h3 class="me-2">{{ $expanseCatCount }}</h3> <span class="mt-2">10%</span>
                            </div>
                        </div>
                        <div class="col-4 m-0 p-0  text-end">
                            <img src="{{ asset('uploads/expense/catagory.png') }}" alt="Catagory">
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
                            <p class="mb-2">Total Ledger</p>
                            <div class="d-flex">
                                <h3 class="me-2">{{ $expanseledgerCount }}</h3> <span class="mt-2">+2.01%</span>
                            </div>
                        </div>
                        <div class="col-4 m-0 p-0  text-end">
                            <img src="{{ asset('uploads/expense/ledger.png') }}" alt="Catagory">
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
                            <p class="mb-2">Total Sub-Ledger</p>
                            <div class="d-flex">
                                <h3 class="me-2">20</h3> <span class="mt-2">+2.01%</span>
                            </div>
                        </div>
                        <div class="col-4 m-0 p-0  text-end">
                            <img src="{{ asset('uploads/expense/sub-ledger.png') }}" alt="sub-ledger">
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
                            <p class="mb-2">Total Invoices</p>
                            <div class="d-flex">
                                <h3 class="me-2">{{$expanseInvoiceCount}}</h3> <span class="mt-2">+2.01%</span>
                            </div>
                        </div>
                        <div class="col-4 m-0 p-0  text-end">
                            <img src="{{ asset('uploads/expense/invoice.png') }}" alt="invoice">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- //////////////////////Money Flow Chart//////////////////////// --}}
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            @include('all_modules.expense.expanse_dashboard.money_flow_chart')
        </div>
    </div>
    {{-- //////////////////////Spend by category//////////////////////// --}}
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            @include('all_modules.expense.expanse_dashboard.spend_category_chart')
        </div>
        <div class="col-md-6 grid-margin stretch-card">
            @include('all_modules.expense.expanse_dashboard.payment_status_chart')
        </div>
    </div>
    <div class="row bg-color-white" style="margin: 0px 0px 20px 0px">
        <div class="col-md-12  p-3 Payroll-border">
            @include('all_modules.expense.expanse_dashboard.month_activitie_table')
        </div>
    </div>
    <!-------------------------Salary Sheet End----------------------------->
@endsection
