@extends('master')
@section('title', '| Employee List')
@section('admin')
    <div class="row">

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12 grid-margin stretch-card d-flex mb-2 justify-content-between">
                        <div class="">
                            <h6 class="card-title ">View Salary Sheet</h6>
                        </div>
                    </div>
                    <div id="" class="table-responsive">
                        <table id="showSlipTable" class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Payment Date</th>
                                    <th>Total Gross Salary</th>
                                    <th>total Deductions</th>
                                    <th>Total Employee Bonus</th>
                                    <th>Total Convenience Amount</th>
                                    <th>Total Net Salary</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="showSlip">

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
         const userRole = @json(Auth::user()->role);
        function fetchPaySlips() {

            $.ajax({
                url: '/employe/all/slip/view',
                type: "GET",
                dataType: "json",
                success: function(response) {
                    // console.log(response.paySlip);
                    if ($.fn.DataTable.isDataTable('#showSlipTable')) {
                        $('#showSlipTable').DataTable().clear().destroy();
                    }
                    if (response.paySlip) {
                        $('.showSlip').empty(); // Clear previous data if any

                        $.each(response.paySlip, function(index, paySlips) {
                            $('.showSlip').append(`
                    <tr>
                        <td>${paySlips.employee ? paySlips.employee.full_name : 'N/A'}</td>
                        <td>${paySlips.pay_period_date}</td>
                        <td>${paySlips.total_gross_salary}</td>
                        <td>${paySlips.total_deductions}</td>
                        <td>${paySlips.total_employee_bonus}</td>
                        <td>${paySlips.total_convenience_amount}</td>
                        <td>${paySlips.total_net_salary}</td>
                        <td>
 ${
                userRole === 'accountant'
                    ? ` <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton${paySlips.id}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span id="statusBadge${paySlips.id}" class="badge text-dark
                                    ${paySlips.status === 'pending' ? 'bg-warning' : (paySlips.status === 'approved' ? 'bg-success' : (paySlips.status === 'paid' ? 'bg-primary' : 'bg-info'))}">
                                    ${paySlips.status ? paySlips.status.charAt(0).toUpperCase() + paySlips.status.slice(1) : 'Processing'}
                                </span>
                            </button>`
                    : `
                          <div class="dropdown" id="statusChange${paySlips.id}">
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton${paySlips.id}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span id="statusBadge${paySlips.id}" class="badge text-dark
                                    ${paySlips.status === 'pending' ? 'bg-warning' : (paySlips.status === 'approved' ? 'bg-success' : (paySlips.status === 'paid' ? 'bg-primary' : 'bg-info'))}">
                                    ${paySlips.status ? paySlips.status.charAt(0).toUpperCase() + paySlips.status.slice(1) : 'Processing'}
                                </span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton${paySlips.id}">
                                <a class="dropdown-item" href="#" onclick="changeStatusPayslip(${paySlips.id}, 'pending' , ${paySlips.employee_id})">Pending</a>
                                <a class="dropdown-item" href="#" onclick="changeStatusPayslip(${paySlips.id}, 'approved')">Approved</a>
                                <a class="dropdown-item" href="#" onclick="changeStatusPayslip(${paySlips.id}, 'processing')">Processing</a>
                            </div>
                        </div>
                         `}
                        </td>

                        <td id="editButtonContainer${paySlips.id}">
                            ${paySlips.status === 'pending'  ? `</a>` : ''}
                            <a href="#" class="btn btn-sm btn-primary btn-icon payment_salary" data-id="${paySlips.id}">
                                <i class="fa-solid fa-money-check-dollar"></i>
                            </a>
                    </td>
                    </tr>
                `);
                        });
                    }
                    ///
                    $('#showSlipTable').DataTable({
                        columnDefs: [{
                            "defaultContent": "-",
                            "targets": "_all"
                        }],
                        dom: 'Bfrtip',
                        buttons: [{
                                extend: 'excelHtml5',
                                text: 'Excel',
                                exportOptions: {
                                    header: true,
                                    columns: ':visible'
                                },
                                customize: function(xlsx) {
                                    return '{{ $header ?? '' }}\n {{ $phone ?? '+880.....' }}\n {{ $email ?? '' }}\n{{ $address ?? '' }}\n\n' +
                                        xlsx + '\n\n';
                                }
                            },
                            {
                                extend: 'pdfHtml5',
                                text: 'PDF',
                                exportOptions: {
                                    header: true,
                                    columns: ':visible'
                                },
                                customize: function(doc) {
                                    doc.content.unshift({
                                        text: '{{ $header ?? '' }}\n {{ $phone ?? '+880.....' }}\n {{ $email ?? '' }}\n{{ $address ?? '' }}',
                                        fontSize: 14,
                                        alignment: 'center',
                                        margin: [0, 0, 0, 12]
                                    });
                                    doc.content.push({
                                        text: 'Thank you for using our service!',
                                        fontSize: 14,
                                        alignment: 'center',
                                        margin: [0, 12, 0, 0]
                                    });
                                    return doc;
                                }
                            },
                            {
                                extend: 'print',
                                text: 'Print',
                                exportOptions: {
                                    header: true,
                                    columns: ':visible'
                                },
                                customize: function(win) {
                                    $(win.document.body).prepend(
                                        '<h4>{{ $header }}</br>{{ $phone ?? '+880....' }}</br>Email:{{ $email }}</br>Address:{{ $address }}</h4>'
                                    );
                                    $(win.document.body).find('h1')
                                        .hide(); // Hide the title element
                                }
                            }
                        ]
                    });
                    ///
                },
                error: function(xhr, status, error) {
                    console.error("Failed to fetch pay slips:", error);
                }
            });
        }
        fetchPaySlips();
        ///Status Change
        function changeStatusPayslip(id, status, employee_id) {
            if ($('#statusBadge' + id).text().trim().toLowerCase() === 'paid') {
                toastr.warning("Status cannot be changed as it's already 'Paid'.");
                return;
            }
            $.ajax({
                url: '/update-status-payslip',
                type: 'POST',
                data: {
                    id: id,
                    status: status,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Update badge color and text dynamically
                    const badge = $('#statusBadge' + id);
                    badge.text(status.charAt(0).toUpperCase() + status.slice(1));

                    // Remove existing badge classes and add new one based on status
                    badge.removeClass('bg-warning bg-success bg-primary bg-info');
                    if (status === 'pending') {
                        badge.addClass('bg-warning');
                    } else if (status === 'approved') {
                        badge.addClass('bg-success');
                    } else if (status === 'paid') {
                        badge.addClass('bg-primary');
                    } else if (status === 'processing') {
                        badge.addClass('bg-info');
                    }
                    const editButtonContainer = $('#editButtonContainer' + id);
                    if (status === 'pending') {
                        // Show or add the edit button if status is pending
                        editButtonContainer.html(`
                    <a href="/employee/profile/edit/${employee_id}/${id}" class="btn btn-sm btn-primary btn-icon payslip_edit" data-id="${id}">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                `);
                    } else {
                        // Remove the edit button if status is not pending
                        editButtonContainer.html('');
                    }
                },
                error: function(error) {
                    console.error("Error updating status", error);
                    alert("There was an issue updating the status. Please try again.");
                }
            });
        }



        $(document).on('click', '.payment_salary', function(e) {
            e.preventDefault();
            let id = this.getAttribute('data-id');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: `/pay-slip/${id}`,
                type: 'GET',
                success: function(res) {
                    if (res.status == 200) {
                        const salary = res.paySlip;
                        // console.log(salary);
                        $('#globalPaymentModal #data_id').val(salary.id);
                        $('#globalPaymentModal #payment_balance').val(salary.total_net_salary);
                        $('#globalPaymentModal #purpose').val('Employee Salary');
                        $('#globalPaymentModal #transaction_type').val('withdraw');
                        $('#globalPaymentModal #due-amount').text(salary.total_net_salary);
                        // Open the Payment Modal
                        $('#globalPaymentModal').modal('show');
                    } else {
                        toastr.error("data Not Found");
                    }
                }
            });
        })
    </script>
@endsection
