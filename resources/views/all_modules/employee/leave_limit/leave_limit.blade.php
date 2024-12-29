<div class="row">
    <div class="col-md-12 grid-margin stretch-card d-flex justify-content-end">
        {{-- <div class="">

            <h4 class="text-right"><a href="{{ route('employee.view') }}" class="btn" style="background: #5660D9">View
                    All Employee</a></h4>
        </div> --}}
    </div>
    <div class="col-md-12 stretch-card">
        <div class="card">
            <div class="card-body">
                @php
                    // $employee = App\Models\EmployeePayroll\Employee::all();
                    $LeaveType = App\Models\LeaveApplication\LeaveType::where('status', 'active')->get();
                @endphp
                <form id="limitValidForm" class="leavelimitForm row">
                    <div class="mb-3 col-md-6">
                        <label for="name" class="form-label">Employee Name <span
                                class="text-danger">*</span></label> <br>
                        <select class="js-example-basic-single form-control " name="employee_name" id="employeeIdDown"
                            onchange="filterLeaveTypes2(this)" style="width: 100%">

                        </select>
                        <span class="text-danger employee_name_error"></span>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="name" class="form-label">leave Type Name <span
                                class="text-danger">*</span></label>
                        <select class="form-control " name="leaveType_name" id="leaveTypeDropdown"
                            onchange="errorRemove(this);">
                            <option value="" selected disabled>Select leave Type</option>


                        </select>
                        <span class="text-danger leaveType_error"></span>
                    </div>
                    <div class="mb-3 col-md-12">
                        <label for="name" class="form-label"> Limit Day <span class="text-danger">*</span></label>
                        <input id="defaultconfig" class="form-control leavelimit" name="leavelimit" type="number"
                            onkeyup="errorRemove(this);" onblur="errorRemove(this);">
                        <span class="text-danger leavelimit_error"></span>
                    </div>
            </div>
            <div class="m-3">
                <button type="button" class="btn btn-primary save_limit">Save</button>
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
                    const employeeDropdown = document.getElementById('employeeIdDown');
                        const selectedEmployeeId = employeeDropdown.value;

                        // Check if an employee is selected and update leave types
                        if (selectedEmployeeId) {
                            filterLeaveTypes2({ value: selectedEmployeeId }); // Call filterLeaveTypes2 with the selected employee ID
                        }
                    if (res.status == 200) {
                        $('#exampleModalLongScollable').modal('hide');
                        $('.leavelimitForm')[0].reset();

                        toastr.success(res.message);
                        const profileTab = document.getElementById("profile-tab");
                        const balanceTab = document.getElementById("balance-tab");

                      // Remove active class from current tab
                        profileTab.classList.remove("active");
                        profileTab.setAttribute("aria-selected", "false");

                        // Add active class to 'Add Leave Limits' tab
                        balanceTab.classList.add("active");
                        balanceTab.setAttribute("aria-selected", "true");

                        // Show the corresponding tab pane

                        document.getElementById("balance").classList.add("show", "active");
                        document.getElementById("profile").classList.remove("show", "active");

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

    });
    ///////////////////////////Leave Type get if not inserted////////////////////////////
    function filterLeaveTypes2(select) {
        const employeeId = select.value; // Get selected employee ID
        const leaveTypeDropdown = document.getElementById('leaveTypeDropdown');

        // Clear current options in leave type dropdown
        leaveTypeDropdown.innerHTML = '<option value="" selected disabled>Select Leave Type</option>';

        // Fetch available leave types for the selected employee
        fetch(`/get-available-leave-types/${employeeId}`)
            .then(response => response.json())
            .then(data => {
                // console.log(data);

                if (data.leaveTypes.length > 0) {
                    data.leaveTypes.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.name;
                        leaveTypeDropdown.appendChild(option);

                    });
                } else {
                    const option = document.createElement('option');
                    option.textContent = 'No leave types available';
                    leaveTypeDropdown.appendChild(option);
                }
            })
    }
    function fetchEmployees() {
        $.ajax({
            url: '{{ route('get.employees') }}',
            method: 'GET',
            success: function(data) {

                const employeeDropdown = $('#employeeIdDown');
                employeeDropdown.empty(); // Clear existing options
                employeeDropdown.append('<option value="" selected disabled>Select Employee</option>');

                data.forEach(function(employee, index) {
                    const isSelected = index === 0 ? 'selected' : '';
                    employeeDropdown.append(`<option value="${employee.id}" ${isSelected}>${employee.full_name}</option>`);
                });

                // Reinitialize the select plugin after dynamically updating options
                $('.js-example-basic-single').select2();
                // const firstEmployee = data[0];
                //     if (firstEmployee) {
                //         filterLeaveTypes2({ value: firstEmployee.id }); // Simulate a select element with the first employee's ID
                //}
                 const latestEmployee = data[0];
                if (latestEmployee) {
                    employeeDropdown.val(latestEmployee.id).trigger('change');
                    filterLeaveTypes2(); // Refresh leave types for the latest employee
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching employees:', error);
            }
        });
    }
    $(document).ready(function() {
        fetchEmployees();
        filterLeaveTypes2();
    });

//     document.getElementById("limitValidForm").addEventListener("submit", function (e) {
//     e.preventDefault(); // Prevent the default form submission

//     const formData = new FormData(this);

//     fetch(this.action, {
//         method: "POST",
//         headers: {
//             "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
//         },
//         body: formData,
//     })
//     .then(response => response.json())
//     .then(data => {
//         if (data.success) {
//             // Show success message
//             toastr.success(data.message);
//             // Activate the 'Add Leave Limits' tab
//             const profileTab = document.getElementById("profile-tab");
//             const balanceTab = document.getElementById("balance-tab");

//             // Remove active class from current tab
//             profileTab.classList.remove("active");
//             profileTab.setAttribute("aria-selected", "false");

//             // Add active class to 'Add Leave Limits' tab
//             balanceTab.classList.add("active");
//             balanceTab.setAttribute("aria-selected", "true");

//             // Show the corresponding tab pane

//             document.getElementById("balance").classList.add("show", "active");
//             document.getElementById("home").classList.remove("show", "active");

//             // Optionally reset the form
//             document.getElementById("limitValidForm").reset();
//         } else {
//             toastr.error('Something Went Wrong'); // Show error message
//         }
//     })

// });

</script>
