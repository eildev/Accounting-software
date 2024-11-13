@extends('master')
@section('title', '| Asset Revaluation')
@section('admin')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Asset Revaluation</li>
        </ol>
    </nav>
    <style>
        .nav-link:hover,
        .nav-link.active {
            color: #6587ff !important;
        }
    </style>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="card-title">Asset Revaluation Table</h6>
                        <button class="btn btn-rounded-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#assetRevaluationModal"><i data-feather="plus"></i></button>
                    </div>
                    <div id="" class="table-responsive">
                        <table id="assetRevaluationTable" class="table">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Asset Name</th>
                                    <th>Revaluation Date</th>
                                    <th>Revaluation Amount</th>
                                    <th>New Book Value</th>
                                    <th>Reason</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="asset_revaluation_data">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Asset Revaluation Modal -->
    <div class="modal fade" id="assetRevaluationModal" tabindex="-1" aria-labelledby="exampleModalScrollableTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Asset Revaluation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form class="assetRevaluationForm row">
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Select Asset<span class="text-danger">*</span></label>
                            <select class="form-control asset_id" name="asset_id" onchange="errorRemove(this);">
                                @if ($assets->count() > 0)
                                    <option value="" selected disabled>Select Asset</option>
                                    @foreach ($assets as $asset)
                                        <option value="{{ $asset->id }}">{{ $asset->asset_name ?? '' }}</option>
                                    @endforeach
                                @else
                                    <option value="">No Asset Found</option>
                                @endif
                            </select>
                            <span class="text-danger asset_id_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Revaluation Date<span
                                    class="text-danger">*</span></label>
                            <div class="input-group flatpickr me-2 mb-2 mb-md-0" id="dashboardDate">
                                <span class="input-group-text input-group-addon bg-transparent border-primary"
                                    data-toggle><i data-feather="calendar" class="text-primary"></i></span>
                                <input type="text" name="revaluation_date"
                                    class="form-control bg-transparent border-primary revaluation_date"
                                    placeholder="Select date" data-input>
                            </div>
                            <span class="text-danger revaluation_date_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Revaluation Amount<span
                                    class="text-danger">*</span></label>
                            <input class="form-control revaluation_amount" name="revaluation_amount" type="number"
                                onkeyup="errorRemove(this);">
                            <span class="text-danger revaluation_amount_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">New Book Value<span
                                    class="text-danger">*</span></label>
                            <input class="form-control new_book_value" name="new_book_value" type="number"
                                onkeyup="errorRemove(this);" placeholder="0.00">
                            <span class="text-danger new_book_value_error"></span>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="name" class="form-label">Reason</label>
                            <input class="form-control reason" name="reason" type="text" onkeyup="errorRemove(this);">
                            <span class="text-danger reason_error"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary modal_close" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save_asset_revaluation">Save</button>
                </div>
            </div>
        </div>
    </div>




    <script>
        // error remove
        function errorRemove(element) {
            if (element.value != '') {
                $(element).siblings('span').hide();
                $(element).css('border-color', 'green');
            }
        }


        // ready function
        $(document).ready(function() {

            // show error
            function showError(name, message) {
                $(name).css('border-color', 'red'); // Highlight input with red border
                $(name).focus(); // Set focus to the input field
                $(`${name}_error`).show().text(message); // Show error message
            }



            // save Loan information
            const saveAssetRevaluation = document.querySelector('.save_asset_revaluation');
            saveAssetRevaluation.addEventListener('click', function(e) {
                e.preventDefault();

                let formData = new FormData($('.assetRevaluationForm')[0]);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/asset-revaluation/store',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.status == 200) {
                            $('#assetRevaluationModal').modal('hide');
                            $('.assetRevaluationForm')[0].reset();
                            assetRevaluationView();
                            toastr.success(res.message);
                        } else {
                            if (res.error.asset_id) {
                                showError('.asset_id', res.error.asset_id);
                            }
                            if (res.error.revaluation_date) {
                                showError('.revaluation_date', res.error.revaluation_date);
                            }
                            if (res.error.revaluation_amount) {
                                showError('.revaluation_amount', res.error.revaluation_amount);
                            }
                            if (res.error.new_book_value) {
                                showError('.new_book_value', res.error.new_book_value);
                            }
                            if (res.error.reason) {
                                showError('.reason', res.error.reason);
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error(xhr.responseJSON.message ||
                            'An unexpected error occurred');
                    }
                });
            })

            // // Loan Info View Function
            function assetRevaluationView() {
                $.ajax({
                    url: '/asset-revaluation/view',
                    method: 'GET',
                    success: function(res) {
                        // console.log(res);
                        const assetRevaluations = res.data;
                        $('.asset_revaluation_data').empty();
                        if ($.fn.DataTable.isDataTable('#assetRevaluationTable')) {
                            $('#assetRevaluationTable').DataTable().clear().destroy();
                        }
                        if (assetRevaluations.length > 0) {
                            $.each(assetRevaluations, function(index, loan) {
                                const tr = document.createElement('tr');

                                tr.innerHTML = `
                                <td>
                                ${index+1}
                                </td>
                                <td>
                                    <a href="#">
                                        ${loan.asset.asset_name ?? ""}
                                    </a>
                                </td>
                                <td>${loan.revaluation_date ?? ""}</td>
                                <td>${loan.revaluation_amount ?? ""}</td>
                                <td>${loan.new_book_value ?? ""}</td>
                                <td>${loan.reason ?? 0}</td>
                                <td>
                                    <a href="#" class="btn btn-icon btn-xs btn-primary">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="#" class="btn btn-icon btn-xs btn-success">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="#" class="btn btn-icon btn-xs btn-danger">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </td>
                            `;
                                $('.asset_revaluation_data').append(tr);

                            });
                        } else {
                            $('.asset_revaluation_data').html(`
                        <tr>
                            <td colspan='9'>
                                <div class="text-center text-warning mb-2">Data Not Found</div>
                                <div class="text-center">
                                    <button class="btn btn-xs btn-primary" data-bs-toggle="modal" data-bs-target="#assetRevaluationModal">Add Asset Revaluation<i data-feather="plus"></i></button>
                                </div>
                            </td>
                        </tr>
                        `);
                        }
                        // Reinitialize DataTable
                        dynamicDataTableFunc('assetRevaluationTable');
                    }
                });
            }
            assetRevaluationView();

        }); //


        document.addEventListener("DOMContentLoaded", function() {
            modalShowHide('assetRevaluationModal');
        });
    </script>


@endsection
