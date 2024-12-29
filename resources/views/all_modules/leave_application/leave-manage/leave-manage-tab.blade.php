@extends('master')
@section('title', '| Leave Mnage')
@section('admin')
    {{-- ///////////////////////////////////////////////////////////////////////// --}}
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Leave Manage</li>
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
                            aria-controls="home" aria-selected="true">Leave Application</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab"
                            aria-controls="profile" aria-selected="false">Add Leave Limits</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="balance-tab" data-bs-toggle="tab" href="#balance" role="tab"
                            aria-controls="balance" aria-selected="false">Salary Structure</a>
                    </li>
                </ul>
                <div class="tab-content border border-top-0 p-3" id="myTabContent">

                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="col-md-12">
                            @include('all_modules.leave_application.leave_application.leave_application')

                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                        @include('all_modules.leave_application.leave_limit.leave_limit')

                    </div>

                    <div class="tab-pane fade" id="balance" role="tabpanel" aria-labelledby="balance-tab">

                        {{-- @include('all_modules.employee.salary_structure.salary_structure') --}}

                    </div>

                </div>
            </div>
        </div>
    </div>
    @endsection
