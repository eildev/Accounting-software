@extends('master')
@section('title', '| Ledger Management')
@section('admin')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ledgers</li>
        </ol>
    </nav>
    <style>
        .nav-link:hover,
        .nav-link.active {
            color: #6587ff !important;
        }
    </style>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="example w-100">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab"
                            aria-controls="home" aria-selected="true">All Ledgers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab"
                            aria-controls="profile" aria-selected="false">Primary Ledgers</a>
                    </li>
                </ul>
                <div class="tab-content border border-top-0 p-3" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    @include('all_modules.ledgers.all-ledger')
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="card">
                            <div class="card-body">
                                @include('all_modules.ledgers.primary')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Add All Ledger Modal -->
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
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Ledger Name<span class="text-danger">*</span></label>
                            <input class="form-control account_name" name="account_name" type="text"
                                onkeyup="errorRemove(this);">
                            <span class="text-danger account_name_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Primary Ledger<span
                                    class="text-danger">*</span></label>
                            <select class="form-control group_id" name="group_id" onchange="errorRemove(this);">
                                <option value="">Select Primary Ledger</option>

                            </select>
                            <span class="text-danger group_id_error"></span>
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

    <!-- Add Primary Ledgers Modal -->
    <div class="modal fade" id="primaryLedgerModal" tabindex="-1" aria-labelledby="exampleModalScrollableTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Add Primary Ledger Info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form id="signupForm" class="primaryLedgerForm row">
                        <div class="mb-3 col-md-12">
                            <label for="name" class="form-label">Primary Ledger Name <span
                                    class="text-danger">*</span></label>
                            <input class="form-control group_name" name="group_name" type="text"
                                onkeyup="errorRemove(this);">
                            <span class="text-danger group_name_error"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary modal_close" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save_primary_ledger">Save</button>
                </div>
            </div>
        </div>
    </div>







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
            function primaryLedgerViewOnSelectTag() {
                $.ajax({
                    url: '/ledger/view',
                    method: 'GET',
                    success: function(res) {

                        const primaryLedgers = res.data;
                        if (primaryLedgers.length > 0) {
                            $('.group_id').html(
                                `<option selected disabled>Select Primary Ledger</option>`
                            ); // Clear and set default option
                            $.each(primaryLedgers, function(index, ledger) {
                                $('.group_id').append(
                                    `<option value="${ledger.id}">${ledger.group_name ?? "" }</option>`
                                );
                            });
                        } else {
                            $('.group_id').html(
                                `<option selected disabled>No Primary Ledger Found</option>`
                            ); // Clear and set default option
                        }
                    }
                })
            }
            primaryLedgerViewOnSelectTag();

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
                $.ajax({
                    url: '/all-ledger/view',
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
                                    <td>${ledger?.ledger_group?.group_name ?? "" }</td>
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


            // save Primary Ledger information
            const savePrimaryLedger = document.querySelector('.save_primary_ledger');
            savePrimaryLedger.addEventListener('click', function(e) {
                e.preventDefault();
                let formData = new FormData($('.primaryLedgerForm')[0]);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/ledger/store',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.status == 200) {
                            $('#primaryLedgerModal').modal('hide');
                            $('.primaryLedgerForm')[0].reset();
                            primaryLedgerView();
                            primaryLedgerViewOnSelectTag();
                            toastr.success(res.message);
                        } else {
                            if (res.error.group_name) {
                                showError('.group_name', res.error.group_name);
                            }
                        }
                    }
                });
            })

            // Primary Ledger View Function
            function primaryLedgerView() {
                $.ajax({
                    url: '/ledger/view',
                    method: 'GET',
                    success: function(res) {
                        const primaryLedgers = res.data;
                        $('.show_primary_ledger_data').empty();
                        if ($.fn.DataTable.isDataTable('#primaryLedgerTable')) {
                            $('#primaryLedgerTable').DataTable().clear().destroy();
                        }
                        if (primaryLedgers.length > 0) {
                            $.each(primaryLedgers, function(index, ledger) {
                                // Calculate the sum of account_transaction balances
                                const tr = document.createElement('tr');
                                tr.innerHTML = `
                                    <td>
                                        ${index+1}
                                    </td>
                                    <td>
                                        <a href="/ledger/details/${ledger.id}" >${ledger.group_name ?? ""}</a>
                                    </td>
                                    <td>
                                        <a href="/ledger/details/${ledger.id}" class="btn btn-icon btn-xs btn-primary">
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
                                $('.show_primary_ledger_data').append(tr);
                            });
                        } else {
                            $('.show_primary_ledger_data').html(`
                            <tr>
                                <td colspan='9'>
                                    <div class="text-center text-warning mb-2">Data Not Found</div>
                                    <div class="text-center">
                                        <button class="btn btn-xs btn-primary" data-bs-toggle="modal" data-bs-target="#primaryLedgerModal">Add Primary Ledger<i data-feather="plus"></i></button>
                                    </div>
                                </td>
                            </tr>
                            `);
                        }
                        dynamicDataTableFunc('primaryLedgerTable');
                    }
                });
            }
            primaryLedgerView();



        })


        // tab active on the page reload
        document.addEventListener("DOMContentLoaded", function() {
            // Get the last active tab from localStorage
            let activeTab = localStorage.getItem('activeTab');

            // If there is an active tab stored, activate it
            if (activeTab) {
                let tabElement = document.querySelector(`a[href="${activeTab}"]`);
                if (tabElement) {
                    new bootstrap.Tab(tabElement).show();
                }
            }

            // Store the currently active tab in localStorage
            document.querySelectorAll('.nav-link').forEach(tab => {
                tab.addEventListener('shown.bs.tab', function(event) {
                    let activeTabHref = event.target.getAttribute('href');
                    localStorage.setItem('activeTab', activeTabHref);
                });
            });


            // modal not close function
            modalShowHide('primaryLedgerModal');
            modalShowHide('ledgerModal');
        });
    </script>




@endsection
