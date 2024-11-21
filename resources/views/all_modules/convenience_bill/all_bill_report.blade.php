@extends('master')
@section('title', '| Conveyance List')
@section('admin')

    <div class="row">

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-title text-info">View Conveyance Bill Report List</h6>
                        <div>
                            @if ($convenienceBill->status != 'paid')
                                <button class="btn btn-sm btn-primary payment_conveience_bill"
                                    data-id="{{ $convenienceBill->id }}">
                                    Payment
                                </button>
                            @endif
                        </div>
                    </div>
                    @if (
                        $movementCosts->isNotEmpty() &&
                            $movementCosts->some(fn($movementCost) => $movementCost->movementDetails->isNotEmpty()))
                        <h4>Movement Bill</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Date</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Purpose</th>
                                        <th>Mode of Transport</th>
                                        <th>Amount (TK)</th>
                                        <th>Assigned</th>
                                    </tr>
                                </thead>
                                <tbody class="showData">
                                    @foreach ($movementCosts as $key => $movementCost)
                                        @if ($movementCost->movementDetails->isNotEmpty())
                                            @foreach ($movementCost->movementDetails as $detail)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $detail->movement_date ?? '' }}</td>
                                                    <td>{{ $detail->movement_from ?? '' }}</td>
                                                    <td>{{ $detail->movement_to ?? '' }}</td>
                                                    <td>{{ $detail->movement_purpose ?? '-' }}</td>
                                                    <td>{{ $detail->mode_of_transport ?? '' }}</td>
                                                    <td>{{ $detail->movement_amount ?? '' }}</td>
                                                    <td>{{ $detail->movement_assigned ?? '' }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    @if ($foodingCosts->isNotEmpty() && $foodingCosts->some(fn($foodingCost) => $foodingCost->foodingDetails->isNotEmpty()))
                        <h4>Fooding Bill</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Date</th>
                                        <th>Place of Visit</th>
                                        <th>Purpose</th>
                                        <th>Fooding Time</th>
                                        <th>Amount (TK)</th>
                                        <th>Assigned</th>
                                    </tr>
                                </thead>
                                <tbody class="showData">
                                    @foreach ($foodingCosts as $key => $foodingCost)
                                        @if ($foodingCost->foodingDetails->isNotEmpty())
                                            @foreach ($foodingCost->foodingDetails as $detail)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $detail->fooding_date ?? '' }}</td>
                                                    <td>{{ $detail->fooding_place_of_visit ?? '' }}</td>
                                                    <td>{{ $detail->fooding_purpose ?? '' }}</td>
                                                    <td>{{ $detail->fooding_time ?? '' }}</td>
                                                    <td>{{ $detail->fooding_amount ?? '' }}</td>
                                                    <td>{{ $detail->fooding_assigned ?? '' }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    @if (
                        $overnightCosts->isNotEmpty() &&
                            $overnightCosts->some(fn($overnightCost) => $overnightCost->overnightDetails->isNotEmpty()))
                        <h4>Overnight Bill</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Date</th>
                                        <th>Place of Visit</th>
                                        <th>Purpose</th>
                                        <th>Stay period</th>
                                        <th>Amount (TK)</th>
                                        <th>Assigned</th>
                                    </tr>
                                </thead>
                                <tbody class="showData">
                                    @foreach ($overnightCosts as $key => $overnightCost)
                                        @if ($overnightCost->overnightDetails->isNotEmpty())
                                            @foreach ($overnightCost->overnightDetails as $detail)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $detail->overnight_date ?? '' }}</td>
                                                    <td>{{ $detail->overnight_place_of_visit ?? '' }}</td>
                                                    <td>{{ $detail->overnight_purpose ?? '' }}</td>
                                                    <td>{{ $detail->overnight_stay_period ?? '' }}</td>
                                                    <td>{{ $detail->overnight_amount ?? '' }}</td>
                                                    <td>{{ $detail->overnight_assigned ?? '' }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    @if (
                        $otherExpenseCosts->isNotEmpty() &&
                            $otherExpenseCosts->some(fn($otherExpenseCost) => $otherExpenseCost->otherExpensetDetails->isNotEmpty()))
                        <h4>Other Expense Bill</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Date</th>
                                        <th>Purpose</th>
                                        <th>Amount (TK)</th>
                                        <th>Assigned</th>
                                    </tr>
                                </thead>
                                <tbody class="showData">
                                    @foreach ($otherExpenseCosts as $key => $otherExpenseCost)
                                        @if ($otherExpenseCost->otherExpensetDetails->isNotEmpty())
                                            @foreach ($otherExpenseCost->otherExpensetDetails as $detail)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $detail->other_expense_date ?? '' }}</td>
                                                    <td>{{ $detail->other_expense_purpose ?? '' }}</td>
                                                    <td>{{ $detail->other_expense_amount ?? '' }}</td>
                                                    <td>{{ $detail->other_expense_assigned ?? '' }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>


    <script>
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
