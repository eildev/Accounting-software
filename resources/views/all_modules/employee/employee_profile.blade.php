@extends('master')
@section('title', '| Employee Profile Employee')
@section('admin')
<style>
    .nav-link:hover, .nav-link:focus {
    color: #5660D9 !important;
    /* background-color: var(--nav-hover-background-color); */
}
</style>
    <div class="row">
        <div class="col-12  grid-margin">
            <div class="card">
                <div class="position-relative">
                    <figure class="overflow-hidden mb-0 d-flex justify-content-center">
                        <img src="{{ asset('uploads/employee/default-cover.jpeg') }}" height="390" width="1560"
                            class="rounded-top" alt="profile cover">
                    </figure>
                    <div
                        class="d-flex justify-content-between align-items-center position-absolute top-90 w-100 px-2 px-md-4 mt-n4">
                        <div>
                            <img class="wd-70 rounded-circle"
                                src="{{ $employee->pic ? asset('uploads/employee/' . $employee->pic) : asset('uploads/employee/dafault-profile.jpg') }}"
                                alt="profile">
                            <span class="h4 ms-3 text-dark">{{ $employee->full_name }}</span>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center p-3 rounded-bottom">
                    <ul class="d-flex align-items-center m-0 p-0 nav nav-tabs" id="myTab" role="tablist">

                        <li class="d-flex align-items-center active">
                            <i class="me-1 icon-md" data-feather="credit-card"></i>
                            <a class="pt-1px d-md-block text-dark nav-link active" id="Home-tab"
                                data-bs-toggle="tab" href="#home" role="tab" aria-controls="home"
                                aria-selected="true">Salary Month Info</a>
                        </li>

                        <li class="ms-3 ps-3 border-start d-flex align-items-center">
                            <i class="me-1 icon-md" data-feather="dollar-sign"></i>
                            <a class="pt-1px d-md-block text-body nav-link" id="convenience-tab" data-bs-toggle="tab"
                                href="#convenience" role="tab" aria-controls="convenience"
                                aria-selected="false">Convenience Bill</a>
                        </li>

                        <li class="ms-3 ps-3 border-start d-flex align-items-center">
                            <i class="me-1 icon-md" data-feather="file-text"></i>
                            <a class="pt-1px d-md-block text-body nav-link" id="payslip-tab" data-bs-toggle="tab"
                                href="#payslip" role="tab" aria-controls="payslip" aria-selected="false">PaySlip
                                Genarator</a>
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
                <div class="card-body ">
                    {{-- <h5 class="text-center">Info</h5> --}}
                    <div class=" align-items-center  justify-content-between mb-2">
                        <h4 class="card-title mb-0  ">Name :</h4>
                        <h6 class="mt-1" style="color: #7987a1">{{ $employee->full_name ?? '-' }}</h6>
                    </div>
                    <div class=" align-items-center justify-content-between mb-2">
                        <h4 class="card-title mb-0 ">Phone :</h4>
                        <h6 class="mt-1" style="color: #7987a1">{{ $employee->phone ?? '-' }}</h6>
                    </div>
                    <div class=" align-items-center justify-content-between mb-2">
                        <h4 class="card-title mb-0 ">Email :</h4>
                        <h6 class="mt-1" style="color: #7987a1">{{ $employee->email ?? '-' }}</h6>
                    </div>
                    <div class=" align-items-center   justify-content-between mb-2">
                        <h4 class="card-title mb-0  ">Designation :</h4>
                        <h6 class="mt-1" style="color: #7987a1">{{ $employee->designation ?? '-' }}</h6>
                    </div>
                    <div class="align-items-center   justify-content-between mb-2">
                        <h4 class="card-title mb-0  ">Address :</h4>
                        <h6 class="mt-1" style="color: #7987a1">{{ $employee->address ?? '-' }}</h6>
                    </div>
                </div>
            </div>
            <div class="card rounded mt-3">
                <div class="card-body ">
                    <h5 class="text-center">Salary Structure</h5>
                    <div class=" align-items-center mt-3  justify-content-between mb-2">
                        <h4 class="card-title mb-0  ">Salary :</h4>
                        <h6 class="mt-1" style="color: #7987a1">{{ $salaryStructure->base_salary ?? '-' }}</h6>
                    </div>
                    <div class=" align-items-center justify-content-between mb-2">
                        <h4 class="card-title mb-0 ">House Rent :</h4>
                        <h6 class="mt-1" style="color: #7987a1">{{ $salaryStructure->house_rent ?? '-' }}</h6>
                    </div>
                    <div class=" align-items-center justify-content-between mb-2">
                        <h4 class="card-title mb-0 ">Transport Allowance :</h4>
                        <h6 class="mt-1" style="color: #7987a1">{{ $salaryStructure->transport_allowance ?? '-' }}</h6>
                    </div>
                    <div class=" align-items-center   justify-content-between mb-2">
                        <h4 class="card-title mb-0  ">Other Fixed Allowance :</h4>
                        <h6 class="mt-1" style="color: #7987a1">{{ $salaryStructure->other_fixed_allowances ?? '-' }}
                        </h6>
                    </div>
                    <div class="align-items-center   justify-content-between mb-2">
                        <h4 class="card-title mb-0  ">Deductions :</h4>
                        <h6 class="mt-1" style="color: #7987a1">{{ $salaryStructure->deductions ?? '-' }}</h6>
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
                        <div class="tab-pane fade show active" id="home" role="tabpanel"
                            aria-labelledby="home-tab">
                            <div class="card rounded">
                                <div class="card-body table-responsive">
                                    <p class="mb-3 tx-14">Salary Month Info</p>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Pay Date</th>
                                                <th>Total Gross Salary</th>
                                                <th>Total Deductions</th>
                                                <th>Total Net Salary</th>
                                                <th>Total Bonus Amount</th>
                                                <th>Total Conveyance Amount</th>

                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="showSlip">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade " id="convenience" role="tabpanel" aria-labelledby="convenience-tab">
                            <div class="card rounded">
                                <div class="card-body">

                                    <div class="col-md-12 grid-margin stretch-card">

                                        <div
                                            class="col-md-12 grid-margin stretch-card d-flex  mb-0 justify-content-between">
                                            <p class="mb-3 tx-14">Conveyance Bill</p>
                                            <div class="">
                                                <h5 class="text-right"><a href="{{ route('convenience') }}"
                                                        class="btn btn-sm" style="background: #5660D9">Add Conveyance
                                                        Bill</a></h5>
                                            </div>
                                        </div>

                                    </div>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Invoice No</th>
                                                <th>Total Amount</th>
                                                <th>Create Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($conveniences as $convenience)
                                                <tr>
                                                    <td><a
                                                            href="{{ route('convenience.invoice', $convenience->id) }}">{{ $convenience->bill_number ?? '-' }}</a>
                                                    </td>
                                                    <td>{{ $convenience->total_amount ?? '-' }}</td>
                                                    <td>{{ $convenience->created_at ? $convenience->created_at->format('d F Y') : '-' }}
                                                    </td>
                                                    <td>
                                                        @if ($convenience->status == 'pending')
                                                            <p class="btn btn-sm badge bg-warning ">Pending</p>
                                                        @elseif($convenience->status == 'approved')
                                                            <p class="btn btn-sm badge bg-success">Approved</p>
                                                        @elseif($convenience->status == 'paid')
                                                            <p class="btn btn-sm badge bg-success">Paid</p>
                                                        @else
                                                            <p class="btn btn-sm badge bg-info color-black">Processing</p>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @php
                            $totalEarnings = 0;
                            if ($salaryStructure) {
                                $totalEarnings =
                                    ($salaryStructure->base_salary ?? 0) +
                                    ($salaryStructure->house_rent ?? 0) +
                                    ($salaryStructure->transport_allowance ?? 0) +
                                    ($salaryStructure->other_fixed_allowances ?? 0) +
                                    ($totalBonusAmount ?? 0) +
                                    ($conveniencesTotalAmount ?? 0);
                            }
                            $deductions = $salaryStructure->deductions ?? 0;
                            $netPay = $totalEarnings - $deductions;
                        @endphp
                        <div class="tab-pane fade " id="payslip" role="tabpanel" aria-labelledby="payslip-tab">
                            <div class="card rounded">
                                <div class="card-body">
                                    <p class="mb-3 tx-14">Current Month Salary</p>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <p class="mb-3 tx-14">Gross Salary</p>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Title</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Base Salary</td>
                                                        <td>{{ $salaryStructure->base_salary ?? 0 }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>House Rent</td>
                                                        <td>{{ $salaryStructure->house_rent ?? 0 }}</td>
                                                    </tr>

                                                    <tr>
                                                        <td>Transport Allowance</td>
                                                        <td>{{ $salaryStructure->transport_allowance ?? 0 }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Other Fixed Allowances</td>
                                                        <td>{{ $salaryStructure->other_fixed_allowances ?? 0 }}</td>
                                                    </tr>
                                                    {{-- @foreach ($bonuses as $bonus)
                                                    <tr>
                                                        <td>Employee Bonus</td>
                                                        <td>{{$bonus->bonus_amount}}</td>
                                                    </tr>
                                                    @endforeach --}}
                                                    @php
                                                        $totalBonusConv =
                                                            ($payslip_id->total_employee_bonus ?? 0) +
                                                            ($payslip_id->total_convenience_amount ?? 0);
                                                    @endphp
                                                    <tr>
                                                        @if (Request::is('employee/profile/edit/*'))
                                                            <td>Total Employee Bonus</td>
                                                            <td> {{ $totalBonusAmount + $payslip_id->total_employee_bonus ?? 0 }}<span>.00</span>
                                                            </td>
                                                        @else
                                                            <td>Total Employee Bonus</td>
                                                            <td>{{ $totalBonusAmount ?? 0 }}<span>.00</span></td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        @if (Request::is('employee/profile/edit/*'))
                                                            <td>Total Conveyance Amount</td>
                                                            <td>{{ $conveniencesTotalAmount + $payslip_id->total_convenience_amount ?? 0 }}<span>.00</span>
                                                            </td>
                                                        @else
                                                            <td>Total Conveyance Amount</td>
                                                            <td>{{ $conveniencesTotalAmount ?? 0 }}<span>.00</span></td>
                                                        @endif

                                                    </tr>
                                                    {{-- <tr style="font-size: 20px;font-weignt:bold">
                                                        <td>Total Gross </td>
                                                        <td>{{ $totalEarnings ?? 0 }}<span>.00</span></td>
                                                    </tr> --}}
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="mb-3 tx-14">Total Amount </p>
                                            <table class="table "
                                                style="font-size: 15px; font-weignt:bold ;margin-right: 10px">
                                                <thead>
                                                    <tr>
                                                        <th>Title</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <tr>
                                                        @if (Request::is('employee/profile/edit/*'))
                                                            <td>Total Gross : </td>
                                                            <td>{{ $totalEarnings + $totalBonusConv ?? 0 }}<span>.00</span>
                                                            </td>
                                                        @else
                                                            <td>Total Gross : </td>
                                                            <td>{{ $totalEarnings ?? 0 }}<span>.00</span></td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <td>Deductions Amount : </td>
                                                        <td>{{ $salaryStructure->deductions ?? 0 }} </td>
                                                    </tr>
                                                    <tr>
                                                        @if (Request::is('employee/profile/edit/*'))
                                                            <td>Net Salary : </td>
                                                            <td>{{ $netPay + $totalBonusConv ?? 0 }}<span>.00</span></td>
                                                        @else
                                                            <td>Net Salary : </td>
                                                            <td>{{ $netPay ?? 0 }} .00 </td>
                                                        @endif
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <hr>
                                        <div class="col-md-12 text-end mt-2" style="">
                                            {{-- <p class="mb-3" style="font-size: 20px; font-weignt:bold ;margin-right: 65px"> Net Salary = {{ $netPay }}<span>.00</span> </p> --}}
                                        </div>


                                        {{-- <div class="col-md-12 text-center mt-2 ">
                                            <a href="#" onclick="previewPayslip()" class="btn btn-sm fs-5"
                                                style="background-color: #6571FF;color:#fff">Genarate Slip</a>
                                        </div> --}}
                                        @if (Auth::user()->can('genarate.payslip.single'))
                                            @if (Request::is('employee/profile/*') && !Request::is('employee/profile/edit/*'))
                                                <div class="col-md-12 text-center mt-2">
                                                    <a href="#" onclick="previewPayslip()" class="btn btn-sm fs-5"
                                                        style="background-color: #6571FF; color:#fff;">
                                                        Generate Slip
                                                    </a>
                                                </div>
                                            @endif
                                        @endif
                                        @if (Request::is('employee/profile/edit/*'))
                                            <div class="col-md-12 text-center mt-2">
                                                <a href="#" class="btn btn-sm fs-5" onclick="updatePayslip()"
                                                    style="background-color: #6571FF; color:#fff;">
                                                    Update Slip
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for Preview -->
    <div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="border: 2px solid #333; padding: 20px;">
                <form action="" class="paySlipForm">
                    <input type="hidden" name="total_deductions" value="{{ $deductions ?? 0 }}">
                    <input type="hidden" name="total_gross_salary" value="{{ $totalEarnings ?? 0 }}">
                    <input type="hidden" name="total_employee_bonus" value="{{ $totalBonusAmount ?? 0 }}">
                    <input type="hidden" name="total_convenience_amount" value="{{ $conveniencesTotalAmount ?? 0 }}">
                    <input type="hidden" name="total_net_salary" value="{{ $netPay ?? 0 }}">
                    <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                    <input type="hidden" name="base_salary" value="{{ $salaryStructure->base_salary ?? 0 }}">

                    @foreach ($conveniencesAmount as $convenience)
                        <input type="hidden" name="convenience_ids[]" value="{{ $convenience->id }}">
                    @endforeach

                    @foreach ($bonuses as $bonus)
                        <input type="hidden" name="bonus_ids[]" value="{{ $bonus->id }}">
                    @endforeach
                    <div class="modal-body" style="font-family: Arial, sans-serif;">

                        <!-- Payslip Title and Date -->
                        <div style="text-align: center; margin-bottom: 20px;">
                            <h2 style="font-weight: bold; margin: 0;">Payslip</h2>
                            <p class="mt-2">Pay Date: {{ date('Y/m/d') }}</p>
                        </div>

                        <!-- Employee Details -->
                        <div style="margin-bottom: 15px;">
                            <p><strong>Employee Name:</strong> {{ $employee->full_name ?? '-' }}</p>
                            <p><strong>Employee ID:</strong> 00{{ $employee->id ?? '' }}</p>

                        </div>

                        <!-- Earnings Section -->
                        <div style="border: 1px solid #333; padding: 10px; margin-bottom: 15px;">
                            <h6><strong> Gross </strong></h6>
                            <table class="table table-bordered" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Basic Salary</td>
                                        <td>{{ $salaryStructure->base_salary ?? 0 }}</td>
                                    </tr>
                                    <tr>
                                        <td>House Rent</td>
                                        <td>{{ $salaryStructure->house_rent ?? 0 }}</td>
                                    </tr>
                                    <tr>
                                        <td>Transport Allowance</td>
                                        <td>{{ $salaryStructure->transport_allowance ?? 0 }}</td>
                                    </tr>
                                    <tr>
                                        <td>Other Fixed Allowance</td>
                                        <td>{{ $salaryStructure->other_fixed_allowances ?? 0 }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Employee Bonus</td>
                                        <td>{{ $totalBonusAmount ?? 0 }}<span>.00</span></td>
                                    </tr>
                                    <tr>
                                        <td>Total Convenience Amount</td>
                                        <td>{{ $conveniencesTotalAmount ?? 0 }}<span>.00</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total Gross </strong></td>
                                        <td><strong>{{ $totalEarnings }}.00</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!--- Deductions Section --->
                        <div style="border: 1px solid #333; padding: 10px; margin-bottom: 15px;">
                            <h6><strong>Deductions</strong></h6>
                            <table class="table table-bordered" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- <tr>
                                        <td>Deductions</td>
                                        <td>{{ $deductions}}</td>
                                    </tr> --}}
                                    <tr>
                                        <td><strong>Total Deductions</strong></td>
                                        <td><strong>{{ $deductions }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Net Pay Section -->
                        <div
                            style="margin-top: 15px; padding: 10px; background-color: #000; text-align: center; color:#fff">
                            <h6><strong>Net Salary:</strong> {{ $netPay }}<span>.00</span></h6>
                        </div>

                        {{-- <!-- Signature Section -->
                    <div style="margin-top: 30px; text-align: center;">
                        <div style="display: inline-block; width: 45%; text-align: center;">
                            <p><strong>Employer Signature</strong></p>
                            <p>______________________________</p>
                        </div>
                        <div style="display: inline-block; width: 45%; text-align: center;">
                            <p><strong>Employee Signature</strong></p>
                            <p>______________________________</p>
                        </div>
                    </div> --}}

                        <!-- Footer -->
                        <div style="text-align: center; margin-top: 20px;">
                            <p style="font-size: 12px;">This is a system-generated payslip</p>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top: 1px solid #333;">
                        <button type="button" class="btn print btn-primary">Print</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            onclick="$('#previewModal').modal('hide');">Close</button>
                        <button type="button" class="save_pay_slip btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- update Modal for Preview -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="border: 2px solid #333; padding: 20px;">
                <form action="" class="updatePaySlipForm">
                    <input type="hidden" name="total_deductions" value="{{ $deductions ?? 0 }}">
                    <input type="hidden" name="total_gross_salary" value="{{ $totalEarnings ?? 0 }}">
                    <input type="hidden" name="total_employee_bonus" value="{{ $totalBonusAmount ?? 0 }}">
                    <input type="hidden" name="total_convenience_amount" value="{{ $conveniencesTotalAmount ?? 0 }}">
                    <input type="hidden" name="total_net_salary" value="{{ $netPay ?? 0 }}">
                    <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                    {{-- //Url Match  --}}
                    @if (Request::is('employee/profile/edit/*'))
                        <input type="hidden" name="payslip_id" value="{{ $payslip_id->id }}">
                    @endif
                    @foreach ($conveniencesAmount as $convenience)
                        <input type="hidden" name="convenience_ids[]" value="{{ $convenience->id }}">
                    @endforeach
                    @foreach ($bonuses as $bonus)
                        <input type="hidden" name="bonus_ids[]" value="{{ $bonus->id }}">
                    @endforeach
                    <div class="modal-body" style="font-family: Arial, sans-serif;">
                        <!-- Payslip Title and Date -->
                        <div style="text-align: center; margin-bottom: 20px;">
                            <h2 style="font-weight: bold; margin: 0;">Payslip</h2>
                            @if (Request::is('employee/profile/edit/*'))
                                <p class="mt-2">Pay Date: {{ $payslip_id->pay_period_date }}</p>
                            @endif
                        </div>

                        <!-- Employee Details -->
                        <div style="margin-bottom: 15px;">
                            <p><strong>Employee Name:</strong> {{ $employee->full_name ?? '-' }}</p>
                            <p><strong>Employee ID:</strong> 00{{ $employee->id ?? '' }}</p>

                        </div>

                        <!-- Earnings Section -->
                        <div style="border: 1px solid #333; padding: 10px; margin-bottom: 15px;">
                            <h6><strong> Gross </strong></h6>
                            <table class="table table-bordered" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Basic Salary</td>
                                        <td>{{ $salaryStructure->base_salary ?? 0 }}</td>
                                    </tr>
                                    <tr>
                                        <td>House Rent</td>
                                        <td>{{ $salaryStructure->house_rent ?? 0 }}</td>
                                    </tr>
                                    <tr>
                                        <td>Transport Allowance</td>
                                        <td>{{ $salaryStructure->transport_allowance ?? 0 }}</td>
                                    </tr>
                                    <tr>
                                        <td>Other Fixed Allowance</td>
                                        <td>{{ $salaryStructure->other_fixed_allowances ?? 0 }}</td>
                                    </tr>
                                    <tr>
                                        @if (Request::is('employee/profile/edit/*'))
                                            <td>Total Employee Bonus</td>
                                            <td>{{ $totalBonusAmount + $payslip_id->total_employee_bonus ?? 0 }}<span>.00</span>
                                            </td>
                                        @else
                                            <td>Total Employee Bonus</td>
                                            <td>{{ $totalBonusAmount ?? 0 }}<span>.00</span></td>
                                        @endif

                                    </tr>
                                    <tr>
                                        @if (Request::is('employee/profile/edit/*'))
                                            <td>Total Conveyance Amount</td>
                                            <td>{{ $conveniencesTotalAmount + $payslip_id->total_convenience_amount ?? 0 }}<span>.00</span>
                                            </td>
                                        @else
                                            <td>Total Conveyance Amount</td>
                                            <td>{{ $conveniencesTotalAmount ?? 0 }}<span>.00</span></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        @if (Request::is('employee/profile/edit/*'))
                                            <td><strong>Total Gross </strong></td>
                                            <td><strong>{{ $totalEarnings + $totalBonusConv }}.00</strong></td>
                                        @else
                                            <td><strong>Total Gross </strong></td>
                                            <td><strong>{{ $totalEarnings }}.00</strong></td>
                                        @endif

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!--- Deductions Section --->
                        <div style="border: 1px solid #333; padding: 10px; margin-bottom: 15px;">
                            <h6><strong>Deductions</strong></h6>
                            <table class="table table-bordered" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- <tr>
                                <td>Deductions</td>
                                <td>{{ $deductions}}</td>
                            </tr> --}}
                                    <tr>
                                        <td><strong>Total Deductions</strong></td>
                                        <td><strong>{{ $deductions }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Net Pay Section -->
                        <div
                            style="margin-top: 15px; padding: 10px; background-color: #000; text-align: center; color:#fff">
                            @if (Request::is('employee/profile/edit/*'))
                                <h6><strong>Net Salary:</strong> {{ $netPay + $totalBonusConv ?? 0 }}<span>.00</span></h6>
                            @else
                                <h6><strong>Net Salary:</strong> {{ $netPay }}<span>.00</span></h6>
                            @endif

                        </div>

                        {{-- <!-- Signature Section -->
            <div style="margin-top: 30px; text-align: center;">
                <div style="display: inline-block; width: 45%; text-align: center;">
                    <p><strong>Employer Signature</strong></p>
                    <p>______________________________</p>
                </div>
                <div style="display: inline-block; width: 45%; text-align: center;">
                    <p><strong>Employee Signature</strong></p>
                    <p>______________________________</p>
                </div>
            </div> --}}

                        <!-- Footer -->
                        {{-- <div style="text-align: center; margin-top: 20px;">
                    <p style="font-size: 12px;">This is a system-generated payslip</p>
                </div> --}}
                    </div>
                    <div class="modal-footer" style="border-top: 1px solid #333;">
                        <button type="button" class="btn print btn-primary">Print</button>
                        <button type="button" class="btn btn-secondary btnupdate" data-dismiss="modal"
                            onclick="$('#updateModal').modal('hide');">Close</button>
                        <button type="button" class="update_pay_slip btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function previewPayslip() {
            $('#previewModal').modal('show');
        }
        //update modal
        function updatePayslip() {
            $('#updateModal').modal('show');
        }
        document.querySelector('.btn-secondary').addEventListener('click', function() {
            $('#previewModal').modal('hide');
        });
        //update modal
        document.querySelector('.btnupdate').addEventListener('click', function() {
            $('#updateModal').modal('hide');
        });
        //////////////Ajax view Month Salary//////////////////////

        const employeeId = {{ $employee->id }};

        function fetchPaySlip(employeeId) {
            $.ajax({
                url: `/employee/${employeeId}/slip/view`,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    $('.showSlip').empty();
                    // Populate table with pay slip data
                    $.each(response.paySlips, function(index, paySlip) {
                        $('.showSlip').append(`
                                <tr>
                                    <td>${paySlip.pay_period_date}</td>
                                    <td>${paySlip.total_gross_salary}</td>
                                    <td>${paySlip.total_deductions}</td>
                                    <td>${paySlip.total_net_salary}</td>
                                    <td>${paySlip.total_employee_bonus}</td>
                                    <td>${paySlip.total_convenience_amount}</td>
                                    <td>
                                        ${paySlip.status === 'pending' ? '<p class="btn btn-sm badge bg-warning">Pending</p>' : ''}
                                        ${paySlip.status === 'approved' ? '<p class="btn btn-sm badge bg-success">Approved</p>' : ''}
                                        ${paySlip.status === 'paid' ? '<p class="btn btn-sm badge bg-success">Paid</p>' : ''}
                                        ${!['pending', 'approved', 'paid'].includes(paySlip.status) ? '<p class="btn btn-sm badge bg-info color-black">Processing</p>' : ''}
                                    </td>
                                </tr>
                            `);
                    });

                },
                error: function(xhr, status, error) {
                    console.error("Failed to fetch pay slips:", error);
                }
            });
        }
        fetchPaySlip(employeeId);
        ////////Save PaySlip//////////
        const save_pay_slip = document.querySelector('.save_pay_slip');
        save_pay_slip.addEventListener('click', function(e) {
            //    alert('ok');
            e.preventDefault();
            let formData = new FormData($('.paySlipForm')[0]);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/employee/payslip/store',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.status == 200) {
                        $('#previewModal').modal('hide');
                        $('.paySlipForm')[0].reset();
                        toastr.success(res.message);
                        fetchPaySlip(employeeId);
                    } else if (res.status == 500) {
                        toastr.error(res.message);
                    }

                }
            });
        });
        //////////// Update payslip /////////////
        const update_pay_slip = document.querySelector('.update_pay_slip');
        update_pay_slip.addEventListener('click', function(e) {
            //    alert('ok');
            e.preventDefault();
            let formData = new FormData($('.updatePaySlipForm')[0]);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/employee/profile/payslip/update',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.status == 200) {
                        $('#updateModal').modal('hide');
                        $('.updatePaySlipForm')[0].reset();
                        toastr.success(res.message);
                        fetchPaySlip(employeeId);
                    } else if (res.status == 500) {
                        toastr.error(res.message);
                    }

                }
            });
        });
        ///////////Atcive tab///////
        document.addEventListener("DOMContentLoaded", function() {
            // Get the last active tab from localStorage
            let activeTab = localStorage.getItem('activeTab');

            // If there is an active tab stored, activate it
            if (activeTab) {
                let tabElement = document.querySelector(`a[href="${activeTab}"]`);
                if (tabElement) {
                    new bootstrap.Tab(tabElement).show();
                }
            }

            // Store the currently active tab in localStorage
            document.querySelectorAll('.nav-link').forEach(tab => {
                tab.addEventListener('shown.bs.tab', function(event) {
                    let activeTabHref = event.target.getAttribute('href');
                    localStorage.setItem('activeTab', activeTabHref);
                });
            });
        });
        ////////////////////////// print////////////////////

        // document.querySelector('.print').addEventListener('click', function() {
        //     // Clone the modal content
        //     const printContent = document.querySelector('#previewModal .modal-content').cloneNode(true);

        //     // Create a new window for printing
        //     const printWindow = window.open('', '_blank', 'width=800, height=600');
        //     printWindow.document.open();
        //     printWindow.document.close();
        //     // Add basic HTML structure and styles for the print window
        //     printWindow.document.write(`
    //     <html>
    //         <head>
    //             <title>Payslip</title>
    //             <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    //             <style>
    //                 body { font-family: Arial, sans-serif; }
    //                 .table { width: 100%; border-collapse: collapse; }
    //                 .table th, .table td { padding: 10px; border: 1px solid #333; }
    //                 .modal-content { border: 2px solid #333; padding: 20px; }
    //                 .modal-footer { border-top: 1px solid #333; }
    //                 .text-center { text-align: center; }
    //                 .font-weight-bold { font-weight: bold; }
    //                 .bg-dark { background-color: #000; color: #fff; padding: 10px; }
    //             </style>
    //         </head>
    //         <body>
    //             ${printContent.outerHTML}
    //         </body>
    //     </html>
    // `);

        //     printWindow.document.close();
        //     printWindow.print();
        // });
    </script>

@endsection
