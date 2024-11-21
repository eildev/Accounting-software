@extends('master')
@section('title', '| Conveyance Bill Management')
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
                        <h6 class="card-title">Conveyance Bill Table</h6>
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
                                    <select class="form-control js-example-basic-single  employee-selectid" name="empoyee"
                                        id="employee-select">
                                        <option selected disabled>Select Name</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->full_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="ms-5">
                                        <h3 class="grandTotal">Total Amount: <span id="grandTotalDisplay">0</span></h3>
                                    </div>
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
                                                        {{-- <tr>
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
                                                                <select class="form-control"
                                                                    name="movementMode_of_Transport[]">
                                                                    <option value="bike">Bike</option>
                                                                    <option value="rickshaw">Rickshaw</option>
                                                                    <option value="cars"> Cars</option>
                                                                    <option value="buses"> Buses</option>
                                                                </select>
                                                            </td>
                                                            <td><input type="number"
                                                                    class="form-control"name="movementAmount[]"></td>
                                                            <td><input type="text" class="form-control"
                                                                    name="movementAssigned[]">
                                                            </td>
                                                        </tr> --}}
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
                                            {{-- <input type="file" name="movementCostsFile" id="movementCostsFile"> --}}
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
                                                        {{-- <tr>
                                                            <td><button type="button"
                                                                    class="removeRowBtn2 form-control text-danger btn-xs btn-danger">
                                                                    <i class="fa-solid fa-trash-can"></i>
                                                                </button></td>
                                                            <td><input id="flatpickr-date" type="date"
                                                                    class="input-group form-control" name="foodingDate[]">
                                                            </td>
                                                            <td>
                                                                <textarea class="form-control" id="" cols="30" rows="2" name="foodingPlceofvisit[]"
                                                                    placeholder="Place of visit "></textarea>
                                                            </td>
                                                            <td>
                                                                <textarea class="form-control" id="" cols="30" rows="2" name="foodingPurpose[]"
                                                                    placeholder="Enter Purpose "></textarea>
                                                            </td>
                                                            <td>
                                                                <select class="form-control" name="foodingtime[]">
                                                                    <option value="breakfast">Breakfast</option>
                                                                    <option value="lunch">Lunch</option>
                                                                    <option value="dinner">Dinner</option>
                                                                    <option value="snacks">Snacks</option>
                                                                </select>
                                                            </td>
                                                            <td><input type="number"
                                                                    class="form-control"name="foodingAmount[]"
                                                                    value=""></td>
                                                            <td><input type="text" class="form-control"
                                                                    name="foodingAssigned[]" value="">
                                                            </td>
                                                        </tr> --}}
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
                                                        {{-- <tr>
                                                            <td><button type="button"
                                                                    class="removeRowBtn2 form-control text-danger btn-xs btn-danger">
                                                                    <i class="fa-solid fa-trash-can"></i>
                                                                </button></td>
                                                            <td><input id="flatpickr-date" type="date"
                                                                    class="input-group form-control"
                                                                    name="overnightDate[]">
                                                            </td>
                                                            <td>
                                                                <textarea class="form-control" id="" cols="30" rows="2" name="overnightPlceofvisit[]"
                                                                    placeholder="Place of visit "></textarea>
                                                            </td>
                                                            <td>
                                                                <textarea class="form-control" id="" cols="30" rows="2" name="overnightPurpose[]"
                                                                    placeholder="Enter Purpose "></textarea>
                                                            </td>
                                                            <td>
                                                                <select class="form-control" name="overnightStayperiod[]">
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
                                                            <td><input type="number"
                                                                    class="form-control"name="overnightAmount[]"
                                                                    value=""></td>
                                                            <td><input type="text" class="form-control"
                                                                    name="overnightAssigned[]" value="">
                                                            </td>
                                                        </tr> --}}
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
                                                        {{-- <tr>
                                                            <td><button type="button"
                                                                    class="removeRowBtn4 form-control text-danger btn-xs btn-danger">
                                                                    <i class="fa-solid fa-trash-can"></i>
                                                                </button></td>
                                                            <td><input id="flatpickr-date" type="date"
                                                                    class="input-group form-control"
                                                                    name="otherExpensesDate[]">
                                                            </td>

                                                            <td>
                                                                <textarea class="form-control" id="" cols="30" rows="2" name="otherExpensesPurpose[]"
                                                                    placeholder="Enter Purpose "></textarea>
                                                            </td>

                                                            <td><input type="number" class="form-control"
                                                                    name="otherExpensesAmount[]" value=""></tdput
                                                                    type="text" clas>
                                                            <td><input type="text" class="form-control"
                                                                    name="otherExpensesAssigned[]" value="">
                                                            </td>
                                                        </tr> --}}
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

                        <form id="convenienceForm" method="POST" enctype="multipart/form-data">
                            <input class="d-none" type="number" name="employee_id" id="selected_employee_id">
                            <!---MOVEMENT list 1 --->
                            <div class="col-md-12" id="movementCostData">
                                <h4> </h4>
                                <table id="expenseTable">
                                    <thead>
                                        {{-- <h2>Movement Table:</h2> --}}
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <input type="file" class="input-group d-none border-0 form-control mt-2"
                                                id="movementCostsFileId" name="movementCostsFile"
                                                style="border: 0; background-color: transparent;" readonly value="">
                                            <input class="d-none" type="number" name="movementCostsTotal"
                                                id="movementCostsTotal" style="border: 0; background-color: transparent;">

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
                                            <input type="file" class="input-group d-none border-0 form-control mt-2"
                                                id="foodingCostFileId" name="foodingCostFile"
                                                style="border: 0; background-color: transparent;" readonly value="">
                                            <input class="d-none" type="number" name="foodingCostsTotal"
                                                id="foodingCostsTotal" style="border: 0; background-color: transparent;">
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
                                            <input type="file" class="input-group d-none border-0 form-control mt-2"
                                                id="overnightStayCostFileId" name="overnightStayCostFile"
                                                style="border: 0; background-color: transparent;" readonly value="">
                                            <input class="d-none" type="number" name="overnightStayCostTotal"
                                                id="overnightStayCostTotal"
                                                style="border: 0; background-color: transparent;">
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
                                            <input type="file" class="input-group d-none border-0 form-control mb-3"
                                                id="otherExpensesCostFileId" name="otherExpensesCostFile"
                                                style="border: 0; background-color: transparent;" readonly value="">
                                            <input class="d-none" type="number" name="otherExpensesCostsTotal"
                                                id="otherExpensesCostsTotal"
                                                style="border: 0; background-color: transparent;">
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Four Other Expenses costs End -->
                            <button class="btn btn-md float-end mb-2" style="border:1px solid #6587ff "
                                type="submit">Submit</button>
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
        //////////////////////////////////////////////////////Passs Employee ID /////////////////////////////////

        $(document).ready(function() {
            $('.employee-selectid').on('change', function() {
                let employeeSelectId = $(this).val();
                $('#selected_employee_id').val(employeeSelectId);
            });
        });

        ////////////////////////////////////////////////////First MOVEMENT costs Cost Add New (ROW**)  Start//////////////////////////////////////////////
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
                        <option value="bike">Bike</option>
                        <option value="rickshaw">Rickshaw</option>
                        <option value="cars"> Cars</option>
                        <option value="buses"> Buses</option>
                        <option value="airplane"> Airplane</option>
                        <option value="train"> Train</option>
                </select>
                </td>
                <td><input type="number" class="form-control" name="movementAmount[]" value="" ></td>
                <td><input type="text" class="form-control" name="movementAssigned[]" value=""></td>

            `;
            // Append the new row to the table body
            tableBody.appendChild(newRow);
            //validation neg value input
            let amountInput = newRow.querySelector('input[name="movementAmount[]"]');
            amountInput.addEventListener('input', function() {
                if (parseFloat(amountInput.value) < 0) {
                    toastr.warning("Amount cannot be negative!");
                    amountInput.value = "";
                }
                calculateTotal1();
            });
            newRow.querySelector('input[name="movementAmount[]"]').addEventListener('input', calculateTotal1);
            // Calculate total amount in the main table
            function calculateTotal1() {
                let total = 0;
                document.querySelectorAll('#movementcostsTable input[name="movementAmount[]"]').forEach(function(
                    input) {
                    total += parseFloat(input.value) || 0;
                });
                // Display the total amount in the element with ID 'totalAmount'
                document.getElementById('totalAmount').textContent = total.toFixed(2);
            }

            newRow.querySelector('.removeRowBtn').addEventListener('click', function() {
                newRow.remove();
                calculateTotal1();
            });
        });

        //First  Add row  Tab End

        //////////////////////////////////MOVEMENT Costs Added New (Table**)//////////////////////////////////////
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
                let movementMode_of_Transport = row.querySelector(
                    'select[name="movementMode_of_Transport[]"]').value;
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

            if (!allFieldsFilled) {
                toastr.error(errorMessages.join('<br>'));
                return;
            }
            ///////////////Validation End /////////////
            // Check if <thead> is empty or doesn't exist, and add it if necessary
            if (rows.length > 0) {
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
            }


            let totalAmountMovement = 0;

            function updateTotalAmountMovement() {
                totalAmountMovement = 0;
                addedTableBody.querySelectorAll('input[name="movementAmount[]"]').forEach(function(input) {
                    totalAmountMovement += parseFloat(input.value) || 0;
                });
                document.querySelector('#movementCostsTotal').value = parseFloat(totalAmountMovement);
                updateGrandTotal();
            }
            // Loop through all rows in the first table and get the data
            rows.forEach(function(row) {
                let movementDate = row.querySelector('input[name="movementDate[]"]').value;
                let movementFrom = row.querySelector('textarea[name="movementFrom[]"]').value;
                let movementTo = row.querySelector('textarea[name="movementTo[]"]').value;
                let movementPurpose = row.querySelector('textarea[name="movementPurpose[]"]').value;
                let movementMode_of_Transport = row.querySelector(
                    'select[name="movementMode_of_Transport[]"]').value;
                let movementAmount = parseFloat(row.querySelector('input[name="movementAmount[]"]')
                    .value) || 0;

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
                toastr.info("Successfully added!");
                totalAmountMovement += movementAmount;
                document.getElementById('movementCostsFileId').classList.remove('d-none');

                newRow.querySelector('.deleteRowBtn').addEventListener('click', function() {
                    newRow.remove();
                    if (!addedTableBody.querySelector('tr')) {
                        addedTableHead.innerHTML = '';
                        tableTitle.innerHTML = '';
                        if (hrElement) hrElement.remove();
                    }
                    updateTotalAmountMovement();
                    updateGrandTotal();
                });

            });
            document.querySelector('#movementCostsTotal').value = parseFloat(totalAmountMovement);
            updateGrandTotal();
        });

        ////////////////////////////////////////////////////Second tab FOODING cost Add (ROW**) Start//////////////////////////////////////////////
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
                            <textarea class="form-control" id="" cols="30" rows="2" name="foodingPlceofvisit[]" placeholder="Place of visit "></textarea>
                        </td>
                        <td>
                            <textarea class="form-control" id="" cols="30" rows="2" name="foodingPurpose[]"
                                placeholder="Enter Purpose "></textarea>
                        </td>
                        <td>
                            <select class="form-control" name="foodingtime[]">
                                <option value="breakfast">Breakfast</option>
                                <option value="lunch">Lunch</option>
                                <option value="dinner">Dinner</option>
                                <option value="snacks">Snacks</option>
                            </select>
                        </td>
                        <td><input type="number" class="form-control"name="foodingAmount[]"
                                value=""></td>
                        <td><input type="text" class="form-control" name="foodingAssigned[]"
                                value="">
                        </td>
            `;
            // Append the new row to the table body
            tableBody.appendChild(newRow);
            //validation neg value input
            let amountInput2 = newRow.querySelector('input[name="foodingAmount[]"]');
            amountInput2.addEventListener('input', function() {
                if (parseFloat(amountInput2.value) < 0) {
                    toastr.warning("Amount cannot be negative!");
                    amountInput2.value = "";
                }
                calculateTotal2();
            });

            newRow.querySelector('input[name="foodingAmount[]"]').addEventListener('input', calculateTotal2);
            // Calculate total amount in the main table
            function calculateTotal2() {
                let total = 0;
                document.querySelectorAll('#foodingcostsTable input[name="foodingAmount[]"]').forEach(function(
                    input) {
                    total += parseFloat(input.value) || 0;
                });
                // Display the total amount in the element with ID 'totalAmount'
                document.getElementById('totalAmount2').textContent = total.toFixed(2);
            }
            // Attach event listener to remove button of new row
            newRow.querySelector('.removeRowBtn2').addEventListener('click', function() {
                newRow.remove();
                calculateTotal2();
            });
        }); //End


        ////////////////////////////////////////////////////Second tab FOODING cost Add (Table**)  Start//////////////////////////////////////////////
        const foodingcostsAdd = document.querySelector('.foodingcostsAdd');
        foodingcostsAdd.addEventListener('click', function(e) {
            e.preventDefault();

            let rows = document.querySelectorAll('#foodingcostsTable tbody tr');
            let addedTable = document.querySelector('#foodingTable');
            let addedTableBody = addedTable.querySelector('tbody');
            let addedTableHead = addedTable.querySelector('thead');
            let tableTitle2 = document.querySelector('#foodingCostData h4');
            let hrElement2 = document.querySelector('#foodingCostData hr');
            //VAlidation errors
            let allFieldsFilled = true;
            let errorMessages = []
            rows.forEach(function(row) {

                let foodingDate = row.querySelector('input[name="foodingDate[]"]').value;
                let foodingPurpose = row.querySelector('textarea[name="foodingPurpose[]"]').value;
                let foodingtime = row.querySelector('select[name="foodingtime[]"]').value;
                let foodingAmount = row.querySelector('input[name="foodingAmount[]"]').value;

                if (!foodingDate) {
                    errorMessages.push('⚠️ Date field is required.');
                    allFieldsFilled = false;
                }

                if (!foodingPurpose) {
                    errorMessages.push('⚠️ Fooding Purpose is required.');
                    allFieldsFilled = false;
                }
                if (!foodingtime) {
                    errorMessages.push('⚠️ Fooding Time field is required.');
                    allFieldsFilled = false;
                }
                if (!foodingAmount) {
                    errorMessages.push('⚠️ Amount field is required.');
                    allFieldsFilled = false;
                }
            });

            // Show all error messages in a single toastr notification if any field is missing
            if (!allFieldsFilled) {
                toastr.error(errorMessages.join('<br>')); // Join messages with line breaks
                return; // Stop execution if any field is missing
            }


            // Check if <thead> is empty or doesn't exist, and add it if necessary
            if (rows.length > 0) {
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

            }
            let totalAmountFooding = 0;

            function updateTotalAmountFooding() {
                totalAmountFooding = 0;
                addedTableBody.querySelectorAll('input[name="foodingAmount[]"]').forEach(function(input) {
                    totalAmountFooding += parseFloat(input.value) || 0;
                });
                document.querySelector('#foodingCostsTotal').value = parseFloat(totalAmountFooding);
                updateGrandTotal();
            } //

            // Loop through all rows in the first table and get the data
            rows.forEach(function(row) {
                let foodingDate = row.querySelector('input[name="foodingDate[]"]').value;
                let foodingPlceofvisit = row.querySelector('textarea[name="foodingPlceofvisit[]"]').value;
                let foodingPurpose = row.querySelector('textarea[name="foodingPurpose[]"]').value;
                let foodingtime = row.querySelector('select[name="foodingtime[]"]').value;
                let foodingAmount = parseFloat(row.querySelector('input[name="foodingAmount[]"]').value) ||
                    0;
                let foodingAssigned = row.querySelector('input[name="foodingAssigned[]"]').value;

                // Create a new row for the second table
                let newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td><input id="flatpickr-date" type="date"
                   class="input-group form-control border-0" name="foodingDate[]"   style="border: none; background-color: transparent;" readonly
                    value="${foodingDate}"></td>
                    <td> <input type="text"
                   class="input-group border-0 form-control" name="foodingPlceofvisit[]"  style="border: 0; background-color: transparent;" readonly
                    value="${foodingPlceofvisit}"> </td>
                    <td> <input type="text"
                   class="input-group border-0 form-control" name="foodingPurpose[]"   style="border: 0; background-color: transparent;" readonly
                    value="${foodingPurpose}"> </td>
                    <td><input type="text"
                   class="input-group border-0 form-control" name="foodingtime[]"   style="border: 0; background-color: transparent;" readonly
                    value="${foodingtime}"> </td>
                    <td> <input type="text"
                   class="input-group border-0 form-control" name="foodingAmount[]"   style="border: 0; background-color: transparent;" readonly
                    value="${foodingAmount}"> </td>
                    <td> <input type="text"
                   class="input-group border-0 form-control" name="foodingAssigned[]"   style="border: 0; background-color: transparent;" readonly
                    value="${foodingAssigned}"> </td>
                  <td><button class="deleteRowBtn2 form-control text-danger btn-xs btn-danger">Delete</button></td>
         `;
                // Append the new row to the second table body
                addedTableBody.appendChild(newRow);
                toastr.info("Successfully added!");
                totalAmountFooding += foodingAmount;
                document.getElementById('foodingCostFileId').classList.remove('d-none');
                // Add event listener for delete button to remove row on click

                newRow.querySelector('.deleteRowBtn2').addEventListener('click', function() {
                    newRow.remove();

                    if (!addedTableBody.querySelector('tr')) {
                        addedTableHead.innerHTML = '';
                        tableTitle2.innerHTML = '';
                        if (hrElement2) hrElement2.remove();
                    }
                    updateTotalAmountFooding()
                    updateGrandTotal();
                });
            });

            document.querySelector('#foodingCostsTotal').value = parseFloat(totalAmountFooding);
            updateGrandTotal();
        }); //End
        //////////////////////////////////////////////////// Third Overnight Stay Costs (ROW**)  Add   Start//////////////////////////////////////////////
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
                                name="overnightDate[]">
                        </td>
                        <td>
                            <textarea class="form-control" id="" cols="30" rows="2" name="overnightPlceofvisit[]" placeholder="Place of visit "></textarea>
                        </td>
                        <td>
                            <textarea class="form-control" id="" cols="30" rows="2" name="overnightPurpose[]"
                                placeholder="Enter Purpose "></textarea>
                        </td>
                        <td>
                             <select class="form-control" name="overnightStayperiod[]">
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
                        <td><input type="number" class="form-control"name="overnightAmount[]"
                                value=""></td>
                        <td><input type="text" class="form-control" name="overnightAssigned[]"
                                value="">
                        </td>

            `;
            // Append the new row to the table body
            tableBody.appendChild(newRow);
            //validation neg value input
            let amountInput3 = newRow.querySelector('input[name="overnightAmount[]"]');
            amountInput3.addEventListener('input', function() {
                if (parseFloat(amountInput3.value) < 0) {
                    toastr.warning("Amount cannot be negative!");
                    amountInput3.value = "";
                }
                calculateTotal3();
            }); //End validation
            newRow.querySelector('input[name="overnightAmount[]"]').addEventListener('input', calculateTotal3);
            // Calculate total amount in the main table
            function calculateTotal3() {
                let total = 0;
                document.querySelectorAll('#overnightStayCostsTable input[name="overnightAmount[]"]').forEach(
                    function(
                        input) {
                        total += parseFloat(input.value) || 0;
                    });
                // Display the total amount in the element with ID 'totalAmount'
                document.getElementById('totalAmount3').textContent = total.toFixed(2);
            }

            // Attach event listener to remove button of new row
            newRow.querySelector('.removeRowBtn3').addEventListener('click', function() {
                newRow.remove();
                calculateTotal3();
            });

        });

        ////////////////////////////////////////////////////Third Overnight Stay Costs Add (Table**) Start//////////////////////////////////////////////

        const overnightStayCostsAdd = document.querySelector('.overnightStayCostsAdd');
        overnightStayCostsAdd.addEventListener('click', function(e) {
            e.preventDefault();

            let rows = document.querySelectorAll('#overnightStayCostsTable tbody tr');
            let addedTable = document.querySelector('#overnightStayTable');
            let addedTableBody = addedTable.querySelector('tbody');
            let addedTableHead = addedTable.querySelector('thead');
            let tableTitle3 = document.querySelector('#overnightStayCostsData h4');
            let hrElement3 = document.querySelector('#overnightStayCostsData hr');

            //VAlidation errors
            let allFieldsFilled = true;
            let errorMessages = []
            rows.forEach(function(row) {
                let overnightDate = row.querySelector('input[name="overnightDate[]"]').value;
                let overnightPlceofvisit = row.querySelector('textarea[name="overnightPlceofvisit[]"]')
                    .value;
                let overnightStayperiod = row.querySelector('select[name="overnightStayperiod[]"]').value;
                let overnightAmount = row.querySelector('input[name="overnightAmount[]"]').value;

                if (!overnightDate) {
                    errorMessages.push('⚠️ Date field is required!');
                    allFieldsFilled = false;
                }
                if (!overnightPlceofvisit) {
                    errorMessages.push('⚠️ Place of visit required!');
                    allFieldsFilled = false;
                }
                if (!overnightStayperiod) {
                    errorMessages.push('⚠️ Overnight Stay Period field is required!');
                    allFieldsFilled = false;
                }
                if (!overnightAmount) {
                    errorMessages.push('⚠️ Amount field is required!');
                    allFieldsFilled = false;
                }
            });

            // Show all error messages in a single toastr notification if any field is missing
            if (!allFieldsFilled) {
                toastr.error(errorMessages.join('<br>')); // Join messages with line breaks
                return; // Stop execution if any field is missing
            }

            // Check if <thead> is empty or doesn't exist, and add it if necessary
            if (rows.length > 0) {
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
            }
            let totalAmountOvernight = 0;

            function updateTotalAmountOvernight() {
                totalAmountOvernight = 0;
                addedTableBody.querySelectorAll('input[name="overnightAmount[]"]').forEach(function(input) {
                    totalAmountOvernight += parseFloat(input.value) || 0;
                });
                document.querySelector('#overnightStayCostTotal').value = parseFloat(totalAmountOvernight);
                updateGrandTotal();
            }
            // Loop through all rows in the first table and get the data
            rows.forEach(function(row) {
                let overnightDate = row.querySelector('input[name="overnightDate[]"]').value;
                let overnightPlceofvisit = row.querySelector('textarea[name="overnightPlceofvisit[]"]')
                    .value;
                let overnightPurpose = row.querySelector('textarea[name="overnightPurpose[]"]').value;
                let overnightStayperiod = row.querySelector('select[name="overnightStayperiod[]"]').value;
                let overnightAmount = parseFloat(row.querySelector('input[name="overnightAmount[]"]')
                    .value) || 0;
                let overnightAssigned = row.querySelector('input[name="overnightAssigned[]"]').value;



                // Create a new row for the second table
                let newRow = document.createElement('tr');
                newRow.innerHTML = `

                <td><input id="flatpickr-date" type="date"
                   class="input-group form-control border-0" name="overnightDate[]"   style="border: none; background-color: transparent;" readonly
                    value="${overnightDate}"></td>
                    <td> <input type="text"
                   class="input-group border-0 form-control" name="overnightPlceofvisit[]"  style="border: 0; background-color: transparent;" readonly
                    value="${overnightPlceofvisit}"> </td>
                    <td> <input type="text"
                   class="input-group border-0 form-control" name="overnightPurpose[]"   style="border: 0; background-color: transparent;" readonly
                    value="${overnightPurpose}"> </td>
                    <td><input type="text"
                   class="input-group border-0 form-control" name="overnightStayperiod[]"   style="border: 0; background-color: transparent;" readonly
                    value="${overnightStayperiod}"> </td>
                    <td> <input type="text"
                   class="input-group border-0 form-control" name="overnightAmount[]"   style="border: 0; background-color: transparent;" readonly
                    value="${overnightAmount}"> </td>
                    <td> <input type="text"
                   class="input-group border-0 form-control" name="overnightAssigned[]"   style="border: 0; background-color: transparent;" readonly
                    value="${overnightAssigned}"> </td>

              <td><button class="deleteRowBtn3 form-control text-danger btn-xs btn-danger">Delete</button></td>
         `;

                // Append the new row to the second table body
                addedTableBody.appendChild(newRow);
                toastr.info("Successfully added!");
                totalAmountOvernight += overnightAmount;
                document.getElementById('overnightStayCostFileId').classList.remove('d-none');
                // Add event listener for delete button to remove row on click
                newRow.querySelector('.deleteRowBtn3').addEventListener('click', function() {
                    newRow.remove();
                    if (!addedTableBody.querySelector('tr')) {
                        addedTableHead.innerHTML = '';
                        tableTitle3.innerHTML = '';
                        if (hrElement3) hrElement3.remove();
                    }
                    updateTotalAmountOvernight();
                    updateGrandTotal();
                });
            });
            document.querySelector('#overnightStayCostTotal').value = parseFloat(totalAmountOvernight);
            updateGrandTotal();

        }); //End

        //////////////////////////////////////////////////// Four other Expenses Costs Add  (ROW**)  Start//////////////////////////////////////////////
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
                                name="otherExpensesDate[]">
                        </td>
                        <td>
                            <textarea class="form-control" id="" cols="20" rows="2" name="otherExpensesPurpose[]"
                                placeholder="Enter Purpose "></textarea>
                        </td>
                        <td><input type="number" class="form-control" name="otherExpensesAmount[]"
                                value=""></td>
                        <td><input type="text" class="form-control" name="otherExpensesAssigned[]"
                                value="">
                        </td>

            `;
            // Append the new row to the table body
            tableBody.appendChild(newRow);

            let amountInput4 = newRow.querySelector('input[name="otherExpensesAmount[]"]');
            amountInput4.addEventListener('input', function() {
                if (parseFloat(amountInput4.value) < 0) {
                    toastr.warning("Amount cannot be negative!");
                    amountInput4.value = "";
                }
                calculateTotal4();
            }); //End validation
            newRow.querySelector('input[name="otherExpensesAmount[]"]').addEventListener('input', calculateTotal4);
            // Calculate total amount in the main table
            function calculateTotal4() {
                let total = 0;
                document.querySelectorAll('#otherExpensesCostsTable input[name="otherExpensesAmount[]"]').forEach(
                    function(
                        input) {
                        total += parseFloat(input.value) || 0;
                    });
                // Display the total amount in the element with ID 'totalAmount'
                document.getElementById('totalAmount4').textContent = total.toFixed(2);
            }

            // Attach event listener to remove button of new row
            newRow.querySelector('.removeRowBtn4').addEventListener('click', function() {
                newRow.remove();
                calculateTotal4();
            });


        });

        ////////////////////////////////////////////////////Four Other Expenses Costs Add (Table**) Start//////////////////////////////////////////////
        const otherExpensesCostsAdd = document.querySelector('.otherExpensesCostsAdd');
        otherExpensesCostsAdd.addEventListener('click', function(e) {
            e.preventDefault();

            let rows = document.querySelectorAll('#otherExpensesCostsTable tbody tr');
            let addedTable = document.querySelector('#otherExpensesTable');
            let addedTableBody = addedTable.querySelector('tbody');
            let addedTableHead = addedTable.querySelector('thead');
            let tableTitle4 = document.querySelector('#otherExpensesCostsData h4');
            let hrElement4 = document.querySelector('#otherExpensesCostsData hr');
            //VAlidation errors
            let allFieldsFilled = true;
            let errorMessages = []

            rows.forEach(function(row) {
                let otherExpensesDate = row.querySelector('input[name="otherExpensesDate[]"]').value;
                let otherExpensesPurpose = row.querySelector('textarea[name="otherExpensesPurpose[]"]')
                    .value;
                let otherExpensesAmount = row.querySelector('input[name="otherExpensesAmount[]"]').value;

                if (!otherExpensesDate) {
                    errorMessages.push('⚠️ Date field is required!');
                    allFieldsFilled = false;
                }

                if (!otherExpensesPurpose) {
                    errorMessages.push('⚠️ Purpose field required!');
                    allFieldsFilled = false;
                }

                if (!otherExpensesAmount) {
                    errorMessages.push('⚠️ Amount field is required!');
                    allFieldsFilled = false;
                }
            });

            // Show all error messages in a single toastr notification if any field is missing
            if (!allFieldsFilled) {
                toastr.error(errorMessages.join('<br>')); // Join messages with line breaks
                return; // Stop execution if any field is missing
            }
            // Check if <thead> is empty or doesn't exist, and add it if necessary
            if (rows.length > 0) {
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
            }
            let totalAmountOtherExpense = 0;

            function updateTotalAmountOtherExpense() {
                totalAmountOtherExpense = 0;
                addedTableBody.querySelectorAll('input[name="otherExpensesAmount[]"]').forEach(function(input) {
                    totalAmountOtherExpense += parseFloat(input.value) || 0;
                });
                document.querySelector('#otherExpensesCostsTotal').value = parseFloat(totalAmountOtherExpense);
                updateGrandTotal();
            }
            // Loop through all rows in the first table and get the data
            rows.forEach(function(row) {
                let otherExpensesDate = row.querySelector('input[name="otherExpensesDate[]"]').value;
                let otherExpensesPurpose = row.querySelector('textarea[name="otherExpensesPurpose[]"]')
                    .value;
                let otherExpensesAmount = parseFloat(row.querySelector(
                    'input[name="otherExpensesAmount[]"]').value) || 0;
                let otherExpensesAssigned = row.querySelector('input[name="otherExpensesAssigned[]"]')
                    .value;
                // Create a new row for the second table
                let newRow = document.createElement('tr');
                newRow.innerHTML = `
             <td><input id="flatpickr-date" type="date"
                   class="input-group form-control border-0" name="otherExpensesDate[]"   style="border: none; background-color: transparent;" readonly
                    value="${otherExpensesDate}"></td>
                    <td> <input type="text"
                   class="input-group border-0 form-control" name="otherExpensesPurpose[]"  style="border: 0; background-color: transparent;" readonly
                    value="${otherExpensesPurpose}"> </td>
                    <td> <input type="text"
                   class="input-group border-0 form-control" name="otherExpensesAmount[]"   style="border: 0; background-color: transparent;" readonly
                    value="${otherExpensesAmount}"> </td>
                    <td><input type="text"
                   class="input-group border-0 form-control" name="otherExpensesAssigned[]"   style="border: 0; background-color: transparent;" readonly
                    value="${otherExpensesAssigned}"> </td>

              <td><button class="deleteRowBtn4 form-control text-danger btn-xs btn-danger">Delete</button></td>
         `;
                // Append the new row to the second table body
                addedTableBody.appendChild(newRow);
                toastr.info("Successfully added!");
                totalAmountOtherExpense += otherExpensesAmount;
                document.getElementById('otherExpensesCostFileId').classList.remove('d-none');
                // Add event listener for delete button to remove row on click
                newRow.querySelector('.deleteRowBtn4').addEventListener('click', function() {
                    newRow.remove();
                    if (!addedTableBody.querySelector('tr')) {
                        addedTableHead.innerHTML = '';
                        tableTitle4.innerHTML = '';
                        if (hrElement4) hrElement4.remove();
                    }
                    updateTotalAmountOtherExpense();
                    updateGrandTotal();
                });
            });
            document.querySelector('#otherExpensesCostsTotal').value = parseFloat(totalAmountOtherExpense);
            updateGrandTotal();
        }); //End

        /////////////////////////////////////////////Grand Sum Show  //////////////////////////////////////////////
        function updateGrandTotal() {
            const foodingTotal = parseFloat(document.querySelector('#foodingCostsTotal').value) || 0;
            const movementTotal = parseFloat(document.querySelector('#movementCostsTotal').value) || 0;
            const overnightTotal = parseFloat(document.querySelector('#overnightStayCostTotal').value) || 0;
            const otherExpenseTotal = parseFloat(document.querySelector('#otherExpensesCostsTotal').value) || 0;

            const grandTotal = foodingTotal + movementTotal + overnightTotal + otherExpenseTotal;

            // Update the grand total display
            document.querySelector('#grandTotalDisplay').textContent = grandTotal.toFixed(2);
        }
        ////////////////////////////Convenience Store////////////////////////////
        $(document).ready(function() {
            $('#convenienceForm').on('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission

                if ($('#employee-select').val() === null) {
                    toastr.error("Please select an Employee ");
                }
                let formData = new FormData(this); // Get the form data
                // console.log(formData); //
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
                        console.log(response);
                        if (response.status == 200) {
                            $('#convenienceForm')[0].reset();
                            toastr.success(response.message);
                            window.location.reload();
                        } else {
                            toastr.error(response.error);
                        }

                    },
                    error: function(xhr, status, error) {
                        console.log(xhr, status, error)
                        alert("An error occurred while submitting the form.");
                    }
                });
            });
        });
    </script>
@endsection
