@extends('master')
@section('title', '| Expense')
@section('admin')
    <style>
        button {
            border: none !important;
        }
    </style>
    <div class="row">
        <div id="filter-rander">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title text-info">Convenience Bill Report</h6>
                        <div id="tableContainer" class="table-responsive">
                            <table id="example" class="table">
                                <thead class="action">
                                    <tr>
                                        <th>SN</th>
                                        <th>Invoice No.</th>
                                        <th>Employee Name</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="showData">

                                    @if ($convenience->count() > 0)
                                        @foreach ($convenience as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td><a
                                                        href="{{ route('convenience.invoice', $item->id) }}">{{ $item->bill_number }}</a>
                                                </td>
                                                <td>{{ $item->employee->full_name }}</td>
                                                <td>{{ $item->total_amount }}</td>
                                                <td>
                                                    <div class="dropdown" id="statusChange{{ $item->id }}">
                                                        <button class="btn dropdown-toggle" type="button"
                                                            id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                            <a href="#" id="statusBadge{{ $item->id }}"
                                                                class="badge text-dark
                                                    {{ $item->status == 'pending' ? 'bg-warning' : ($item->status == 'approved' ? 'bg-success' : 'bg-primary') }}">
                                                                {{ ucfirst($item->status) }}
                                                            </a>
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a class="dropdown-item" href="#"
                                                                onclick="changeStatus({{ $item->id }}, 'pending')">Pending</a>
                                                            <a class="dropdown-item" href="#"
                                                                onclick="changeStatus({{ $item->id }}, 'approved')">Approved</a>
                                                            <a class="dropdown-item" href="#"
                                                                onclick="changeStatus({{ $item->id }}, 'paid')">Paid</a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="#"
                                                        class="btn btn-icon btn-xs btn-primary payment_conveience_bill"
                                                        data-id={{ $item->id }}>
                                                        <i class="fa-regular fa-credit-card"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="12">
                                                <div class="text-center text-warning mb-2">Data Not Found</div>
                                                <div class="text-center">
                                                    <a href="#" class="btn btn-primary">Add Convenience<i
                                                            data-feather="plus"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function changeStatus(id, status) {
            $.ajax({
                url: '/update-status', // Adjust with your route URL
                type: 'POST',
                data: {
                    id: id,
                    status: status,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Update badge color and text
                    let badge = $('#statusBadge' + id);
                    badge.text(status.charAt(0).toUpperCase() + status.slice(1));

                    if (status === 'pending') {
                        badge.removeClass('bg-success bg-primary').addClass('bg-warning');
                    } else if (status === 'approved') {
                        badge.removeClass('bg-warning bg-primary').addClass('bg-success');
                    } else if (status === 'paid') {
                        badge.removeClass('bg-warning bg-success').addClass('bg-primary');
                    }
                },
                error: function(error) {
                    console.error("Error updating status", error);
                }
            });
        }
        changeStatus()



        $(document).on('click', '.payment_conveience_bill', function(e) {
            e.preventDefault();
            let id = this.getAttribute('data-id');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: `/convenience/view-details/${id}`,
                type: 'GET',
                success: function(res) {
                    if (res.status == 200) {
                        const convenience = res.convenience;
                        $('#globalPaymentModal #data_id').val(convenience
                            .id); // assuming res.data contains asset_id
                        $('#globalPaymentModal #payment_balance').val(convenience
                            .total_amount);
                        $('#globalPaymentModal #purpose').val('Convenience Bill');
                        $('#globalPaymentModal #transaction_type').val('withdraw');
                        $('#globalPaymentModal #due-amount').text(convenience
                            .total_amount);
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
