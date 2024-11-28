<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h6 class="card-title">Money Flow</h6>
            <div class="d-flex justify-content-between">
                <div class="form-group primary-color-text mb-2">
                    <select class="form-control primary-color-text" id="moneyFlowMonthSelect">
                        <option disabled selected class="bg-white" value="{{ Carbon\Carbon::now()->format('m') }}">
                            <p class="selected-option">Month</p>
                            <i class="fas fa-chevron-down"></i>
                        </option>
                        <option value="1" data-month="1">January</option>
                        <option value="2" data-month="2">February</option>
                        <option value="3" data-month="3">March</option>
                        <option value="4" data-month="4">April</option>
                        <option value="5" data-month="5">May</option>
                        <option value="6" data-month="6">June</option>
                        <option value="7" data-month="7">July</option>
                        <option value="8" data-month="8">August</option>
                        <option value="9" data-month="9">September</option>
                        <option value="10" data-month="10">October</option>
                        <option value="11" data-month="11">November</option>
                        <option value="12" data-month="12">December</option>
                    </select>
                </div>

            </div>
        </div>
        <div id="apexArea"></div>
    </div>
</div>
