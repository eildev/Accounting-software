@extends('master')
@section('title', '| Leave Application ')
@section('admin')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Leave Application</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="card-title">Leave Application Table</h6>
                        @if (Auth::user()->can('leave.application.add'))
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#exampleModalLongScollable">Add Leave Application</button>
                         @endif
                    </div>

                    <div id="" class="table-responsive">
                        <table id="example" class="table">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Employee Name</th>
                                    <th>Subject</th>
                                    <th>Leave Type</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Total Days</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody class="showleaveData">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $employee = App\Models\EmployeePayroll\Employee::all();
        $LeaveType = App\Models\LeaveApplication\LeaveType::where('status', 'active')->get();
    @endphp

    <!--  leave Limits Add Modal -->
    <div class="modal fade" id="exampleModalLongScollable" tabindex="-1" aria-labelledby="exampleModalScrollableTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Add Leave Application Info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form id="signupForm" class="leaveAppliactionForm row">
                        <div class="mb-3 col-md-12">
                            <label for="name" class="form-label">Subject <span class="text-danger">*</span></label>
                            <input id="defaultconfig" class="form-control subject" name="subject" type="text"
                                onkeyup="errorRemove(this);" onblur="errorRemove(this);">
                            <span class="text-danger subject_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Employee Name <span
                                    class="text-danger">*</span></label>

                                    @php
                                    $id = Illuminate\Support\Facades\Auth::user()->employee_id;
                                    $limits = App\Models\LeaveApplication\LeaveLimits::where('employee_id', $id)->get();
                                    // dd($limits);
                                    @endphp
                            @if ($id)
                            <select class="form-control " name="employee_name" onchange="errorRemove(this);">
                                <option value="{{ Auth::user()->employee_id }}">{{ Auth::user()->name }}</option>
                            </select>
                                {{-- <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly> --}}
                            @else
                                <select class="form-control " name="employee_name" onchange="errorRemove(this);">
                                    <option value="" selected disabled>Select Employee</option>
                                    @foreach ($employee as $item)
                                        <option value="{{ $item->id }}">{{ $item->full_name }}</option>
                                    @endforeach
                                </select>
                            @endif
                            <span class="text-danger employee_name_error"></span>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">leave Type Name <span id="totalLeave"></span> <span
                                    class="text-danger">*</span></label>
                            <select class="form-control " name="leaveType_name"
                                onchange="fetchTotalLeave(this.value, {{ $id }});errorRemove(this)">
                                <option value="" selected disabled>Select leave Type</option>
                                @if ($limits)
                                    @foreach ($limits as $limit)
                                        <option value="{{ $limit->leaveType->id }}">{{ $limit->leaveType->name }}</option>
                                    @endforeach
                                @else
                                    @foreach ($LeaveType as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <span class="text-danger leaveType_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label"> Start Day <span class="text-danger">*</span></label>
                            <div class="input-group flatpickr me-2 mb-2 mb-md-0 date-select" id="dashboardDate">
                                <span class="input-group-text input-group-addon bg-transparent border-primary"
                                    data-toggle><i data-feather="calendar" class="text-primary"></i></span>
                                <input type="text" name="start_date" id="start_date" onkeyup="errorRemove(this);"
                                    onblur="errorRemove(this);"
                                    class="form-control start_date bg-transparent border-primary" placeholder="Select date"
                                    data-input>
                            </div>
                            <span class="text-danger start_date_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label"> End Day <span class="text-danger">*</span></label>
                            <div class="input-group flatpickr me-2 mb-2 mb-md-0 date-select" id="dashboardDate">
                                <span class="input-group-text input-group-addon bg-transparent border-primary"
                                    data-toggle><i data-feather="calendar" class="text-primary "></i></span>
                                <input type="text" name="end_date" id="end_date" onkeyup="errorRemove(this);"
                                    onblur="errorRemove(this);"
                                    class="form-control end_date bg-transparent border-primary" placeholder="Select date"
                                    data-input>
                            </div>
                            <span class="text-danger end_date_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label"> Total Days <span
                                    class="text-danger">*</span></label>
                            <input id="total_day" class="form-control total_day" name="total_day" type="number"
                                onkeyup="errorRemove(this);" onblur="errorRemove(this);">
                            <span class="text-danger total_day_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label"> Message </label>
                            <textarea id="defaultconfig" class="form-control " name="message" onkeyup="errorRemove(this);"
                                onblur="errorRemove(this);"> </textarea>

                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save_application">Save</button>
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
            const save_application = document.querySelector('.save_application');
            const leavelimitForm = document.querySelector('.leaveAppliactionForm');
            leavelimitForm.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                }
            });
            save_application.addEventListener('click', function(e) {
                // console.log('ok');

                e.preventDefault();
                let formData = new FormData($('.leaveAppliactionForm')[0]);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/leave/application/store',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.status == 200) {
                            $('#exampleModalLongScollable').modal('hide');
                            $('.leaveAppliactionForm')[0].reset();
                            LeaveApplicationView();
                            toastr.success(res.message);
                        } else {
                            if (res.error.subject) {
                                showError('.subject', res.error.subject);
                            }
                            if (res.error.employee_name) {
                                showError('.employee_name', res.error.employee_name);
                            }
                            if (res.error.leaveType_name) {
                                showError('.leaveType', res.error.leaveType_name);
                            }
                            if (res.error.leavelimit) {
                                showError('.leavelimit', res.error.leavelimit);
                            }
                            if (res.error.start_date) {
                                showError('.start_date', res.error.start_date);
                            }
                            if (res.error.end_date) {
                                showError('.end_date', res.error.end_date);
                            }
                            if (res.error.total_day) {
                                showError('.total_day', res.error.total_day);
                            }
                        }
                    }
                });
            });
            const userRole = @json(Auth::user()->role);

            function LeaveApplicationView() {
                $.ajax({
                    url: '/leave/application/view',
                    method: 'GET',
                    success: function(res) {
                        const leaveApplications = res.data;
                        // console.log(leaveApplications);
                        $('.showleaveData').empty();
                        if ($.fn.DataTable.isDataTable('#example')) {
                            $('#example').DataTable().clear().destroy();
                        }
                        // Check if leave Types data is present
                        if (leaveApplications.length > 0) {
                            $.each(leaveApplications, function(index, leaveApplication) {
                                const tr = document.createElement('tr');
                                tr.innerHTML = `
                                            <td>${index + 1}</td>
                                            <td>${leaveApplication.employee?.full_name ?? ""}</td>
                                             <td>${leaveApplication.subject ??''}</td>
                                             <td>${leaveApplication.leave_type?.name?? "N/A"}</td>
                                             <td>${leaveApplication.leave_application_details[0]?.start_date ?? "-"}</td>
                                            <td>${leaveApplication.leave_application_details[0]?.end_date ?? "-"}</td>
                                            <td>${leaveApplication.leave_application_details[0]?.total_day ?? "-"}</td>
                                            <td>
                                        ${
                                            userRole === 'hr'
                                            ? `
                                                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton${leaveApplication.id}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span id="statusBadge${leaveApplication.id}" class="badge text-dark ${
                                                        leaveApplication.status === 'pending' ? 'bg-warning' :
                                                        leaveApplication.status === 'approved' ? 'bg-success' :
                                                        leaveApplication.status === 'canceled' ? 'bg-danger' : 'bg-danger'
                                                    }">
                                                        ${leaveApplication.status ? leaveApplication.status.charAt(0).toUpperCase() + leaveApplication.status.slice(1) : ''}
                                                    </span>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton${leaveApplication.id}">
                                                    <a class="dropdown-item" href="#" onclick="changeStatusleave(${leaveApplication.id}, 'pending')">Pending</a>
                                                    <a class="dropdown-item" href="#" onclick="changeStatusleave(${leaveApplication.id}, 'approved')">Approved</a>
                                                    <a class="dropdown-item" href="#" onclick="changeStatusleave(${leaveApplication.id}, 'canceled')">Cancel</a>
                                                </div>
                                                `
                                                : userRole === 'employee'
                                                ? `
                                                    <span id="statusBadge${leaveApplication.id}" class="badge text-dark ${
                                                        leaveApplication.status === 'pending' ? 'bg-warning' :
                                                        leaveApplication.status === 'approved' ? 'bg-success' :
                                                        leaveApplication.status === 'canceled' ? 'bg-danger' : 'bg-danger'
                                                    }">
                                                        ${leaveApplication.status ? leaveApplication.status.charAt(0).toUpperCase() + leaveApplication.status.slice(1) : ''}
                                                    </span>
                                                `
                                            : `
                                                <div class="dropdown" id="statusChange${leaveApplication.id}">
                                                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton${leaveApplication.id}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span id="statusBadge${leaveApplication.id}" class="badge text-dark ${
                                                            leaveApplication.status === 'pending' ? 'bg-warning' :
                                                            leaveApplication.status === 'approved' ? 'bg-success' :
                                                            leaveApplication.status === 'canceled' ? 'bg-danger' : 'bg-danger'
                                                        }">
                                                            ${leaveApplication.status ? leaveApplication.status.charAt(0).toUpperCase() + leaveApplication.status.slice(1) : ''}
                                                        </span>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton${leaveApplication.id}">
                                                        <a class="dropdown-item" href="#" onclick="changeStatusleave(${leaveApplication.id}, 'pending')">Pending</a>
                                                        <a class="dropdown-item" href="#" onclick="changeStatusleave(${leaveApplication.id}, 'approved')">Approved</a>
                                                        <a class="dropdown-item" href="#" onclick="changeStatusleave(${leaveApplication.id}, 'canceled')">Cancel</a>
                                                    </div>
                                                </div>
                                                `
                                        }
                                    </td>

                               `;
                                $('.showleaveData').append(tr);
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
            LeaveApplicationView();


            ////////////Date Calculate ////
            function calculateTotalDays() {
                const startDate = document.querySelector('.start_date').value;
                const endDate = document.querySelector('.end_date').value;
                const totalDaysInput = document.querySelector('#total_day');

                if (startDate && endDate) {
                    const start = new Date(startDate);
                    const end = new Date(endDate);

                    // Calculate the difference in time
                    const timeDiff = end - start;

                    // Convert time difference to days
                    const daysDiff = timeDiff / (1000 * 60 * 60 * 24);
                    // Set the total days
                    totalDaysInput.value = daysDiff >= 0 ? daysDiff + 1 : 0; // Include both start and end dates

                    const totalDaysInput2 = document.querySelector('#total_day').value;
                    console.log(totalDaysInput2)

                } else {
                    totalDaysInput.value = ''; // Clear total days if either date is missing
                }
            }
            calculateTotalDays()
            // Add event listeners to trigger calculation
            document.querySelector('.start_date').addEventListener('change', calculateTotalDays);
            document
                .querySelector('.end_date').addEventListener('change', calculateTotalDays);
        });
        ///////////////////Status Change ////////////
        function changeStatusleave(id, status) {
            if ($('#statusBadge' + id).text().trim().toLowerCase() === 'approved') {
                toastr.warning("Status cannot be changed as it's already 'Approved'.");
                return;
            }
            $.ajax({
                url: '/leave-application/update-status', // Adjust with your route URL
                type: 'POST',
                data: {
                    id: id,
                    status: status,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Update badge color and text
                    let badge = $('#statusBadge' + id);
                    badge.text(status.charAt(0).toUpperCase() + status.slice(1));

                    if (status === 'pending') {
                        badge.removeClass('bg-success bg-primary bg-danger bg-info').addClass('bg-warning');
                    } else if (status === 'approved') {
                        badge.removeClass('bg-warning bg-primary bg-danger bg-info').addClass('bg-success');
                    } else if (status === 'canceled') {
                        badge.removeClass('bg-warning bg-success bg-primary').addClass('bg-danger');
                    }
                },
                error: function(error) {
                    console.error("Error updating status", error);
                }
            });
        }
        ///Show Total Leave
        function fetchTotalLeave(leaveTypeId, employeeId) {

            if (!leaveTypeId) return;

            fetch(`/get-total-leave-data/${leaveTypeId}/${employeeId}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log(data);
                        const leaveDataDiv = document.getElementById('totalLeave');
                        leaveDataDiv.innerHTML = `

                    <span><strong>Limit:</strong> ${data.limit}</span>
                `;
                    } else {
                        alert(data.message || 'Failed to fetch leave data.');
                    }
                })
                .catch(error => console.error('Error fetching leave data:', error));
        }
    </script>
@endsection
