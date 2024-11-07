@extends('master')
@section('title', '| Recurring Expanse Management')
@section('admin')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Recurring Expanse Management</li>
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
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="card-title">Recurring Expanse Table</h6>
                        <button class="btn btn-rounded-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#recurringExpanse"><i data-feather="plus"></i></button>
                    </div>
                    <div class="table-responsive">
                        <table id="myDataTable" class="table">
                            <thead>
                                <tr>
                                    <th>Expanse Name</th>
                                    <th>Expanse Category</th>
                                    <th>Amount</th>
                                    <th>Start Date</th>
                                    <th>Recurrence Period</th>
                                    <th>Next Due Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="expanse_data">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Loan Modal -->
    <div class="modal fade" id="recurringExpanse" tabindex="-1" aria-labelledby="exampleModalScrollableTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Recurring Expanse</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form class="recurringExpanseForm row">
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Expanse Name<span class="text-danger">*</span></label>
                            <input class="form-control expanse_name" name="name" type="text"
                                onkeyup="errorRemove(this);">
                            <span class="text-danger expanse_name_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <div class="row">
                                <div class="col-md-10">
                                    <label for="name" class="form-label">Expanse Category<span
                                            class="text-danger">*</span></label>
                                    <select class="form-control expanse_category_id" name="expanse_category_id"
                                        onchange="errorRemove(this);">
                                    </select>
                                    <span class="text-danger expanse_category_id_error"></span>
                                </div>
                                <div class="col-md-2 d-flex justify-content-center align-items-center mt-4">
                                    <a class="btn btn-rounded-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#expanseCategory"><i data-feather="plus"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Amount<span class="text-danger">*</span></label>
                            <input class="form-control amount" name="amount" type="number" onkeyup="errorRemove(this);">
                            <span class="text-danger amount_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Start Date<span class="text-danger">*</span></label>
                            <div class="input-group flatpickr me-2 mb-2 mb-md-0" id="dashboardDate">
                                <span class="input-group-text input-group-addon bg-transparent border-primary"
                                    data-toggle><i data-feather="calendar" class="text-primary"></i></span>
                                <input type="text" name="start_date"
                                    class="form-control bg-transparent border-primary start_date" placeholder="Select date"
                                    data-input>
                            </div>
                            <span class="text-danger start_date_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Next Due Date<span class="text-danger">*</span></label>
                            <div class="input-group flatpickr me-2 mb-2 mb-md-0" id="dashboardDate">
                                <span class="input-group-text input-group-addon bg-transparent border-primary"
                                    data-toggle><i data-feather="calendar" class="text-primary"></i></span>
                                <input type="text" name="next_due_date"
                                    class="form-control bg-transparent border-primary next_due_date"
                                    placeholder="Select date" data-input>
                            </div>
                            <span class="text-danger next_due_date_error"></span>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Recurrence Period<span
                                    class="text-danger">*</span></label>
                            <select class="form-control recurrence_period" name="recurrence_period"
                                onchange="errorRemove(this);">
                                <option value="">Select Recurrence Period</option>
                                <option value="monthly">Monthly</option>
                                <option value="quarterly">Quarterly</option>
                                <option value="annually">Annually</option>
                            </select>
                            <span class="text-danger recurrence_period_error"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary modal_close" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save_recurring_expanse">Save</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Expanse Category Modal -->
    <div class="modal fade" id="expanseCategory" tabindex="-1" aria-labelledby="exampleModalScrollableTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Add Expanse Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form class="expanseCategoryForm row">
                        <div class="mb-3 col-md-12">
                            <label for="name" class="form-label">Expanse Category Name <span
                                    class="text-danger">*</span></label>
                            <input class="form-control expanse_category_name" name="name" type="text"
                                onkeyup="errorRemove(this);">
                            <span class="text-danger xpanse_category_error"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary modal_close" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save_expanse_category">Save</button>
                </div>
            </div>
        </div>
    </div>




    <script>
        ///////////////////////// Error Remove Function ///////////////////
        function errorRemove(element) {
            if (element.value != '') {
                $(element).siblings('span').hide();
                $(element).css('border-color', 'green');
            }
        }


        // ready function 
        $(document).ready(function() {

            ///////////////////////// Show Error Function //////////////////
            function showError(name, message) {
                $(name).css('border-color', 'red'); // Highlight input with red border
                $(name).focus(); // Set focus to the input field
                $(`${name}_error`).show().text(message); // Show error message
            }


            ///////////////////////// Recurring Expanse category related code///////////////////
            // save recurring expanse information
            const saveBtn = document.querySelector('.save_recurring_expanse');
            saveBtn.addEventListener('click', function(e) {
                e.preventDefault();
                // Convert the date inputs to YYYY-MM-DD format
                let startDate = new Date($('.recurringExpanseForm [name="start_date"]').val());
                let nextDUueDate = new Date($('.recurringExpanseForm [name="next_due_date"]').val());

                // Set the dates in the form fields in the correct format
                $('.recurringExpanseForm [name="start_date"]').val(startDate.toISOString().slice(0, 10));
                $('.recurringExpanseForm [name="next_due_date"]').val(nextDUueDate.toISOString().slice(0,
                    10));

                let formData = new FormData($('.recurringExpanseForm')[0]);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/expense/recurring/store',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.status == 200) {
                            $('#recurringExpanse').modal('hide');
                            $('.recurringExpanseForm')[0].reset();
                            viewFunc();
                            toastr.success(res.message);
                        } else {
                            if (res.error.expanse_category_id) {
                                showError('.expanse_category_id', res.error
                                    .expanse_category_id);
                            }
                            if (res.error.amount) {
                                showError('.amount', res.error.amount);
                            }
                            if (res.error.start_date) {
                                showError('.start_date', res.error.start_date);
                            }
                            if (res.error.next_due_date) {
                                showError('.next_due_date', res.error.next_due_date);
                            }
                            if (res.error.recurrence_period) {
                                showError('.recurrence_period', res.error.recurrence_period);
                            }
                            if (res.error.name) {
                                showError('.expanse_name', res.error.name);
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error(xhr?.statusText ||
                            'An unexpected error occurred');
                    }
                });
            })

            // recurring View Function 
            function viewFunc() {
                $.ajax({
                    url: '/expense/recurring/view',
                    method: 'GET',
                    success: function(res) {
                        const expanses = res.data;
                        $('.expanse_data').empty();
                        if (expanses.length > 0) {
                            $.each(expanses, function(index, expanse) {
                                const tr = document.createElement('tr');
                                let statusBadge = ''; // Initialize status badge variable

                                // Check loan status and assign the correct badge
                                if (expanse.status === 'active') {
                                    statusBadge =
                                        '<span class="badge bg-success">Active</span>';
                                } else {
                                    statusBadge =
                                        '<span class="badge bg-danger">Inactive</span>';
                                }

                                // Format dates
                                const formatDate = (dateString) => {
                                    if (!dateString) return "";
                                    const date = new Date(dateString);
                                    return new Intl.DateTimeFormat('en-GB', {
                                        day: '2-digit',
                                        month: 'short',
                                        year: 'numeric'
                                    }).format(date);
                                };

                                const formattedStartDate = formatDate(expanse.start_date);
                                const formattedNextDueDate = formatDate(expanse.next_due_date);

                                tr.innerHTML = `
                                        <td>${expanse.name ?? ""}</td>
                                        <td>
                                            ${expanse?.expense_category?.name ?? ""}  
                                        </td>
                                        <td>${expanse.amount ?? 0}</td>
                                        <td>${formattedStartDate}</td>
                                        <td class="text-capitalize">${expanse.recurrence_period ?? 0}</td>
                                        <td>${formattedNextDueDate}</td>
                                        <td>
                                            ${statusBadge}
                                        </td>
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
                                $('.expanse_data').append(tr);

                            });
                        } else {
                            $('.expanse_data').html(`
                                <tr>
                                    <td colspan='9'>
                                        <div class="text-center text-warning mb-2">Data Not Found</div>
                                        <div class="text-center">
                                            <button class="btn btn-xs btn-primary" data-bs-toggle="modal" data-bs-target="#recurringExpanse">Add Recurring Expanse<i data-feather="plus"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            `);
                        }
                        dynamicDataTableFunc('myDataTable');
                    }
                });
            }
            viewFunc();



            ///////////////////////// Expanse category related code///////////////////
            const saveExpanseCategory = document.querySelector('.save_expanse_category');
            saveExpanseCategory.addEventListener('click', function(e) {
                e.preventDefault();
                let formData = new FormData($('.expanseCategoryForm')[0]);
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
                            $('#expanseCategory').modal('hide');
                            $('.expanseCategoryForm')[0].reset();
                            expanseView();
                            toastr.success(res.message);
                        } else {
                            if (res.error.name) {
                                showError('.expanse_category_name', res.error
                                    .name);
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error(xhr?.statusText ||
                            'An unexpected error occurred');
                    }
                });
            })

            // recurring View Function 
            function expanseView() {
                $.ajax({
                    url: '/expense/category/view',
                    method: 'GET',
                    success: function(res) {
                        const categories = res.data;
                        // console.log(categories);
                        if (categories.length > 0) {
                            $('.expanse_category_id').html(
                                `<option selected disabled>Select Expanse Category</option>`
                            ); // Clear and set default option
                            $.each(categories, function(index, category) {
                                // console.log(account);
                                $('.expanse_category_id').append(
                                    `<option value="${category.id}">${category.name ?? ""}</option>`
                                );
                            });

                        } else {
                            $('.expanse_category_id').html(
                                `<option selected disabled>No Category Found</option>`
                            ); // Clear and set default option
                        }


                    }
                });
            }
            expanseView();

        })


        ///////////////////////// Tab Active/Inactive related code///////////////////
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
            // Initialize the Recurring Expense modal with backdrop and keyboard options
            var recurringExpanseModal = new bootstrap.Modal(document.getElementById('recurringExpanse'), {
                backdrop: 'static', // Prevent closing by clicking outside
                keyboard: false // Prevent closing with Escape key
            });

            // Initialize the Expanse Category modal
            var expanseCategoryModal = new bootstrap.Modal(document.getElementById('expanseCategory'), {
                backdrop: 'static',
                keyboard: false
            });

            // Open Recurring Expense modal when the main button is clicked
            document.querySelector('.btn[data-bs-target="#recurringExpanse"]').addEventListener('click',
                function() {
                    recurringExpanseModal.show();
                });

            // Open Expanse Category modal and hide Recurring Expense modal
            document.querySelector('.btn[data-bs-target="#expanseCategory"]').addEventListener('click', function() {
                recurringExpanseModal.hide();
                expanseCategoryModal.show();
            });

            // Custom close functionality for Recurring Expense modal
            document.querySelectorAll('#recurringExpanse .modal_close, #recurringExpanse .btn-close').forEach(
                button => {
                    button.addEventListener('click', function() {
                        recurringExpanseModal.hide();
                    });
                });

            // Custom close functionality for Expanse Category modal
            document.querySelectorAll('#expanseCategory .modal_close, #expanseCategory .btn-close').forEach(
                button => {
                    button.addEventListener('click', function() {
                        expanseCategoryModal.hide();
                    });
                });

            // Reopen the Recurring Expense modal when Expanse Category modal is fully hidden
            document.getElementById('expanseCategory').addEventListener('hidden.bs.modal', function() {
                recurringExpanseModal.show();
            });
        });
    </script>


@endsection
