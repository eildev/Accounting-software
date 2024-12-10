@extends('master')
@section('title', '| Salary Structure Page')
@section('admin')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Bonuses </li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="card-title">Bonuses Table</h6>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#exampleModalLongScollable">Add Bonuses</button>
                    </div>
                    @php

                    @endphp
                    <div id="" class="table-responsive">
                        <table id="example" class="table">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Employee Name</th>
                                    <th>Bonus Type </th>
                                    <th>Bonus Amount</th>
                                    <th>Bonus Reason</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="showData">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Add Modal -->
    <div class="modal fade" id="exampleModalLongScollable" tabindex="-1" aria-labelledby="exampleModalScrollableTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Add Bonuse Info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form id="signupForm" class="employeeBonusForm row">
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Departments Name</label>
                            <select class="form-control " name="department" id="department-select">
                                <option value="" selected disabled>Select Departments</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class=" mb-3 col-md-6">
                            <label for="name" class="form-label">Employees Name<span
                                    class="text-danger">*</span></label>
                            <select class="form-control  employee-selectid employee_id" onchange="errorRemove(this);"  name="employee_id" id="employee-select">
                                <option selected disabled>Select Employees Name</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->full_name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger employee_id_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Bonuse Type<span class="text-danger">*</span></label>

                            <select class="form-control bonus_type" name="bonus_type" width="100" onchange="errorRemove(this);" >
                                <option selected disabled>Select Bonuse Type</option>
                                <option value="performance">Performance</option>
                                <option value="festival">Festival</option>
                                <option value="other">Other</option>
                            </select>
                            <span class="text-danger bonus_type_error"></span>

                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Bonus amount<span class="text-danger">*</span></label>
                            <input id="defaultconfig212" class="form-control bonus_amount" name="bonus_amount"
                                type="number" onkeyup="errorRemove(this);" onblur="errorRemove(this);" min="0"
                                max="9999999999999"
                                oninput="if(this.value.length > 13) this.value = this.value.slice(0, 13)">
                            <span class="text-danger bonus_amount_error"></span>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="name3" class="form-label">Bonus Reason</label>
                            <textarea name="bonus_reason" class="form-control"cols="10" rows="2"></textarea>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save_employee_bonus">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!--Edit Salary Structure Modal -->
    <div class="modal fade" id="edit" tabindex="-1" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Edit Salary Structure</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form id="signupForm" class="editEmployeeBonusForm row">
                        <div class=" mb-3 col-md-6">
                            <label for="name" class="form-label">Employees Name<span
                                    class="text-danger">*</span></label>
                            <select class="form-control  employee-selectid employee_id" onchange="errorRemove(this);"  name="employee_id" id="employee-select">
                                <option selected disabled>Select Employees Name</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->full_name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger employee_id_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Bonuse Type<span class="text-danger">*</span></label>

                            <select class="form-control bonus_type" name="bonus_type" width="100" onchange="errorRemove(this);" >
                                <option selected disabled>Select Bonuse Type</option>
                                <option value="performance">Performance</option>
                                <option value="festival">Festival</option>
                                <option value="other">Other</option>
                            </select>
                            <span class="text-danger bonus_type_error"></span>

                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Bonus amount<span class="text-danger">*</span></label>
                            <input id="defaultconfig212" class="form-control bonus_amount" name="bonus_amount"
                                type="number" onkeyup="errorRemove(this);" onblur="errorRemove(this);" min="0"
                                max="9999999999999"
                                oninput="if(this.value.length > 13) this.value = this.value.slice(0, 13)">
                            <span class="text-danger bonus_amount_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name3" class="form-label ">Bonus Reason</label>
                            <textarea name="bonus_reason" class="form-control bonus_reason"cols="10" rows="2"></textarea>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary update_employee_bonus">Save</button>
                </div>
                </form>
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
                $(name).css('border-color', 'red');
                $(name).focus();
                $(`${name}_error`).show().text(message);
            }
            // save Employee Bonus
            const save_employee_bonus = document.querySelector('.save_employee_bonus');
            save_employee_bonus.addEventListener('click', function(e) {
                //    alert('ok');
                e.preventDefault();
                let formData = new FormData($('.employeeBonusForm')[0]);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/employee/bonus/store',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.status == 200) {
                            $('#exampleModalLongScollable').modal('hide');
                            $('.employeeBonusForm')[0].reset();
                            BonusView()
                            toastr.success(res.message);
                        } else {
                            if (res.error.employee_id) {
                                showError('.employee_id', res.error.employee_id);
                            }
                            if (res.error.bonus_type) {
                                showError('.bonus_type', res.error.bonus_type);
                            }
                            if (res.error.bonus_amount) {
                                showError('.bonus_amount', res.error.bonus_amount);
                            }
                        }
                    }
                });
            });

            function BonusView() {
                $.ajax({
                    url: '/employee/bonus/view',
                    method: 'GET',
                    success: function(res) {
                        const bonuses = res.data;
                        console.log(bonuses);
                        // console.log(salaryStructure)
                        $('.showData').empty();
                        if ($.fn.DataTable.isDataTable('#example')) {
                            $('#example').DataTable().clear().destroy();
                        }
                        // Check if salaryStructure data is present
                        if (bonuses.length > 0) {
                            $.each(bonuses, function(index, bonus) {
                                const tr = document.createElement('tr');
                                tr.innerHTML = `
                                        <td>${index + 1}</td>
                                        <td>${bonus.employee.full_name  ?? ""}</td>
                                        <td>${bonus.bonus_type  ?? ""}</td>
                                        <td>${bonus.bonus_amount  ?? ""}</td>
                                        <td>${bonus.bonus_reason  ?? ""}</td>

                                       <div class="dropdown" id="statusChange${bonus.id}">
                                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton${bonus.id}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span id="statusBadge${bonus.id}" class="badge text-dark
                                                ${bonus.status === 'pending' ? 'bg-warning' : (bonus.status === 'approved' ? 'bg-success' : (bonus.status === 'paid' ? 'bg-primary' : 'bg-info'))}">
                                                ${bonus.status ? bonus.status.charAt(0).toUpperCase() + bonus.status.slice(1) : 'Processing'}
                                            </span>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton${bonus.id}">
                                            <a class="dropdown-item" href="#" onclick="changeStatusBonus(${bonus.id}, 'pending')">Pending</a>
                                            <a class="dropdown-item" href="#" onclick="changeStatusBonus(${bonus.id}, 'approved')">Approved</a>
                                            <a class="dropdown-item" href="#" onclick="changeStatusBonus(${bonus.id}, 'processing')">Processing</a>
                                            </div>
                                        </div>

                                        <td>
                                            <a href="#" class="btn btn-primary btn-icon bonuses_edit" data-id="${bonus.id}" data-bs-toggle="modal" data-bs-target="#edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            ${bonus.status === 'pending' ? `<a href="#" class="btn btn-danger btn-icon employee_bonus_delete" data-id="${bonus.id}"><i class="fa-solid fa-trash-can"></i></a>` : ''}
                                        </td>
                                    `;
                                $('.showData').append(tr);
                            });
                        } else {
                            $('.showData').html(`
                                <tr>
                                    <td colspan='8'>
                                        <div class="text-center text-warning mb-2">Data Not Found</div>
                                        <div class="text-center">
                                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalLongScollable">Add  Bonuses<i data-feather="plus"></i></button>
                                        </div>

                                    </td>
                                </tr>`);
                        }
                        // Reinitialize DataTable
                        $('#example').DataTable({
                            columnDefs: [{
                                "defaultContent": "-",
                                "targets": "_all"
                            }],
                            dom: 'Bfrtip',
                            buttons: [{
                                    extend: 'excelHtml5',
                                    text: 'Excel',
                                    exportOptions: {
                                        header: true,
                                        columns: ':visible'
                                    },
                                    customize: function(xlsx) {
                                        return '{{ $header ?? '' }}\n {{ $phone ?? '+880.....' }}\n {{ $email ?? '' }}\n{{ $address ?? '' }}\n\n' +
                                            xlsx + '\n\n';
                                    }
                                },
                                {
                                    extend: 'pdfHtml5',
                                    text: 'PDF',
                                    exportOptions: {
                                        header: true,
                                        columns: ':visible'
                                    },
                                    customize: function(doc) {
                                        doc.content.unshift({
                                            text: '{{ $header ?? '' }}\n {{ $phone ?? '+880.....' }}\n {{ $email ?? '' }}\n{{ $address ?? '' }}',
                                            fontSize: 14,
                                            alignment: 'center',
                                            margin: [0, 0, 0, 12]
                                        });
                                        doc.content.push({
                                            text: 'Thank you for using our service!',
                                            fontSize: 14,
                                            alignment: 'center',
                                            margin: [0, 12, 0, 0]
                                        });
                                        return doc;
                                    }
                                },
                                {
                                    extend: 'print',
                                    text: 'Print',
                                    exportOptions: {
                                        header: true,
                                        columns: ':visible'
                                    },
                                    customize: function(win) {
                                        $(win.document.body).prepend(
                                            '<h4>{{ $header }}</br>{{ $phone ?? '+880....' }}</br>Email:{{ $email }}</br>Address:{{ $address }}</h4>'
                                        );
                                        $(win.document.body).find('h1')
                                            .hide(); // Hide the title element
                                    }
                                }
                            ]
                        });
                    }
                });
            }
            BonusView();

            // edit Bonus
            $(document).on('click', '.bonuses_edit', function(e) {
                e.preventDefault();
                let id = this.getAttribute('data-id');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: `/employee/bonuses/edit/${id}`,
                    type: 'GET',
                    success: function(res) {
                        if (res.status == 200) {
                            $('.employee_id').val(res.employeeBonus.employee_id);
                            $('.bonus_type').val(res.employeeBonus.bonus_type);
                            $('.bonus_amount').val(res.employeeBonus.bonus_amount);
                            $('.bonus_reason').val(res.employeeBonus.bonus_reason);
                            $('.update_employee_bonus').val(res.employeeBonus.id);
                        } else {
                            toastr.warning("No Data Found");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error);
                        toastr.error("An error occurred while fetching data.");
                    }
                });
            });

            //  update employee bonus
            $('.update_employee_bonus').click(function(e) {
                e.preventDefault();

                let id = $(this).val();
                // console.log(id);
                // alert(id);
                let formData = new FormData($('.editEmployeeBonusForm')[0]);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: `/employee/bonus/update/${id}`,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.status == 200) {
                            $('#edit').modal('hide');
                            $('.editEmployeeBonusForm')[0].reset();
                            BonusView();
                            toastr.success(res.message);
                        } else {
                            if (res.error.employee_id) {
                                showError('.employee_id', res.error.employee_id);
                            }
                            if (res.error.bonus_type) {
                                showError('.bonus_type', res.error.bonus_type);
                            }
                            if (res.error.bonus_amount) {
                                showError('.bonus_amount', res.error.bonus_amount);
                            }
                        }
                    }
                });
            })

            //     // Employee Bonus Delete
                $(document).on('click', '.employee_bonus_delete', function(e) {
                    e.preventDefault();
                    let id = this.getAttribute('data-id');

                    Swal.fire({
                        title: "Are you sure?",
                        text: "You won't be able to Delete this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                url: `/employee/bonus/destroy/${id}`,
                                type: 'GET',
                                success: function(data) {
                                    if (data.status == 200) {
                                        Swal.fire({
                                            title: "Deleted!",
                                            text: "Your file has been deleted.",
                                            icon: "success"
                                        });
                                        BonusView();
                                    } else {
                                        Swal.fire({
                                            position: "top-end",
                                            icon: "warning",
                                            title: "Deleted Unsuccessful!",
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                    }
                                }
                            });
                        }
                    });
                })
                //////////////dep Dropdow onload///////////
            $('#department-select').on('change', function() {
                var departmentId = $(this).val();

                // Clear the employee dropdown before new data is loaded
                $('#employee-select').empty().append(
                    '<option value="" selected disabled>Loading...</option>');
                $.ajax({
                    url: '/employees-by-department/' + departmentId,
                    type: 'GET',
                    success: function(data) {
                        // Clear the employee dropdown and add the default option
                        $('#employee-select').empty().append(
                            '<option value="" selected disabled>Select Name</option>');

                        $.each(data, function(index, employee) {
                            $('#employee-select').append(
                                `<option value="${employee.id}">${employee.full_name}</option>`
                            );
                        });
                    },
                    error: function() {
                        alert('Error fetching employees.');
                    }
                });
            });

        });
        ////Status Change
        function changeStatusBonus(id, status) {
            if ($('#statusBadge' + id).text().trim().toLowerCase() === 'paid') {
                toastr.warning("Status cannot be changed as it's already 'Paid'.");
                return;
            }
    $.ajax({
        url: '/update-status-bonus',
        type: 'POST',
        data: {
            id: id,
            status: status,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            const badge = $('#statusBadge' + id);
            badge.text(status.charAt(0).toUpperCase() + status.slice(1));

            // Remove existing badge classes and add new one based on status
            badge.removeClass('bg-warning bg-success bg-primary bg-info');
            if (status === 'pending') {
                badge.addClass('bg-warning');
            } else if (status === 'approved') {
                badge.addClass('bg-success');
            } else if (status === 'paid') {
                badge.addClass('bg-primary');
            }
            else if (status === 'processing') {
                badge.addClass('bg-info');
            }
            // Show or hide the delete button based on the new status
            if (status === 'pending') {
                $(`#statusChange${id}`).next('.employee_bonus_delete').show();
            } else {
                $(`#statusChange${id}`).next('.employee_bonus_delete').hide();
            }
        },
        error: function(error) {
            console.error("Error updating status", error);
            alert("There was an issue updating the status. Please try again.");
        }
    });
}

    </script>
@endsection
