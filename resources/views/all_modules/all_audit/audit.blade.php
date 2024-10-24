@extends('master')
@section('title', '| Bank Account Management')
@section('admin')
<style>
    .no-gutters {
        margin-right: 0;
        margin-left: 0;
    }
    .no-gutters > .col-md-2, .no-gutters > .col-md-4 {
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

        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            font-weight: bold;
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
                <div id="" class="table-responsive">
                    <div class="bill-header">
                        <form  id="auditForm" method="POST">
                            @csrf
                        <div class="row no-gutters">
                            <div class="col-md-2">
                                <strong>Department:</strong>
                            </div>
                            <div class="col-md-4">
                                <select class="form-control js-example-basic-single"  name="department"  id="department-select">
                                    <option value="" selected disabled>Select Departments</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <p><div class="row no-gutters">
                            <div class="col-md-2">
                                <strong>Name:</strong>
                            </div>
                            <div class="col-md-4">
                                <select class="form-control js-example-basic-single " name="empoyee" id="employee-select">
                                    <option  selected disabled>Select Name</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div></p>
                        {{-- <p><strong>Bill Entry Number (Admin):</strong></p> --}}

                        <p><strong>Date:</strong> <span id="current-date"></span></p>

                    </div>


                        <table id="expenseTable">
                            <thead>
                                <tr>
                                    <th><button type="button" class="form-control"   id="addRowBtn">+ </button></th>
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
                                    <td><button type="button" class="removeRowBtn form-control text-danger btn-xs btn-danger">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button></td>
                                    <td><input id="flatpickr-date" type="date" class="nput-group flatpickr form-control" name="date[]" value="2024-10-21"></td>
                                    <td>
                                        <textarea class="form-control"  cols="30" rows="2" name="from[]" placeholder="From "></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control" id="" cols="30" rows="2" name="to[]"  placeholder="To "></textarea>
                                    </td>
                                    <td>

                                       <textarea class="form-control" id="" cols="30" rows="2"  name="purpose[]" placeholder="Enter Purpose "></textarea>
                                    </td>

                                    <td>
                                        <select class="form-control" name="Mode_of_Transport[]">
                                            <option  selected disabled>Select Transport</option>
                                            <option value="bike">Bike</option>
                                            <option value="rickshaw">Rickshaw</option>
                                            <option value="cars"> Cars</option>
                                            <option value="buses"> Buses</option>
                                      </select>

                                    </td>
                                    <td><input type="number" class="form-control"name="amount[]" value="150"></td>
                                    <td><input type="text" class="form-control" name="assigned[]" value="Admin"></td>

                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-end"><strong>Total Money</strong></td>
                                    <td ><strong id="totalAmount">00</strong></td>
                                    <td></td>

                                </tr>
                            </tfoot>
                        </table>
                        <button  class="btn border-1" type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    <script>
        document.getElementById('addRowBtn').addEventListener('click', function() {
            let tableBody = document.querySelector('#expenseTable tbody');
            let newRow = document.createElement('tr');

            // Create new row with input fields
            newRow.innerHTML = `
              <td><button type="button" class="removeRowBtn form-control text-danger btn-xs btn-danger">
                                            <i class="fa-solid fa-trash-can "></i>
                                        </button></td>
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

    //////////////////////////Drowdown //////////////////////
        $(document).ready(function() {
    $('#department-select').on('change', function() {
        var departmentId = $(this).val();

        // Clear the employee dropdown before new data is loaded
        $('#employee-select').empty().append('<option value="" selected disabled>Loading...</option>');
        $.ajax({
            url: '/employees-by-department/' + departmentId,
            type: 'GET',
            success: function(data) {
                // Clear the employee dropdown and add the default option
                $('#employee-select').empty().append('<option value="" selected disabled>Select Name</option>');

                $.each(data, function(index, employee) {
                    $('#employee-select').append(`<option value="${employee.id}">${employee.full_name}</option>`);
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
    ////////////////////////////Store////////////////////////////
    $(document).ready(function () {
        $('#auditForm').on('submit', function (event) {
            event.preventDefault(); // Prevent the default form submission
            let formData = new FormData(this); // Get the form data

            $.ajax({
                url: "{{route('audit.store')}}", // The route to handle form submission
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    $('#auditForm')[0].reset();
                    $('#expenseTable tbody').empty(); // Clear table rows if needed
                    calculateTotal(); //
                    // Handle success - Display a success message, clear form, etc.
                    alert("Form submitted successfully.");
                },
                error: function (xhr, status, error) {
                    // Handle error - Display error message, etc.
                    alert("An error occurred while submitting the form.");
                }
            });
        });
    });
    </script>
@endsection
