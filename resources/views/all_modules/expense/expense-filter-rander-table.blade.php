<div class="col-md-12 grid-margin stretch-card">
    <div id="tableContainer" class="table-responsive">
        <table id="example" class="table">
            <thead class="action">
                <tr>
                    <th>SN</th>
                    <th>purpose</th>
                    <th>Amount</th>
                    <th>Spender</th>
                    <th>Bank Account</th>
                    <th>Expense Category</th>
                    <th>Expense Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="showData">

                @if ($expense->count() > 0)
                    @foreach ($expense as $key => $expenses)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $expenses->purpose ?? '' }}</td>
                            <td>{{ $expenses->amount ?? '' }}</td>
                            <td>{{ $expenses->spender ?? '' }}</td>
                            <td>{{ $expenses->bank_account_id ? $expenses->bank->bank_name : $expenses->cash->cash_account_name ?? '' }}
                            </td>
                            <td>{{ $expenses->expenseCat->account_name ?? '' }}</td>
                            <td>{{ $expenses->expense_date->format('d M Y') ?? '' }}</td>
                            <td>
                                @if ($expenses->status == 'purchased')
                                    <span class="badge bg-primary">Paid</span>
                                @else
                                    <span class="badge bg-warning">Proccessing</span>
                                @endif
                            </td>
                            <td>
                                @if (Auth::user()->can('expense.edit'))
                                    <a href="{{ route('expense.edit', $expenses->id) }}" class="btn btn-sm btn-primary "
                                        title="Edit">
                                        Edit
                                    </a>
                                @endif
                                @if (Auth::user()->can('expense.delete'))
                                    <a href="{{ route('expense.delete', $expenses->id) }}" id="delete"
                                        class="btn btn-sm btn-danger " title="Delete">
                                        Delete
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="12">
                            <div class="text-center text-warning mb-2">Data Not Found</div>
                        </td>
                    </tr>
                @endif

            </tbody>
        </table>
    </div>
</div>
<div class="col-md-12 grid-margin stretch-card">
    <div id="tableContainer" class="table-responsive">
        <table id="example" class="table">
            <thead class="action">
                <tr>
                    <th>SN</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>transaction id</th>
                    <th>Group Id</th>
                    <th>Expense Category</th>
                    <th>subledger id</th>
                </tr>
            </thead>
            <tbody>
                {{-- @dd($testData) --}}
                @forelse ($testData as $key => $element)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $element->transaction_date ?? 'null' }}</td>
                        <td>{{ $element->entry_amount ?? 'null' }}</td>
                        <td>{{ $element->transaction_id ?? 'null' }}</td>
                        <td>{{ $element->group_id ?? 'null' }}</td>
                        <td>{{ $element->account_id ?? 'null' }}</td>
                        <td>{{ $element->sub_ledger_id ?? 'null' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12">
                            <div class="text-center text-warning mb-2">Data Not Found</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
