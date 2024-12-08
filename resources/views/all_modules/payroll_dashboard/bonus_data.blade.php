<div class="row">
    <div class="col-12 col-md-7 mb-5 grid-margin primary-color-text stretch-card">
        <div class="card pb-4" style="padding: 7px">
            <div class="card-body secondary-color">
                <div class="d-flex justify-content-between">
                    <h4>All Bonus</h4>
                    <div>
                        <div class="form-group primary-color-text">

                            <select class="form-control primary-color-text" id="monthSelect">
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
                <div class="d-flex gap-2 justify-content-around mt-3 mb-1 secondary-color">
                    <div class="card-body rounded-3 primary-color " id="festivalClick">
                        <div class="d-flex align-items-center justify-content-between  mb-3">
                            <span class="primary-color-text"><img
                                    src="{{ asset('uploads/payroll_dashboard/bonus_icon/Group000003486.png') }}"
                                    alt="Bonus Iocn" height="60px"></span>
                            <span class="fs-5 me-2"><i class="fas fa-chevron-right"></i></span>
                        </div>
                        <h6 class="mb-2 ">Festival Bonus</h6>
                        <h4 id="festivalBonus">{{ $data['festivalBonusesSum'] }}</h4>
                    </div>

                    <div class="card-body rounded-3 bg-color-white  " id="performanceClick">
                        <div class="d-flex justify-content-between align-items-center  mb-3">
                            <span><img src="{{ asset('uploads/payroll_dashboard/bonus_icon/performance.png') }}"
                                    alt="Bonus Iocn" height="60px"></span>
                            <span class="fs-5 me-2"><i class="fas fa-chevron-right"></i></span>
                        </div>
                        <h6 class="mb-2 ">Performance Bonus</h6>
                        <h4 id="performanceBonus">{{ $data['performanceBonusesSum'] }}</h4>
                    </div>

                    <div class="card-body bg-color-white rounded-3 " id="otherClick">
                        <div class="d-flex justify-content-between align-items-center   mb-3">
                            <span><img src="{{ asset('uploads/payroll_dashboard/bonus_icon/bonus-icon-2.png') }}"
                                    alt="Bonus Iocn" height="60px"></span>
                            <span class="fs-5 me-2"><i class="fas fa-chevron-right"></i></span>
                        </div>
                        <h6 class="mb-2 ">Other Bonus</h6>
                        <h4 id="otherBonus">{{ $data['otherBonusesSum'] }}</h4>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-5 col-lg-5 primary-color-text">
        <div class="card">
            <div class="card-body secondary-color">
                <div class="d-flex justify-content-between ">
                    <h4 id="nameSelected">Festival Bonus</h4>
                </div>
                <div class="row mt-3">
                    {{-- <div class="col-md-4 col-lg-4 text-lign-center">
                                    <span>
                                        <div class="card">
                                            <div class="card-body">
                                                <div id="apexDonut"></div>
                                            </div>
                                        </div>
                                    </span>
                                </div> --}}
                    <div class="col-md-12 col-lg-12 px-4">
                        <div class="d-flex fs-5 mb-2 justify-content-between">
                            <span>Successfully Paid</span>
                            <span id="paid">{{ $data['result']['Paid'] }}</span>
                        </div>
                        <div class="d-flex fs-5 mb-2 justify-content-between">
                            <span>Processing</span>
                            <span id="processing">{{ $data['result']['Processing'] }}</span>
                        </div>
                        <div class="d-flex fs-5 mb-2 justify-content-between">
                            <span>Pending</span>
                            <span id="pending">{{ $data['result']['Pending'] }}</span>
                        </div>
                        <div class="d-flex fs-5 mb-2 justify-content-between">
                            <span>Unpaid</span>
                            <span id="unpaid">{{ $data['result']['Unpaid'] }}</span>
                        </div>
                    </div>
                </div>
                <hr>
                <div class=" rounded-1 text-center border-1">
                    <a href="{{ route('employee.bonus') }}" class="text-white"> <button
                            class="btn primary-color px-6">See Other Bonus</button></a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        ////////////Bonus show month ways/////////////
        $('#monthSelect').on('change', function() {
            const selectedMonth = $(this).val();
            $.ajax({
                url: '/get-month-bonus-data',
                type: 'GET',
                data: {
                    month: selectedMonth
                },
                success: function(response) {
                    // Update the UI with the dynamic data
                    $('#festivalBonus').text(response.festivalBonusesSum);
                    $('#performanceBonus').text(response.performanceBonusesSum);
                    $('#otherBonus').text(response.otherBonusesSum);
                    $('#inputFativalId').val(response.month);

                    console.log(response.month)
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        });
        // dynamic bonus change
        $('#festivalClick').on('click', function() {
            const month = document.getElementById('monthSelect').value;

            $.ajax({
                url: '/get-festival-percentage-data',
                type: 'GET',
                data: {
                    month: month
                },
                success: function(response) {
                    $('#paid').text(response.result.Paid);
                    $('#pending').text(response.result.Pending);
                    $('#unpaid').text(response.result.Unpaid);
                    $('#processing').text(response.result.Processing);
                    $('#nameSelected').text("Festival Bonus");
                    $('#festivalClick').addClass('primary-color').removeClass(
                        'bg-color-white');
                    $('#performanceClick').removeClass('primary-color').addClass(
                        'bg-color-white');
                    $('#otherClick').removeClass('primary-color').addClass(
                        'bg-color-white');
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        });
        $('#performanceClick').on('click', function() {
            const month = document.getElementById('monthSelect').value;
            $.ajax({
                url: '/get-performance-percentage-data',
                type: 'GET',
                data: {
                    month: month
                },
                success: function(response) {
                    $('#paid').text(response.result.Paid);
                    $('#pending').text(response.result.Pending);
                    $('#unpaid').text(response.result.Unpaid);
                    $('#processing').text(response.result.Processing);
                    $('#nameSelected').text("Performance Bonus");
                    $('#performanceClick').addClass('primary-color').removeClass(
                        'bg-color-white');
                    $('#festivalClick').removeClass('primary-color').addClass(
                        'bg-color-white');
                    $('#otherClick').removeClass('primary-color').addClass(
                        'bg-color-white');
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        });
        $('#otherClick').on('click', function() {
            const month = document.getElementById('monthSelect').value;
            $.ajax({
                url: '/get-other-percentage-data',
                type: 'GET',
                data: {
                    month: month
                },
                success: function(response) {
                    $('#paid').text(response.result.Paid);
                    $('#pending').text(response.result.Pending);
                    $('#unpaid').text(response.result.Unpaid);
                    $('#processing').text(response.result.Processing);
                    $('#nameSelected').text("Other Bonus");
                    $('#festivalClick').removeClass('primary-color').addClass(
                        'bg-color-white');
                    $('#performanceClick').removeClass('primary-color').addClass(
                        'bg-color-white');
                    $('#otherClick').addClass('primary-color').removeClass(
                        'bg-color-white');
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        });
    });
</script>
