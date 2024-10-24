@extends('master')
@section('title')
    | {{ $loan->loan_name }}
@endsection
@section('admin')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                Loan Ledger
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
                            @if ($loan->loan_balance > 0)
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
                                                <td>
                                                    <b><i>Loan Name</i></b>
                                                </td>
                                                <td>
                                                    {{ $loan->loan_name ?? '' }}
                                                </td>
                                                <td><b><i>Bank Account name</i></b></td>
                                                <td>{{ $loan->bankAccounts->account_name ?? '' }}</td>
                                                <td>
                                                    <b><i>Loan Principal</i></b>
                                                </td>
                                                <td>{{ $loan->loan_principal ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b><i>Loan Balance</i></b>
                                                </td>
                                                <td>{{ $loan->loan_balance ?? 00 }}</td>
                                                <td>
                                                    <b><i>Interest Rate</i></b>
                                                </td>
                                                <td>{{ $loan->interest_rate ?? '' }}</td>
                                                <td>
                                                    <b><i>Repayment Schedule</i></b>
                                                </td>
                                                <td>{{ $loan->repayment_schedule ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b><i>Loan Duration</i></b>
                                                </td>
                                                <td>{{ $loan->loan_duration ?? '' }}</td>
                                                <td>
                                                    <b><i>Start Date</i></b>
                                                </td>
                                                <td>{{ $loan->start_date ?? '' }}</td>
                                                <td>
                                                    <b><i>End Date</i></b>
                                                </td>
                                                <td>{{ $loan->end_date ?? '' }}</td>
                                            </tr>
                                        </thead>
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

        // // due Show 
        // function dueShow() {
        //     let dueAmountText = document.getElementById('due-amount').innerText.trim();
        //     let dueAmount = parseFloat(dueAmountText.replace(/[^\d.-]/g, ''));

        //     let paymentBalanceText = document.querySelector('.payment_balance').value.trim();
        //     let paymentBalance = parseFloat(paymentBalanceText)

        //     let remainingDue = dueAmount - (paymentBalance || 0);
        //     document.getElementById('remaining-due').innerText = remainingDue.toFixed(2) ?? 0 + ' ৳';

        // }


        // const savePayment = document.getElementById('add_payment');
        // savePayment.addEventListener('click', function(e) {
        //     // console.log('Working on payment')
        //     e.preventDefault();

        //     let formData = new FormData($('.addPaymentForm')[0]);
        //     // CSRF Token setup
        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });

        //     // AJAX request
        //     $.ajax({
        //         url: '/due/invoice/payment/transaction',
        //         type: 'POST',
        //         data: formData,
        //         processData: false,
        //         contentType: false,
        //         success: function(res) {
        //             console.log(res);
        //             if (res.status == 200) {
        //                 // Hide the correct modal
        //                 $('#duePayment').modal('hide');
        //                 // Reset the form
        //                 $('.addPaymentForm')[0].reset();
        //                 toastr.success(res.message);
        //                 window.location.reload();
        //             } else if (res.status == 400) {
        //                 showError('.account', res.message);
        //             } else {
        //                 // console.log(res);
        //                 if (res.error.payment_balance) {
        //                     showError('.payment_balance', res.error.payment_balance);
        //                 }
        //                 if (res.error.account) {
        //                     showError('.account', res.error.account);
        //                 }
        //             }
        //         },
        //         error: function(err) {
        //             toastr.error('An error occurred, Empty Feild Required.');
        //         }
        //     });
        // });


        // print
        document.querySelector('.print-btn').addEventListener('click', function(e) {
            e.preventDefault();
            $('#dataTableExample').removeAttr('id');
            $('.table-responsive').removeAttr('class');
            // Trigger the print function
            window.print();
        });


        // $('.print').click(function(e) {
        //     e.preventDefault();
        //     let id = $(this).attr('data-id');
        //     let type = $(this).attr('type');
        //     var printFrame = $('#printFrame')[0];



        //     // if (type == 'sale') {
        //     //     var printContentUrl = '/sale/invoice/' + id;
        //     // } else if (type == 'return') {
        //     //     var printContentUrl = '/return/products/invoice/' + id;
        //     // } else if (type == 'purchase') {
        //     //     var printContentUrl = '/purchase/invoice/' + id;
        //     // } else {
        //     //     var printContentUrl = '/transaction/invoice/receipt/' + id;
        //     // }

        //     $('#printFrame').attr('src', printContentUrl);
        //     printFrame.onload = function() {
        //         printFrame.contentWindow.focus();
        //         printFrame.contentWindow.print();
        //     };
        // })
    </script>
@endsection
