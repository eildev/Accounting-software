@extends('master')
@section('title', '| Sub Ledgers Management')
@section('admin')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sub Ledgers</li>
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
            <div class="card">
                <div class="card-body">
                    @include('all_modules.ledgers.sub-ledgers.sub-ledger-table')
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


            // Sub Ledger View Function
            function subLedgerView() {
                $.ajax({
                    url: '/sub-ledger/view',
                    method: 'GET',
                    success: function(res) {
                        console.log(res);
                        const ledgers = res.data;
                        $('.show_sub_ledger_data').empty();
                        if (ledgers.length > 0) {
                            $.each(ledgers, function(index, ledger) {
                                // Calculate the sum of account_transaction balances
                                const tr = document.createElement('tr');
                                tr.innerHTML = `
                                    <td>
                                        ${index+1}
                                    </td>
                                    <td>
                                        <a href="/sub-ledger/details/${ledger.id}" >${ledger.sub_ledger_name ?? ""}</a>
                                    </td>
                                    <td>${ledger?.ledger?.account_name ?? "" }</td>
                                    <td>
                                        <a href="/sub-ledger/details/${ledger.id}" class="btn btn-icon btn-xs btn-primary">
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
                        dynamicDataTableFunc('subLedgerTable');
                    }
                });
            }
            subLedgerView();

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
