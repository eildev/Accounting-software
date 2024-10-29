@extends('master')
@section('title', '| Convenience Bill Management')
@section('admin')
    @php
        $mode = App\models\PosSetting::all()->first();
    @endphp
    <style>
        .no-gutters {
            margin-right: 0;
            margin-left: 0;
        }

        .no-gutters>.col-md-2,
        .no-gutters>.col-md-4 {
            padding-right: 0;
            padding-left: 0;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .bill-header p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .movementcosts table th,
        .movementcosts table td,
        .otherExpensesCosts table th,
        .otherExpensesCosts table td,
        .overnightStayCosts table th,
        .overnightStayCosts table td,
        .foodingcosts table th,
        .foodingcosts table td {
            border: 1px solid #6587ff;
            padding: 5px;
            text-align: left;
        }

        table th {
            font-weight: bold;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #6587ff !important;
        }

        .p-3 {
            padding-bottom: 50px !important;
        }

        /*  list Table css*/
        #expenseTable,
        #foodingTable,
        #overnightStayTable,
        #otherExpensesTable {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ddd;
        }

        #expenseTable th,
        #foodingTable th,
        #overnightStayTable th,
        #otherExpensesTable th,
        #expenseTable td,
        #foodingTable td,
        #overnightStayTable td,
        #otherExpensesTable td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        #expenseTable th,
        #foodingTable th,
        #overnightStayTable th,
        #otherExpensesTable th {
            @if ($mode->dark_mode == 2)

            @else
                background-color: #f2f2f2;
            @endif

        }
    </style>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="card-title">Convenience Bill Table</h6>
                        {{-- <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#exampleModalLongScollable">Add Departments</button> --}}
                    </div>


                    <div id="" class="table-responsive">
                        <div class="bill-header">
                            <div class="row no-gutters">
                                <div class="col-md-2">
                                    <strong>Department:</strong>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-control js-example-basic-single" name="department"
                                        id="department-select">
                                        <option value="" selected disabled>Select Departments</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <p>
                            <div class="row no-gutters">
                                <div class="col-md-2">
                                    <strong>Name:</strong>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-control js-example-basic-single " name="empoyee"
                                        id="employee-select">
                                        <option selected disabled>Select Name</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->full_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            </p>
                            {{-- <p><strong>Bill Entry Number (Admin):</strong></p> --}}
                            <p><strong>Date:</strong> <span id="current-date"></span></p>
                        </div>

                        <!-- /////////Tabing Start//// -->
                        <div class="row">
                            <div class="col-md-12 grid-margin stretch-card">
                                <div class="example w-100">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <!---First li--->
                                        <li class="nav-item">
                                            <a class="nav-link active" id="movementcosts-tab" data-bs-toggle="tab"
                                                href="#movementcosts" role="tab" aria-controls="movementcosts"
                                                aria-selected="true">Movement Costs
                                            </a>
                                        </li>
                                        <!---Second li--->
                                        <li class="nav-item">
                                            <a class="nav-link" id="foodingcosts-tab" data-bs-toggle="tab"
                                                href="#foodingcosts" role="tab" aria-controls="foodingcosts"
                                                aria-selected="false">Fooding Costs
                                            </a>
                                        </li>
                                        <!---Third li--->
                                        <li class="nav-item">
                                            <a class="nav-link" id="overnightStayCosts-tab" data-bs-toggle="tab"
                                                href="#overnightStayCosts" role="tab" aria-controls="overnightStayCosts"
                                                aria-selected="false">Overnight Stay costs
                                            </a>
                                        </li>
                                        <!---Fourth li--->
                                        <li class="nav-item">
                                            <a class="nav-link" id="otherExpensesCosts-tab" data-bs-toggle="tab"
                                                href="#otherExpensesCosts" role="tab" aria-controls="otherExpensesCosts"
                                                aria-selected="false">Other Expenses Costs
                                            </a>
                                        </li>
                                    </ul>
                                    <!--First Tab  Start-->

                                    <div class="tab-content border border-top-0 p-3" id="myTabContent">

                                        <div class="tab-pane fade show active" id="movementcosts" role="tabpanel"
                                            aria-labelledby="movementcosts-tab">
                                            <div class="col-md-12 movementcosts">

                                                <table id="movementcostsTable">
                                                    <thead>
                                                        <tr>
                                                            <th><button type="button" class="form-control" id="addRowBtn">+
                                                                </button></th>
                                                            <th>Date</th>
                                                            <th>From</th>
                                                            <th>To</th>
                                                            <th>Purpose</th>
                                                            <th>Mode of Transport</th>
                                                            <th>Amount (TK)</th>
                                                            <th>Assigned</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><button type="button"
                                                                    class="removeRowBtn form-control text-danger btn-xs btn-danger">
                                                                    <i class="fa-solid fa-trash-can"></i>
                                                                </button></td>
                                                            <td><input id="flatpickr-date" type="date"
                                                                    class="input-group flatpickr form-control"
                                                                    name="movementDate[]">
                                                            </td>
                                                            <td>
                                                                <textarea class="form-control" cols="30" rows="2" name="movementFrom[]" placeholder="From "></textarea>
                                                            </td>
                                                            <td>
                                                                <textarea class="form-control" id="" cols="30" rows="2" name="movementTo[]" placeholder="To "></textarea>
                                                            </td>
                                                            <td>

                                                                <textarea class="form-control" id="" cols="30" rows="2" name="movementPurpose[]"
                                                                    placeholder="Enter Purpose "></textarea>
                                                            </td>

                                                            <td>
                                                                <select class="form-control" name="movementMode_of_Transport[]">
                                                                    <option value="bike">Bike</option>
                                                                    <option value="rickshaw">Rickshaw</option>
                                                                    <option value="cars"> Cars</option>
                                                                    <option value="buses"> Buses</option>
                                                                </select>
                                                            </td>
                                                            <td><input type="number" class="form-control"name="movementAmount[]"
                                                                   ></td>
                                                            <td><input type="text" class="form-control"
                                                                    name="movementAssigned[]" >
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="6" class="text-end"><strong>Total
                                                                    Money</strong>
                                                            </td>
                                                            <td><strong id="totalAmount">00</strong></td>
                                                            <td></td>
                                                        </tr>

                                                    </tfoot>

                                                </table>
                                            </div>
                                            <input type="file" name="movementCostsFile" id="movementCostsFile"
                                                accept="image/*">
                                            <a class="btn btn-md float-end movementCostsAdd"
                                                style="border:1px solid #6587ff ">Add</a>

                                        </div>
                                        <!--First Tab End -->
                                        <!--Second fooding costs Tab Start -->
                                        <div class="tab-pane fade" id="foodingcosts" role="tabpanel"
                                            aria-labelledby="foodingcosts-tab">
                                            <div class="col-md-12 foodingcosts">

                                                <table id="foodingcostsTable">
                                                    <thead>
                                                        <tr>
                                                            <th><button type="button" class="form-control"
                                                                    id="addRowBtn2">+
                                                                </button></th>
                                                            <th>Date</th>
                                                            <th>Place of Visit</th>
                                                            <th>Purpose</th>
                                                            <th>Fooding Time</th>
                                                            <th>Amount (TK)</th>
                                                            <th>Assigned</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><button type="button"
                                                                    class="removeRowBtn2 form-control text-danger btn-xs btn-danger">
                                                                    <i class="fa-solid fa-trash-can"></i>
                                                                </button></td>
                                                            <td><input id="flatpickr-date" type="date"
                                                                    class="input-group form-control" name="foodingDate[]"
                                                                    value="2024-10-21">
                                                            </td>
                                                            <td>
                                                                <textarea class="form-control" id="" cols="30" rows="2" name="plceofvisit[]"
                                                                    placeholder="Place of visit "></textarea>
                                                            </td>
                                                            <td>
                                                                <textarea class="form-control" id="" cols="30" rows="2" name="purpose2[]"
                                                                    placeholder="Enter Purpose "></textarea>
                                                            </td>
                                                            <td>
                                                                <select class="form-control" name="foodingtime[]">
                                                                    <option selected disabled>Select Fooding Time</option>
                                                                    <option value="breakfast">Breakfast</option>
                                                                    <option value="lunch">Lunch</option>
                                                                    <option value="dinner">Dinner</option>
                                                                    <option value="snacks">Snacks</option>
                                                                </select>
                                                            </td>
                                                            <td><input type="number" class="form-control"name="amount2[]"
                                                                    value=""></td>
                                                            <td><input type="text" class="form-control"
                                                                    name="assigned2[]" value="">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="5" class="text-end"><strong>Total
                                                                    Money</strong>
                                                            </td>
                                                            <td><strong id="totalAmount2">00</strong></td>
                                                            <td></td>
                                                        </tr>

                                                    </tfoot>

                                                </table>
                                            </div>
                                            <a class="btn btn-md float-end foodingcostsAdd"
                                                style="border:1px solid #6587ff ">Add</a>
                                        </div>
                                        <!--Second fooding costs Tab End -->
                                        <!--Third Over Night Stay Costs  costs Tab Start -->
                                        <div class="tab-pane fade" id="overnightStayCosts" role="tabpanel"
                                            aria-labelledby="overnightStayCosts-tab">
                                            <div class="col-md-12 overnightStayCosts">

                                                <table id="overnightStayCostsTable">
                                                    <thead>
                                                        <tr>
                                                            <th><button type="button" class="form-control"
                                                                    id="addRowBtn3">+
                                                                </button></th>
                                                            <th>Date</th>
                                                            <th>Place of Visit</th>
                                                            <th>Purpose</th>
                                                            <th>Stay period</th>
                                                            <th>Amount (TK)</th>
                                                            <th>Assigned</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><button type="button"
                                                                    class="removeRowBtn2 form-control text-danger btn-xs btn-danger">
                                                                    <i class="fa-solid fa-trash-can"></i>
                                                                </button></td>
                                                            <td><input id="flatpickr-date" type="date"
                                                                    class="input-group form-control" name="date3[]"
                                                                    value="2024-10-21">
                                                            </td>
                                                            <td>
                                                                <textarea class="form-control" id="" cols="30" rows="2" name="plceofvisit3[]"
                                                                    placeholder="Place of visit "></textarea>
                                                            </td>
                                                            <td>
                                                                <textarea class="form-control" id="" cols="30" rows="2" name="purpose3[]"
                                                                    placeholder="Enter Purpose "></textarea>
                                                            </td>
                                                            <td>
                                                                <select class="form-control" name="stayperiod[]">
                                                                    <option selected disabled>Select Stay period</option>
                                                                    <option value="1">1 Night</option>
                                                                    <option value="2">2 Night</option>
                                                                    <option value="3">3 Night</option>
                                                                    <option value="4">4 Night</option>
                                                                    <option value="5">5 Night</option>
                                                                    <option value="6">6 Night</option>
                                                                    <option value="7">7 Night</option>
                                                                    <option value="8">8 Night</option>
                                                                    <option value="10">10 Night</option>
                                                                    <option value="10">10 Night</option>
                                                                    <option value="20"> 20 Night</option>
                                                                </select>
                                                            </td>
                                                            <td><input type="number" class="form-control"name="amount3[]"
                                                                    value=""></td>
                                                            <td><input type="text" class="form-control"
                                                                    name="assigned3[]" value="">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="5" class="text-end"><strong>Total
                                                                    Money</strong>
                                                            </td>
                                                            <td><strong id="totalAmount3">00</strong></td>
                                                            <td></td>
                                                        </tr>

                                                    </tfoot>

                                                </table>
                                            </div>
                                            <a class="btn btn-md float-end overnightStayCostsAdd"
                                                style="border:1px solid #6587ff ">Add</a>
                                        </div>
                                        <!--Third Over Night Stay Costs Tab End -->
                                        <!-- Four Other Expenses costs Tab Start -->
                                        <div class="tab-pane fade" id="otherExpensesCosts" role="tabpanel"
                                            aria-labelledby="otherExpensesCosts-tab">
                                            <div class="col-md-12 otherExpensesCosts">

                                                <table id="otherExpensesCostsTable">
                                                    <thead>
                                                        <tr>
                                                            <th><button type="button" class="form-control"
                                                                    id="addRowBtn4">+
                                                                </button></th>
                                                            <th>Date</th>
                                                            <th>Purpose</th>
                                                            <th>Amount (TK)</th>
                                                            <th>Assigned</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><button type="button"
                                                                    class="removeRowBtn4 form-control text-danger btn-xs btn-danger">
                                                                    <i class="fa-solid fa-trash-can"></i>
                                                                </button></td>
                                                            <td><input id="flatpickr-date" type="date"
                                                                    class="input-group form-control" name="date4[]"
                                                                    >
                                                            </td>

                                                            <td>
                                                                <textarea class="form-control" id="" cols="30" rows="2" name="purpose4[]"
                                                                    placeholder="Enter Purpose "></textarea>
                                                            </td>

                                                            <td><input type="number" class="form-control" name="amount4[]"
                                                                    value=""></tdput type="text" clas>
                                                            <td><input type="text" class="form-control"
                                                                    name="assigned4[]" value="">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="3" class="text-end"><strong>Total
                                                                    Money</strong>
                                                            </td>
                                                            <td><strong id="totalAmount4">00</strong></td>
                                                            <td></td>
                                                        </tr>

                                                    </tfoot>

                                                </table>
                                            </div>
                                            <a class="btn btn-md float-end otherExpensesCostsAdd"
                                                style="border:1px solid #6587ff ">Add</a>
                                        </div>
                                        <!--TFour Other Expenses  Tab End -->
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- /////////Tabing End//// -->

                            <form id="auditForm" method="POST">
                            <!---MOVEMENT list 1 --->
                            <div class="col-md-12" id="movementCostData">
                                  <h4> </h4>
                                <table id="expenseTable">
                                    <thead>
                                        {{-- <h2>Movement Table:</h2> --}}
                                    </thead>
                                    <tbody>
                                        <tr>

                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <span id="movement"></span>
                                    </tfoot>
                                </table>
                            </div>

                            <!---MOVEMENT list End--->
                            <!---Fooding list Start 2--->
                            <div class="col-md-12" id="foodingCostData">
                                <table id="foodingTable">
                                    <h4> </h4>
                                    <thead>
                                        {{-- <h2>fooding Cost Table:</h2> --}}
                                    </thead>
                                    <tbody>
                                        <tr>

                                        </tr>
                                    </tbody>

                                </table>
                            </div>
                            <!---Fooding List 2 End--->
                            <!---Overnight Stay Costs list Start 3  --->
                            <div class="col-md-12" id="overnightStayCostsData">
                                <h4> </h4>
                                <table id="overnightStayTable">
                                    <thead>

                                    </thead>
                                    <tbody>
                                        <tr>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!---Overnight Stay Costs 3 End--->
                            <!-- Four Other Expenses costs 4 Start -->
                            <div class="col-md-12" id="otherExpensesCostsData">
                                <table id="otherExpensesTable">
                                    <h4> </h4>
                                    <hr>
                                    <thead>

                                    </thead>
                                    <tbody>
                                        <tr>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Four Other Expenses costs End -->
                            <button class="btn btn-md float-end mb-2" style="border:1px solid #6587ff " type="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        ///////////////////////////////////////// Drowdown show Department To Employee //////////////////////////////////////////////////
        $(document).ready(function() {
            $('#department-select').on('change', function() {
                var departmentId = $(this).val();

                // Clear the employee dropdown before new data is loaded
                $('#employee-select').empty().append(
                    '<option value="" selected disabled>Loading...</option>');
                $.ajax({
                    url: '/employees-by-department/' + departmentId,
                    type: 'GET',
                    success: function(data) {
                        // Clear the employee dropdown and add the default option
                        $('#employee-select').empty().append(
                            '<option value="" selected disabled>Select Name</option>');

                        $.each(data, function(index, employee) {
                            $('#employee-select').append(
                                `<option value="${employee.id}">${employee.full_name}</option>`
                            );
                        });
                    },
                    error: function() {
                        alert('Error fetching employees.');
                    }
                });
            });
        });
        //////////////////////////////////////Date Show/////////////////////////////////
        // Get today's date
        let today = new Date();
        let formattedDate = today.getDate() + '/' + (today.getMonth() + 1) + '/' + today.getFullYear();
        document.getElementById('current-date').textContent = formattedDate;

        ////////////////////////////////////////////////////First MOVEMENT costs Cost Add New row  Start//////////////////////////////////////////////
        document.getElementById('addRowBtn').addEventListener('click', function() {
            let tableBody = document.querySelector('#movementcostsTable tbody');
            let newRow = document.createElement('tr');

            // Create new row with input fields
            newRow.innerHTML = `
              <td><button type="button" class="removeRowBtn form-control text-danger btn-xs btn-danger">
                <i class="fa-solid fa-trash-can "></i></button></td>
                <td> <input type="date" class="input-group flatpickr form-control" name="movementDate[]" value=""></td>
                <td><textarea class="form-control"  cols="30" rows="2" name="movementFrom[]" placeholder="From "></textarea></td>
                <td> <textarea class="form-control" id="" cols="30" rows="2" name="movementTo[]"  placeholder="To "></textarea></td>
                <td> <textarea class="form-control" id="" cols="30" rows="2"  name="movementPurpose[]" placeholder="Enter Purpose "></textarea></td>
                <td>
                <select class="form-control" name="movementMode_of_Transport[]">
                        <option selected disabled>Select Transport</option>
                        <option value="bike">Bike</option>
                        <option value="rickshaw">Rickshaw</option>
                        <option value="cars"> Cars</option>
                        <option value="buses"> Buses</option>
                </select>
                </td>
                <td><input type="number" class="form-control" name="movementAmount[]" value=""></td>
                <td><input type="text" class="form-control" name="movementAssigned[]" value=""></td>

            `;
            // Append the new row to the table body
            tableBody.appendChild(newRow);

            // Attach event listener to remove button of new row
            newRow.querySelector('.removeRowBtn').addEventListener('click', function() {
                newRow.remove();
                calculateTotal1();
            });
            // Recalculate total after adding a new row
            newRow.querySelector('input[name="movementAmount[]"]').addEventListener('input', calculateTotal1);
            // Recalculate total after adding a new row
            calculateTotal1()
        });

        // Function to calculate total
        function calculateTotal1() {
            let total = 0;
            document.querySelectorAll('input[name="movementAmount[]"]').forEach(function(input) {
                total += parseFloat(input.value) || 0;
            });
            document.getElementById('totalAmount').textContent = total;
        }
        document.querySelectorAll('input[name="movementAmount[]"]').forEach(function(input) {
            input.addEventListener('input', calculateTotal1);
        });
        // Event listener for removing a row
        document.querySelectorAll('.removeRowBtn').forEach(function(button) {
            button.addEventListener('click', function() {
                this.closest('tr').remove();
                calculateTotal1();
            });
        });
        //First  Add row  Tab End

        //////////////////////////////////MOVEMENT Costs Added New Table//////////////////////////////////////
        const movementCostsAdd = document.querySelector('.movementCostsAdd');
        movementCostsAdd.addEventListener('click', function(e) {
            e.preventDefault();

            let rows = document.querySelectorAll('#movementcostsTable tbody tr');
            let addedTable = document.querySelector('#expenseTable');
            let addedTableBody = addedTable.querySelector('tbody');
            let addedTableHead = addedTable.querySelector('thead');
            let tableTitle = document.querySelector('#movementCostData h4');
            let hrElement = document.querySelector('#movementCostData hr');
            let movementImageContainer = document.querySelector('#movement');

            ///////////////Validation Start /////////////
            let allFieldsFilled = true;
            let errorMessages = []
            rows.forEach(function(row) {
                let movementDate = row.querySelector('input[name="movementDate[]"]').value;
                let movementFrom = row.querySelector('textarea[name="movementFrom[]"]').value;
                let movementTo = row.querySelector('textarea[name="movementTo[]"]').value;
                let movementMode_of_Transport = row.querySelector('select[name="movementMode_of_Transport[]"]').value;
                let movementAmount = row.querySelector('input[name="movementAmount[]"]').value;

                if (!movementDate) {
                    errorMessages.push('⚠️ Date field is required.');
                    allFieldsFilled = false;
                }
                if (!movementFrom) {
                    errorMessages.push('⚠️ From field is required.');
                    allFieldsFilled = false;
                }
                if (!movementTo) {
                    errorMessages.push('⚠️ To field is required.');
                    allFieldsFilled = false;
                }
                if (!movementMode_of_Transport) {
                    errorMessages.push('⚠️ Mode of Transport is required.');
                    allFieldsFilled = false;
                }
                if (!movementAmount) {
                    errorMessages.push('⚠️ Amount field is required.');
                    allFieldsFilled = false;
                }
            });

            // Show all error messages in a single toastr notification if any field is missing
            if (!allFieldsFilled) {
                toastr.error(errorMessages.join('<br>')); // Join messages with line breaks
                return; // Stop execution if any field is missing
            }
            ///////////////Validation End /////////////
            // Check if <thead> is empty or doesn't exist, and add it if necessary
            if (!addedTable.querySelector('thead').innerHTML.trim()) {
                addedTable.querySelector('thead').innerHTML = `
            <tr>
                <th>Date</th>
                <th>From</th>
                <th>To</th>
                <th>Purpose</th>
                <th>Mode of Transport</th>
                <th>Amount (TK)</th>
                <th>Assigned</th>
                <th>Actions</th>
            </tr>
          `;
            }
            if (!tableTitle.innerHTML.trim()) {
                tableTitle.innerHTML = 'Movement Cost :';
            }
            if (!hrElement) {
                hrElement = document.createElement('hr');
                document.querySelector('#movementCostData').insertBefore(hrElement, addedTable);
            }
            // Clear previous data from the second table body
            addedTableBody.innerHTML = '';

            // Loop through all rows in the first table and get the data
            rows.forEach(function(row) {
                let movementDate = row.querySelector('input[name="movementDate[]"]').value;
                let movementFrom = row.querySelector('textarea[name="movementFrom[]"]').value;
                let movementTo = row.querySelector('textarea[name="movementTo[]"]').value;
                let movementPurpose = row.querySelector('textarea[name="movementPurpose[]"]').value;
                let movementMode_of_Transport = row.querySelector('select[name="movementMode_of_Transport[]"]').value;
                let movementAmount = row.querySelector('input[name="movementAmount[]"]').value;
                let movementAssigned = row.querySelector('input[name="movementAssigned[]"]').value;

                // Create a new row for the second table
                let newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td><input id="flatpickr-date" type="date"
                   class="input-group form-control border-0" name="movementDate[]"   style="border: none; background-color: transparent;" readonly
                    value="${movementDate}"></td>
                    <td> <input type="text"
                   class="input-group border-0 form-control" name="movementFrom[]"  style="border: 0; background-color: transparent;" readonly
                    value="${movementFrom}"> </td>
                    <td> <input type="text"
                   class="input-group border-0 form-control" name="movementTo[]"   style="border: 0; background-color: transparent;" readonly
                    value="${movementTo}"> </td>
                    <td><input type="text"
                   class="input-group border-0 form-control" name="movementPurpose[]"   style="border: 0; background-color: transparent;" readonly
                    value="${movementPurpose}"> </td>
                    <td><input type="text"
                   class="input-group border-0 form-control" name="movementMode_of_Transport[]"   style="border: 0; background-color: transparent;" readonly
                    value="${movementMode_of_Transport}"> </td>
                    <td> <input type="text"
                   class="input-group border-0 form-control" name="movementAmount[]"   style="border: 0; background-color: transparent;" readonly
                    value="${movementAmount}"> </td>
                    <td> <input type="text"
                   class="input-group border-0 form-control" name="movementAssigned[]"   style="border: 0; background-color: transparent;" readonly
                    value="${movementAssigned}"> </td>
                    <td><button class="deleteRowBtn form-control text-danger btn-xs btn-danger">Delete</button></td>
                `;
                // Append the new row to the second table body
                addedTableBody.appendChild(newRow);
                // let imageUrl = URL.createObjectURL(file);
                // filepreview.innerHTML = ` <td><img src="${imageUrl}" alt="Uploaded Image" style="width: 50px; height: 50px;"></td>`
                // filepreview.appendChild(filepreview);
                // Add event listener for delete button to remove row on click
                newRow.querySelector('.deleteRowBtn').addEventListener('click', function() {
                    newRow.remove();
                    if (!addedTableBody.querySelector('tr')) {
                        addedTableHead.innerHTML = '';
                        tableTitle.innerHTML = '';
                        if (hrElement) hrElement.remove();
                    }
                });

            });
        });

        ////////////////////////////////////////////////////Second tab FOODING cost Add row Start//////////////////////////////////////////////
        document.getElementById('addRowBtn2').addEventListener('click', function() {
            let tableBody = document.querySelector('#foodingcostsTable tbody');
            let newRow = document.createElement('tr');

            // Create new row with input fields
            newRow.innerHTML = `
                            <td><button type="button"
                                class="removeRowBtn2 form-control text-danger btn-xs btn-danger">
                                <i class="fa-solid fa-trash-can"></i>
                            </button></td>
                        <td><input id="flatpickr-date" type="date"
                                class="input-group form-control"
                                name="foodingDate[]">
                        </td>
                        <td>
                            <textarea class="form-control" id="" cols="30" rows="2" name="plceofvisit[]" placeholder="Place of visit "></textarea>
                        </td>
                        <td>
                            <textarea class="form-control" id="" cols="30" rows="2" name="purpose2[]"
                                placeholder="Enter Purpose "></textarea>
                        </td>
                        <td>
                            <select class="form-control" name="foodingtime[]">
                                <option selected disabled>Select Fooding Time</option>
                                <option value="breakfast">Breakfast</option>
                                <option value="lunch">Lunch</option>
                                <option value="dinner">Dinner</option>
                                <option value="snacks">Snacks</option>
                            </select>
                        </td>
                        <td><input type="number" class="form-control"name="amount2[]"
                                value=""></td>
                        <td><input type="text" class="form-control" name="assigned2[]"
                                value="">
                        </td>

            `;
            // Append the new row to the table body
            tableBody.appendChild(newRow);

            // Attach event listener to remove button of new row
            newRow.querySelector('.removeRowBtn2').addEventListener('click', function() {
                newRow.remove();
                calculateTotal2();
            });
            // Recalculate total after adding a new row
            newRow.querySelector('input[name="amount2[]"]').addEventListener('input', calculateTotal2);
            // Recalculate total after adding a new row
            calculateTotal2()
        }); //End

        // Function to calculate total
        function calculateTotal2() {
            let total = 0;
            document.querySelectorAll('input[name="amount2[]"]').forEach(function(input) {
                total += parseFloat(input.value) || 0;
            });
            document.getElementById('totalAmount2').textContent = total;
        }
        document.querySelectorAll('input[name="amount2[]"]').forEach(function(input) {
            input.addEventListener('input', calculateTotal2);
        });
        // Event listener for removing a row
        document.querySelectorAll('.removeRowBtn2').forEach(function(button) {
            button.addEventListener('click', function() {
                this.closest('tr').remove();
                calculateTotal2();
            });
        });
        //First  Add row  Tab End

        ////////////////////////////////////////////////////Second tab FOODING cost Add Table  Start//////////////////////////////////////////////

        const foodingcostsAdd = document.querySelector('.foodingcostsAdd');
        foodingcostsAdd.addEventListener('click', function(e) {
            e.preventDefault();

            let rows = document.querySelectorAll('#foodingcostsTable tbody tr');
            let addedTable = document.querySelector('#foodingTable');
            let addedTableBody = addedTable.querySelector('tbody');
            let addedTableHead = addedTable.querySelector('thead');
            let tableTitle2 = document.querySelector('#foodingCostData h4');
            let hrElement2 = document.querySelector('#foodingCostData hr');
            // Check if <thead> is empty or doesn't exist, and add it if necessary
            if (!addedTable.querySelector('thead').innerHTML.trim()) {
                addedTable.querySelector('thead').innerHTML = `
            <tr>
                <th>Date</th>
                <th>Place of Visit</th>
                <th>Purpose</th>
                <th>Fooding Time</th>
                <th>Amount (TK)</th>
                <th>Assigned</th>
                <th>Actions</th>
            </tr>
         `;
            }
            if (!tableTitle2.innerHTML.trim()) {
                tableTitle2.innerHTML = 'Fooding Cost:';
            }
            if (!hrElement2) {
                hrElement2 = document.createElement('hr');
                document.querySelector('#foodingCostData').insertBefore(hrElement2, addedTable);
            }
            // Clear previous data from the second table body
            addedTableBody.innerHTML = '';

            // Loop through all rows in the first table and get the data
            rows.forEach(function(row) {
                let foodingDate = row.querySelector('input[name="foodingDate[]"]').value;
                let plceofvisit = row.querySelector('textarea[name="plceofvisit[]"]').value;
                let purpose2 = row.querySelector('textarea[name="purpose2[]"]').value;
                let foodingtime = row.querySelector('select[name="foodingtime[]"]').value;
                let amount2 = row.querySelector('input[name="amount2[]"]').value;
                let assigned2 = row.querySelector('input[name="assigned2[]"]').value;

                // Create a new row for the second table
                let newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td><input id="flatpickr-date" type="date"
                   class="input-group form-control border-0" name="foodingDate[]"   style="border: none; background-color: transparent;" readonly
                    value="${foodingDate}"></td>
                    <td> <input type="text"
                   class="input-group border-0 form-control" name="plceofvisit[]"  style="border: 0; background-color: transparent;" readonly
                    value="${plceofvisit}"> </td>
                    <td> <input type="text"
                   class="input-group border-0 form-control" name="purpose2[]"   style="border: 0; background-color: transparent;" readonly
                    value="${purpose2}"> </td>
                    <td><input type="text"
                   class="input-group border-0 form-control" name="foodingtime[]"   style="border: 0; background-color: transparent;" readonly
                    value="${foodingtime}"> </td>
                    <td> <input type="text"
                   class="input-group border-0 form-control" name="amount2[]"   style="border: 0; background-color: transparent;" readonly
                    value="${amount2}"> </td>
                    <td> <input type="text"
                   class="input-group border-0 form-control" name="assigned2[]"   style="border: 0; background-color: transparent;" readonly
                    value="${assigned2}"> </td>
                  <td><button class="deleteRowBtn2 form-control text-danger btn-xs btn-danger">Delete</button></td>
         `;
                // Append the new row to the second table body
                addedTableBody.appendChild(newRow);

                // Add event listener for delete button to remove row on click
                newRow.querySelector('.deleteRowBtn2').addEventListener('click', function() {
                    newRow.remove();
                    if (!addedTableBody.querySelector('tr')) {
                        addedTableHead.innerHTML = '';
                        tableTitle2.innerHTML = '';
                        if (hrElement2) hrElement2.remove();
                    }
                });
            });
        }); //End
        //////////////////////////////////////////////////// Third Overnight Stay Costs row  Add   Start//////////////////////////////////////////////
        document.getElementById('addRowBtn3').addEventListener('click', function() {
            let tableBody = document.querySelector('#overnightStayCostsTable tbody');
            let newRow = document.createElement('tr');

            // Create new row with input fields
            newRow.innerHTML = `
                            <td><button type="button"
                                class="removeRowBtn3 form-control text-danger btn-xs btn-danger">
                                <i class="fa-solid fa-trash-can"></i>
                            </button></td>
                        <td><input id="flatpickr-date" type="date"
                                class="input-group form-control"
                                name="date3[]">
                        </td>
                        <td>
                            <textarea class="form-control" id="" cols="30" rows="2" name="plceofvisit3[]" placeholder="Place of visit "></textarea>
                        </td>
                        <td>
                            <textarea class="form-control" id="" cols="30" rows="2" name="purpose3[]"
                                placeholder="Enter Purpose "></textarea>
                        </td>
                        <td>
                             <select class="form-control" name="stayperiod[]">
                                <option selected disabled>Select Stay period</option>
                                <option value="1">1 Night</option>
                                <option value="2">2 Night</option>
                                <option value="3">3 Night</option>
                                <option value="4">4 Night</option>
                                <option value="5">5 Night</option>
                                <option value="6">6 Night</option>
                                <option value="7">7 Night</option>
                                <option value="8">8 Night</option>
                                <option value="10">10 Night</option>
                                <option value="10">10 Night</option>
                                <option value="20"> 20 Night</option>
                            </select>
                        </td>
                        <td><input type="number" class="form-control"name="amount3[]"
                                value=""></td>
                        <td><input type="text" class="form-control" name="assigned3[]"
                                value="">
                        </td>

            `;
            // Append the new row to the table body
            tableBody.appendChild(newRow);

            // Attach event listener to remove button of new row
            newRow.querySelector('.removeRowBtn3').addEventListener('click', function() {
                newRow.remove();
                calculateTotal3();
            });
            // Recalculate total after adding a new row
            newRow.querySelector('input[name="amount3[]"]').addEventListener('input', calculateTotal3);
            // Recalculate total after adding a new row
            calculateTotal3()
        });

        // Function to calculate total
        function calculateTotal3() {
            let total = 0;
            document.querySelectorAll('input[name="amount3[]"]').forEach(function(input) {
                total += parseFloat(input.value) || 0;
            });
            document.getElementById('totalAmount3').textContent = total;
        }
        document.querySelectorAll('input[name="amount3[]"]').forEach(function(input) {
            input.addEventListener('input', calculateTotal3);
        });
        // Event listener for removing a row
        document.querySelectorAll('.removeRowBtn3').forEach(function(button) {
            button.addEventListener('click', function() {
                this.closest('tr').remove();
                calculateTotal3();
            });
        });
        //First  Add row  Tab End

        ////////////////////////////////////////////////////Third Overnight Stay Costs Add Table Start//////////////////////////////////////////////

        const overnightStayCostsAdd = document.querySelector('.overnightStayCostsAdd');
        overnightStayCostsAdd.addEventListener('click', function(e) {
            e.preventDefault();

            let rows = document.querySelectorAll('#overnightStayCostsTable tbody tr');
            let addedTable = document.querySelector('#overnightStayTable');
            let addedTableBody = addedTable.querySelector('tbody');
            let addedTableHead = addedTable.querySelector('thead');
            let tableTitle3 = document.querySelector('#overnightStayCostsData h4');
            let hrElement3 = document.querySelector('#overnightStayCostsData hr');
            // Check if <thead> is empty or doesn't exist, and add it if necessary
            if (!addedTable.querySelector('thead').innerHTML.trim()) {
                addedTable.querySelector('thead').innerHTML = `
            <tr>
                <th>Date</th>
                <th>Place of Visit</th>
                <th>Purpose</th>
                <th>Stay period</th>
                <th>Amount (TK)</th>
                <th>Assigned</th>
                <th>Actions</th>
            </tr>
         `;
            }
            if (!tableTitle3.innerHTML.trim()) {
                tableTitle3.innerHTML = 'Overnight Stay Cost :';
            }
            if (!hrElement3) {
                hrElement3 = document.createElement('hr');
                document.querySelector('#overnightStayCostsData').insertBefore(hrElement3, addedTable);
            }
            // Clear previous data from the second table body
            addedTableBody.innerHTML = '';

            // Loop through all rows in the first table and get the data
            rows.forEach(function(row) {
                let date3 = row.querySelector('input[name="date3[]"]').value;
                let plceofvisit3 = row.querySelector('textarea[name="plceofvisit3[]"]').value;
                let purpose3 = row.querySelector('textarea[name="purpose3[]"]').value;
                let stayperiod3 = row.querySelector('select[name="stayperiod[]"]').value;
                let amount3 = row.querySelector('input[name="amount3[]"]').value;
                let assigned3 = row.querySelector('input[name="assigned3[]"]').value;

                // Create a new row for the second table
                let newRow = document.createElement('tr');
                newRow.innerHTML = `

                <td><input id="flatpickr-date" type="date"
                   class="input-group form-control border-0" name="date3[]"   style="border: none; background-color: transparent;" readonly
                    value="${date3}"></td>
                    <td> <input type="text"
                   class="input-group border-0 form-control" name="plceofvisit3[]"  style="border: 0; background-color: transparent;" readonly
                    value="${plceofvisit3}"> </td>
                    <td> <input type="text"
                   class="input-group border-0 form-control" name="purpose3[]"   style="border: 0; background-color: transparent;" readonly
                    value="${purpose3}"> </td>
                    <td><input type="text"
                   class="input-group border-0 form-control" name="stayperiod[]"   style="border: 0; background-color: transparent;" readonly
                    value="${stayperiod3}"> </td>
                    <td> <input type="text"
                   class="input-group border-0 form-control" name="amount3[]"   style="border: 0; background-color: transparent;" readonly
                    value="${amount3}"> </td>
                    <td> <input type="text"
                   class="input-group border-0 form-control" name="assigned3[]"   style="border: 0; background-color: transparent;" readonly
                    value="${assigned3}"> </td>

              <td><button class="deleteRowBtn3 form-control text-danger btn-xs btn-danger">Delete</button></td>
         `;
                // Append the new row to the second table body
                addedTableBody.appendChild(newRow);

                // Add event listener for delete button to remove row on click
                newRow.querySelector('.deleteRowBtn3').addEventListener('click', function() {
                    newRow.remove();
                    if (!addedTableBody.querySelector('tr')) {
                        addedTableHead.innerHTML = '';
                        tableTitle3.innerHTML = '';
                        if (hrElement3) hrElement3.remove();
                    }
                });
            });
        }); //End


        //////////////////////////////////////////////////// Four other Expenses Costs Add  row  Start//////////////////////////////////////////////
        document.getElementById('addRowBtn4').addEventListener('click', function() {
            let tableBody = document.querySelector('#otherExpensesCostsTable tbody');
            let newRow = document.createElement('tr');

            // Create new row with input fields
            newRow.innerHTML = `
                        <td><button type="button"
                            class="removeRowBtn4 form-control text-danger btn-xs btn-danger">
                            <i class="fa-solid fa-trash-can"></i>
                        </button></td>
                        <td>
                            <input id="flatpickr-date" type="date"
                                class="input-group form-control"
                                name="date4[]">
                        </td>
                        <td>
                            <textarea class="form-control" id="" cols="20" rows="2" name="purpose4[]"
                                placeholder="Enter Purpose "></textarea>
                        </td>
                        <td><input type="number" class="form-control"name="amount4[]"
                                value=""></td>
                        <td><input type="text" class="form-control" name="assigned4[]"
                                value="">
                        </td>

            `;
            // Append the new row to the table body
            tableBody.appendChild(newRow);

            // Attach event listener to remove button of new row
            newRow.querySelector('.removeRowBtn4').addEventListener('click', function() {
                newRow.remove();
                calculateTotal4();
            });
            // Recalculate total after adding a new row
            newRow.querySelector('input[name="amount4[]"]').addEventListener('input', calculateTotal4);
            // Recalculate total after adding a new row
            calculateTotal4()
        });

        // Function to calculate total//
        function calculateTotal4() {
            let total = 0;
            document.querySelectorAll('input[name="amount4[]"]').forEach(function(input) {
                total += parseFloat(input.value) || 0;
            });
            document.getElementById('totalAmount4').textContent = total;
        }
        document.querySelectorAll('input[name="amount4[]"]').forEach(function(input) {
            input.addEventListener('input', calculateTotal4);
        });
        // Event listener for removing a row
        document.querySelectorAll('.removeRowBtn4').forEach(function(button) {
            button.addEventListener('click', function() {
                this.closest('tr').remove();
                calculateTotal4();
            });
        });
        //First  Add row  Tab End
        ////////////////////////////////////////////////////Four Other Expenses Costs Add Table Start//////////////////////////////////////////////
        const otherExpensesCostsAdd = document.querySelector('.otherExpensesCostsAdd');
        otherExpensesCostsAdd.addEventListener('click', function(e) {
            e.preventDefault();

            let rows = document.querySelectorAll('#otherExpensesCostsTable tbody tr');
            let addedTable = document.querySelector('#otherExpensesTable');
            let addedTableBody = addedTable.querySelector('tbody');
            let addedTableHead = addedTable.querySelector('thead');
            let tableTitle4 = document.querySelector('#otherExpensesCostsData h4');
            let hrElement4 = document.querySelector('#otherExpensesCostsData hr');
            // Check if <thead> is empty or doesn't exist, and add it if necessary
            if (!addedTable.querySelector('thead').innerHTML.trim()) {
                addedTable.querySelector('thead').innerHTML = `
            <tr>
                <th>Date</th>
                <th>Purpose</th>
                <th>Amount (TK)</th>
                <th>Assigned</th>
                <th>Actions</th>
            </tr>
         `;
            }
            if (!tableTitle4.innerHTML.trim()) {
                tableTitle4.innerHTML = 'Other Expenses Costs :';
            }
            if (!hrElement4) {
                hrElement4 = document.createElement('hr');
                document.querySelector('#otherExpensesCostsData').insertBefore(hrElement4, addedTable);
            }
            // Clear previous data from the second table body
            addedTableBody.innerHTML = '';

            // Loop through all rows in the first table and get the data
            rows.forEach(function(row) {
                let date4 = row.querySelector('input[name="date4[]"]').value;
                let purpose4 = row.querySelector('textarea[name="purpose4[]"]').value;
                let amount4 = row.querySelector('input[name="amount4[]"]').value;
                let assigned4 = row.querySelector('input[name="assigned4[]"]').value;

                // Create a new row for the second table
                let newRow = document.createElement('tr');
                newRow.innerHTML = `
             <td><input id="flatpickr-date" type="date"
                   class="input-group form-control border-0" name="date4[]"   style="border: none; background-color: transparent;" readonly
                    value="${date4}"></td>
                    <td> <input type="text"
                   class="input-group border-0 form-control" name="purpose4[]"  style="border: 0; background-color: transparent;" readonly
                    value="${purpose4}"> </td>
                    <td> <input type="text"
                   class="input-group border-0 form-control" name="amount4[]"   style="border: 0; background-color: transparent;" readonly
                    value="${amount4}"> </td>
                    <td><input type="text"
                   class="input-group border-0 form-control" name="assigned4[]"   style="border: 0; background-color: transparent;" readonly
                    value="${assigned4}"> </td>

              <td><button class="deleteRowBtn4 form-control text-danger btn-xs btn-danger">Delete</button></td>
         `;
                // Append the new row to the second table body
                addedTableBody.appendChild(newRow);

                // Add event listener for delete button to remove row on click
                newRow.querySelector('.deleteRowBtn4').addEventListener('click', function() {
                    newRow.remove();
                    if (!addedTableBody.querySelector('tr')) {
                        addedTableHead.innerHTML = '';
                        tableTitle4.innerHTML = '';
                        if (hrElement4) hrElement4.remove();
                    }
                });
            });
        }); //End


        ////////////////////////////Store////////////////////////////
        $(document).ready(function() {
            $('#auditForm').on('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission
                let formData = new FormData(this); // Get the form data
                console.log(formData); //
                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
                $.ajax({
                    url: "{{ route('convenience.store') }}", // The route to handle form submission
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#auditForm')[0].reset();
                        // $('#expenseTable tbody').empty(); // Clear table rows if needed
                        calculateTotal(); //
                        // Handle success - Display a success message, clear form, etc.
                        alert("Form submitted successfully.");
                    },
                    error: function(xhr, status, error) {
                        // Handle error - Display error message, etc.
                        alert("An error occurred while submitting the form.");
                    }
                });
            });
        });
    </script>
@endsection
