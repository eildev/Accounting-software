<h6 class="card-title text-info">Expense Category </h6>
<div id="tableContainer" class="table-responsive">
    <table class="table">
        <thead class="action">
            <tr>
                <th>SN</th>
                <th>Category name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="showData">
            @if ($expenseCat->count() > 0)
                @foreach ($expenseCat as $key => $expensesCategory)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $expensesCategory->name ?? '-' }}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-primary category_edit" title="Edit"
                                data-bs-toggle="modal"
                                data-bs-target="#exampleModalLongScollable1{{ $expensesCategory->id }}">
                                Edit
                            </a>
                            <a href="{{ route('expense.category.delete', $expensesCategory->id) }}" id="delete"
                                class="btn btn-sm btn-danger " title="Delete">
                                Delete
                            </a>
                        </td>
                    </tr>
                    <div class="modal fade" id="exampleModalLongScollable1{{ $expensesCategory->id }}" tabindex="-1"
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
                                    <form id="signupForm{{ $expensesCategory->id }}" class="categoryFormEdit">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Edit
                                                Expense Category Name</label>
                                            <input id="defaultconfig" class="form-control category_name" maxlength="250"
                                                name="name" type="text" onkeyup="errorRemove(this);"
                                                onblur="errorRemove(this);" value="{{ $expensesCategory->name }}">
                                            <span class="text-danger category_name_error"></span>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary update_expense_category"
                                        data-category-id="{{ $expensesCategory->id }}">Update</button>
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
                            <a href="{{ route('expense.add') }}" class="btn btn-primary">Add Expanse<i
                                    data-feather="plus"></i></a>
                        </div>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
