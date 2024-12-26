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
                @php
                    $check = Auth::user()->role ==='employee'
                @endphp
                @if( $check)
                <li class="nav-item">
                    <a class="nav-link active" id="balance-tab" data-bs-toggle="tab" href="#balance" role="tab"
                        aria-controls="balance" aria-selected="false">Leave Application</a>
                </li>
                @else
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
                        aria-controls="balance" aria-selected="false">Leave Application</a>
                </li>
                @endif


            </ul>
            <div class="tab-content border border-top-0 p-3" id="myTabContent">
                @if( $check)
                <div class="tab-pane fade show active" id="balance" role="tabpanel" aria-labelledby="balance-tab">
                    {{-- <div class="card">
                        <div class="card-body"> --}}
                            @include('all_modules.leave_application.leave_application.leave_application')
                        {{-- </div>
                    </div> --}}
                </div>
                @else
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
                    {{-- <div class="card">
                        <div class="card-body"> --}}
                            @include('all_modules.leave_application.leave_limit.leave_limit')
                        {{-- </div>
                    </div> --}}
                </div>

                <div class="tab-pane fade" id="balance" role="tabpanel" aria-labelledby="balance-tab">
                    {{-- <div class="card">
                        <div class="card-body"> --}}
                            @include('all_modules.leave_application.leave_application.leave_application')
                        {{-- </div>
                    </div> --}}
                </div>
                @endif
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

</script>
{{-- ///////////////////////////////////////////////////////////////////////// --}}

@endsection
