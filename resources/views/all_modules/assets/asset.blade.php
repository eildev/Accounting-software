<div class="d-flex justify-content-between align-items-center mb-3">
    <h6 class="card-title">Asset Table</h6>
    {{-- <button class="btn btn-rounded-primary btn-sm" data-bs-toggle="modal" data-bs-target="#assetModal"><i
            data-feather="plus"></i></button> --}}
    <div>
        <button class="btn btn-xs btn-primary add-asset-btn" data-asset-type="old" data-bs-toggle="modal"
            data-bs-target="#assetModal">
            Add Old Asset
        </button>
        <button class="btn btn-xs btn-primary add-asset-btn" data-asset-type="new" data-bs-toggle="modal"
            data-bs-target="#assetModal">
            Add New Asset
        </button>
    </div>
</div>
<div class="table-responsive">
    <table id="assetTable" class="table">
        <thead>
            <tr>
                <th>SN</th>
                <th>Asset Name</th>
                <th>Asset Type</th>
                <th>Purchase Date</th>
                <th>Acquisition Cost</th>
                <th>Useful Life</th>
                <th>Salvage Value</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="asset_data">
        </tbody>
    </table>
</div>
