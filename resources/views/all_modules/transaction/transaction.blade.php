@extends('master')
@section('title', '| Bank Account Management')
@section('admin')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Transaction Management</li>
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
                            aria-controls="home" aria-selected="true">Cash Withdraw</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab"
                            aria-controls="profile" aria-selected="false">Cash Deposite</a>
                    </li>
                </ul>
                <div class="tab-content border border-top-0 p-3" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    @include('all_modules.transaction.withdraw')
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="card">
                            <div class="card-body">
                                @include('all_modules.transaction.deposite')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Cash Withdraw Modal -->
    <div class="modal fade" id="cashWithdrawModal" tabindex="-1" aria-labelledby="exampleModalScrollableTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Cash Withdraw</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form class="withdrawForm row">
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Purpuse<span class="text-danger">*</span></label>
                            <input class="form-control source_type" name="source_type" type="text"
                                onkeyup="errorRemove(this);">
                            <span class="text-danger source_type_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Transaction Date<span
                                    class="text-danger">*</span></label>
                            <div class="input-group flatpickr me-2 mb-2 mb-md-0" id="dashboardDate">
                                <span class="input-group-text input-group-addon bg-transparent border-primary"
                                    data-toggle><i data-feather="calendar" class="text-primary"></i></span>
                                <input type="text" name="transaction_date"
                                    class="form-control bg-transparent border-primary transaction_date"
                                    placeholder="Select date" data-input>
                            </div>
                            <span class="text-danger transaction_date_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Account Type<span class="text-danger">*</span></label>
                            <select class="form-control account_type" name="account_type" onblur="errorRemove(this);"
                                onchange="checkPaymentAccount(this);">
                                <option value="">Select Account Type</option>
                                <option value="cash">Cash</option>
                                <option value="bank">Bank</option>
                            </select>
                            <span class="text-danger account_type_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Payment Account<span
                                    class="text-danger">*</span></label>
                            <select class="form-control payment_account_id" name="payment_account_id"
                                onchange="errorRemove(this);">
                                <option value="">Select Payment Account</option>
                            </select>
                            <span class="text-danger payment_account_id_error"></span>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Amount<span class="text-danger">*</span></label>
                            <input class="form-control amount" name="amount" type="number"
                                onkeyup="errorRemove(this);">
                            <span class="text-danger amount_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Note/Comments</label>
                            <input class="form-control description" name="description" type="text"
                                onkeyup="errorRemove(this);">
                            <span class="text-danger description_error"></span>
                        </div>
                        <input class="form-control transaction_type" name="transaction_type" type="hidden"
                            value="withdrawal">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary modal_close" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save_withdraw">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Cash Deposite Modal -->
    <div class="modal fade" id="cashDepositeModal" tabindex="-1" aria-labelledby="exampleModalScrollableTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Cash Deposite</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form class="depositeForm row">
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Purpuse<span class="text-danger">*</span></label>
                            <input class="form-control source_type" name="source_type" type="text"
                                onkeyup="errorRemove(this);">
                            <span class="text-danger source_type_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Transaction Date<span
                                    class="text-danger">*</span></label>
                            <div class="input-group flatpickr me-2 mb-2 mb-md-0" id="dashboardDate">
                                <span class="input-group-text input-group-addon bg-transparent border-primary"
                                    data-toggle><i data-feather="calendar" class="text-primary"></i></span>
                                <input type="text" name="transaction_date"
                                    class="form-control bg-transparent border-primary transaction_date"
                                    placeholder="Select date" data-input>
                            </div>
                            <span class="text-danger transaction_date_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Account Type<span
                                    class="text-danger">*</span></label>
                            <select class="form-control account_type" name="account_type" onblur="errorRemove(this);"
                                onchange="checkPaymentAccount(this);">
                                <option value="">Select Account Type</option>
                                <option value="cash">Cash</option>
                                <option value="bank">Bank</option>
                            </select>
                            <span class="text-danger account_type_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Payment Account<span
                                    class="text-danger">*</span></label>
                            <select class="form-control payment_account_id" name="payment_account_id"
                                onchange="errorRemove(this);">
                                <option value="">Select Payment Account</option>
                            </select>
                            <span class="text-danger payment_account_id_error"></span>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Amount<span class="text-danger">*</span></label>
                            <input class="form-control amount" name="amount" type="number"
                                onkeyup="errorRemove(this);">
                            <span class="text-danger amount_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Note/Comments</label>
                            <input class="form-control description" name="description" type="text"
                                onkeyup="errorRemove(this);">
                            <span class="text-danger description_error"></span>
                        </div>
                        <input class="form-control transaction_type" name="transaction_type" type="hidden"
                            value="deposit">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary modal_close" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save_deposite">Save</button>
                </div>
            </div>
        </div>
    </div>





    <script>
        // error remove
        ///////////////////////// error remove function Using for validation is ok then remove all error ///////////////////
        function errorRemove(element) {
            if (element.value != '') {
                $(element).siblings('span').hide();
                $(element).css('border-color', 'green');
            }
        }

        ///////////////////////// Check payment Account Using for check payment type ///////////////////
        function checkPaymentAccount(element) {
            const paymentType = $(element).val(); // 'element' is passed in from the onclick event
            const paymentAccounts = $('.payment_account_id');
            $.ajax({
                url: '/check-account-type',
                method: 'GET',
                data: {
                    payment_type: paymentType
                },
                success: function(res) {
                    const accounts = res.data;
                    // console.log(accounts);
                    if (accounts.length > 0) {
                        $('.payment_account_id').html(
                            `<option selected disabled>Select Account</option>`
                        ); // Clear and set default option
                        $.each(accounts, function(index, account) {
                            // console.log(account);
                            $('.payment_account_id').append(
                                `<option value="${account.id}">${account.bank_name ?? account.cash_account_name ?? ""}</option>`
                            );
                        });

                    } else {
                        $('.payment_account_id').html(
                            `<option selected disabled>No Account Found</option>`
                        ); // Clear and set default option
                    }
                }
            });
        }

        $(document).ready(function() {
            ///////////////////////// show error function using validation ///////////////////
            function showError(name, message) {
                $(name).css('border-color', 'red'); // Highlight input with red border
                $(name).focus(); // Set focus to the input field
                $(`${name}_error`).show().text(message); // Show error message
            }


            ///////////////////////// Save Dynamic data function ///////////////////
            function saveData(formData, modalName, formName) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/transaction/store',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.status == 200) {
                            $(`#${modalName}`).modal('hide');
                            $(`.${formName}`)[0].reset();
                            withdrawView();
                            toastr.success(res.message);
                        } else if (res.status == 400) {
                            toastr.warning(res.message);
                        } else {
                            if (res.error.account_type) {
                                showError('.account_type', res.error.account_type);
                            }
                            if (res.error.payment_account_id) {
                                showError('.payment_account_id', res.error.payment_account_id);
                            }
                            if (res.error.transaction_date) {
                                showError('.transaction_date', res.error.transaction_date);
                            }
                            if (res.error.amount) {
                                showError('.amount', res.error.amount);
                            }
                            if (res.error.transaction_type) {
                                toastr.warning(res.error.transaction_type);
                            }
                            if (res.error.description) {
                                showError('.description', res.error.description);
                            }
                            if (res.error.source_type) {
                                showError('.source_type', res.error.source_type);
                            }
                        }
                    }
                });
            }

            ///////////////////////// saveWithdraw button triggerd for save Withdraw Data ///////////////////
            const saveWithdraw = document.querySelector('.save_withdraw');
            saveWithdraw.addEventListener('click', function(e) {
                e.preventDefault();
                let formData = new FormData($('.withdrawForm')[0]);
                saveData(formData, 'cashWithdrawModal', 'withdrawForm');
            })

            ///////////////////////// savedeposite button triggerd for save deposit Data ///////////////////
            const saveDeposite = document.querySelector('.save_deposite');
            saveDeposite.addEventListener('click', function(e) {
                e.preventDefault();
                let formData = new FormData($('.depositeForm')[0]);
                saveData(formData, 'cashDepositeModal', 'depositeForm');
            })


            ///////////////////////// Fetching Data from Transaction Module ///////////////////
            function withdrawView() {
                $.ajax({
                    url: '/transaction/view',
                    method: 'GET',
                    success: function(res) {
                        if (res.status == 200) {
                            const withdrawal = res.withdraw;
                            const deposit = res.deposit;

                            dynamicView('show_withdraw_data', withdrawal, 'cashWithdrawModal',
                                'withdrawTable');
                            dynamicView('show_deposit_data', deposit, 'cashDepositeModal',
                                'depositTable');

                        } else {
                            toastr.error(res.message);
                        }
                    }
                });
            }


            ///////////////////////// Dynamic function for view dynamic Data /////////////////// 
            function dynamicView(tbody, transactions, modalName, table) {
                $(`.${tbody}`).empty();
                if ($.fn.DataTable.isDataTable(`#${table}`)) {
                    $(`#${table}`).DataTable().clear().destroy();
                }
                if (transactions.length > 0) {
                    $.each(transactions, function(index, transaction) {
                        // Generate the table row using viewDataOnTable
                        const tr = viewDataOnTable(transaction);
                        // Append the generated row to the table
                        $(`.${tbody}`).append(tr);
                    });
                } else {
                    $(`.${tbody}`).html(`
                        <tr>
                            <td colspan='9'>
                                <div class="text-center text-warning mb-2">Data Not Found</div>
                                <div class="text-center">
                                    <button class="btn btn-xs btn-primary" data-bs-toggle="modal" data-bs-target="#${modalName}">
                                        Add Transaction Info <i data-feather="plus"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `);
                }
                // Initialize DataTables after table data is populated
                dynamicDataTableFunc(table);
            }

            ///////////////////////// viewDataOnTable function for view Data /////////////////// 
            function viewDataOnTable(transaction) {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${transaction.source_type ?? ""}</td>
                    <td>${transaction.transaction_date ?? ""}</td>
                    <td>${transaction.bank?.bank_name ?? (transaction.cash?.cash_account_name ?? "")}</td>
                    <td>${transaction.amount ?? 0}</td>
                    <td>${transaction.description ?? 0}</td>
                    <td>${transaction.transaction_id ?? 0}</td>
                    <td>
                        <a href="/transaction/view-details/${transaction.id}" class="btn btn-icon btn-xs btn-primary">
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
                return tr;
            }
            withdrawView();
        })


        ///////////////////////// Tab active and inactive related code /////////////////// 
        document.addEventListener("DOMContentLoaded", function() {
            // tab active on the page reload 
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


            ///////////////////////// Modal show and close related code /////////////////// 
            // modal not close function 
            modalShowHide('cashWithdrawModal');
            modalShowHide('cashDepositeModal');
        });
    </script>


@endsection
