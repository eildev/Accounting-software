
<div class="row">
    <div class="col-md-12 grid-margin stretch-card d-flex justify-content-end">
        {{-- <div class="">

            <h4 class="text-right"><a href="{{ route('employee.view') }}" class="btn" style="background: #5660D9">View
                    Salary Structure</a></h4>
        </div> --}}
    </div>
    <div class="col-md-12 stretch-card">
        <div class="card">
            <div class="card-body">
    <form id="signupForm" class="salaryStructuresForm row">
        <div class="mb-3 col-md-6">
            <label for="name" class="form-label">Employee Name<span class="text-danger">*</span></label>
            <select class=" form-control employee_id_structure" id="employeestructureDropdown"
                name="employee_id" onkeyup="errorRemove(this);"
                style="width: 100%">
                <option selected disabled>Select Employee</option>
            </select>
            <span class="text-danger employee_id_error"></span>
        </div>
        <div class="mb-3 col-md-6">
            <label for="name" class="form-label">Basic Salary<span class="text-danger">*</span></label>
            <input id="defaultconfig11" class="form-control basic_salary_name" min="0"
                max="9999999999999" name="base_salary" type="number" onkeyup="errorRemove(this);"
                onblur="errorRemove(this);"
                oninput="if(this.value.length > 13) this.value = this.value.slice(0, 13)">
            <span class="text-danger basic_salary_name_error"></span>
        </div>
        <div class="mb-3 col-md-6">
            <label for="name" class="form-label">House Rent</label>
            <input id="defaultconfig21" class="form-control house_rent" min="0" max="9999999999999"
                name="house_rent" type="number" onkeyup="errorRemove(this);" onblur="errorRemove(this);"
                oninput="if(this.value.length > 13) this.value = this.value.slice(0, 13)">
            <span class="text-danger house_rent_error"></span>
        </div>
        <div class="mb-3 col-md-6">
            <label for="name3" class="form-label">Transport Allowance</label>
            <input id="defaultconfig2" class="form-control transport_allowance" min="0"
                max="9999999999999" name="transport_allowance" type="number" onkeyup="errorRemove(this);"
                onblur="errorRemove(this);"
                oninput="if(this.value.length > 13) this.value = this.value.slice(0, 13)">
            <span class="text-danger transport_allowance_error"></span>
        </div>
        <div class="mb-3 col-md-6">
            <label for="name3" class="form-label">Other Fixed Allowance</label>
            <input id="defaultconfig3" class="form-control other_fixed_allowances" min="0"
                max="9999999999999" name="other_fixed_allowances" type="number"
                onkeyup="errorRemove(this);" onblur="errorRemove(this);">
            <span class="text-danger other_fixed_allowances_error"></span>
        </div>
        <div class="mb-3 col-md-6">
            <label for="name4" class="form-label">Fixed Deductions</label>
            <input id="defaultconfig5" class="form-control deductions" min="0"
                max="9999999999999" name="deductions" type="number" onkeyup="errorRemove(this);"
                onblur="errorRemove(this);"
                oninput="if(this.value.length > 13) this.value = this.value.slice(0, 13)">
            <span class="text-danger deductions_error"></span>
        </div>
</div>
<div class=" m-3">
    <button type="button" class="btn btn-primary save_salaryStructures">Save</button>
</div>
</form>
</div>
</div>
</div>
<script>
    function errorRemove(element) {
            if (element.value != '') {
                $(element).siblings('span').hide();
                $(element).css('border-color', 'green');
            }
        }
        $(document).ready(function() {
            // show error
            function showError(name, message) {
                $(name).css('border-color', 'red');
                $(name).focus();
                $(`${name}_error`).show().text(message);
            }
            // save Salary Structure
            const saveSalaryStructures = document.querySelector('.save_salaryStructures');

            saveSalaryStructures.addEventListener('click', function(e) {
                //    alert('ok');
                e.preventDefault();
                let formData = new FormData($('.salaryStructuresForm')[0]);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/salary/structure/store',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.status == 200) {
                            $('#exampleModalLongScollable').modal('hide');
                            $('.salaryStructuresForm')[0].reset();

                            toastr.success(res.message);

                            const balanceTab = document.getElementById("balance-tab");
                            const idPwtabTab = document.getElementById("IDandPass-tab");
                            // Remove active class from current tab
                            balanceTab.classList.remove("active");
                            balanceTab.setAttribute("aria-selected", "false");

                            // Add active class to 'Add Leave Limits' tab
                            idPwtabTab.classList.add("active");
                            idPwtabTab.setAttribute("aria-selected", "true");

                            // Show the corresponding tab pane

                            document.getElementById("IDandPass").classList.add("show", "active");
                            document.getElementById("balance").classList.remove("show", "active");


                        } else {
                            if (res.error.employee_id) {
                                showError('.employee_id_structure', res.error.employee_id);
                            }
                            if (res.error.base_salary) {
                                showError('.basic_salary_name', res.error.base_salary);
                            }
                            if (res.error.house_rent) {
                                showError('.house_rent', res.error.house_rent);
                            }
                            if (res.error.transport_allowance) {
                                showError('.transport_allowance', res.error
                                .transport_allowance);
                            }
                            if (res.error.other_fixed_allowances) {
                                showError('.other_fixed_allowances', res.error
                                    .other_fixed_allowances);
                            }
                            if (res.error.deductions) {
                                showError('.deductions', res.error.deductions);
                            }

                        }
                    }
                });
            });

            /////////////////////////////////dropdown Already not exist check///////////

            $('#employeestructureDropdown').on('focus', function() {
                // Check if the dropdown already has options loaded (optional)
                if ($(this).data('loaded') === "true") {
                    return;
                }
                $.ajax({
                    url: '/employees-without-salary-structure',
                    method: 'GET',
                    success: function(data) {
                        var employeeDropdown = $('#employeestructureDropdown');
                        employeeDropdown.empty();
                        employeeDropdown.append(
                            '<option selected disabled>Select Employee</option>');

                        $.each(data, function(index, employee) {
                            employeeDropdown.append('<option value="' + employee.id +
                                '">' + employee.full_name + '</option>');
                        });

                         if (data.length > 0) {
                         employeeDropdown.val(data[data.length - 1].id); // Select the last employee
                        }
                        // Mark dropdown as loaded
                        employeeDropdown.data('loaded', true)
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching employees:', error);
                    }
                });
            });
            });

</script>
