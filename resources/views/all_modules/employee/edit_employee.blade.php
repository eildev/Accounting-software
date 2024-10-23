@extends('master')
@section('title', '| Edit Employee')
@section('admin')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card d-flex justify-content-end">
            <div class="">

                <h4 class="text-right"><a href="{{ route('employee.view') }}" class="btn" style="background: #5660D9">View All Employee</a></h4>
            </div>
        </div>
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title ">Edit Employee</h6>
                    <form id="employeeEditValidForm" action="{{ route('employee.update', $employees->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Col -->
                            <div class="col-sm-6">
                                <div class="mb-3 form-valid-groups">
                                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text"  maxlength="255" value="{{ $employees->full_name }}" name="full_name" class="form-control field_required" placeholder="Enter Employee name">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="mb-3 form-valid-groups">
                                    <label class="form-label">Select Departments<span class="text-danger">*</span></label>
                                    <select
                                    class="js-example-basic-single form-control"
                                    name="department_id"  width="100">
                                    <option selected disabled>Select Depertments</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}" {{$department->id == $employees->department_id ? 'selected' : ''}}>{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="mb-3 form-valid-groups">
                                    <label class="form-label">Phone<span class="text-danger">*</span></label>
                                    <input type="integer"  maxlength="13" value="{{ $employees->phone }}" name="phone" class="form-control" placeholder="Enter Employee Number">
                                </div>
                            </div>
                            <div class="col-sm-6 ">
                                <div class="mb-3 form-valid-groups">
                                    <label class="form-label">Email address<span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control"  value="{{ $employees->email }}" placeholder="Enter Employee Email">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6 ">
                                <div class="mb-3 form-valid-groups">
                                    <label class="form-label">NID Number (Optional)</label>
                                    <input type="number" maxlength="15" class="form-control" name="nid" value="{{ $employees->nid }}"  placeholder="Enter NID Number">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6 ">
                                <div class="mb-3 form-valid-groups">
                                    <label class="form-label">Designation (Optional)</label>
                                    <input type="text" name="designation"   value="{{ $employees->designation }}"  maxlength="255" class="form-control" placeholder="Enter Employee Designation">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6 ">
                                <div class="mb-6 form-valid-groups">
                                    <label class="form-label">Basic Salary (Optional)</label>
                                    <input type="number" maxlength="12" class="form-control"  value="{{ $employees->salary }}" name="salary" placeholder="Enter Employee Salary">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="mb-3 form-valid-groups">
                                    <label class="form-label">Employee Address(Optional)</label>
                                    <textarea name="address" class="form-control"  placeholder="Write Employee Address" rows="4" cols="50"></textarea>
                                </div>
                            </div><!-- Col -->
                        </div><!-- Row -->
                        <div class="row">
                        <div class="col-sm-12">
                        <div class="mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title">Employee Image</h6>
                                            <p class="mb-3 text-warning">Note: <span class="fst-italic">Image not
                                                    required. If you
                                                    add
                                                    a image
                                                    please add a 35mm (width) x 45mm (height) size image.</span></p>
                                                    <input type="file"
                                                    data-default-file="{{ $employees->pic ? asset('uploads/employee/' . $employees->pic) : '' }}"
                                                    class="employeeImage" name="image" id="myDropify" />
                                        </div>
                                    </div>
                                </div>
                            </div><!-- Col -->
                            <!-- Col -->
                            <!-- Col -->
                        </div><!-- Row -->
                        <div>
                            <input type="submit" class="btn btn-primary submit" value="Save">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#employeeEditValidForm').validate({
            rules: {
                full_name: {
                    required : true,
                },
                phone: {
                    required : true,
                },
                email: {
                    required : true,
                },

                department_id: {
                    required : true,
                },

            },
            messages :{
                full_name: {
                    required : 'Please Enter Employee Name',
                },
                phone: {
                    required : 'Please Enter Phone Number',
                },
                email: {
                    required : 'Please Enter Employee Email',
                },
                department_id: {
                    required : 'Select Department',
                },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-valid-groups').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                    $(element).addClass('is-valid');
                },
            });
        });
    </script>
@endsection
