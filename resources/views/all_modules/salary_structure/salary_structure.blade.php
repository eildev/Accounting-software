@extends('master')
@section('title', '| Salary Structure Page')
@section('admin')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Salary Structure</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="card-title">Salary Structure Table</h6>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#exampleModalLongScollable">Add Salary Structure</button>
                    </div>
                    @php

                    @endphp
                    <div id="" class="table-responsive">
                        <table id="example" class="table">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Employee Name</th>
                                    <th>Basic Salary</th>
                                    <th>Rouse Rent</th>
                                    <th>Transport Allowance</th>
                                    <th>Other Fixed Allowance</th>
                                    <th>Deductions</th>
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
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Add Salary Structure Info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form id="signupForm" class="salaryStructuresForm row">
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Employee Name<span class="text-danger">*</span></label>
                            <select class="js-example-basic-single2 form-control employee_id" id="employeeDropdown"
                                data-loaded="false" name="employee_id" onkeyup="errorRemove(this);"
                                onblur="errorRemove(this);">
                                <option selected disabled>Select Employee</option>
                                {{-- @foreach ($employees as $employee)
                               <option value="{{$employee->id}}">{{$employee->full_name}}</option>
                               @endforeach --}}
                            </select>
                            <span class="text-danger employee_id_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Basic Salary<span class="text-danger">*</span></label>
                            <input id="defaultconfig11" class="form-control basic_salary_name" min="0"
                                max="9999999999999" name="base_salary" type="number" onkeyup="errorRemove(this);"
                                onblur="errorRemove(this);"
                                oninput="if(this.value.length > 13) this.value = this.value.slice(0, 13)">
                            <span class="text-danger basic_salary_name_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">House Rent</label>
                            <input id="defaultconfig21" class="form-control house_rent" min="0" max="9999999999999"
                                name="house_rent" type="number" onkeyup="errorRemove(this);" onblur="errorRemove(this);"
                                oninput="if(this.value.length > 13) this.value = this.value.slice(0, 13)">
                            <span class="text-danger house_rent_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name3" class="form-label">Transport Allowance</label>
                            <input id="defaultconfig2" class="form-control transport_allowance" min="0"
                                max="9999999999999" name="transport_allowance" type="number" onkeyup="errorRemove(this);"
                                onblur="errorRemove(this);"
                                oninput="if(this.value.length > 13) this.value = this.value.slice(0, 13)">
                            <span class="text-danger transport_allowance_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name3" class="form-label">Other Fixed Allowance</label>
                            <input id="defaultconfig3" class="form-control other_fixed_allowances" min="0"
                                max="9999999999999" name="other_fixed_allowances" type="number"
                                onkeyup="errorRemove(this);" onblur="errorRemove(this);">
                            <span class="text-danger other_fixed_allowances_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name4" class="form-label">Fixed Deductions</label>
                            <input id="defaultconfig5" class="form-control deductions" min="0"
                                max="9999999999999" name="deductions" type="number" onkeyup="errorRemove(this);"
                                onblur="errorRemove(this);"
                                oninput="if(this.value.length > 13) this.value = this.value.slice(0, 13)">
                            <span class="text-danger deductions_error"></span>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save_salaryStructures">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!--Edit Salary Structure Modal -->
    <div class="modal fade" id="edit" tabindex="-1" aria-labelledby="exampleModalScrollableTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Edit Salary Structure</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form id="signupForm" class="editSalaryStructureForm row">
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Employee Name<span
                                    class="text-danger">*</span></label>
                            <select class="js-example-basic-single2 form-control employee_id" name="employee_id"
                                onkeyup="errorRemove(this);" onblur="errorRemove(this);"   >
                                <option selected disabled>Select Employee</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->full_name }}</option>
                                @endforeach
                                <span class="text-danger employee_id_error"></span>
                            </select>

                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Basic Salary</label>
                            <input id="defaultconfig121" class="form-control basic_salary_name" name="base_salary"
                                min="0" max="9999999999999"
                                oninput="if(this.value.length > 13) this.value = this.value.slice(0, 13)" type="number"
                                onkeyup="errorRemove(this);" onblur="errorRemove(this);">
                            <span class="text-danger basic_salary_name_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">House Rent</label>
                            <input id="defaultconfig222" class="form-control house_rent" min="0"
                                max="9999999999999" name="house_rent" type="number" onkeyup="errorRemove(this);"
                                onblur="errorRemove(this);"
                                oninput="if(this.value.length > 13) this.value = this.value.slice(0, 13)">
                            <span class="text-danger house_rent_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name3" class="form-label">Transport Allowance</label>
                            <input id="defaultconfig23" class="form-control transport_allowance" min="0"
                                max="9999999999999" name="transport_allowance"
                                oninput="if(this.value.length > 13) this.value = this.value.slice(0, 13)" type="number"
                                onkeyup="errorRemove(this);" onblur="errorRemove(this);">
                            <span class="text-danger transport_allowance_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name3" class="form-label">Other Fixed Allowance</label>
                            <input id="defaultconfig33" class="form-control other_fixed_allowances"
                                name="other_fixed_allowances" min="0" max="9999999999999"
                                oninput="if(this.value.length > 13) this.value = this.value.slice(0, 13)" type="number"
                                onkeyup="errorRemove(this);" onblur="errorRemove(this);">
                            <span class="text-danger other_fixed_allowances_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name4" class="form-label">Fixed Deductions</label>
                            <input id="defaultconfig53" class="form-control deductions" min="0"
                                max="9999999999999" name="deductions"
                                oninput="if(this.value.length > 13) this.value = this.value.slice(0, 13)" type="number"
                                onkeyup="errorRemove(this);" onblur="errorRemove(this);">
                            <span class="text-danger deductions_error"></span>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary update_salaryStructure">Update</button>
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
            // save Salary Structure
            const saveSalaryStructures = document.querySelector('.save_salaryStructures');

            saveSalaryStructures.addEventListener('click', function(e) {
                //    alert('ok');
                e.preventDefault();
                let formData = new FormData($('.salaryStructuresForm')[0]);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/salary/structure/store',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.status == 200) {
                            $('#exampleModalLongScollable').modal('hide');
                            $('.salaryStructuresForm')[0].reset();
                            SalaryStructureView()
                            toastr.success(res.message);
                        } else {
                            if (res.error.employee_id) {
                                showError('.employee_id', res.error.employee_id);
                            }
                            if (res.error.base_salary) {
                                showError('.basic_salary_name', res.error.base_salary);
                            }
                            if (res.error.house_rent) {
                                showError('.house_rent', res.error.house_rent);
                            }
                            if (res.error.transport_allowance) {
                                showError('.transport_allowance', res.error
                                .transport_allowance);
                            }
                            if (res.error.other_fixed_allowances) {
                                showError('.other_fixed_allowances', res.error
                                    .other_fixed_allowances);
                            }
                            if (res.error.deductions) {
                                showError('.deductions', res.error.deductions);
                            }

                        }
                    }
                });
            });

            function SalaryStructureView() {
                $.ajax({
                    url: '/salary/structure/view',
                    method: 'GET',
                    success: function(res) {
                        const salaryStructure = res.data;
                        console.log(salaryStructure)
                        $('.showData').empty();
                        if ($.fn.DataTable.isDataTable('#example')) {
                            $('#example').DataTable().clear().destroy();
                        }
                        // Check if salaryStructure data is present
                        if (salaryStructure.length > 0) {
                            $.each(salaryStructure, function(index, salaryStructures) {
                                const tr = document.createElement('tr');
                                tr.innerHTML = `
                                        <td>${index + 1}</td>
                                        <td>${salaryStructures.employee.full_name  ?? ""}</td>
                                        <td>${salaryStructures.base_salary  ?? ""}</td>
                                        <td>${salaryStructures.house_rent  ?? ""}</td>
                                        <td>${salaryStructures.transport_allowance  ?? ""}</td>
                                        <td>${salaryStructures.other_fixed_allowances  ?? ""}</td>
                                        <td>${salaryStructures.deductions  ?? ""}</td>
                                        <td>
                                            <a href="#" class="btn btn-primary btn-icon salaryStructures_edit" data-id="${salaryStructures.id}" data-bs-toggle="modal" data-bs-target="#edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <a href="#" class="btn btn-danger btn-icon salaryStructures_delete" data-id="${salaryStructures.id}">
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
                                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalLongScollable">Add Salary Structure<i data-feather="plus"></i></button>
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
            SalaryStructureView();

            // // // edit salary Structures
            // $(document).on('click', '.salaryStructures_edit', function(e) {
            //     e.preventDefault();
            //     // console.log('0k');
            //     let id = this.getAttribute('data-id');
            //     $.ajaxSetup({
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         }
            //     });
            //     $.ajax({
            //         url: `/salary/structure/edit/${id}`,
            //         type: 'GET',
            //         success: function(res) {
            //             if (res.status == 200) {
            //                 $('.employee_id').val(res.salarySturcture.employee_id);
            //                 $('.basic_salary_name').val(res.salarySturcture.base_salary);
            //                 $('.house_rent').val(res.salarySturcture.house_rent);
            //                 $('.transport_allowance').val(res.salarySturcture
            //                     .transport_allowance);
            //                 $('.other_fixed_allowances').val(res.salarySturcture
            //                     .other_fixed_allowances);
            //                 $('.deductions').val(res.salarySturcture.deductions);
            //                 $('.update_salaryStructure').val(res.salarySturcture.id);
            //             } else {
            //                 toastr.warning("No Data Found");
            //             }
            //         }
            //     });
            // })
            // Edit salary structures
            $(document).on('click', '.salaryStructures_edit', function(e) {
                e.preventDefault();
                let id = this.getAttribute('data-id');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: `/salary/structure/edit/${id}`,
                    type: 'GET',
                    success: function(res) {
                        if (res.status == 200) {
                            // Populate employee dropdown
                            let employeeDropdown = $('.employee_id');
                            employeeDropdown.empty(); // Clear existing options
                            employeeDropdown.append('<option selected disabled>Select Employee</option>');

                            res.employees.forEach(function(employee) {
                                let isSelected = (employee.id === res.selectedEmployeeId) ? 'selected' : '';
                                employeeDropdown.append(`<option value="${employee.id}" ${isSelected}>${employee.full_name}</option>`);
                            });

                            // Populate other form fields with salary structure data
                            $('.basic_salary_name').val(res.salarySturcture.base_salary);
                            $('.house_rent').val(res.salarySturcture.house_rent);
                            $('.transport_allowance').val(res.salarySturcture.transport_allowance);
                            $('.other_fixed_allowances').val(res.salarySturcture.other_fixed_allowances);
                            $('.deductions').val(res.salarySturcture.deductions);
                            $('.update_salaryStructure').val(res.salarySturcture.id);
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

            // // update departments
            $('.update_salaryStructure').click(function(e) {
                e.preventDefault();

                let id = $(this).val();
                // console.log(id);
                // alert(id);
                let formData = new FormData($('.editSalaryStructureForm')[0]);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: `/salary/structure/update/${id}`,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.status == 200) {
                            $('#edit').modal('hide');
                            $('.editSalaryStructureForm')[0].reset();
                            SalaryStructureView();
                            toastr.success(res.message);
                        } else {
                            if (res.error.employee_id) {
                                showError('.employee_id', res.error.employee_id);
                            }
                            if (res.error.base_salary) {
                                showError('.basic_salary_name', res.error.base_salary);
                            }
                            if (res.error.house_rent) {
                                showError('.house_rent', res.error.house_rent);
                            }
                            if (res.error.transport_allowance) {
                                showError('.transport_allowance', res.error
                                .transport_allowance);
                            }
                            if (res.error.other_fixed_allowances) {
                                showError('.other_fixed_allowances', res.error
                                    .other_fixed_allowances);
                            }
                            if (res.error.deductions) {
                                showError('.deductions', res.error.deductions);
                            }
                        }
                    }
                });
            })

            // // Salary Structure Delete
            $(document).on('click', '.salaryStructures_delete', function(e) {
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
                            url: `/salary/structure/destroy/${id}`,
                            type: 'GET',
                            success: function(data) {
                                if (data.status == 200) {
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: "Your file has been deleted.",
                                        icon: "success"
                                    });
                                    SalaryStructureView();
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


////////////////////////////////////////////////dropdown Already not exist check///////////
        $(document).ready(function() {
            $('#employeeDropdown').on('focus', function() {
                // Check if the dropdown already has options loaded (optional)
                if ($(this).data('loaded') === "true") {
                    return;
                }
                $.ajax({
                    url: '/employees-without-salary-structure',
                    method: 'GET',
                    success: function(data) {
                        var employeeDropdown = $('#employeeDropdown');
                        employeeDropdown.empty();
                        employeeDropdown.append(
                            '<option selected disabled>Select Employee</option>');

                        $.each(data, function(index, employee) {
                            employeeDropdown.append('<option value="' + employee.id +
                                '">' + employee.full_name + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching employees:', error);
                    }
                });
            });
        });
    </script>
@endsection
