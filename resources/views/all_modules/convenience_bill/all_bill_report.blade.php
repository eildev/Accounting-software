@extends('master')
@section('title', '| Conveyance List')
@section('admin')
<style>
    /* Print Styles */
    @media print {
        /* General Reset */
        * {
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            color: #000;
            margin: 0;
            padding: 20px;
            background: #fff;
        }

        .card, .table {
            box-shadow: none !important;
            border: none !important;
        }
        /* Hide Unnecessary Elements */
        button, a, .dropdown-item, .navbar-content, .search-form, .navbar, #myfooter,.file  {
            display: none !important;
        }

        /* Header and Titles */
        h4, h6 {
            font-weight: bold;
            color: #000;
            margin: 15px 0 10px 0;
        }
        .main-wrapper .page-wrapper .page-content{
            margin-top: 0px;
            padding-top: 0;

        }
        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            box-shadow: none !important; /* Remove any table shadow */
        }
        table, th, td, tr {
            border: 1px solid #000; /* Solid borders for visibility */
            box-shadow: none !important; /* Remove any shadow */
            -webkit-box-shadow: none !important;
        }
        th, td {
            padding: 8px;
            text-align: center;
            vertical-align: middle;
            font-size: 12px;
        }

        /* Table Header */
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        /* Table Alternating Row Colors */
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Avoid Breaking Tables */
        .table-responsive {
            page-break-inside: avoid;
        }

        /* Prevent Elements From Splitting */
        tr, td {
            page-break-inside: avoid;
        },
        tfoot {
        page-break-before: always; /* Forces the footer to appear on a new page */
    }

        /* Page Margins */
        @page {
            margin: 1.5cm;
        }

    }
</style>


    <div class="row">

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card" style="border: none!important;shadow: none    " >
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-title ">View Conveyance Bill Report List</h6>
                        <div>
                        <button class="btn btn-sm btn-primary convenience-print" onclick="window.print()">
                            Print
                        </button>
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
                        <h4  class="mt-3">Movement Bill</h4>
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
                                            @foreach ($movementCost->movementDetails as $key => $detail)
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
                                            <td class="file">
                                                @if ($movementCost->image)
                                                <a class="dropdown-item" href="{{ route('convenience.money.receipt', ['type' => 'movement', 'id' => $movementCost->id]) }}">
                                                    <i class="fa-solid fa-receipt me-2"></i>Receipt
                                                </a>
                                            @endif
                                        </td>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    @if ($foodingCosts->isNotEmpty() && $foodingCosts->some(fn($foodingCost) => $foodingCost->foodingDetails->isNotEmpty()))
                        <h4  class="mt-3">Fooding Bill</h4>
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
                                            @foreach ($foodingCost->foodingDetails as $key =>  $detail)
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
                                            <td class="file">
                                                @if ($foodingCost->image)
                                                <a class="dropdown-item" href="{{ route('convenience.money.receipt', ['type' => 'fooding', 'id' => $foodingCost->id]) }}">
                                                    <i class="fa-solid fa-receipt me-2"></i>Receipt
                                                </a>
                                               @endif
                                        </td>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    @if (
                        $overnightCosts->isNotEmpty() &&
                            $overnightCosts->some(fn($overnightCost) => $overnightCost->overnightDetails->isNotEmpty()))
                        <h4 class="mt-3">Overnight Bill</h4>
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
                                            @foreach ($overnightCost->overnightDetails as $key =>  $detail)
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
                                            <td class="file">
                                                @if ($overnightCost->image)
                                                <a class="dropdown-item" href="{{ route('convenience.money.receipt', ['type' => 'overnight', 'id' => $overnightCost->id]) }}">
                                                    <i class="fa-solid fa-receipt me-2"></i>Receipt
                                                </a>
                                            @endif
                                        </td>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    @if (
                        $otherExpenseCosts->isNotEmpty() &&
                            $otherExpenseCosts->some(fn($otherExpenseCost) => $otherExpenseCost->otherExpensetDetails->isNotEmpty()))
                        <h4  class="mt-3">Other Expense Bill</h4>
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
                                            @foreach ($otherExpenseCost->otherExpensetDetails as $key =>  $detail)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $detail->other_expense_date ?? '' }}</td>
                                                    <td>{{ $detail->other_expense_purpose ?? '' }}</td>
                                                    <td>{{ $detail->other_expense_amount ?? '' }}</td>
                                                    <td>{{ $detail->other_expense_assigned ?? '' }}</td>
                                                </tr>
                                            @endforeach
                                            <td class="file">
                                                @if ($otherExpenseCost->image)
                                                <a class="dropdown-item" href="{{ route('convenience.money.receipt', ['type' => 'other', 'id' => $otherExpenseCost->id]) }}">
                                                    <i class="fa-solid fa-receipt me-2"></i>Receipt
                                                </a>
                                            @endif
                                            </td>

                                        @endif
                                    @endforeach

                                </tbody>
                            </table>
                           <div>
                            <table  style="margin-top:20px; border:none">
                                <tfoot>
                                    <tr >
                                        <td colspan="3" style="text-align: right; font-weight: bold;">Total Amount : </td>
                                        <td style="font-weight: bold;">
                                            {{ $convenienceBill->total_amount ?? '0.00' }}
                                        </td>
                                    </tr>
                                </tfoot>
                                </table>
                           </div>
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
