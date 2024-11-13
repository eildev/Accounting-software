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
        {{-- /////All Paid Slep ////////// --}}
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12 grid-margin stretch-card d-flex mb-2 justify-content-between">
                        <div class="">
                            <h6 class="card-title ">View pay Slip List</h6>
                        </div>

                    </div>
                    <div id="" class="table-responsive">
                        <table id="showSlipTable" class="table">
                            <thead>
                                <tr>

                                    <th>Name</th>
                                    <th>payment Date</th>
                                    <th>Total Gross Salary</th>
                                    <th>total Deductions</th>
                                    <th>Total Net Salary</th>
                                    <th>Total Employee Bonus</th>
                                    <th>Total Convenience Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="showSlip">

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
                        if (response.status == 500) {
                            response.existing_employees.forEach(function(employee) {
                                toastr.warning(response.message, employee.employee_name);
                            });
                        } else if (response.status == 200) {
                            toastr.success(response.message);
                        }
                        fetchPaySlips()
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

        ////Slip Vew //
        function fetchPaySlips() {
            $.ajax({
                url: '/employe/all/slip/view',
                type: "GET",
                dataType: "json",
                success: function(response) {
                    // console.log(response.paySlip);
                    if ($.fn.DataTable.isDataTable('#showSlipTable')) {
                        $('#showSlipTable').DataTable().clear().destroy();
                    }
                    if (response.paySlip) {
                        $('.showSlip').empty(); // Clear previous data if any

                        $.each(response.paySlip, function(index, paySlips) {
                            $('.showSlip').append(`
                            <tr>
                                <td>${paySlips.employee ? paySlips.employee.full_name : 'N/A'}</td>
                                <td>${paySlips.pay_period_date}</td>
                                <td>${paySlips.total_gross_salary}</td>
                                <td>${paySlips.total_deductions}</td>
                                <td>${paySlips.total_net_salary}</td>
                                <td>${paySlips.total_employee_bonus}</td>
                                <td>${paySlips.total_convenience_amount}</td>
                                <td>
                                  <div class="dropdown" id="statusChange${paySlips.id}">
                                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton${paySlips.id}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span id="statusBadge${paySlips.id}" class="badge text-dark
                                            ${paySlips.status === 'pending' ? 'bg-warning' : (paySlips.status === 'approved' ? 'bg-success' : (paySlips.status === 'paid' ? 'bg-primary' : 'bg-info'))}">
                                            ${paySlips.status ? paySlips.status.charAt(0).toUpperCase() + paySlips.status.slice(1) : 'Processing'}
                                        </span>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton${paySlips.id}">
                                        <a class="dropdown-item" href="#" onclick="changeStatusPayslip(${paySlips.id}, 'pending' , ${paySlips.employee_id})">Pending</a>
                                        <a class="dropdown-item" href="#" onclick="changeStatusPayslip(${paySlips.id}, 'approved')">Approved</a>
                                        <a class="dropdown-item" href="#" onclick="changeStatusPayslip(${paySlips.id}, 'paid')">Paid</a>
                                    </div>
                                </div>
                                </td>
                                <td id="editButtonContainer${paySlips.id}">
                                     ${paySlips.status === 'pending' ? `
                                    <a href="/employee/profile/edit/${paySlips.employee_id}" class="btn btn-sm btn-primary btn-icon payslip_edit" data-id="${paySlips.employee_id}">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>` : ''}
                            </td>
                            </tr>
                        `);
                        });
                    }
                    ///
                    $('#showSlipTable').DataTable({
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
                    ///
                },
                error: function(xhr, status, error) {
                    console.error("Failed to fetch pay slips:", error);
                }
            });
        }
        fetchPaySlips();
        ///Status Change
        function changeStatusPayslip(id, status,employee_id) {
            $.ajax({
                url: '/update-status-payslip',
                type: 'POST',
                data: {
                    id: id,
                    status: status,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Update badge color and text dynamically
                    const badge = $('#statusBadge' + id);
                    badge.text(status.charAt(0).toUpperCase() + status.slice(1));

                    // Remove existing badge classes and add new one based on status
                    badge.removeClass('bg-warning bg-success bg-primary');
                    if (status === 'pending') {
                        badge.addClass('bg-warning');
                    } else if (status === 'approved') {
                        badge.addClass('bg-success');
                    } else if (status === 'paid') {
                        badge.addClass('bg-primary');
                    }
                    const editButtonContainer = $('#editButtonContainer' + id);
                    if (status === 'pending') {
                        // Show or add the edit button if status is pending
                        editButtonContainer.html(`
                            <a href="/employee/profile/edit/${employee_id}" class="btn btn-sm btn-primary btn-icon payslip_edit" data-id="${id}">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        `);
                    } else {
                        // Remove the edit button if status is not pending
                        editButtonContainer.html('');
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
