@extends('master')
@section('title', '| Asset Management')
@section('admin')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Asset Management</li>
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
            <div class="example w-100">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab"
                            aria-controls="home" aria-selected="true">Asset Managment</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab"
                            aria-controls="profile" aria-selected="false">Asset Type</a>
                    </li>
                </ul>
                <div class="tab-content border border-top-0 p-3" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    @include('all_modules.assets.asset')
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="card">
                            <div class="card-body">
                                @include('all_modules.assets.asset-type')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Asset Modal -->
    <div class="modal fade" id="assetModal" tabindex="-1" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Asset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form class="assetForm row">
                        <input type="hidden" name="new_asset" class="new_asset" value="">
                        <div class="mb-3 col-md-6">
                            <label for="asset_name" class="form-label">Asset Name<span class="text-danger">*</span></label>
                            <input class="form-control asset_name" name="asset_name" type="text"
                                onkeyup="errorRemove(this);">
                            <span class="text-danger asset_name_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="asset_type_id" class="form-label">Asset Type<span
                                    class="text-danger">*</span></label>
                            <select class="form-control asset_type_id" name="asset_type_id" onchange="errorRemove(this);">
                                <option value="">Select Asset Type</option>
                            </select>
                            <span class="text-danger asset_type_id_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="purchase_date" class="form-label">Purchase Date<span
                                    class="text-danger">*</span></label>
                            <div class="input-group flatpickr me-2 mb-2 mb-md-0" id="dashboardDate">
                                <span class="input-group-text input-group-addon bg-transparent border-primary"
                                    data-toggle><i data-feather="calendar" class="text-primary"></i></span>
                                <input type="text" name="purchase_date"
                                    class="form-control bg-transparent border-primary purchase_date"
                                    placeholder="Select date" data-input>
                            </div>
                            <span class="text-danger purchase_date_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Acquisition Cost<span
                                    class="text-danger">*</span></label>
                            <input class="form-control acquisition_cost" name="acquisition_cost" type="number"
                                onkeyup="errorRemove(this);">
                            <span class="text-danger acquisition_cost_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Useful Life<span
                                    class="text-danger">*</span></label>
                            <input class="form-control useful_life" name="useful_life" type="number"
                                onkeyup="errorRemove(this);">
                            <span class="text-danger useful_life_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Salvage Value<span
                                    class="text-danger">*</span></label>
                            <input class="form-control salvage_value" name="salvage_value" type="number"
                                onkeyup="errorRemove(this);">
                            <span class="text-danger salvage_value_error"></span>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="initial_depreciation_date" class="form-label">Initial Depreciation Date<span
                                    class="text-danger">*</span></label>
                            <div class="input-group flatpickr me-2 mb-2 mb-md-0" id="dashboardDate">
                                <span class="input-group-text input-group-addon bg-transparent border-primary"
                                    data-toggle><i data-feather="calendar" class="text-primary"></i></span>
                                <input type="text" name="initial_depreciation_date"
                                    class="form-control bg-transparent border-primary initial_depreciation_date"
                                    placeholder="Select date" data-input>
                            </div>
                            <span class="text-danger initial_depreciation_date_error"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary modal_close" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save_asset">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Asset Type Modal -->
    <div class="modal fade" id="assetTypeModal" tabindex="-1" aria-labelledby="exampleModalScrollableTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Loan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form class="assetTypeForm row">
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Name<span class="text-danger">*</span></label>
                            <input class="form-control name" name="name" type="text" onkeyup="errorRemove(this);">
                            <span class="text-danger name_error"></span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Depreciation Rate<span
                                    class="text-danger">*</span></label>
                            <input class="form-control depreciation_rate" name="depreciation_rate" type="number"
                                onkeyup="errorRemove(this);">
                            <span class="text-danger depreciation_rate_error"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary modal_close" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save_asset_type">Save</button>
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

            // // assetType View Function
            function selectAssetTypeView() {
                $.ajax({
                    url: '/asset-type/view',
                    method: 'GET',
                    success: function(res) {
                        const assetTypes = res.data;
                        if (assetTypes.length > 0) {
                            $('.asset_type_id').html(
                                `<option selected disabled>Select Asset Type</option>`
                            ); // Clear and set default option
                            $.each(assetTypes, function(index, asset) {
                                // console.log(account);
                                $('.asset_type_id').append(
                                    `<option value="${asset.id}">${asset.name ?? ""}</option>`
                                );
                            });

                        } else {
                            $('.asset_type_id').html(
                                `<option selected disabled>No Asset Type Found</option>`
                            ); // Clear and set default option
                        }
                    }
                });
            }
            selectAssetTypeView();


            // save Asset information
            const saveAsset = document.querySelector('.save_asset');
            saveAsset.addEventListener('click', function(e) {
                e.preventDefault();

                let formData = new FormData($('.assetForm')[0]);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/asset/store',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.status == 200) {
                            $('#assetModal').modal('hide');

                            // Check if asset is new
                            if ($('.new_asset').val() === 'new') {
                                // Populate the Payment Modal fields
                                $('#globalPaymentModal #data_id').val(res.data
                                    .asset_id); // assuming res.data contains asset_id
                                $('#globalPaymentModal #payment_balance').val(res.data
                                    .acquisition_cost);
                                $('#globalPaymentModal #purpose').val('Fixed Asset Purchase');
                                $('#globalPaymentModal #transaction_type').val('withdraw');
                                $('#globalPaymentModal #due-amount').text(res.data
                                    .acquisition_cost);
                                // Open the Payment Modal
                                $('#globalPaymentModal').modal('show');

                                $('.assetForm')[0].reset();
                                assetView();
                            } else {
                                $('.assetForm')[0].reset();
                                assetView();
                                toastr.success(res.message);
                            }
                        } else {
                            if (res.error.asset_name) {
                                toastr.error("Something went wrong with your Transaction");
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error(xhr.statusText || 'An unexpected error occurred');
                    }
                });
            })

            // assetType View Function
            function assetView() {
                $.ajax({
                    url: '/asset/view',
                    method: 'GET',
                    success: function(res) {
                        const assets = res.data;
                        $('.asset_data').empty();
                        if ($.fn.DataTable.isDataTable('#assetTable')) {
                            $('#assetTable').DataTable().clear().destroy();
                        }
                        if (assets.length > 0) {
                            $.each(assets, function(index, asset) {
                                const tr = document.createElement('tr');
                                let statusBadge = ''; // Initialize status badge variable

                                // Check loan status and assign the correct badge
                                if (asset.status === 'purchased') {
                                    statusBadge =
                                        '<span class="badge bg-success">Purchased</span>';
                                } else {
                                    statusBadge =
                                        '<span class="badge bg-warning">Purchasing</span>';
                                }
                                tr.innerHTML = `
                                    <td>
                                        ${index+1}
                                    </td>
                                    <td>
                                        <a href="#">
                                            ${asset.asset_name ?? ""}
                                        </a>
                                    </td>
                                    <td>${asset.asset_type.name ?? ""}</td>
                                    <td>${asset.purchase_date ?? ""}</td>
                                    <td>${asset.acquisition_cost ?? ""}</td>
                                    <td>${asset.useful_life ?? ""}</td>
                                    <td>${asset.salvage_value ?? ""}</td>
                                    <td>${statusBadge}</td>
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
                                $('.asset_data').append(tr);
                            });
                        } else {
                            $('.asset_data').html(`
                            <tr>
                                <td>
                                    <div class="text-center text-warning mb-2">Data Not Found</div>
                                    <div class="text-center">
                                        <button class="btn btn-xs btn-primary add-asset-btn" data-asset-type="old" data-bs-toggle="modal" data-bs-target="#assetModal">
                                            Add Old Asset
                                        </button>
                                        <button class="btn btn-xs btn-primary add-asset-btn" data-asset-type="new" data-bs-toggle="modal" data-bs-target="#assetModal">
                                            Add New Asset
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        `);
                        }
                        // Reinitialize DataTable
                        dynamicDataTableFunc('assetTable');
                    }
                });
            }
            assetView();

            // Set new_asset value based on which button is clicked using event delegation
            $(document).on('click', '.add-asset-btn', function() {
                const assetType = $(this).data('asset-type');
                $('.new_asset').val(assetType === 'new' ? 'new' : '');
            });




            // save AssetType information
            const saveAssetType = document.querySelector('.save_asset_type');
            saveAssetType.addEventListener('click', function(e) {
                e.preventDefault();

                let formData = new FormData($('.assetTypeForm')[0]);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/asset-type/store',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.status == 200) {
                            $('#assetTypeModal').modal('hide');
                            $('.assetTypeForm')[0].reset();
                            assetTypeView();
                            selectAssetTypeView();
                            toastr.success(res.message);
                        } else {
                            if (res.error.name) {
                                showError('.name', res.error.name);
                            }
                            if (res.error.depreciation_rate) {
                                showError('.depreciation_rate', res.error.depreciation_rate);
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error(xhr.responseJSON.message ||
                            'An unexpected error occurred');
                    }
                });
            })

            // // assetType View Function
            function assetTypeView() {
                $.ajax({
                    url: '/asset-type/view',
                    method: 'GET',
                    success: function(res) {
                        const assetTypes = res.data;
                        $('.asset_type_data').empty();
                        if ($.fn.DataTable.isDataTable('#assetTypeTable')) {
                            $('#assetTypeTable').DataTable().clear().destroy();
                        }
                        if (assetTypes.length > 0) {
                            $.each(assetTypes, function(index, asset) {
                                const tr = document.createElement('tr');

                                tr.innerHTML = `
                                <td>
                                    ${index+1}
                                </td>
                                <td>
                                    <a href="#">
                                        ${asset.name ?? ""}
                                    </a>
                                </td>
                                <td>${asset.depreciation_rate ?? 0} %</td>
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
                                $('.asset_type_data').append(tr);

                            });
                        } else {
                            $('.asset_type_data').html(`
                        <tr>
                            <td colspan='4'>
                                <div class="text-center text-warning mb-2">Data Not Found</div>
                                <div class="text-center">
                                    <button class="btn btn-xs btn-primary" data-bs-toggle="modal" data-bs-target="#assetTypeModal">Add Asset Type<i data-feather="plus"></i></button>
                                </div>
                            </td>
                        </tr>
                        `);
                        }
                        // Reinitialize DataTable
                        dynamicDataTableFunc('assetTypeTable');
                    }
                });
            }
            assetTypeView();
        }); //


        document.addEventListener("DOMContentLoaded", function() {
            // tab active on the page reload
            // Get the last active tab from localStorage
            let activeTab = localStorage.getItem('activeTab');

            // If there is an active tab stored, activate it
            if (activeTab) {
                let tabElement = document.querySelector(`a[href="${activeTab}"]`);
                if (tabElement) {
                    new bootstrap.Tab(tabElement).show();
                }
            }

            // Store the currently active tab in localStorage
            document.querySelectorAll('.nav-link').forEach(tab => {
                tab.addEventListener('shown.bs.tab', function(event) {
                    let activeTabHref = event.target.getAttribute('href');
                    localStorage.setItem('activeTab', activeTabHref);
                });
            });



            // modal on off
            // Initialize modal with backdrop and keyboard options
            modalShowHide('assetModal');
            modalShowHide('assetTypeModal');
        });
    </script>


@endsection
