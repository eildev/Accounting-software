@extends('master')
@section('title', '| Services Name')
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

        .serviceSale table th,
        .serviceSale table td,
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
            <div class="card ">
                <div class="card-body">
                    <div class="col-md-12 grid-margin stretch-card d-flex  mb-0 justify-content-between">
                        <div>

                        </div>
                        <div class="">
                            <h4 class="text-right"><a href="{{ route('service.sale.view') }}" class="btn"
                                    style="background: #5660D9">View Service Sale</a></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form action="" id="serviceForm">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="card-title">Service Name Table</h6>
                            {{-- <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                    data-bs-target="#exampleModalLongScollable">Add Departments</button> --}}
                        </div>
                        <div id="" class="table-responsive">
                            <div class="bill-header">
                                <div class="row no-gutters">
                                    <div class="col-md-2">
                                        <strong>Customer Name:</strong>
                                    </div>
                                    @php
                                        $customers = App\Models\Customer::get();
                                    @endphp
                                    <div class="col-md-4">
                                        <select class="form-control js-example-basic-single " name="customer_id"
                                            id="customer-select">
                                            <option selected disabled>Select Name</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="ms-5">
                                            <h3 class="grandTotal">Total Amount: <span id="grandTotalDisplay">0</span></h3>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-2">
                                        <strong>Date:</strong>
                                    </div>
                                    <div class="col-md-4 mb-4 mt-2">
                                        <div class="input-group flatpickr me-2 mb-2 mb-md-0 date-select" id="dashboardDate">
                                            <span class="input-group-text input-group-addon bg-transparent border-primary"
                                                data-toggle><i data-feather="calendar" class="text-primary"></i></span>
                                            <input type="text" name="date"
                                                class="form-control bg-transparent border-primary" placeholder="Select date"
                                                data-input>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- /////////Tabing Start//// -->
                            <div class="row">
                                <div class="col-md-12 grid-margin stretch-card">
                                    <div class="example w-100">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <!---First li--->
                                            {{-- <li class="nav-item">
                                        <a class="nav-link active" id="serviceSale-tab" data-bs-toggle="tab"
                                            href="#serviceSale" role="tab" aria-controls="serviceSale"
                                            aria-selected="true">Movement Costs
                                        </a>
                                         </li> --}}

                                        </ul>
                                        <!--First Tab  Start-->

                                        <div class="tab-content border border-top-0 p-3" id="myTabContent">

                                            <div class="tab-pane fade show active" id="serviceSale" role="tabpanel"
                                                aria-labelledby="serviceSale-tab">
                                                <div class="col-md-12 serviceSale">

                                                    <table id="serviceTable">
                                                        <thead>
                                                            <tr>
                                                                <th><button type="button" class="form-control"
                                                                        id="addServiceRowBtn">+
                                                                    </button></th>
                                                                <th>Product/Service Name</th>
                                                                <th>Volume</th>
                                                                <th>Price</th>
                                                                <th>Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="4" class="text-end"><strong>Total
                                                                        Amount</strong>
                                                                </td>
                                                                <td><strong id="totalAmount">00</strong></td>

                                                            </tr>

                                                        </tfoot>
                                                    </table>
                                                </div>
                                                <button type="submit" class="btn btn-md float-end serviceSaleAdd"
                                                    style="border:1px solid #6587ff ">Submit</button>

                                            </div>
                                            <!--First Tab End -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('addServiceRowBtn').addEventListener('click', function() {
            let tableBody = document.querySelector('#serviceTable tbody');
            let totalAmountElement = document.getElementById('totalAmount');
            let grandTotalAmountElement = document.getElementById('grandTotalDisplay');
            let newRow = document.createElement('tr');

            // Create new row with input fields
            newRow.innerHTML = `
              <td><button type="button" class="removeServiceRowBtn form-control text-danger btn-xs btn-danger">
                <i class="fa-solid fa-trash-can "></i></button></td>
                <td> <input type="text" class="input-group flatpickr form-control" name="serviceName[]" placeholder="Service Name" value=""></td>

                <td><input type="number" class="form-control volume-input"  name="volume[]" placeholder="Volume"></td>

                <td> <input type="number" class="form-control price-input"  name="price[]"  placeholder="Price"></td>

                <td><input type="number" class="form-control  total-input" readonly name="total[]" value=""  placeholder="Total Price"></td>

            `;
            // Append the new row to the table body
            tableBody.appendChild(newRow);

            let volumeInput = newRow.querySelector('.volume-input');
            let priceInput = newRow.querySelector('.price-input');
            let totalInput = newRow.querySelector('.total-input');
            [volumeInput, priceInput].forEach(input => {
                input.addEventListener('input', function() {
                    if (this.value < 0) {
                        this.value = '';
                        toastr.warning('⚠️ Negative values are not allowed.');
                    }
                });
            });

            function calculateTotal() {
                let volume = parseFloat(volumeInput.value) || 0;
                let price = parseFloat(priceInput.value) || 0;
                totalInput.value = (volume * price).toFixed(2);
                calculateTotalSum();
            }
            volumeInput.addEventListener('input', calculateTotal);
            priceInput.addEventListener('input', calculateTotal);

            function calculateTotalSum() {
                let totalInputs = document.querySelectorAll('.total-input');
                let grandTotal = 0;

                totalInputs.forEach(input => {
                    grandTotal += parseFloat(input.value) || 0;
                });

                totalAmountElement.textContent = grandTotal.toFixed(2);
                grandTotalAmountElement.textContent = grandTotal.toFixed(2);
            }
            newRow.querySelector('.removeServiceRowBtn').addEventListener('click', function() {
                newRow.remove();
                calculateTotalSum();
            });
        });
        //Validate
        const serviceSaleAdd = document.querySelector('.serviceSaleAdd');
        const serviceForm = document.getElementById('serviceForm');
        serviceSaleAdd.addEventListener('click', function(e) {
            e.preventDefault();
            ///////////////Validation Start /////////////
            const rows = document.querySelectorAll('#serviceTable tbody tr');

            // Initialize validation variables
            let allFieldsFilled = true;
            let errorMessages = [];

            // Loop through each row and validate inputs
            rows.forEach(function(row) {
                let serviceName = row.querySelector('input[name="serviceName[]"]').value.trim();
                let volume = row.querySelector('input[name="volume[]"]').value.trim();
                let price = row.querySelector('input[name="price[]"]').value.trim();

                // Validate Service Name
                if (!serviceName) {
                    errorMessages.push('⚠️ Service Name field is required.');
                    allFieldsFilled = false;
                }

                // Validate Volume
                if (!volume) {
                    errorMessages.push('⚠️ Volume field is required.');
                    allFieldsFilled = false;
                } else if (isNaN(volume) || volume <= 0) {
                    errorMessages.push('⚠️ Volume must be a positive number.');
                    allFieldsFilled = false;
                }

                // Validate Price
                if (!price) {
                    errorMessages.push('⚠️ Price field is required.');
                    allFieldsFilled = false;
                } else if (isNaN(price) || price <= 0) {
                    errorMessages.push('⚠️ Price must be a positive number.');
                    allFieldsFilled = false;
                }
            });

            // If validation fails, display error messages
            if (!allFieldsFilled) {
                toastr.warning(errorMessages.join('<br>'));
                return;
            }
            ///////////////Validation End /////////////
            if(rows.length > 0){
                if ($('#customer-select').val() === null || $('#customer-select').val() === '') {
                    toastr.error("Please select a Customer ");
                }
            // AJAX Submission
            let formData = new FormData(serviceForm);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('service.sale.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 200) {
                        serviceForm.reset();
                        $('#serviceTable tbody').empty(); // Clear the table rows
                        toastr.success(response.message);
                        // Optionally reload the page
                        window.location.href = '/service/sale/view';
                    } else {
                        toastr.error(response.error || 'Something went wrong.');
                    }
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 422) { // Validation error from server
                        let errors = xhr.responseJSON.errors;
                        let errorList = Object.values(errors).flat().join('<br>');
                        toastr.error(errorList);
                    } else {
                        toastr.warning('An unexpected error occurred.');
                    }
                }
            });
        }else{
            toastr.error('⚠️ Please Add a Service First.');
        }

        });
    </script>
@endsection
