<div class="row">
    <div class=" col-md-7 col-12 grid-margin primary-color-text stretch-card">
        <div class="card ">
            <div class="card-body secondary-color">
                <div class="d-flex justify-content-between">
                    <h4>Conveyance Cost</h4>
                    <div>
                        <div class="form-group primary-color-text">

                            <select class="form-control primary-color-text" id="conveniencemonthSelect">
                                <option disabled selected class="bg-white"
                                    value="{{ Carbon\Carbon::now()->format('m') }}">
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
                <div class="m-2 mt-3 mb-1  secondary-color">
                    <div class="row ">
                        <div class="col-md-3 col-6 bg-color-white card-border mr-1">
                            <div class="card-body rounded-3" id="transportationClick">
                                <div class="d-flex align-items-center justify-content-between  mb-3">
                                    <span class="primary-color-text"><img
                                            src="{{ asset('uploads/payroll_dashboard/convenience_icon/move.png') }}"
                                            alt="Movement Iocn" height="60px"></span>
                                    {{-- <span class="fs-5 me-2"><i class="fas fa-chevron-right"></i></span> --}}
                                </div>
                                <h6 class="mb-2 ">Movement</h6>
                                <h4 id="movementCost">{{ $data['movementCostSum'] }}</h4>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 bg-color-white  card-border">
                            <div class="card-body rounded-3 " id="overNightClick">
                                <div class="d-flex justify-content-between align-items-center  mb-3">
                                    <span><img src="{{ asset('uploads/payroll_dashboard/convenience_icon/time.png') }}"
                                            alt="Night Iocn" height="60px"></span>
                                    {{-- <span class="fs-5 me-2"><i class="fas fa-chevron-right"></i></span> --}}
                                </div>
                                <h6 class="mb-2 ">Over Night</h6>
                                <h4 id="overNightCost">{{ $data['overNightCostSum'] }}</h4>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 bg-color-white card-border">
                            <div class="card-body  rounded-3 " id="foodClick">
                                <div class="d-flex justify-content-between align-items-center   mb-3">
                                    <span><img src="{{ asset('uploads/payroll_dashboard/convenience_icon/food.png') }}"
                                            alt="Food Iocn" height="60px"></span>
                                    {{-- <span class="fs-5 me-2"><i class="fas fa-chevron-right"></i></span> --}}
                                </div>
                                <h6 class="mb-2">Food</h6>
                                <h4 id="foodingCost">{{ $data['foodingCostSum'] }}</h4>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 bg-color-white card-border">
                            <div class="card-body rounded-3 " id="foodClick">
                                <div class="d-flex justify-content-between align-items-center   mb-3">
                                    <span><img
                                            src="{{ asset('uploads/payroll_dashboard/bonus_icon/bonus-icon-2.png') }}"
                                            alt="Other Iocn" height="60px"></span>
                                    {{-- <span class="fs-5 me-2"><i class="fas fa-chevron-right"></i></span> --}}
                                </div>
                                <h6 class="mb-2"> Other</h6>
                                <h4 id="otherCost">{{ $data['otherCostSum'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <div class=" col-md-5  col-12 primary-color-text">
        <div class="card">
            <div class="card-body secondary-color">
                <div class="d-flex justify-content-between mb-2">
                    <h4 class="color-text-black">Conveyance Payment Status</h4>
                </div>
                <h4 class="mt-4">{{ $data['convenienceDataSum'] }}</h4>
                <span class="">
                    <div class="progress mt-3 bg-white">
                        <div class="progress-bar bg-warning" role="progressbar"
                            style="width: {{ $data['conveniencePercentage']['conveniencePending'] }} ; border-top-left-radius: 20px;
                            border-bottom-left-radius: 20px;"
                            aria-valuenow="{{ $data['conveniencePercentage']['conveniencePending'] }}"
                            aria-valuemin="0" aria-valuemax="100">
                        </div>
                        <div class="progress-bar shape-progress bg-primary" role="progressbar"
                            style="width: {{ $data['conveniencePercentage']['conveniencePrecessing'] }}"
                            aria-valuenow="{{ $data['conveniencePercentage']['conveniencePrecessing'] }}"
                            aria-valuemin="0" aria-valuemax="100">
                        </div>
                        <div class="progress-bar " role="progressbar"
                            style="width: {{ $data['conveniencePercentage']['convenienceUnpaid'] }}; background: #9566F2;"
                            aria-valuenow="{{ $data['conveniencePercentage']['convenienceUnpaid'] }}" aria-valuemin="0"
                            aria-valuemax="100">
                        </div>
                        <div class="progress-bar primary-color" role="progressbar"
                            style="width: {{ $data['conveniencePercentage']['conveniencePaid'] }} "
                            aria-valuenow="{{ $data['conveniencePercentage']['conveniencePaid'] }}" aria-valuemin="0"
                            aria-valuemax="100">
                        </div>
                    </div>
                </span>
                <div class="row mt-4" style="padding-top: =10px;">
                    <div class="col-md-12 d-flex justify-content-between">

                        <div class="fs-5 mt-1 ">
                            <span
                                style="background-color: #FBBC06;padding: 0px 6px 0px 13px;margin-right: 4px;border-radius: 6px;"></span>
                            <span id="pending"> {{ $data['conveniencePercentage']['conveniencePending'] }}</span>
                            <p class="pt-3">Pending</p>

                        </div>
                        <div class="fs-5 mt-1">
                            <span
                                style="    background-color: #6571FF;padding: 0px 6px 0px 13px;margin-right: 4px;border-radius: 6px;"></span>
                            <span id="pending">{{ $data['conveniencePercentage']['conveniencePrecessing'] }}</span>
                            <p class="pt-3">Processing</p>
                        </div>
                        <div class="fs-5 mb-2 mt-1">
                            <span
                                style="    background-color: #9566F2;padding: 0px 6px 0px 13px;margin-right: 4px;border-radius: 6px;"></span>
                            <span id="unpaid">{{ $data['conveniencePercentage']['convenienceUnpaid'] }}</span>
                            <p class="pt-3">Unpaid</p>
                        </div>
                        <div class="fs-5 mt-1">
                            <span
                                style="    background-color: #1E62E4;padding: 0px 6px 0px 13px;margin-right: 4px;border-radius: 6px;"></span>
                            <span id="paid">{{ $data['conveniencePercentage']['conveniencePaid'] }}</span>
                            <p class="pt-3">Successfully Paid</p>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        ////////////Convenience show month ways/////////////
        $('#conveniencemonthSelect').on('change', function() {
            const selectedMonth = $(this).val();
            $.ajax({
                url: '/get-month-convenience-data',
                type: 'GET',
                data: {
                    month: selectedMonth
                },
                success: function(response) {
                    // Update the UI with the dynamic data
                    $('#movementCost').text(response.movementCost);
                    $('#overNightCost').text(response.overNightCost);
                    $('#foodingCost').text(response.foodingCost);
                    $('#otherCost').text(response.otherCost);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        });
    }); //
</script>
