@extends('master')
@section('title', '| Audit Management')
@section('admin')
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
    </style>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="card-title">Audit Table</h6>
                        {{-- <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#exampleModalLongScollable">Add Departments</button> --}}
                    </div>
                    {{-- <form id="auditForm" method="POST"> --}}
                    @csrf
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
                                                                    name="date[]" value="2024-10-21">
                                                            </td>
                                                            <td>
                                                                <textarea class="form-control" cols="30" rows="2" name="from[]" placeholder="From "></textarea>
                                                            </td>
                                                            <td>
                                                                <textarea class="form-control" id="" cols="30" rows="2" name="to[]" placeholder="To "></textarea>
                                                            </td>
                                                            <td>

                                                                <textarea class="form-control" id="" cols="30" rows="2" name="purpose[]"
                                                                    placeholder="Enter Purpose "></textarea>
                                                            </td>

                                                            <td>
                                                                <select class="form-control" name="Mode_of_Transport[]">
                                                                    <option selected disabled>Select Transport</option>
                                                                    <option value="bike">Bike</option>
                                                                    <option value="rickshaw">Rickshaw</option>
                                                                    <option value="cars"> Cars</option>
                                                                    <option value="buses"> Buses</option>
                                                                </select>
                                                            </td>
                                                            <td><input type="number" class="form-control"name="amount[]"
                                                                    value="150"></td>
                                                            <td><input type="text" class="form-control" name="assigned[]"
                                                                    value="Admin">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="6" class="text-end"><strong>Total Money</strong>
                                                            </td>
                                                            <td><strong id="totalAmount">00</strong></td>
                                                            <td></td>
                                                        </tr>

                                                    </tfoot>

                                                </table>
                                            </div>
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
                                                            <th><button type="button" class="form-control" id="addRowBtn2">+
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
                                                                    class="input-group form-control"
                                                                    name="date2[]" value="2024-10-21">
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
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="5" class="text-end"><strong>Total Money</strong>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /////////Tabing End//// -->
                        <!---Added tab data show by list--->
                        <div class="col-md-12" id="movementCostData">

                            <table id="expenseTable">
                                <thead>
                                    <tr>
                                        {{-- <th>Date</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Purpose</th>
                                        <th>Mode of Transport</th>
                                        <th>Amount (TK)</th>
                                        <th>Assigned</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>

                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                    <!----Final Table---->
                                    </tr>

                                </tfoot>

                            </table>
                        </div>
                        <!---Added tab data show by list End--->
                    </div>
                    {{-- </form> --}}
                </div>
            </div>
        </div>
    </div>

    <script>
        ////////////////////////////////////////////////////First movementcosts Cost Add New row  Start//////////////////////////////////////////////
        document.getElementById('addRowBtn').addEventListener('click', function() {
            let tableBody = document.querySelector('#movementcostsTable tbody');
            let newRow = document.createElement('tr');

            // Create new row with input fields
            newRow.innerHTML = `
              <td><button type="button" class="removeRowBtn form-control text-danger btn-xs btn-danger">
                <i class="fa-solid fa-trash-can "></i></button></td>
                <td> <input type="date" class="input-group flatpickr form-control" name="date[]" value=""></td>
                <td><textarea class="form-control"  cols="30" rows="2" name="from[]" placeholder="From "></textarea></td>
                <td> <textarea class="form-control" id="" cols="30" rows="2" name="to[]"  placeholder="To "></textarea></td>
                <td> <textarea class="form-control" id="" cols="30" rows="2"  name="purpose[]" placeholder="Enter Purpose "></textarea></td>
                <td>
                <select class="form-control" name="Mode_of_Transport[]">
                        <option selected disabled>Select Transport</option>
                        <option value="bike">Bike</option>
                        <option value="rickshaw">Rickshaw</option>
                        <option value="cars"> Cars</option>
                        <option value="buses"> Buses</option>
                </select>
                </td>
                <td><input type="number" class="form-control" name="amount[]" value=""></td>
                <td><input type="text" class="form-control" name="assigned[]" value=""></td>

            `;
            // Append the new row to the table body
            tableBody.appendChild(newRow);

            // Attach event listener to remove button of new row
            newRow.querySelector('.removeRowBtn').addEventListener('click', function() {
                newRow.remove();
                calculateTotal();
            });
            // Recalculate total after adding a new row
            newRow.querySelector('input[name="amount[]"]').addEventListener('input', calculateTotal);
            // Recalculate total after adding a new row
            calculateTotal()
        });

        // Function to calculate total
        function calculateTotal() {
            let total = 0;
            document.querySelectorAll('input[name="amount[]"]').forEach(function(input) {
                total += parseFloat(input.value) || 0;
            });
            document.getElementById('totalAmount').textContent = total;
        }
        document.querySelectorAll('input[name="amount[]"]').forEach(function(input) {
            input.addEventListener('input', calculateTotal);
        });
        // Event listener for removing a row
        document.querySelectorAll('.removeRowBtn').forEach(function(button) {
            button.addEventListener('click', function() {
                this.closest('tr').remove();
                calculateTotal();
            });
        });
        //First  Add row  Tab End
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

        //////////////////////////////////movement Costs Added New Table//////////////////////////////////////
      const  movementCostsAdd = document.querySelector('.movementCostsAdd');
      movementCostsAdd.addEventListener('click', function(e){
        e.preventDefault();
        let rows = document.querySelectorAll('#movementcostsTable tbody tr');
        let addedTable = document.querySelector('#movementCostData');
        let addedTableBody = document.querySelector('#movementCostData tbody');

        if (!addedTable.querySelector('thead')) {
        let newHeader = document.createElement('thead');
        newHeader.innerHTML = `
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
        addedTable.insertBefore(newHeader, addedTableBody); // Insert <thead> before <tbody>
    }
      // Clear previous data from the second table
       addedTableBody.innerHTML = '';

    // Loop through all rows in the first table and get the data
    rows.forEach(function(row) {
        let date = row.querySelector('input[name="date[]"]').value;
        let from = row.querySelector('textarea[name="from[]"]').value;
        let to = row.querySelector('textarea[name="to[]"]').value;
        let purpose = row.querySelector('textarea[name="purpose[]"]').value;
        let modeOfTransport = row.querySelector('select[name="Mode_of_Transport[]"]').value;
        let amount = row.querySelector('input[name="amount[]"]').value;
        let assigned = row.querySelector('input[name="assigned[]"]').value;

        // Create a new row for the second table
        let newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>${date}</td>
            <td>${from}</td>
            <td>${to}</td>
            <td>${purpose}</td>
            <td>${modeOfTransport}</td>
            <td>${amount}</td>
            <td>${assigned}</td>
              <td><button class="deleteRowBtn form-control text-danger btn-xs btn-danger">Delete</button></td>
        `;
        // Append the new row to the second table body
        addedTableBody.appendChild(newRow);
        newRow.querySelector('.deleteRowBtn').addEventListener('click', function() {
            newRow.remove(); // Removes the row when the delete button is clicked
        });
    });
      });
 ////////////////////////////////////////////////////Second tab Fooding cost Add row  Start//////////////////////////////////////////////
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
                                name="date2[]" value="2024-10-21">
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
                calculateTotal();
            });
            // Recalculate total after adding a new row
            newRow.querySelector('input[name="amount2[]"]').addEventListener('input', calculateTotal);
            // Recalculate total after adding a new row
              calculateTotal()
        });

        // Function to calculate total
        function calculateTotal() {
            let total = 0;
            document.querySelectorAll('input[name="amount2[]"]').forEach(function(input) {
                total += parseFloat(input.value) || 0;
            });
            document.getElementById('totalAmount2').textContent = total;
        }
        document.querySelectorAll('input[name="amount2[]"]').forEach(function(input) {
            input.addEventListener('input', calculateTotal);
        });
        // Event listener for removing a row
        document.querySelectorAll('.removeRowBtn2').forEach(function(button) {
            button.addEventListener('click', function() {
                this.closest('tr').remove();
                calculateTotal();
            });
        });
        //First  Add row  Tab End
        ////////////////////////////Store////////////////////////////


        // $(document).ready(function() {
        //     $('#auditForm').on('submit', function(event) {
        //         event.preventDefault(); // Prevent the default form submission
        //         let formData = new FormData(this); // Get the form data

        //         $.ajax({
        //             url: "{{ route('audit.store') }}", // The route to handle form submission
        //             type: "POST",
        //             data: formData,
        //             processData: false,
        //             contentType: false,
        //             success: function(response) {
        //                 $('#auditForm')[0].reset();
        //                 $('#expenseTable tbody').empty(); // Clear table rows if needed
        //                 calculateTotal(); //
        //                 // Handle success - Display a success message, clear form, etc.
        //                 alert("Form submitted successfully.");
        //             },
        //             error: function(xhr, status, error) {
        //                 // Handle error - Display error message, etc.
        //                 alert("An error occurred while submitting the form.");
        //             }
        //         });
        //     });
        // });
    </script>
@endsection
