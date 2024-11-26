@extends('master')
@section('title', '| Employee List')
@section('admin')

    <div class="row">
        @if (Auth::user()->can('employee.add'))
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card ">
                    <div class="card-body">
                        <div class="col-md-12 grid-margin stretch-card d-flex  mb-0 justify-content-between">
                            <div>
                                <h5 class="mb-2">Total Departments : {{ $departments->count() }}</h5>
                                <h5>Total Employee : {{ $employees->count() }} </h5>
                            </div>
                            <div class="">
                                <h4 class="text-right"><a href="{{ route('employee') }}" class="btn"
                                        style="background: #5660D9">Add New Employee</a></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12 grid-margin stretch-card d-flex mb-2 justify-content-between">
                        <div class="">
                            <h6 class="card-title ">View Employee List</h6>
                        </div>
                        <div class="">
                            <a href="javascript:void(0)" class="btn" id="generate-slip"
                                style="background: #5660D9">Generate Slip</a>
                        </div>
                    </div>
                    <div id="" class="table-responsive">
                        <table id="example" class="table">
                            <thead>
                                <tr>
                                    <th> <input type="checkbox" id="select-all" class="me-2"> Select All</th>
                                    <th>SN</th>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Salary</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="showData">
                                @if ($employees->count() > 0)
                                    @foreach ($employees as $key => $employe)
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="employee-checkbox"
                                                    data-id="{{ $employe->id }}">
                                            </td>
                                            <td>{{ $key + 1 }}</td>
                                            <td><a
                                                    href="{{ route('employee.profile', $employe->id) }}">{{ $employe->full_name ?? '' }}</a>
                                            </td>
                                            <td>{{ $employe->designation ?? '' }}</td>
                                            <td>{{ $employe->email ?? '' }}</td>
                                            <td>{{ $employe->phone ?? '' }}</td>
                                            <td>{{ $employe->salary ?? '' }}</td>
                                            <td>
                                                @if (Auth::user()->can('employee.edit'))
                                                    <a href="{{ route('employee.edit', $employe->id) }}"
                                                        class="btn btn-sm btn-primary btn-icon">
                                                        <i data-feather="edit"></i>
                                                    </a>
                                                @endif
                                                @if (Auth::user()->can('employee.delete'))
                                                    <a href="{{ route('employee.delete', $employe->id) }}" id="delete"
                                                        class="btn btn-sm btn-danger btn-icon">
                                                        <i data-feather="trash-2"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="12">
                                            <div class="text-center text-warning mb-2">Data Not Found</div>
                                            <div class="text-center">
                                                <a href="{{ route('employee') }}" class="btn btn-primary">Add Employee<i
                                                        data-feather="plus"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        // Select All functionality
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.employee-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
        // Click event for "Generate Slip" button
        document.getElementById('generate-slip').addEventListener('click', function() {
            // Collect selected checkbox IDs
            let selectedIds = [];
            document.querySelectorAll('.employee-checkbox:checked').forEach(function(checkbox) {
                selectedIds.push(checkbox.getAttribute('data-id'));
            });

            if (selectedIds.length > 0) {

                $.ajax({
                    url: '/employe/multilple/slip/store',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        selected_ids: selectedIds
                    },
                    success: function(response) {
                        if ($.fn.DataTable.isDataTable('#showSlipTable')) {
                        $('#showSlipTable').DataTable().clear().destroy();
                        }
                        if (response.status == 500) {
                            response.existing_employees.forEach(function(employee) {
                                toastr.warning(response.message, employee.employee_name);
                            });
                        } else if (response.status == 200) {
                            if (response.message_type === 'success') {
                                toastr.success(response.message); // Green color for success
                            } else if (response.message_type === 'warning') {
                                toastr.info(response.message); // Yellow color for warning
                            }else if(response.status == 200){
                                toastr.success(response.message);
                            }
                                //Success End
                            if (response.not_inserted.length > 0) {
                                let errorReasons = [];
                                let warningReasons = [];
                                // let message = "The following employees were not inserted:\n";
                                // response.not_inserted.forEach(item => {
                                //     message += `Employee Name: ${item.employee_name}, Reason: ${item.reason}\n`;
                                // });
                                // toastr.warning(message.replace(/\n/g, '<br>')); // Replace newlines with HTML line breaks for better formatting
                                response.not_inserted.forEach(item => {
                                    if (item.reason_type === 'error') {
                                        errorReasons.push(`Employee Name: ${item.employee_name}, Reason: ${item.reason}`);
                                    } else if (item.reason_type === 'warning') {
                                        warningReasons.push(`Employee Name: ${item.employee_name}, Reason: ${item.reason}`);
                                    }
                                });

                                // Show error messages
                                if (errorReasons.length > 0) {
                                    let errorMessage = "Salary Structure:\n" + errorReasons.join("\n");
                                    toastr.error(errorMessage.replace(/\n/g, '<br>')); // Red for critical errors
                                }

                                // Show warning messages
                                if (warningReasons.length > 0) {
                                    let warningMessage = "Warnings:\n" + warningReasons.join("\n");
                                    toastr.warning(warningMessage.replace(/\n/g, '<br>')); // Yellow for warnings
                                }
                            }

                        }else if(response.status == 400){
                            toastr.error(response.message);
                        }
                        //
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        toastr.error('Something went wrong! Please try again.');
                        console.error(error);
                    }
                });
            } else {
                toastr.error('Please select at least one employee to generate the slip.');
            }
        });


    </script>
@endsection
