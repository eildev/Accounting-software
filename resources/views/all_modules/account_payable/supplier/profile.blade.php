@extends('master')
@section('title')
    | {{ $data->name }}
@endsection
@section('admin')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                Supplier Profile
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
                                <a href="#" class="noble-ui-logo logo-light d-block mt-3">EIL<span>Electro</span></a>
                            @endif
                            <hr>
                            <p class="show_branch_address">{{ $branch->address ?? '' }}</p>
                            <p class="show_branch_email">{{ $branch->email ?? '' }}</p>
                            <p class="show_branch_phone">{{ $branch->phone ?? '' }}</p>
                        </div>
                        <div>
                            @if ($data->receivable > 0)
                                <button type="button"
                                    class="btn btn-outline-primary btn-icon-text float-left add_money_modal"
                                    id="payment-btn" data-bs-toggle="modal" data-bs-target="#duePayment">
                                    <i class="btn-icon-prepend" data-feather="credit-card"></i>
                                    Payment
                                </button>
                            @endif
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
                                            <tr>
                                                <td>Account Of</td>
                                                <td>{{ $data->name ?? '' }}</td>
                                                <td>Address</td>
                                                <td>{{ $data->address ?? '' }}</td>
                                                <td>Contact No.</td>
                                                <td>{{ $data->phone ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Email</td>
                                                <td>{{ $data->email ?? '' }}</td>
                                                <td>Total Receivable</td>
                                                <td>{{ number_format($data->receivable ?? 0, 2) }}</td>
                                                <td>Total Paid</td>
                                                <td>{{ number_format($data->payable ?? 0, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td>Total Due</td>
                                                <td>{{ number_format($data->wallet_balance ?? 0, 2) }}</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h4 class="my-3 text-center">
                        Supplier Ledger
                    </h4>
                    <div class="container-fluid w-100">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th class="id">Invoice</th>
                                                <th>Total Quantity</th>
                                                <th>Total</th>
                                                <th>Paid</th>
                                                <th>Due</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @if ($purchaseReport->count() > 0)
                                                @foreach ($purchaseReport as $purchase)
                                                    <tr>
                                                        <td>{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('F j, Y') ?? '' }}
                                                        </td>
                                                        <td class="id">
                                                            <a href="{{ route('purchase.invoice', $purchase->id) }}">
                                                                #{{ $purchase->invoice ?? 0 }}
                                                            </a>
                                                        </td>
                                                        <td>
                                                            {{ $purchase->total_quantity ?? '' }}
                                                        </td>
                                                        <td>
                                                            {{ number_format($purchase->total_amount ?? 0, 2) }}
                                                        </td>
                                                        <td>
                                                            @if ($purchase->carrying_cost)
                                                                {{ number_format($purchase->paid ?? 0, 2) }}
                                                            @else
                                                                {{ number_format($purchase->paid ?? 0, 2) }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($purchase->carrying_cost)
                                                                {{ number_format($purchase->due - $purchase->carrying_cost ?? 0, 2) }}
                                                            @else
                                                                {{ number_format($purchase->due ?? 0, 2) }}
                                                            @endif
                                                        </td>

                                                        <td>
                                                            <span
                                                                class="badge text-capitalize {{ $purchase->status == 'completed' ? 'bg-success' : 'bg-danger' }}">
                                                                {{ $purchase->status ?? '' }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="7" class="text-center">No Data Found</td>
                                                </tr>
                                            @endif
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
    <iframe id="printFrame" src="" width="0" height="0"></iframe>


    <!-- Modal add Payment -->
    {{-- <div class="modal fade" id="duePayment" tabindex="-1" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Due Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form id="addPaymentForm" class="addPaymentForm row" method="POST">
                        <input type="hidden" name="data_id" id="data_id" value="{{ $data->id }}">
                        <input type="hidden" name="isCustomer" value="{{ $isCustomer }}">
                        <input type="hidden" name="due_amount" value="{{ $data->wallet_balance }}">
                        <div>
                            <label for="name" class="form-label">Due Amount : <span id="due-amount">
                                    {{ number_format($data->wallet_balance, 2) }}</span> ৳ </label> <br>
                            <label for="remaining" class="form-label">Remaining Due:
                                <span class="text-danger" id="remaining-due">
                                    {{ number_format($data->wallet_balance, 2) }} </span>৳
                            </label>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Balance Amount <span
                                    class="text-danger">*</span></label>
                            <input type="number" class="form-control add_amount payment_balance" name="payment_balance"
                                onkeyup="dueShow()" onkeydown="errorRemove(this);">
                            <span class="text-danger payment_balance_error"></span>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Transaction Account <span
                                    class="text-danger">*</span></label>
                            <select class="form-control account" name="account" id=""
                                onchange="errorRemove(this);">
                                @foreach ($banks as $bank)
                                    <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger account_error"></span>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a type="button" class="btn btn-primary" id="add_payment">Payment</a>
                </div>
                </form>
            </div>
        </div>
    </div> --}}
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
        // Error Remove Function 
        function errorRemove(element) {
            tag = element.tagName.toLowerCase();
            if (element.value != '') {
                // console.log('ok');
                if (tag == 'select') {
                    $(element).closest('.mb-3').find('.text-danger').hide();
                } else {
                    $(element).siblings('span').hide();
                    $(element).css('border-color', 'green');
                }
            }
        }

        // Show Error Function 
        function showError(payment_balance, message) {
            $(payment_balance).css('border-color', 'red');
            $(payment_balance).focus();
            $(`${payment_balance}_error`).show().text(message);
        }

        // due Show 
        function dueShow() {
            let dueAmountText = document.getElementById('due-amount').innerText.trim();
            let dueAmount = parseFloat(dueAmountText.replace(/[^\d.-]/g, ''));

            let paymentBalanceText = document.querySelector('.payment_balance').value.trim();
            let paymentBalance = parseFloat(paymentBalanceText)

            let remainingDue = dueAmount - (paymentBalance || 0);
            document.getElementById('remaining-due').innerText = remainingDue.toFixed(2) ?? 0 + ' ৳';

        }


        const savePayment = document.getElementById('add_payment');
        savePayment.addEventListener('click', function(e) {
            // console.log('Working on payment')
            e.preventDefault();

            let formData = new FormData($('.addPaymentForm')[0]);
            // CSRF Token setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // AJAX request
            $.ajax({
                url: '/due/invoice/payment/transaction',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    console.log(res);
                    if (res.status == 200) {
                        // Hide the correct modal
                        $('#duePayment').modal('hide');
                        // Reset the form
                        $('.addPaymentForm')[0].reset();
                        toastr.success(res.message);
                        window.location.reload();
                    } else if (res.status == 400) {
                        showError('.account', res.message);
                    } else {
                        // console.log(res);
                        if (res.error.payment_balance) {
                            showError('.payment_balance', res.error.payment_balance);
                        }
                        if (res.error.account) {
                            showError('.account', res.error.account);
                        }
                    }
                },
                error: function(err) {
                    toastr.error('An error occurred, Empty Feild Required.');
                }
            });
        });


        // print
        document.querySelector('.print-btn').addEventListener('click', function(e) {
            e.preventDefault();
            $('#dataTableExample').removeAttr('id');
            $('.table-responsive').removeAttr('class');
            // Trigger the print function
            window.print();
        });


        $('.print').click(function(e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let type = $(this).attr('type');
            var printFrame = $('#printFrame')[0];



            if (type == 'sale') {
                var printContentUrl = '/sale/invoice/' + id;
            } else if (type == 'return') {
                var printContentUrl = '/return/products/invoice/' + id;
            } else if (type == 'purchase') {
                var printContentUrl = '/purchase/invoice/' + id;
            } else {
                var printContentUrl = '/transaction/invoice/receipt/' + id;
            }

            $('#printFrame').attr('src', printContentUrl);
            printFrame.onload = function() {
                printFrame.contentWindow.focus();
                printFrame.contentWindow.print();
            };
        })
    </script>
@endsection
