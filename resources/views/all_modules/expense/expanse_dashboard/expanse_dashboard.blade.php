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

    <div class="d-flex mb-2">
        <div class="card  ">
            <div class="card-body">
                <h3>This Month spend</h3>
                <p>
                <a href=""></a>
                <a href=""></a>
                <a href=""></a>
                <a href=""></a>
                <a href=""></a>
                <a href=""></a>
            </p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h3>$22,149,00</h3>
                <p class="mt-2">Total Spend</p>
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
