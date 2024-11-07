@extends('master')
@section('title', '| Employee Profile Employee')
@section('admin')
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
                            <a class="pt-1px d-none d-md-block text-primary nav-link active" id="Home-tab"
                                data-bs-toggle="tab" href="#home" role="tab" aria-controls="home"
                                aria-selected="true">Salary Structure</a>
                        </li>
                        <li class="ms-3 ps-3 border-start d-flex align-items-center">
                            <i class="me-1 icon-md" data-feather="dollar-sign"></i>
                            <a class="pt-1px d-none d-md-block text-body nav-link" id="convenience-tab" data-bs-toggle="tab"
                                href="#convenience" role="tab" aria-controls="convenience"
                                aria-selected="false">Convenience Bill</a>
                        </li>
                        <li class="ms-3 ps-3 border-start d-flex align-items-center">
                            <i class="me-1 icon-md" data-feather="file-text"></i>
                            <a class="pt-1px d-none d-md-block text-body nav-link" id="payslip-tab" data-bs-toggle="tab"
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
                                                <th>Other Fixed Allowance</th>
                                                <th>Deductions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $salaryStructure->base_salary ?? '-' }}</td>
                                                <td>{{ $salaryStructure->house_rent ?? '-' }}</td>
                                                <td>{{ $salaryStructure->transport_allowance ?? '-' }}</td>
                                                <td>{{ $salaryStructure->other_fixed_allowances ?? '-' }}</td>
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
                                                    <td><a
                                                            href="{{ route('convenience.invoice', $convenience->id) }}">{{ $convenience->bill_number ?? '-' }}</a>
                                                    </td>
                                                    <td>{{ $convenience->total_amount ?? '-' }}</td>
                                                    <td>{{ $convenience->created_at ? $convenience->created_at->format('d F Y') : '-' }}
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
                                ($salaryStructure->other_fixed_allowances ?? 0);
                        }
                        // $totalEarnings = $salaryStructure->base_salary ?? 0 + $salaryStructure->house_rent ?? 0 + $salaryStructure->transport_allowance ?? 0;
                        $deductions = $salaryStructure->deductions ?? 0;
                        $netPay = $totalEarnings - $deductions;
                    @endphp
                        <div class="tab-pane fade " id="payslip" role="tabpanel" aria-labelledby="payslip-tab">
                            <div class="card rounded">
                                <div class="card-body">
                                    <p class="mb-3 tx-14">PaySlip Genarator </p>
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
                                                  <tr>
                                                    <td>Total Employee Bonus</td>
                                                       <td>{{ $totalBonusAmount ?? 0 }}<span>.00</span></td>
                                                  </tr>
                                                    <tr style="font-size: 20px;font-weignt:bold">
                                                        <td>Total Gross </td>
                                                        <td>{{ $totalEarnings ?? 0 }}<span>.00</span></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="mb-3 tx-14">Total Deductions </p>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Title</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Deductions Amount</td>
                                                        <td>{{ $salaryStructure->deductions ?? 0 }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                            <hr>
                                        <div class="col-md-12 text-end mt-2" style="">
                                            <p class="mb-3" style="font-size: 20px; font-weignt:bold ;margin-right: 65px"> Net Salary = {{ $netPay }}<span>.00</span> </p>
                                        </div>
                                        <div class="col-md-12 text-center mt-2 ">
                                            <a href="#" onclick="previewPayslip()" class="btn btn-sm fs-5"
                                                style="background-color: #6571FF;color:#fff">Genarate Slip</a>
                                        </div>
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
                                    <td><strong>Total Gross </strong></td>
                                    <td><strong>{{ $totalEarnings }}.00</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Deductions Section -->
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
                    <div style="margin-top: 15px; padding: 10px; background-color: #f1f1f1; text-align: center;">
                        <h6><strong>Net Salary:</strong> {{ $netPay }}<span>.00</span></h6>
                    </div>

                    <!-- Signature Section -->
                    <div style="margin-top: 30px; text-align: center;">
                        <div style="display: inline-block; width: 45%; text-align: center;">
                            <p><strong>Employer Signature</strong></p>
                            <p>______________________________</p>
                        </div>
                        <div style="display: inline-block; width: 45%; text-align: center;">
                            <p><strong>Employee Signature</strong></p>
                            <p>______________________________</p>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div style="text-align: center; margin-top: 20px;">
                        <p style="font-size: 12px;">This is a system-generated payslip</p>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #333;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        onclick="$('#previewModal').modal('hide');">Close</button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewPayslip() {
            $('#previewModal').modal('show');
        }
        document.querySelector('.btn-secondary').addEventListener('click', function() {
            $('#previewModal').modal('hide');
        });
    </script>

@endsection
