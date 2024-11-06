@extends('master')
@section('title', '| Employee Profile Employee')
@section('admin')
    <div class="row">
        <div class="col-12  grid-margin">
            <div class="card">
                <div class="position-relative">
                    <figure class="overflow-hidden mb-0 d-flex justify-content-center">
                        <img src="{{ asset('uploads/employee/default-cover.jpeg') }}" height="390" width="1560" class="rounded-top" alt="profile cover">
                    </figure>
                    <div
                        class="d-flex justify-content-between align-items-center position-absolute top-90 w-100 px-2 px-md-4 mt-n4">
                        <div>
                            <img class="wd-70 rounded-circle" src="{{ $employee->pic ? asset('uploads/employee/' . $employee->pic) : asset('uploads/employee/dafault-profile.jpg') }}"
                                alt="profile">
                            <span class="h4 ms-3 text-dark">{{ $employee->full_name }}</span>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center p-3 rounded-bottom">
                    <ul class="d-flex align-items-center m-0 p-0 nav nav-tabs" id="myTab" role="tablist">
                        <li class="d-flex align-items-center active">
                            <a class="pt-1px d-none d-md-block text-primary nav-link active" id="Home-tab"
                                data-bs-toggle="tab" href="#home" role="tab" aria-controls="home"
                                aria-selected="true">Salary Structure</a>
                        </li>
                        <li class="ms-3 ps-3 border-start d-flex align-items-center">
                            <i class="me-1 icon-md" data-feather="user"></i>
                            <a class="pt-1px d-none d-md-block text-body nav-link" id="convenience-tab" data-bs-toggle="tab"
                                href="#convenience" role="tab" aria-controls="convenience" aria-selected="false">Convenience Bill</a>
                        </li>
                        <li class="ms-3 ps-3 border-start d-flex align-items-center">
                            <i class="me-1 icon-md" data-feather="users"></i>
                            <a class="pt-1px d-none d-md-block text-body" href="#">Friends <span
                                    class="text-muted tx-12">3,765</span></a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row profile-body">
        <!-- left wrapper start -->
        <div class="d-none d-md-block col-md-4 col-xl-3 left-wrapper">
            <div class="card rounded">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center  text-center justify-content-between mb-2">
                        <h4 class="card-title mb-0  text-center">Name</h4>
                        <h6>{{ $employee->full_name ?? '-' }}</h6>
                    </div>
                    <div class="d-flex align-items-center  text-center justify-content-between mb-2">
                        <h4 class="card-title mb-0  text-center">Phone</h4>
                        <h6>{{ $employee->phone ?? '-' }}</h6>
                    </div>
                    <div class="d-flex align-items-center  text-center justify-content-between mb-2">
                        <h4 class="card-title mb-0  text-center">Email</h4>
                        <h6>{{ $employee->email ?? '-' }}</h6>
                    </div>
                    <div class="d-flex align-items-center  text-center justify-content-between mb-2">
                        <h4 class="card-title mb-0  text-center">Designation </h4>
                        <h6>{{ $employee->designation ?? '-' }}</h6>
                    </div>
                    <div class="d-flex align-items-center  text-center justify-content-between mb-2">
                        <h4 class="card-title mb-0  text-center">Address</h4>
                        <h6>{{ $employee->address ?? '-' }}</h6>
                    </div>
                </div>
            </div>
        </div>
        <!-- left wrapper end -->
        <!-- middle wrapper start -->

        <div class="col-md-8 col-xl-9 middle-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin ">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="card rounded">
                                <div class="card-body">
                                    <p class="mb-3 tx-14">Salary Structure</p>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Salary</th>
                                                <th>House Rent</th>
                                                <th>Transport Allowance</th>
                                                <th>Deductions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $salaryStructure->base_salary ?? '-' }}</td>
                                                <td>{{ $salaryStructure->house_rent ?? '-' }}</td>
                                                <td>{{ $salaryStructure->transport_allowance ?? '-' }}</td>
                                                <td>{{ $salaryStructure->deductions ?? '-' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade " id="convenience" role="tabpanel" aria-labelledby="convenience-tab">
                            <div class="card rounded">
                                <div class="card-body">
                                    <p class="mb-3 tx-14">Convenience Bill</p>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Invoice No</th>
                                                <th>Total Amount</th>
                                                <th>Create Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                @foreach ($conveniences as $convenience)
                                                <tr>
                                                <td><a href="{{route('convenience.invoice', $convenience->id)}}">{{ $convenience->bill_number ?? '-' }}</a></td>
                                                <td>{{ $convenience->total_amount ?? '-' }}</td>
                                                <td>{{ $convenience->created_at ? $convenience->created_at->format('d F Y') : '-' }}</td>
                                               </tr>
                                                @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
