@extends('master')
@section('title', '| Expanse Management')
@section('admin')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Expanse Managment</li>
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
                            aria-controls="home" aria-selected="true">Add Expanse</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab"
                            aria-controls="profile" aria-selected="false">Expanse Report</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="expanse-category-tab" data-bs-toggle="tab" href="#expanse-category"
                            role="tab" aria-controls="expanse-category" aria-selected="false">Expanse Category</a>
                    </li>
                </ul>
                <div class="tab-content border border-top-0 p-3" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    @include('all_modules.expense.add-expanse')
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <!-- Col -->
                                    <div class="col-sm-4">
                                        <div class="input-group flatpickr" id="flatpickr-date">
                                            <input type="text" class="form-control from-date" placeholder="Select date"
                                                data-input>
                                            <span class="input-group-text input-group-addon" data-toggle><i
                                                    data-feather="calendar"></i></span>
                                        </div>
                                    </div><!-- Col -->
                                    <div class="col-sm-4">
                                        <div class="input-group flatpickr" id="flatpickr-date">
                                            <input type="text" class="form-control to-date" placeholder="Select date"
                                                data-input>
                                            <span class="input-group-text input-group-addon" data-toggle><i
                                                    data-feather="calendar"></i></span>
                                        </div>
                                    </div>
                                    <style>
                                        .select2-container--default {
                                            width: 100% !important;
                                        }
                                    </style>
                                </div>
                                <br>
                                <div class="row mb-4">
                                    <div class="col-md-11 mb-2"> <!-- Left Section -->
                                        <div class="justify-content-left">
                                            <a href="" class="btn btn-sm bg-info text-dark mr-2"
                                                id="filter">Filter</a>
                                            <a class="btn btn-sm bg-primary text-dark" onclick="resetWindow()">Reset</a>
                                        </div>
                                    </div>

                                    <div class="col-md-1"> <!-- Right Section -->
                                        <div class="justify-content-end">
                                            <a href="#" onclick="printTable()"
                                                class="btn btn-sm bg-info text-dark mr-2"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-printer btn-icon-prepend">
                                                    <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                                    <path
                                                        d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2">
                                                    </path>
                                                    <rect x="6" y="14" width="12" height="8"></rect>
                                                </svg>Print</a>
                                        </div>
                                    </div>
                                </div>
                                <div id="filter-rander" class="row">
                                    @include('all_modules.expense.expense-filter-rander-table')
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="expanse-category" role="tabpanel" aria-labelledby="expanse-category-tab">
                        <div class="card">
                            <div class="card-body">
                                @include('all_modules.expense.expanse-category')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- /////////////////Add Expanse Category Modal//////////////// --}}
    <div class="modal fade" id="expanseCategoryModal" tabindex="-1" aria-labelledby="exampleModalScrollableTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Add Expense Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form id="signupForm" class="categoryForm">
                        <div class="mb-3">
                            <label for="name" class="form-label">Expense Category Name</label>
                            <input id="defaultconfig" class="form-control category_name" maxlength="250" name="name"
                                type="text" onkeyup="errorRemove(this);" onblur="errorRemove(this);">
                            <span class="text-danger category_name_error"></span>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary modal_close" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save_category">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!---------------->


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

            $(document).on('click', '.update_expense_category', function(e) {
                e.preventDefault();
                let categoryId = $(this).data(
                    'category-id'); // Get the category ID from the button's data attribute
                let formData = new FormData($('#signupForm' + categoryId)[
                    0]); // Use the category ID to select the correct form

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: `/expense/category/update/${categoryId}`,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        $('#expanseCatUpModal' + categoryId).modal(
                            'hide'); // Hide the correct modal using the category ID
                        $('#signupForm' + categoryId)[0].reset(); // Reset the form
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: res.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        // Handle errors if necessary
                    }
                });
            });


            const saveCategory = document.querySelector('.save_category');
            saveCategory.addEventListener('click', function(e) {
                e.preventDefault();
                let formData = new FormData($('.categoryForm')[0]);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/expense/category/store',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.status == 200) {
                            $('#expanseCategoryModal').modal('hide');
                            // formData.delete(entry[0]);
                            // alert('added successfully');
                            $('.categoryForm')[0].reset();
                            toastr.success(res.message);
                            window.location.reload();
                        } else {
                            showError('.category_name', res.error.name);
                        }
                    }
                });
            })



            // Function to handle AJAX requests and responses
            function handleExpanseSubmission(url, formData, onSuccess) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.status == 200) {
                            onSuccess(res);
                        } else {
                            // Show validation errors
                            const errorFields = ['purpose', 'amount', 'expense_category_id', 'spender',
                                'expense_date', 'note'
                            ];
                            errorFields.forEach(field => {
                                if (res.error && res.error[field]) {
                                    showError(`.${field}`, res.error[field]);
                                }
                            });
                        }
                    }
                });
            }

            // Add event listeners
            document.querySelectorAll('.save_expanse, .save_expanse_checkout').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const formData = new FormData($('.expanseForm')[0]);
                    const isCheckout = button.classList.contains('save_expanse_checkout');

                    handleExpanseSubmission('/expense/store', formData, function(res) {
                        if (isCheckout) {
                            // Handle checkout-specific logic
                            $('#globalPaymentModal #data_id').val(res.data.expanse_id);
                            $('#globalPaymentModal #payment_balance').val(res.data.amount);
                            $('#globalPaymentModal #purpose').val('Expanse');
                            $('#globalPaymentModal #transaction_type').val('withdraw');
                            $('#globalPaymentModal #due-amount').text(res.data.amount);
                            $('#globalPaymentModal #subLedger_id').val(res.data
                                .subLedger_id);
                            $('#globalPaymentModal').modal('show'); // Open Payment Modal
                        } else {
                            // Reload the page for standard submission
                            window.location.reload();
                        }
                    });
                });
            });



            $('#myValidForm').validate({
                rules: {
                    purpose: {
                        required: true,
                    },
                    amount: {
                        required: true,
                    },
                    expense_category_id: {
                        required: true,
                    },
                    spender: {
                        required: true,
                    },
                    bank_account_id: {
                        required: true,
                    },
                    account_type: {
                        required: true,
                    },
                    expense_date: {
                        required: true,
                    },
                },
                messages: {
                    purpose: {
                        required: 'Please Enter Purpose',
                    },
                    amount: {
                        required: 'Please Enter Amount',
                    },
                    expense_category_id: {
                        required: 'Please select expense category name',
                    },
                    spender: {
                        required: 'Please Enter  spender',
                    },
                    bank_account_id: {
                        required: 'Please Select Bank Name',
                    },
                    account_type: {
                        required: 'Please Select Account Type',
                    },
                    expense_date: {
                        required: 'Please Select Date',
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-valid-groups').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                    $(element).addClass('is-valid');
                },
            });
        });


        const filter = document.querySelector('#filter').addEventListener('click', function(e) {
            e.preventDefault();
            filterData();
        });
        let filterCategoryElement = document.querySelector('.filter-category');
        if (filterCategoryElement) {
            filterCategoryElement.addEventListener('change', function(e) {
                e.preventDefault();
                filterData();
            });
        }


        function filterData() {
            let startDate = document.querySelector('.from-date').value;
            let endDate = document.querySelector('.to-date').value;
            // let filterCtegory = document.querySelector('.filter-category').value;
            // console.log(filterCtegory);
            $.ajax({
                url: "{{ route('expense.filter.view') }}",
                method: 'GET',
                data: {
                    startDate,
                    endDate,

                },
                success: function(res) {
                    jQuery('#filter-rander').html(res);
                }
            });
        } //

        // Print function
        function printTable() {

            // Hide action buttons
            var actionButtons = document.querySelectorAll('.btn-icon');
            actionButtons.forEach(function(button) {
                button.style.display = 'none';
            });
            var actionColumn = document.querySelectorAll('.action th:last-child');
            actionColumn.forEach(function(column) {
                column.style.display = 'none';
            });
            var actionthColumn = document.querySelectorAll('.showData td:last-child');
            actionthColumn.forEach(function(column) {
                column.style.display = 'none';
            });
            // Hide all other elements on the page temporarily
            var bodyContent = document.body.innerHTML;
            var tableContent = document.getElementById('tableContainer').innerHTML;

            document.body.innerHTML = tableContent;

            // Print the specific data table
            window.print();

            // Restore the original content of the page
            document.body.innerHTML = bodyContent;

            // Restore action buttons
            actionButtons.forEach(function(button) {

                button.style.display = 'block';
            });
            // var tabToActivateId = "#expense-tab";
            // window.location.reload();
            window.location.reload();
            // document.getElementById(tabToActivateId).click();
            //
        }
        ////reset button
        function resetWindow() {
            // Reload the page
            window.location.reload();
            // Restore the "Expense Report" tab after the page reloads
            // document.getElementById("profile-tab").click();
        }


        // // tab active on the page reload
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
            modalShowHide('expanseCategoryModal');

        });
    </script>




@endsection
