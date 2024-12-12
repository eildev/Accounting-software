<div class="d-flex justify-content-between align-items-center">
    <h6 class="card-title">Expense Category</h6>
    <button class="btn btn-rounded-primary btn-sm" data-bs-toggle="modal" data-bs-target="#expanseCategoryModal"><i
            data-feather="plus"></i></button>
</div>
<div id="tableContainer" class="table-responsive">
    <table id="dataTableExample" class="table">
        <thead class="action">
            <tr>
                <th>SN</th>
                <th>Category name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="showData">
            @if ($subLedger->count() > 0)
                @foreach ($subLedger as $key => $ledgerAccount)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $ledgerAccount->sub_ledger_name ?? '-' }}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-primary category_edit" title="Edit"
                                data-bs-toggle="modal" data-bs-target="#expanseCatUpModal{{ $ledgerAccount->id }}">
                                Edit
                            </a>
                            {{-- <a href="{{ route('expense.category.delete', $ledgerAccount->id) }}" id="delete"
                                class="btn btn-sm btn-danger " title="Delete">
                                Delete
                            </a> --}}
                        </td>
                    </tr>
                    <div class="modal fade" id="expanseCatUpModal{{ $ledgerAccount->id }}" tabindex="-1"
                        aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalScrollableTitle">Edit Expense
                                        Category</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="btn-close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="signupForm{{ $ledgerAccount->id }}" class="categoryFormEdit">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Edit
                                                Expense Category Name</label>
                                            <input id="defaultconfig" class="form-control category_name" maxlength="250"
                                                name="name" type="text" onkeyup="errorRemove(this);"
                                                onblur="errorRemove(this);"
                                                value="{{ $ledgerAccount->sub_ledger_name }}">
                                            <span class="text-danger category_name_error"></span>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary modal_close"
                                        data-bs-dismiss="modal ">Close</button>
                                    <button type="button" class="btn btn-primary update_expense_category"
                                        data-category-id="{{ $ledgerAccount->id }}">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <tr>
                    <td colspan="12">
                        <div class="text-center text-warning mb-2">Data Not Found</div>
                        <div class="text-center">
                            <button class="btn btn-xs btn-primary" data-bs-toggle="modal"
                                data-bs-target="#expanseCategoryModal">
                                Add Expense Category
                            </button>
                        </div>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
