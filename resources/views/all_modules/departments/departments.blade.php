@extends('master')
@section('title', '| Departments Page')
@section('admin')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Departments</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="card-title">Departments Table</h6>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#exampleModalLongScollable">Add Departments</button>
                    </div>
                    @php

                    @endphp
                    <div id="" class="table-responsive">
                        <table id="example" class="table">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Name</th>
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
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Add Departments Info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form id="signupForm" class="departmentsForm row">
                        <div class="mb-3 col-md-12">
                            <label for="name" class="form-label">Departments Name <span
                                    class="text-danger">*</span></label>
                            <input id="defaultconfig" class="form-control departments_name" maxlength="255" name="name"
                                type="text" onkeyup="errorRemove(this);" onblur="errorRemove(this);">
                            <span class="text-danger departments_name_error"></span>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save_departments">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!--Departmners Modal -->
    <div class="modal fade" id="edit" tabindex="-1" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Edit Departments</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form id="signupForm" class="editDepartmentsForm row">
                        <div class="mb-3 col-md-12">
                            <label for="name" class="form-label">Departments Name <span
                                    class="text-danger">*</span></label>
                            <input id="defaultconfig" class="form-control edit_departments_name" maxlength="255"
                                name="name" type="text" onkeyup="errorRemove(this);" onblur="errorRemove(this);">
                            <span class="text-danger edit_departments_name_error"></span>
                        </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary update_departments">Update</button>
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
                // save Departments
                const saveDepartment = document.querySelector('.save_departments');
                const departmentsForm = document.querySelector('.departmentsForm');
                departmentsForm.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                    }
                });
                saveDepartment.addEventListener('click', function(e) {
                    // console.log('ok');

                    e.preventDefault();
                    let formData = new FormData($('.departmentsForm')[0]);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '/departments/store',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(res) {
                            if (res.status == 200) {
                                $('#exampleModalLongScollable').modal('hide');
                                $('.departmentsForm')[0].reset();
                                DepartmentsView();
                                toastr.success(res.message);
                            } else {
                                if (res.error.name) {
                                    showError('.departments_name', res.error.name);
                                }

                            }
                        }
                    });
                });

                function DepartmentsView() {
                    $.ajax({
                        url: '/depertments/view',
                        method: 'GET',
                        success: function(res) {
                            const departments = res.data;
                            $('.showData').empty();
                            if ($.fn.DataTable.isDataTable('#example')) {
                                $('#example').DataTable().clear().destroy();
                            }
                            // Check if departments data is present
                            if (departments.length > 0) {
                                $.each(departments, function(index, departments) {
                                    const tr = document.createElement('tr');
                                    tr.innerHTML = `
                                        <td>${index + 1}</td>
                                        <td>${departments.name ?? ""}</td>
                                        <td>
                                            <a href="#" class="btn btn-primary btn-icon departments_edit" data-id="${departments.id}" data-bs-toggle="modal" data-bs-target="#edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <a href="#" class="btn btn-danger btn-icon departments_delete" data-id="${departments.id}">
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
                                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalLongScollable">Add Departments<i data-feather="plus"></i></button>
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
                DepartmentsView();

                // edit Departments
                $(document).on('click', '.departments_edit', function(e) {
                    e.preventDefault();
                    // console.log('0k');
                    let id = this.getAttribute('data-id');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: `/departments/edit/${id}`,
                        type: 'GET',
                        success: function(res) {
                            if (res.status == 200) {
                                $('.edit_departments_name').val(res.departments.name);
                                $('.update_departments').val(res.departments.id);
                            } else {
                                toastr.warning("No Data Found");
                            }
                        }
                    });
                })

                // update departments
                $('.update_departments').click(function(e) {
                    e.preventDefault();

                    let id = $(this).val();
                    // console.log(id);
                    // alert(id);
                    let formData = new FormData($('.editDepartmentsForm')[0]);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: `/departments/update/${id}`,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(res) {
                            if (res.status == 200) {
                                $('#edit').modal('hide');
                                $('.editDepartmentsForm')[0].reset();
                                DepartmentsView();
                                toastr.success(res.message);
                            } else {
                                if (res.error.name) {
                                    showError('.edit_departments_name', res.error.name);
                                }
                            }
                        }
                    });
                })

                // Departments Delete
                $(document).on('click', '.departments_delete', function(e) {
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
                                url: `/departments/destroy/${id}`,
                                type: 'GET',
                                success: function(data) {
                                    if (data.status == 200) {
                                        Swal.fire({
                                            title: "Deleted!",
                                            text: "Your file has been deleted.",
                                            icon: "success"
                                        });
                                        DepartmentsView();
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
            });
        </script>
    @endsection
