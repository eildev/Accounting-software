<h6 class="card-title text-info">Add Expanse</h6>
<form id="myValidForm" action="{{ route('expense.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <!-- Col -->
        <div class="col-sm-3">
            <div class="mb-3 form-valid-groups">
                <label class="form-label">Purpose<span class="text-danger">*</span></label>
                <input type="text" name="purpose"
                    class="form-control field_required  @error('purpose') is-invalid @enderror"
                    placeholder="Enter purpose" value="{{ old('purpose') }}">
            </div>
            @error('purpose')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div><!-- Col -->
        <div class="col-sm-3">
            <div class="mb-3 form-valid-groups">
                <label class="form-label">Amount<span class="text-danger">*</span></label>
                <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror"
                    placeholder="Enter Amount" value="{{ old('amount') }}">
            </div>
            @error('amount')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-sm-6 form-valid-group">
            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-3" bis_skin_checked="1">
                        <label for="ageSelect" class="form-label">Select Expense
                            Category <span class="text-danger">*</span></label>
                        <select
                            class="form-select expense_category_name is-valid js-example-basic-single @error('expense_category_id') is-invalid @enderror"
                            name="expense_category_id" aria-invalid="false">
                            <option selected="" disabled="">Select Expense
                                Category </option>
                            @foreach ($ledgerAccounts as $expanse)
                                <option value="{{ $expanse->id }}">
                                    {{ $expanse->account_name }}</option>
                            @endforeach
                        </select>
                        @error('expense_category_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div>
                        <label for="ageSelect" class="form-label">Add Expense
                            Category </label>
                        <a href="" class="btn btn-sm bg-primary" data-bs-toggle="modal"
                            data-bs-target="#expanseCategoryModal">
                            Expense Category</a>
                    </div>
                </div>
            </div>
        </div><!-- Col -->
        <div class="col-sm-3">
            <div class="mb-3 form-valid-groups">
                <label class="form-label">Splender<span class="text-danger">*</span></label>
                <input type="text" name="spender" class="form-control @error('spender') is-invalid @enderror"
                    value="{{ old('spender') }}" placeholder="Enter Splender">
            </div>
            @error('spender')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div><!-- Col -->

        <div class="col-sm-3">
            <div class="mb-3 form-valid-groups">
                <label class="form-label">Date<span class="text-danger">*</span></label>
                <div class="input-group flatpickr" id="flatpickr-date">
                    <input type="text"name="expense_date"
                        class="form-control @error('expense_date') is-invalid @enderror flatpickr-input" data-input=""
                        readonly="readonly" placeholder="Select Expense Date">
                    <span class="input-group-text input-group-addon" data-toggle="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-calendar">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2">
                            </rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </span>
                </div>
            </div>
            @error('expense_date')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-sm-3">
            <div class="mb-3" bis_skin_checked="1">
                <label for="ageSelect" class="form-label">Account Type<span class="text-danger">*</span></label>
                <select class="form-select is-valid @error('account_type') is-invalid @enderror"data-width="100%"
                    name="account_type" aria-invalid="false" onchange="checkPaymentAccount(this);">
                    <option value="">Select Account Type</option>
                    <option value="cash">Cash</option>
                    <option value="bank">Bank</option>
                </select>
                @error('account_type')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <span class="text-danger related_sign_error"></span>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="mb-3" bis_skin_checked="1">
                <label for="ageSelect" class="form-label">Payment
                    Account<span class="text-danger">*</span></label>
                <select
                    class="form-select bank_id is-valid @error('bank_account_id') is-invalid @enderror js-example-basic-single"data-width="100%"
                    name="bank_account_id" aria-invalid="false">
                    <option value="">Select Payment Account</option>
                </select>
                @error('bank_account_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <span class="text-danger related_sign_error"></span>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Expense Image</h6>
                    <p class="mb-3 text-warning">Note: <span class="fst-italic">Image not
                            required.</span></p>
                    <input type="file" name="image" id="myDropify" />
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="mb-3 form-valid-groups">
                <label class="form-label">Note</label>
                <textarea name="note" class="form-control" id="" cols="10" rows="5"></textarea>
            </div>
        </div>
    </div><!-- Row -->
    <div>
        <input type="submit" class="btn btn-primary submit" value="Save">
    </div>
</form>
