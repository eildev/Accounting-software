@extends('master')
@section('title','| Employee')
@section('admin')
{{-- ///////////////////////////////////////////////////////////////////////// --}}
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Employee Section</li>
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
        <div class="example w-100">
            <ul class="nav nav-tabs" id="myTab" role="tablist">

                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab"
                        aria-controls="home" aria-selected="true">Add Employee</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab"
                        aria-controls="profile" aria-selected="false">Add Leave Limits</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="balance-tab" data-bs-toggle="tab" href="#balance" role="tab"
                        aria-controls="balance" aria-selected="false">Salary Structure</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="IDandPass-tab" data-bs-toggle="tab" href="#IDandPass" role="tab"
                        aria-controls="IDandPass" aria-selected="false">Employee ID and Pass</a>
                </li>

            </ul>
            <div class="tab-content border border-top-0 p-3" id="myTabContent">

                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="col-md-12">
                        {{-- <div class="card">
                            <div class="card-body"> --}}
                                @include('all_modules.employee.add_employee.add_employee')
                            {{-- </div>
                        </div> --}}
                    </div>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                            @include('all_modules.employee.leave_limit.leave_limit')

                </div>

                <div class="tab-pane fade" id="balance" role="tabpanel" aria-labelledby="balance-tab">

                            @include('all_modules.employee.salary_structure.salary_structure')

                </div>
                <div class="tab-pane fade" id="IDandPass" role="tabpanel" aria-labelledby="IDandPass-tab">

                            @include('all_modules.employee.Id-and-pass.Id-and-pass')

                </div>

            </div>
        </div>
    </div>
</div>
<script>

document.getElementById("employeeValidForm").addEventListener("submit", function (e) {
    e.preventDefault(); // Prevent the default form submission

    const formData = new FormData(this);

    fetch(this.action, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
        },
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            toastr.success(data.message);

            fetchEmployees();
            fetchEmployeesAdmin()
            // Activate the 'Add Leave Limits' tab
            const profileTab = document.getElementById("profile-tab");
            const homeTab = document.getElementById("home-tab");

            // Remove active class from current tab
            homeTab.classList.remove("active");
            homeTab.setAttribute("aria-selected", "false");

            // Add active class to 'Add Leave Limits' tab
            profileTab.classList.add("active");
            profileTab.setAttribute("aria-selected", "true");

            // Show the corresponding tab pane
            document.getElementById("home").classList.remove("show", "active");
            document.getElementById("profile").classList.add("show", "active");

            // Optionally reset the form
            document.getElementById("employeeValidForm").reset();
        } else {
            toastr.error('Something Went Wrong'); // Show error message
        }
    })

});
function fetchEmployeesAdmin() {
        $.ajax({
            url: '{{ route('get.employees.admin') }}',
            method: 'GET',
            success: function(data) {

                const employeeDropdown = $('#employeeSelect');
                employeeDropdown.empty(); // Clear existing options
                employeeDropdown.append('<option value="" selected disabled>Select Employee</option>');

                data.forEach(function(employee, index) {
                    const isSelected = index === 0 ? 'selected' : '';
                    employeeDropdown.append(`<option value="${employee.id}" ${isSelected}>${employee.full_name}</option>`);
                });

                $('.js-example-basic-single').select2();

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
    fetchEmployeesAdmin()
</script>
{{-- ///////////////////////////////////////////////////////////////////////// --}}

@endsection
