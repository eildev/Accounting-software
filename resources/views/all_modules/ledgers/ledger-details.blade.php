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
                            @if ($ledger->account_name == 'Expanse')
                                <a href="{{ route('expense.view') }}"
                                    class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
                                    <i class="btn-icon-prepend" data-feather="dollar-sign"></i>
                                    Expanse
                                </a>
                            @endif
                            @if ($ledger->account_name == 'Convenience Bill')
                                <a href="{{ route('convenience') }}"
                                    class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
                                    <i class="btn-icon-prepend" data-feather="dollar-sign"></i>
                                    Convenience Bill
                                </a>
                            @endif
                            @if ($ledger->account_name == 'Recurring Expanse')
                                <a href="{{ route('expense.recurring') }}"
                                    class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
                                    <i class="btn-icon-prepend" data-feather="dollar-sign"></i>
                                    Recurring Expanse
                                </a>
                            @endif

                            @if ($ledger->account_name == 'Fixed Asset')
                                <a href="#" class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
                                    <i class="btn-icon-prepend" data-feather="repeat"></i>
                                    Fixed Assets
                                </a>
                            @endif
                            @if ($ledger->account_name == 'Banks')
                                <a href="{{ route('bank') }}"
                                    class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
                                    <i class="btn-icon-prepend" data-feather="aperture"></i>
                                    Banks
                                </a>
                            @endif
                            @if ($ledger->account_name == 'Cash')
                                <a href="{{ route('bank') }}"
                                    class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
                                    <i class="btn-icon-prepend" data-feather="dollar-sign"></i>
                                    Cash
                                </a>
                            @endif
                            @if ($ledger->account_name == 'Loans')
                                <a href="{{ route('loan') }}"
                                    class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
                                    <i class="btn-icon-prepend" data-feather="dollar-sign"></i>
                                    Loan
                                </a>
                            @endif
                            <button type="button" class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0"
                                data-bs-toggle="modal" data-bs-target="#subLedgerModal">
                                <i class="btn-icon-prepend" data-feather="plus"></i>
                                Add Sub Ledger
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
                                    <table id="myDataTable" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>Sub Ledger</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="show_sub_ledger_data">

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
                        <input type="hidden" name="account_id" value="{{ $ledger->id }}">
                        <div class="mb-3 col-md-12">
                            <label for="name" class="form-label">Sub Ledger Name<span
                                    class="text-danger">*</span></label>
                            <input class="form-control sub_ledger_name" name="sub_ledger_name" type="text"
                                onkeyup="errorRemove(this);">
                            <span class="text-danger sub_ledger_name_error"></span>
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

            // all Ledger View Function
            function subLedgerView() {
                let id = '{{ $ledger->id }}';
                $.ajax({
                    url: '/sub-ledger/view/category-wise/' + id,
                    method: 'GET',
                    success: function(res) {
                        // console.log(res);
                        const subLedgers = res.data;
                        $('.show_sub_ledger_data').empty();
                        if ($.fn.DataTable.isDataTable('#myDataTable')) {
                            $('#myDataTable').DataTable().clear().destroy();
                        }
                        if (subLedgers.length > 0) {
                            $.each(subLedgers, function(index, subLedger) {
                                // Calculate the sum of account_transaction balances
                                const tr = document.createElement('tr');
                                tr.innerHTML = `
                                    <td>
                                        ${index+1}
                                    </td>
                                    <td>
                                        <a href="/sub-ledger/details/${subLedger.id}" >${subLedger.sub_ledger_name ?? ""}</a>
                                    </td>
                                    <td>
                                        <a href="/all-ledger/details/${subLedger.id}" class="btn btn-icon btn-xs btn-primary">
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
                                $('.show_sub_ledger_data').append(tr);
                            });
                        } else {
                            $('.show_sub_ledger_data').html(`
                                <tr>
                                    <td colspan='9'>
                                        <div class="text-center text-warning mb-2">Data Not Found</div>
                                        <div class="text-center">
                                            <button class="btn btn-xs btn-primary" data-bs-toggle="modal" data-bs-target="#subLedgerModal">Add Sub Ledger Info<i data-feather="plus"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            `);
                        }
                        dynamicDataTableFunc('myDataTable');
                    }
                });
            }
            subLedgerView();

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
