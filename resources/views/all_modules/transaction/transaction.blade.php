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
                            <label for="name" class="form-label">Account Type<span class="text-danger">*</span></label>
                            <select class="form-control account_type" name="account_type" onkeyup="errorRemove(this);"
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
                                onkeyup="errorRemove(this);">
                                <option value="">Select Payment Account</option>
                            </select>
                            <span class="text-danger payment_account_id_error"></span>
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
                            <label for="name" class="form-label">Amount<span class="text-danger">*</span></label>
                            <input class="form-control amount" name="amount" type="number" onkeyup="errorRemove(this);">
                            <span class="text-danger amount_error"></span>
                        </div>
                        <div class="mb-3 col-md-12">
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


    <!-- Add Cash Modal -->
    <div class="modal fade" id="cash_modal" tabindex="-1" aria-labelledby="exampleModalScrollableTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Add Cash Info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form id="signupForm" class="cashForm row">
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Cash Account Name <span
                                    class="text-danger">*</span></label>
                            <input class="form-control cash_account_name" name="cash_account_name" type="text"
                                onkeyup="errorRemove(this);">
                            <span class="text-danger cash_account_name_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Opening Balance<span
                                    class="text-danger">*</span></label>
                            <input class="form-control opening_balance" name="opening_balance" type="number"
                                onkeyup="errorRemove(this);">
                            <span class="text-danger opening_balance_error"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save_cash">Save</button>
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

            // show error
            function showError(name, message) {
                $(name).css('border-color', 'red'); // Highlight input with red border
                $(name).focus(); // Set focus to the input field
                $(`${name}_error`).show().text(message); // Show error message
            }



            // save Withdraw information
            const saveWithdraw = document.querySelector('.save_withdraw');
            saveWithdraw.addEventListener('click', function(e) {
                e.preventDefault();
                let formData = new FormData($('.withdrawForm')[0]);
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
                            $('#cashWithdrawModal').modal('hide');
                            $('.withdrawForm')[0].reset();
                            // bankView();
                            toastr.success(res.message);
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
                        }
                    }
                });
            })

            // bankInfo View Function 
            function withdrawView() {
                // console.log('hello');
                $.ajax({
                    url: '/bank/view',
                    method: 'GET',
                    success: function(res) {
                        // console.log(res.data);
                        const banks = res.data;
                        // console.log(banks.account_transaction);
                        $('.show_bank_data').empty();
                        if (banks.length > 0) {
                            $.each(banks, function(index, bank) {
                                // console.log(bank);
                                // Calculate the sum of account_transaction balances
                                const tr = document.createElement('tr');
                                tr.innerHTML = `
                                    <td>${bank.account_name ?? ""}</td>
                                    <td>${bank.account_number ?? ""}</td>
                                    <td>${bank.bank_name ?? ""}</td>
                                    <td>${bank.bank_branch_name ?? 0}</td>
                                    <td>${bank.initial_balance ?? 0}</td>
                                    <td>${bank.current_balance ?? 0}</td>
                                    <td>
                                        <a href="#" class="btn btn-icon btn-xs btn-primary">
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
                                $('.show_bank_data').append(tr);

                                // Initialize DataTables after appending the data
                                $('#bankTable').DataTable({
                                    "paging": true, // Enable pagination
                                    "searching": true, // Enable search
                                    "ordering": true, // Enable column sorting
                                    "info": true, // Show table information (e.g. "Showing X to Y of Z entries")
                                    "lengthChange": true // Allow the user to change the number of rows displayed
                                });
                            });
                        } else {
                            $('.show_bank_data').html(`
                            <tr>
                                <td colspan='9'>
                                    <div class="text-center text-warning mb-2">Data Not Found</div>
                                    <div class="text-center">
                                        <button class="btn btn-xs btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalLongScollable">Add Bank Info<i data-feather="plus"></i></button>
                                    </div>
                                </td>
                            </tr>
                            `);
                        }
                        // Initialize DataTables after table data is populated
                        $('#dataTableExample').DataTable();
                    }
                });
            }
            withdrawView();

            // save cash information
            const saveCash = document.querySelector('.save_cash');
            saveCash.addEventListener('click', function(e) {
                e.preventDefault();
                let formData = new FormData($('.cashForm')[0]);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/cash-account/store',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        // console.log(res);
                        if (res.status == 200) {
                            $('#cash_modal').modal('hide');
                            $('.cashForm')[0].reset();
                            cashView();
                            toastr.success(res.message);
                        } else {
                            if (res.error.cash_account_name) {
                                showError('.cash_account_name', res.error.cash_account_name);
                            }
                            if (res.error.opening_balance) {
                                showError('.opening_balance', res.error.opening_balance);
                            }
                        }
                    }
                });
            })


            // Cash Info View Function 
            function cashView() {
                $.ajax({
                    url: '/cash-account/view',
                    method: 'GET',
                    success: function(res) {
                        // console.log(res.data);
                        const banks = res.data;
                        // console.log(banks.account_transaction);
                        $('.show_cash_data').empty();
                        if (banks.length > 0) {
                            $.each(banks, function(index, bank) {
                                // console.log(bank);
                                // Calculate the sum of account_transaction balances
                                const tr = document.createElement('tr');
                                tr.innerHTML = `
                                    <td>${bank.cash_account_name ?? ""}</td>
                                    <td>${bank.opening_balance	 ?? ""}</td>
                                    <td>${bank.current_balance ?? ""}</td>
                                    <td>
                                        <a href="#" class="btn btn-icon btn-xs btn-primary">
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
                                $('.show_cash_data').append(tr);
                            });
                        } else {
                            $('.show_cash_data').html(`
                            <tr>
                                <td colspan='9'>
                                    <div class="text-center text-warning mb-2">Data Not Found</div>
                                    <div class="text-center">
                                        <button class="btn btn-xs btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalLongScollable">Add Bank Info<i data-feather="plus"></i></button>
                                    </div>
                                </td>
                            </tr>
                            `);
                        }
                    }
                });
            }
            cashView();
        })



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


            // // modal not close 
            // // // Get the modal element
            // const cashWithdrawModal = document.getElementById('cashWithdrawModal');

            // // Get the specific buttons that should allow the modal to close
            // const btnClose = cashWithdrawModal.querySelector('.btn-close'); // Top-right close button
            // const modalCloseButton = cashWithdrawModal.querySelector(
            //     '.modal_close'); // Footer "Close" button

            // // Add event listener to prevent modal from closing unless certain buttons are clicked
            // cashWithdrawModal.addEventListener('hide.bs.modal', function(event) {
            //     // Allow modal to close only if triggered by btn-close or modal_close button
            //     if (!(event.relatedTarget === btnClose || event.relatedTarget ===
            //             modalCloseButton)) {
            //         event.preventDefault(); // Prevent modal from closing
            //     }
            // });
        });
    </script>


@endsection
