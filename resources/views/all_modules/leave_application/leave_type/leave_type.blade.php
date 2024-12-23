@extends('master')
@section('title', '| Leave Type Page')
@section('admin')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Leave Type</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="card-title">Leave Type Table</h6>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#exampleModalLongScollable">Add Leave Type</button>
                    </div>

                    <div id="" class="table-responsive">
                        <table id="example" class="table">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Name</th>
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


    <!--  leave Types Add Modal -->
    <div class="modal fade" id="exampleModalLongScollable" tabindex="-1" aria-labelledby="exampleModalScrollableTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Add Leave Type Info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form id="signupForm" class="leaveTypeForm row">
                        <div class="mb-3 col-md-12">
                            <label for="name" class="form-label">Leave Type Name <span
                                    class="text-danger">*</span></label>
                            <input id="defaultconfig" class="form-control leaveType_name" maxlength="255" name="name"
                                type="text" onkeyup="errorRemove(this);" onblur="errorRemove(this);">
                            <span class="text-danger leaveType_name_error"></span>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save_leaveType">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- leave Types Edit Modal -->
    <div class="modal fade" id="edit" tabindex="-1" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Edit LeaveType</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form id="signupForm" class="editleaveTypeForm row">
                        <div class="mb-3 col-md-12">
                            <label for="name" class="form-label">Leave Type Name <span
                                    class="text-danger">*</span></label>
                            <input id="defaultconfig" class="form-control edit_leaveType_name" maxlength="255"
                                name="name" type="text" onkeyup="errorRemove(this);" onblur="errorRemove(this);">
                            <span class="text-danger edit_leaveType_name_error"></span>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary update_leaveType">Update</button>
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
            const saveDepartment = document.querySelector('.save_leaveType');
            const departmentsForm = document.querySelector('.leaveTypeForm');
            departmentsForm.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                }
            });
            saveDepartment.addEventListener('click', function(e) {
                // console.log('ok');

                e.preventDefault();
                let formData = new FormData($('.leaveTypeForm')[0]);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/leave/type/store',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.status == 200) {
                            $('#exampleModalLongScollable').modal('hide');
                            $('.leaveTypeForm')[0].reset();
                            LeaveTypeView();
                            toastr.success(res.message);
                        } else {
                            if (res.error.name) {
                                showError('.leaveType_name', res.error.name);
                            }

                        }
                    }
                });
            });

            function LeaveTypeView() {
                $.ajax({
                    url: '/leave/type/view',
                    method: 'GET',
                    success: function(res) {
                        const leaveTypes = res.data;
                        $('.showData').empty();
                        if ($.fn.DataTable.isDataTable('#example')) {
                            $('#example').DataTable().clear().destroy();
                        }
                        // Check if leave Types data is present
                        if (leaveTypes.length > 0) {
                            $.each(leaveTypes, function(index, leaveType) {
                                const tr = document.createElement('tr');
                                tr.innerHTML = `
                                        <td>${index + 1}</td>
                                        <td>${leaveType.name ?? ""}</td>
                                          <td>
                                         <button id="status" class="btn btn-sm ${leaveType.status === "active" ? "btn-success" : "btn-danger"} status-toggle"
                                            data-id="${leaveType.id}"
                                            data-status="${leaveType.status}">
                                        ${leaveType.status === "active" ? "Active" : "Inactive"}
                                       </button>
                                    </td>
                                        <td>
                                            <a href="#" class="btn btn-primary btn-icon leaveType_edit" data-id="${leaveType.id}" data-bs-toggle="modal" data-bs-target="#edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <a href="#" class="btn btn-danger btn-icon leaveType_delete" data-id="${leaveType.id}">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </a>
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
                                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalLongScollable">Add Leave Type<i data-feather="plus"></i></button>
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
            LeaveTypeView();

            // edit leave Type
            $(document).on('click', '.leaveType_edit', function(e) {
                e.preventDefault();
                // console.log('0k');
                let id = this.getAttribute('data-id');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: `/leave/type/edit/${id}`,
                    type: 'GET',
                    success: function(res) {
                        if (res.status == 200) {
                            $('.edit_leaveType_name').val(res.leaveTypes.name);
                            $('.update_leaveType').val(res.leaveTypes.id);
                        } else {
                            toastr.warning("No Data Found");
                        }
                    }
                });
            })

            // update edit leave Type Form
            $('.update_leaveType').click(function(e) {
                e.preventDefault();

                let id = $(this).val();
                // console.log(id);
                // alert(id);
                let formData = new FormData($('.editleaveTypeForm')[0]);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: `/edit/leave/Type/update/${id}`,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.status == 200) {
                            $('#edit').modal('hide');
                            $('.editleaveTypeForm')[0].reset();
                            LeaveTypeView();
                            toastr.success(res.message);
                        } else {
                            if (res.error.name) {
                                showError('.edit_leaveType_name', res.error.name);
                            }
                        }
                    }
                });
            })

            // leave Type Delete
            $(document).on('click', '.leaveType_delete', function(e) {
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
                            url: `/leave/type/destroy/${id}`,
                            type: 'GET',
                            success: function(data) {
                                if (data.status == 200) {
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: "Your file has been deleted.",
                                        icon: "success"
                                    });
                                    LeaveTypeView();
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
            $(document).on('click', '#status', function(e) {
                e.preventDefault();
                let id = this.getAttribute('data-id');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: `/leave/type/status/${id}`,
                    type: 'GET',
                    success: function(res) {
                        if (res.status == 200) {
                            LeaveTypeView();
                        } else {
                            toastr.warning("Status code: " + res.status);
                        }
                    }
                });
            })
        });
    </script>
@endsection
