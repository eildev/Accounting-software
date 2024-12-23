@extends('master')
@section('title', '| Leave Limit ')
@section('admin')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Leave Limit</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="card-title">Leave Limit Table</h6>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#exampleModalLongScollable">Add Leave Limit</button>
                    </div>

                    <div id="" class="table-responsive">
                        <table id="example" class="table">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Employee Name</th>
                                    <th>Leave Type</th>
                                    <th>Total Leave Limit</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="showlimitData">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
    $employee =  App\Models\EmployeePayroll\Employee::all();
    $LeaveType =  App\Models\LeaveApplication\LeaveType::all();
    @endphp

    <!--  leave Limits Add Modal -->
    <div class="modal fade" id="exampleModalLongScollable" tabindex="-1" aria-labelledby="exampleModalScrollableTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Add Leave Info Info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form id="signupForm" class="leavelimitForm row">
                        <div class="mb-3 col-md-12">
                            <label for="name" class="form-label">Employee Name <span
                                    class="text-danger">*</span></label>
                                    <select class="form-control " name="employee_name" onchange="errorRemove(this);">
                                        <option value="" selected disabled>Select Employee</option>
                                        @foreach ($employee as $item)
                                        <option value="{{$item->id}}" >{{$item->full_name}}</option>
                                        @endforeach
                                    </select>
                            <span class="text-danger employee_name_error"></span>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="name" class="form-label">leave Type Name <span
                                    class="text-danger">*</span></label>
                                    <select class="form-control " name="leaveType_name" onchange="errorRemove(this);">
                                        <option value="" selected disabled>Select leave Type</option>
                                            @foreach ($LeaveType as $item)
                                            <option value="{{$item->id}}" >{{$item->name}}</option>
                                            @endforeach

                                    </select>
                            <span class="text-danger leaveType_error"></span>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="name" class="form-label"> Limit Day <span
                                    class="text-danger">*</span></label>
                            <input id="defaultconfig" class="form-control leavelimit" name="leavelimit"
                                type="number" onkeyup="errorRemove(this);" onblur="errorRemove(this);">
                            <span class="text-danger leavelimit_error"></span>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save_limit">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- leave limit Edit Modal -->
    <div class="modal fade" id="edit" tabindex="-1" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Edit LeaveType</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form id="signupForm" class="editleavelimitsForm row">
                        <div class="mb-3 col-md-12">
                            <label for="name" class="form-label">Employee Name <span
                                    class="text-danger">*</span></label>
                                    <select class="form-control employee_name" name="employee_name" onchange="errorRemove(this);">
                                        <option value="" selected disabled>Select Employee</option>
                                        @foreach ($employee as $item)
                                        <option value="{{$item->id}}" >{{$item->full_name}}</option>
                                        @endforeach
                                    </select>
                            <span class="text-danger employee_name_error"></span>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="name" class="form-label">leave Type Name <span
                                    class="text-danger">*</span></label>
                                    <select class="form-control leaveType_name" name="leaveType_name" onchange="errorRemove(this);">
                                        <option value="" selected disabled>Select leave Type</option>
                                            @foreach ($LeaveType as $item)
                                            <option value="{{$item->id}}" >{{$item->name}}</option>
                                            @endforeach

                                    </select>
                            <span class="text-danger leaveType_error"></span>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="name" class="form-label"> Limit Day <span
                                    class="text-danger">*</span></label>
                            <input id="defaultconfig" class="form-control leavelimit" name="leavelimit"
                                type="number" onkeyup="errorRemove(this);" onblur="errorRemove(this);">
                            <span class="text-danger leavelimit_error"></span>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary update_leavelimits">Update</button>
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
                $(name).css('border-color', 'red'); // Highlight input with red border
                $(name).focus(); // Set focus to the input field
                $(`${name}_error`).show().text(message); // Show error message
            }
            // save  leave Types
            const save_limit = document.querySelector('.save_limit');
            const leavelimitForm = document.querySelector('.leavelimitForm');
            leavelimitForm.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                }
            });
            save_limit.addEventListener('click', function(e) {
                // console.log('ok');

                e.preventDefault();
                let formData = new FormData($('.leavelimitForm')[0]);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/leave/limit/store',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.status == 200) {
                            $('#exampleModalLongScollable').modal('hide');
                            $('.leavelimitForm')[0].reset();
                            LeavelimitView();
                            toastr.success(res.message);
                        } else {
                            if (res.error.employee_name) {
                                showError('.employee_name', res.error.employee_name);
                            }
                            if (res.error.leaveType_name) {
                                showError('.leaveType', res.error.leaveType_name);
                            }
                            if (res.error.leavelimit) {
                                showError('.leavelimit', res.error.leavelimit);
                            }

                        }
                    }
                });
            });

            function LeavelimitView() {
                $.ajax({
                    url: '/leave/limit/view',
                    method: 'GET',
                    success: function(res) {
                        const Leavelimits = res.data;
                        $('.showlimitData').empty();
                        if ($.fn.DataTable.isDataTable('#example')) {
                            $('#example').DataTable().clear().destroy();
                        }
                        // Check if leave Types data is present
                            if (Leavelimits.length > 0) {
                                $.each(Leavelimits, function(index,leavelimit) {
                                    const tr = document.createElement('tr');
                                    tr.innerHTML = `
                                            <td>${index + 1}</td>
                                          <td>${leavelimit.employee?.full_name ?? ""}</td>
                                             <td>${leavelimit.leave_type?.name?? "N/A"}</td>
                                           <td>${leavelimit.leave_limits ?? ""}</td>

                                            <td>
                                                <a href="#" class="btn btn-primary btn-icon leavelimit_edit" data-id="${leavelimit.id}" data-bs-toggle="modal" data-bs-target="#edit">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <a href="#" class="btn btn-danger btn-icon leavelimit_delete" data-id="${leavelimit.id}">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </a>
                                            </td>
                                        `;
                                    $('.showlimitData').append(tr);
                                });
                        } else {
                            $('.showlimitData').html(`
                                    <tr>
                                        <td colspan='8'>
                                            <div class="text-center text-warning mb-2">Data Not Found</div>

                                            <div class="text-center">
                                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalLongScollable">Add Leave Limit<i data-feather="plus"></i></button>
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

                        });
                    }
                });
            }
            LeavelimitView();

            // edit leave Limit
            $(document).on('click', '.leavelimit_edit', function(e) {
                e.preventDefault();
                // console.log('0k');
                let id = this.getAttribute('data-id');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: `/leave/limit/edit/${id}`,
                    type: 'GET',
                    success: function(res) {
                        if (res.status == 200) {
                            $('.employee_name').val(res.leavelimits.employee_id);
                            $('.leaveType_name').val(res.leavelimits.leave_types_id);
                            $('.leavelimit').val(res.leavelimits.leave_limits);
                            $('.update_leavelimits').val(res.leavelimits.id);
                        } else {
                            toastr.warning("No Data Found");
                        }
                    }
                });
            })

            // update edit leave Type Form
            $('.update_leavelimits').click(function(e) {
                e.preventDefault();

                let id = $(this).val();

                // console.log(id);
                // alert(id);
                let formData = new FormData($('.editleavelimitsForm')[0]);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: `/edit/limit/limit/update/${id}`,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.status == 200) {
                            $('#edit').modal('hide');
                            $('.editleavelimitsForm')[0].reset();
                            LeavelimitView();

                            toastr.success(res.message);
                        } else {
                            if (res.error.employee_name) {
                                showError('.employee_name', res.error.employee_name);
                            }
                            if (res.error.leaveType_name) {
                                showError('.leaveType', res.error.leaveType_name);
                            }
                            if (res.error.leavelimit) {
                                showError('.leavelimit', res.error.leavelimit);
                            }
                        }
                    }
                });
            })

            // leave limit Delete
            $(document).on('click', '.leavelimit_delete', function(e) {
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
                            url: `/leave/limit/destroy/${id}`,
                            type: 'GET',
                            success: function(data) {
                                if (data.status == 200) {
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: "Your file has been deleted.",
                                        icon: "success"
                                    });
                                    LeavelimitView();
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
            });

        });
    </script>
@endsection
