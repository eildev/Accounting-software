@extends('master')
@section('title')
    | {{ $data->account_name ?? ($data->cash_account_name ?? ($isBank ? 'Bank Details' : 'Cash Details')) }}
@endsection
@section('admin')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ $isBank ? 'Bank' : 'Cash' }} Details

            </li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card border-0 shadow-none">
                <div class="card-body">
                    <div class="container-fluid d-flex justify-content-between">
                        <div class="col-lg-3 ps-0">
                            @if (!empty($invoice_logo_type))
                                @if ($invoice_logo_type == 'Name')
                                    <a href="#" class="noble-ui-logo logo-light d-block mt-3">{{ $siteTitle }}</a>
                                @elseif($invoice_logo_type == 'Logo')
                                    @if (!empty($logo))
                                        <img class="margin_left_m_14" height="100" width="200"
                                            src="{{ url($logo) }}" alt="logo">
                                    @else
                                        <p class="mt-1 mb-1 show_branch_name"><b>{{ $siteTitle }}</b></p>
                                    @endif
                                @elseif($invoice_logo_type == 'Both')
                                    @if (!empty($logo))
                                        <img class="margin_left_m_14" height="90" width="150"
                                            src="{{ url($logo) }}" alt="logo">
                                    @endif
                                    <p class="mt-1 mb-1 show_branch_name"><b>{{ $siteTitle }}</b></p>
                                @endif
                            @else
                                <a href="#" class="noble-ui-logo logo-light d-block mt-3">EIL<span>Accounts</span></a>
                            @endif
                            <hr>
                            <p class="show_branch_address">{{ $branch->address ?? '' }}</p>
                            <p class="show_branch_email">{{ $branch->email ?? '' }}</p>
                            <p class="show_branch_phone">{{ $branch->phone ?? '' }}</p>
                        </div>
                        <div>
                            <button type="button"
                                class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0 print-btn">
                                <i class="btn-icon-prepend" data-feather="printer"></i>
                                Print
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body show_ledger">
                    <div class="container-fluid w-100">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            @if ($isBank)
                                                <tr>
                                                    <td>
                                                        <b><i>Account Name</i></b>
                                                    </td>
                                                    <td>
                                                        {{ $data->account_name ?? '' }}
                                                    </td>
                                                    <td><b><i>Bank Account Number</i></b></td>
                                                    <td>{{ $data->account_number ?? '' }}</td>
                                                    <td>
                                                        <b><i>Bank Name</i></b>
                                                    </td>
                                                    <td>{{ $data->bank_name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <b><i>Bank Branch Name</i></b>
                                                    </td>
                                                    <td>{{ $data->bank_branch_name }}</td>
                                                    <td>
                                                        <b><i>Initial Balance</i></b>
                                                    </td>
                                                    <td>{{ number_format($data->initial_balance, 2) ?? 0 }}</td>
                                                    <td>
                                                        <b><i>Current Balance</i></b>
                                                    </td>
                                                    <td>{{ number_format($data->current_balance, 2) ?? 0 }}</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <b><i>Currency Code</i></b>
                                                    </td>
                                                    <td>{{ $data->currency_code ?? 0 }}</td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td>
                                                        <b><i>Cash Account Name</i></b>
                                                    </td>
                                                    <td>
                                                        {{ $data->cash_account_name ?? '' }}
                                                    </td>
                                                    <td>
                                                        <b><i>Opening Balance</i></b>
                                                    </td>
                                                    <td>{{ number_format($data->opening_balance, 2) ?? 0 }}</td>
                                                    <td>
                                                        <b><i>Current Balance</i></b>
                                                    </td>
                                                    <td>{{ number_format($data->current_balance, 2) ?? 0 }}</td>
                                                </tr>
                                            @endif
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-md-12">
                                <h5 class="my-2 text-center">Total {{ $isBank ? 'Bank' : 'Cash' }} Transaction</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Instalment No.</th>
                                                <th>Date</th>
                                                <th>Payment Method</th>
                                                <th>Principal Paid</th>
                                                <th>Interest Paid</th>
                                                <th>Total Paid</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        #printFrame {
            display: none;
            /* Hide the iframe */
        }

        .table> :not(caption)>*>* {
            padding: 0px 10px !important;
        }

        .margin_left_m_14 {
            margin-left: -14px;
        }

        .w_40 {
            width: 250px !important;
            text-wrap: wrap;
        }

        @media print {
            .page-content {
                margin-top: 0 !important;
                padding-top: 0 !important;
                min-height: 740px !important;
                background-color: #ffffff !important;
            }

            .grid-margin,
            .card,
            .card-body,
            table {
                background-color: #ffffff !important;
                color: #000 !important;
            }

            .footer_invoice p {
                font-size: 12px !important;
            }

            button,
            a,
            .filter_box,
            nav,
            .footer,
            .id,
            .dataTables_filter,
            .dataTables_length,
            .dataTables_info {
                display: none !important;
            }
        }
    </style>

    <script>
        // print
        document.querySelector('.print-btn').addEventListener('click', function(e) {
            e.preventDefault();
            $('#dataTableExample').removeAttr('id');
            $('.table-responsive').removeAttr('class');
            // Trigger the print function
            window.print();
        });
    </script>
@endsection
