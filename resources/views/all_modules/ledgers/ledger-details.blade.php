@extends('master')
@section('title')
    | {{ $ledger->account_name ?? '' }} Details
@endsection
@section('admin')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ $ledger->account_name ?? '' }} Details
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
                                            <tr>

                                                <td><b><i>Ledger</i></b></td>
                                                <td>{{ $ledger->account_name ?? '' }}</td>
                                                <td>
                                                    <b><i>Primary Ledger</i></b>
                                                </td>
                                                <td>
                                                    {{ $ledger->ledgerGroup->group_name ?? '' }}
                                                </td>
                                                <td>
                                                    <b><i>Total Sub Ledger</i></b>
                                                </td>
                                                <td>{{ $subLedgers->count() }}</td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-md-12">
                                <h5 class="my-2 text-center">Sub Ledger</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>Sub Ledger</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($subLedgers->count() > 0)
                                                @foreach ($subLedgers as $index => $subLedger)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $subLedger->sub_ledger_name ?? '' }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>2" class="text-center">No Data Found</td>
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


    <!-- Add Sub Ledger Modal -->
    <div class="modal fade" id="subLedgerModal" tabindex="-1" aria-labelledby="exampleModalScrollableTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Add Ledger</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form id="signupForm" class="subLedgerForm row">
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Sub Ledger Name<span
                                    class="text-danger">*</span></label>
                            <input class="form-control sub_ledger_name" name="sub_ledger_name" type="text"
                                onkeyup="errorRemove(this);">
                            <span class="text-danger sub_ledger_name_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Primary Ledger<span
                                    class="text-danger">*</span></label>
                            <select class="form-control account_id" name="account_id" onchange="errorRemove(this);">
                                <option value="">Select Primary Ledger</option>

                            </select>
                            <span class="text-danger account_id_error"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary modal_close" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save_sub_ledger">Save</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        #printFrame,
        .action {
            display: none !important;
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
        // error remove
        function errorRemove(element) {
            if (element.value != '') {
                $(element).siblings('span').hide();
                $(element).css('border-color', 'green');
            }
        }


        $(document).ready(function() {

            // show error
            function showError(name, message) {
                $(name).css('border-color', 'red'); // Highlight input with red border
                $(name).focus(); // Set focus to the input field
                $(`${name}_error`).show().text(message); // Show error message
            }



            // select primaryLedgerViewOnSelectTag function 
            function ledgerViewOnSelectTag() {
                $.ajax({
                    url: '/all-ledger/view',
                    method: 'GET',
                    success: function(res) {
                        const primaryLedgers = res.data;
                        if (primaryLedgers.length > 0) {
                            $('.account_id').html(
                                `<option selected disabled>Select Ledger</option>`
                            ); // Clear and set default option
                            $.each(primaryLedgers, function(index, ledger) {
                                $('.account_id').append(
                                    `<option value="${ledger.id}">${ledger.account_name ?? "" }</option>`
                                );
                            });
                        } else {
                            $('.group_id').html(
                                `<option selected disabled>No Ledger Found</option>`
                            ); // Clear and set default option
                        }
                    }
                })
            }
            ledgerViewOnSelectTag();

            // save all Ledger information
            const saveSubLedger = document.querySelector('.save_sub_ledger');
            saveSubLedger.addEventListener('click', function(e) {
                e.preventDefault();
                let formData = new FormData($('.subLedgerForm')[0]);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/sub-ledger/store',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.status == 200) {
                            $('#subLedgerModal').modal('hide');
                            $('.subLedgerForm')[0].reset();
                            subLedgerView();
                            toastr.success(res.message);
                        } else {
                            if (res.error.sub_ledger_name) {
                                showError('.sub_ledger_name', res.error.sub_ledger_name);
                            }
                            if (res.error.account_id) {
                                showError('.account_id', res.error.account_id);
                            }
                        }
                    }
                });
            })

        })

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
