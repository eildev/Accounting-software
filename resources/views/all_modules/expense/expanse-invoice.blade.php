@extends('master')
@section('title', '| Expanse Invoice')
@section('admin')
    @php
        $branch = App\Models\Branch::findOrFail($expanses->branch_id);
        // $loan = App\Models\Bank\LoanManagement\Loan::findOrFail($loanRepayments->loan_id );
    @endphp

<div class="row justify-content-center">
    <div class="col-md-11">
        <div class="card shadow-lg border-0">
            <!-- Invoice Header -->
            <div class="card-header bg-primary text-white py-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0 fw-bold">EIL<span class="text-warning">POS</span></h3>
                        <p class="mb-0">{{ $branch->name ?? '' }}</p>
                        <p class="mb-0">{{ $branch->address ?? 'N/A' }}</p>
                        <p class="mb-0">Email: {{ $branch->email ?? 'N/A' }}</p>
                        <p>Phone: {{ $branch->phone ?? 'N/A' }}</p>
                    </div>
                    <div class="text-end">
                        <h4 class="fw-bold">EXPENSE INVOICE <br></h4> <h5>{{ 'INV-' . now()->year . '-' . str_pad($expanses->id, 5, '0', STR_PAD_LEFT) }} </h5>
                        <p class="mb-0"><strong>Invoice Date:</strong> {{ $expanses->created_at->format('d M Y') }}</p>
                        <p><strong>Expense Date:</strong> {{ $expanses->expense_date->format('d F Y') ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Invoice Body -->
            <div class="card-body px-5">
                <div class="row">
                    <!-- Left Section -->
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td><strong>Expense Category:</strong></td>
                                <td>{{ $expanses->expenseCat->sub_ledger_name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Purpose:</strong></td>
                                <td>{{ $expanses->purpose ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Amount:</strong></td>
                                <td>{{ number_format($expanses->amount, 2) ?? '0.00' }} ৳</td>
                            </tr>
                        </table>
                    </div>
                    <!-- Right Section -->
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td><strong>Spender:</strong></td>
                                <td>{{ $expanses->spender ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Bank Account:</strong></td>
                                <td>{{ $expanses->bank->bank_name ?? $expanses->cash->cash_account_name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td>
                                    <span class="badge {{ $expanses->status == 'paid' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $expanses->status ?? 'N/A' }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Footer Section -->
            <div class="card-footer bg-light text-end">
                <p class="mb-0 text-dark"><strong>Expense Note:</strong> {{ $expanses->note ?? 'No additional notes' }}</p>                <div class="mt-3">
                    <button class="btn btn-outline-primary" onclick="window.print();">
                        <i class="fa fa-print me-2"></i>Print Invoice
                    </button>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary ms-2">
                        <i class="fa-solid fa-arrow-left me-2"></i>Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Print Styles -->
<style>
    @media print {
        nav, .footer, .btn, .card-footer {
            display: none !important;
        }
        .card {
            box-shadow: none !important;
            border: none !important;
        }
        .card-header, .card-footer {
            background-color: #fff !important;
            color: #000 !important;
        }
    }

    .card {
        border-radius: 10px;
        overflow: hidden;
    }

    .badge {
        font-size: 1rem;
        padding: 0.5em 1em;
    }

    .table td {
        padding: 0.5rem 1rem;
    }
</style>
@endsection
