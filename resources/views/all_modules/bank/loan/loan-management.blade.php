@extends('master')
@section('title', '| Loan Management')
@section('admin')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Loan Management</li>
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
                            aria-controls="home" aria-selected="true">Loan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab"
                            aria-controls="profile" aria-selected="false">Loan Repayment</a>
                    </li>
                </ul>
                <div class="tab-content border border-top-0 p-3" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    @include('all_modules.bank.loan.loan')
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="card">
                            <div class="card-body">
                                @include('all_modules.bank.loan.loan-repayments')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Loan Modal -->
    <div class="modal fade" id="loanModal" tabindex="-1" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Loan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form class="loanForm row">
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Loan Account<span class="text-danger">*</span></label>
                            <select class="form-control bank_loan_account_id" name="bank_loan_account_id"
                                onchange="errorRemove(this);">
                                @if ($banks->count() > 0)
                                    <option value="">Select Loan Account</option>
                                    @foreach ($banks as $account)
                                        <option value="{{ $account->id }}">{{ $account->account_name ?? '' }}</option>
                                    @endforeach
                                @else
                                    <option value="">No Account Found</option>
                                @endif
                            </select>
                            <span class="text-danger bank_loan_account_id_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Loan Amount<span class="text-danger">*</span></label>
                            <input class="form-control loan_principal" name="loan_principal" type="number"
                                onkeyup="errorRemove(this);">
                            <span class="text-danger loan_principal_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Interest Rate %<span
                                    class="text-danger">*</span></label>
                            <input class="form-control interest_rate" name="interest_rate" type="number"
                                onkeyup="errorRemove(this);" placeholder="0.00">
                            <span class="text-danger interest_rate_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Repayment Schedule<span
                                    class="text-danger">*</span></label>
                            <select class="form-control repayment_schedule" name="repayment_schedule"
                                onchange="errorRemove(this);">
                                <option value="">Select Repayment Schedule</option>
                                <option value="daily">Daily</option>
                                <option value="weekly">Weekly</option>
                                <option value="monthly">Monthly</option>
                                <option value="yearly">Yearly</option>
                            </select>
                            <span class="text-danger repayment_schedule_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Start Date<span class="text-danger">*</span></label>
                            <div class="input-group flatpickr me-2 mb-2 mb-md-0" id="dashboardDate">
                                <span class="input-group-text input-group-addon bg-transparent border-primary"
                                    data-toggle><i data-feather="calendar" class="text-primary"></i></span>
                                <input type="text" name="start_date"
                                    class="form-control bg-transparent border-primary start_date"
                                    placeholder="Select date" data-input>
                            </div>
                            <span class="text-danger start_date_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">End Date<span class="text-danger">*</span></label>
                            <div class="input-group flatpickr me-2 mb-2 mb-md-0" id="dashboardDate">
                                <span class="input-group-text input-group-addon bg-transparent border-primary"
                                    data-toggle><i data-feather="calendar" class="text-primary"></i></span>
                                <input type="text" name="end_date"
                                    class="form-control bg-transparent border-primary end_date" placeholder="Select date"
                                    data-input>
                            </div>
                            <span class="text-danger end_date_error"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary modal_close" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save_loan">Save</button>
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


        // ready function 
        $(document).ready(function() {

            // show error
            function showError(name, message) {
                $(name).css('border-color', 'red'); // Highlight input with red border
                $(name).focus(); // Set focus to the input field
                $(`${name}_error`).show().text(message); // Show error message
            }



            // save Loan information
            const saveLoan = document.querySelector('.save_loan');
            saveLoan.addEventListener('click', function(e) {
                e.preventDefault();
                // Convert the date inputs to YYYY-MM-DD format
                let startDate = new Date($('.loanForm [name="start_date"]').val());
                let endDate = new Date($('.loanForm [name="end_date"]').val());

                // Set the dates in the form fields in the correct format
                $('.loanForm [name="start_date"]').val(startDate.toISOString().slice(0, 10));
                $('.loanForm [name="end_date"]').val(endDate.toISOString().slice(0, 10));

                let formData = new FormData($('.loanForm')[0]);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/loan/store',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.status == 200) {
                            $('#loanModal').modal('hide');
                            $('.loanForm')[0].reset();
                            loanView();
                            toastr.success(res.message);
                        } else {
                            if (res.error.bank_loan_account_id) {
                                showError('.bank_loan_account_id', res.error
                                    .bank_loan_account_id);
                            }
                            if (res.error.loan_principal) {
                                showError('.loan_principal', res.error.loan_principal);
                            }
                            if (res.error.interest_rate) {
                                showError('.interest_rate', res.error.interest_rate);
                            }
                            if (res.error.repayment_schedule) {
                                showError('.repayment_schedule', res.error.repayment_schedule);
                            }
                            if (res.error.start_date) {
                                showError('.start_date', res.error.start_date);
                            }
                            if (res.error.end_date) {
                                showError('.end_date', res.error.end_date);
                            }

                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error(xhr.responseJSON.message ||
                            'An unexpected error occurred');
                    }
                });
            })

            // Loan Info View Function 
            function loanView() {
                $.ajax({
                    url: '/loan/view',
                    method: 'GET',
                    success: function(res) {
                        const loans = res.data;
                        $('.loan_data').empty();
                        if (loans.length > 0) {
                            $.each(loans, function(index, loan) {
                                const tr = document.createElement('tr');
                                tr.innerHTML = `
                                    <td>${loan.bank_loan_account_id ?? ""}</td>
                                    <td>${loan.loan_principal ?? ""}</td>
                                    <td>${loan.interest_rate ?? ""}</td>
                                    <td>${loan.loan_balance ?? 0}</td>
                                    <td>${loan.initial_balance ?? 0}</td>
                                    <td>${loan.current_balance ?? 0}</td>
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
                                $('.loan_data').append(tr);

                            });
                        } else {
                            $('.loan_data').html(`
                            <tr>
                                <td colspan='9'>
                                    <div class="text-center text-warning mb-2">Data Not Found</div>
                                    <div class="text-center">
                                        <button class="btn btn-xs btn-primary" data-bs-toggle="modal" data-bs-target="#loanModal">Add Loan Info<i data-feather="plus"></i></button>
                                    </div>
                                </td>
                            </tr>
                            `);
                        }
                    }
                });
            }
            loanView();

            //     // save cash information
            //     const saveCash = document.querySelector('.save_cash');
            //     saveCash.addEventListener('click', function(e) {
            //         e.preventDefault();
            //         let formData = new FormData($('.cashForm')[0]);
            //         $.ajaxSetup({
            //             headers: {
            //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //             }
            //         });
            //         $.ajax({
            //             url: '/cash-account/store',
            //             type: 'POST',
            //             data: formData,
            //             processData: false,
            //             contentType: false,
            //             success: function(res) {
            //                 // console.log(res);
            //                 if (res.status == 200) {
            //                     $('#cash_modal').modal('hide');
            //                     $('.cashForm')[0].reset();
            //                     cashView();
            //                     toastr.success(res.message);
            //                 } else {
            //                     if (res.error.cash_account_name) {
            //                         showError('.cash_account_name', res.error.cash_account_name);
            //                     }
            //                     if (res.error.opening_balance) {
            //                         showError('.opening_balance', res.error.opening_balance);
            //                     }
            //                 }
            //             }
            //         });
            //     })


            //     // Cash Info View Function 
            //     function cashView() {
            //         $.ajax({
            //             url: '/cash-account/view',
            //             method: 'GET',
            //             success: function(res) {
            //                 // console.log(res.data);
            //                 const banks = res.data;
            //                 // console.log(banks.account_transaction);
            //                 $('.show_cash_data').empty();
            //                 if (banks.length > 0) {
            //                     $.each(banks, function(index, bank) {
            //                         // console.log(bank);
            //                         // Calculate the sum of account_transaction balances
            //                         const tr = document.createElement('tr');
            //                         tr.innerHTML = `
        //                             <td>${bank.cash_account_name ?? ""}</td>
        //                             <td>${bank.opening_balance	 ?? ""}</td>
        //                             <td>${bank.current_balance ?? ""}</td>
        //                             <td>
        //                                 <a href="#" class="btn btn-icon btn-xs btn-primary">
        //                                     <i class="fa-solid fa-eye"></i>
        //                                 </a>
        //                                 <a href="#" class="btn btn-icon btn-xs btn-success">
        //                                     <i class="fa-solid fa-pen-to-square"></i>
        //                                 </a>
        //                                 <a href="#" class="btn btn-icon btn-xs btn-danger">
        //                                     <i class="fa-solid fa-trash-can"></i>
        //                                 </a>
        //                             </td>
        //                         `;
            //                         $('.show_cash_data').append(tr);
            //                     });
            //                 } else {
            //                     $('.show_cash_data').html(`
        //                     <tr>
        //                         <td colspan='9'>
        //                             <div class="text-center text-warning mb-2">Data Not Found</div>
        //                             <div class="text-center">
        //                                 <button class="btn btn-xs btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalLongScollable">Add Bank Info<i data-feather="plus"></i></button>
        //                             </div>
        //                         </td>
        //                     </tr>
        //                     `);
            //                 }
            //             }
            //         });
            //     }
            //     cashView();
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
