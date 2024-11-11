@extends('master')
@section('title')
    | {{ $primaryLedger->group_name ?? '' }} Details
@endsection
@section('admin')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ $primaryLedger->group_name ?? '' }} Details
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

                            <a href="{{ route('expense.view') }}"
                                class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
                                <i class="btn-icon-prepend" data-feather="dollar-sign"></i>
                                Expanse
                            </a>
                            @if ($primaryLedger->group_name == 'Asset')
                                <a href="{{ route('transaction') }}"
                                    class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
                                    <i class="btn-icon-prepend" data-feather="repeat"></i>
                                    Transaction
                                </a>
                            @endif
                            @if ($primaryLedger->group_name == 'Asset')
                                <a href="{{ route('bank') }}"
                                    class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
                                    <i class="btn-icon-prepend" data-feather="aperture"></i>
                                    Bank
                                </a>
                            @endif
                            <a href="{{ route('loan') }}" class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
                                <i class="btn-icon-prepend" data-feather="plus-circle"></i>
                                Loan
                            </a>
                            <button type="button" class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0"
                                data-bs-toggle="modal" data-bs-target="#ledgerModal">
                                <i class="btn-icon-prepend" data-feather="plus"></i>
                                Add Ledger
                            </button>
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
                                                <td><b><i>Primary Ledger</i></b></td>
                                                <td>{{ $primaryLedger->group_name ?? '' }}</td>
                                                <td>
                                                    <b><i>Total Ledger</i></b>
                                                </td>
                                                <td>{{ $ledgers->count() ?? 0 }}</td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-md-12">
                                <h5 class="my-2 text-center">Ledger Info</h5>
                                <div class="table-responsive">
                                    <table id="myDataTable" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>Ledger</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="show_ledger_data">

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
    <div class="modal fade" id="ledgerModal" tabindex="-1" aria-labelledby="exampleModalScrollableTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Add Ledger</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form id="signupForm" class="ledgerForm row">
                        <input type="hidden" value="{{ $primaryLedger->id }}" name="group_id">
                        <div class="mb-3 col-md-12">
                            <label for="name" class="form-label">Ledger Name<span class="text-danger">*</span></label>
                            <input class="form-control account_name" name="account_name" type="text"
                                onkeyup="errorRemove(this);">
                            <span class="text-danger account_name_error"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary modal_close" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save_ledger">Save</button>
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



            // save all Ledger information
            const saveLedger = document.querySelector('.save_ledger');
            saveLedger.addEventListener('click', function(e) {
                e.preventDefault();
                let formData = new FormData($('.ledgerForm')[0]);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/all-ledger/store',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.status == 200) {
                            $('#ledgerModal').modal('hide');
                            $('.ledgerForm')[0].reset();
                            allLedgerView();
                            toastr.success(res.message);
                        } else {
                            if (res.error.account_name) {
                                showError('.account_name', res.error.account_name);
                            }
                            if (res.error.group_id) {
                                showError('.group_id', res.error.group_id);
                            }
                        }
                    }
                });
            })


            // all Ledger View Function
            function allLedgerView() {
                let id = '{{ $primaryLedger->id }}';
                $.ajax({
                    url: '/all-ledger/view/category-wise/' + id,
                    method: 'GET',
                    success: function(res) {
                        // console.log(res);
                        const ledgers = res.data;
                        $('.show_ledger_data').empty();
                        if ($.fn.DataTable.isDataTable('#myDataTable')) {
                            $('#myDataTable').DataTable().clear().destroy();
                        }
                        if (ledgers.length > 0) {
                            $.each(ledgers, function(index, ledger) {
                                // Calculate the sum of account_transaction balances
                                const tr = document.createElement('tr');
                                tr.innerHTML = `
                                    <td>
                                        ${index+1}
                                    </td>
                                    <td>
                                        <a href="/all-ledger/details/${ledger.id}" >${ledger.account_name ?? ""}</a>
                                    </td>
                                    <td>
                                        <a href="/all-ledger/details/${ledger.id}" class="btn btn-icon btn-xs btn-primary">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="#" class="btn btn-icon btn-xs btn-success">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="#" class="btn btn-icon btn-xs btn-danger">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </td>
                                `;
                                $('.show_ledger_data').append(tr);
                            });
                        } else {
                            $('.show_ledger_data').html(`
                                <tr>
                                    <td colspan='9'>
                                        <div class="text-center text-warning mb-2">Data Not Found</div>
                                        <div class="text-center">
                                            <button class="btn btn-xs btn-primary" data-bs-toggle="modal" data-bs-target="#ledgerModal">Add Al Ledger Info<i data-feather="plus"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            `);
                        }
                        dynamicDataTableFunc('myDataTable');
                    }
                });
            }
            allLedgerView();

        })

        // print
        document.querySelector('.print-btn').addEventListener('click', function(e) {
            e.preventDefault();
            $('#dataTableExample').removeAttr('id');
            $('.table-responsive').removeAttr('class');
            // Trigger the print function
            window.print();
        });

        document.addEventListener("DOMContentLoaded", function() {
            // modal not close function
            modalShowHide('ledgerModal');
        })
    </script>
@endsection
