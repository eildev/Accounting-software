<h6 class="card-title text-info">Add Expanse</h6>
<form id="myValidForm" class="expanseForm" method="post" enctype="multipart/form-data">
    <div class="row">
        <!-- Col -->
        <div class="col-md-4">
            <div class="mb-3 form-valid-groups">
                <label class="form-label">Purpose<span class="text-danger">*</span></label>
                <input type="text" name="purpose" class="form-control purpose" placeholder="Enter purpose">
                <span class="text-danger purpose_error"></span>
            </div>
        </div><!-- Col -->
        <div class="col-md-4">
            <div class="mb-3 form-valid-groups">
                <label class="form-label">Amount<span class="text-danger">*</span></label>
                <input type="number" name="amount" class="form-control amount" placeholder="Enter Amount">
                <span class="text-danger amount_error"></span>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="mb-3 form-valid-groups">
                <label class="form-label">Splender<span class="text-danger">*</span></label>
                <input type="text" name="spender" class="form-control spender" placeholder="Enter Splender">
                <span class="text-danger spender_error"></span>
            </div>
        </div><!-- Col -->
        <div class="col-sm-6 form-valid-group">
            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-3" bis_skin_checked="1">
                        <label for="ageSelect" class="form-label">Select Expense
                            Category <span class="text-danger">*</span></label>
                        <select
                            class="form-select expense_category_name is-valid js-example-basic-single expense_category_id"
                            name="expense_category_id" aria-invalid="false">
                            <option selected="" disabled="">Select Expense
                                Category </option>
                            @foreach ($subLedger as $expanse)
                                <option value="{{ $expanse->id }}">
                                    {{ $expanse->sub_ledger_name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger expense_category_id_error"></span>
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


        <div class="col-sm-6">
            <div class="mb-3 form-valid-groups">
                <label class="form-label">Date<span class="text-danger">*</span></label>
                <div class="input-group flatpickr" id="flatpickr-date">
                    <input type="text"name="expense_date" class="form-control  flatpickr-input expense_date"
                        data-input="" readonly="readonly" placeholder="Select Expense Date">
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
                <span class="text-danger expense_date_error"></span>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="mb-3 form-valid-groups">
                <label class="form-label">Expense Image</label>
                <input type="file" name="image" class="form-control image" />
                <span class="text-danger image_error"></span>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="mb-3 form-valid-groups">
                <label class="form-label">Note</label>
                <textarea name="note" class="form-control note" id="" cols="10" rows="2"></textarea>
                <span class="text-danger note_error"></span>
            </div>
        </div>
    </div><!-- Row -->
    <div>
        <button type="submit" class="btn btn-primary save_expanse">Save</button>
        <button type="submit" class="btn btn-primary save_expanse_checkout">Checkout</button>
    </div>
</form>
