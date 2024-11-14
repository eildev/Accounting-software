<?php

namespace App\Http\Controllers\Assets;

use App\Http\Controllers\Controller;
use App\Models\Assets\AssetDepreciation;
use App\Models\Assets\Assets;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class AssetController extends Controller
{
    public function index()
    {
        try {
            // Attempt to return the view
            return view('all_modules.assets.index');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error loading the Asset Type: ' . $e->getMessage());

            // Optionally return a custom error view or a simple error message
            return response()->view('errors.500', [], 500);
        }
    }

    // asset Type Store Data using store Functions
    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $validator = Validator::make($request->all(), [
                'asset_name' => 'required|max:99',
                'asset_type_id' => 'required|integer',
                'purchase_date' => 'required',
                'acquisition_cost' => 'required|numeric|between:0,999999999999.99',
                'useful_life' => 'required|integer|',
                'salvage_value' => 'required|numeric|between:0,999999999999.99',
                'initial_depreciation_date' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => '500',
                    'error' => $validator->messages()
                ]);
            }
            // If validation passes, proceed with saving the Cash details
            $asset = new Assets;
            $asset->branch_id = Auth::user()->branch_id;
            $asset->asset_name = $request->asset_name;
            $asset->asset_type_id = $request->asset_type_id;
            $asset->purchase_date = Carbon::createFromFormat('d-M-Y', $request->purchase_date)->format('Y-m-d');
            $asset->acquisition_cost = $request->acquisition_cost;
            $asset->useful_life = $request->useful_life;
            $asset->salvage_value = $request->salvage_value;
            $asset->initial_depreciation_date = Carbon::createFromFormat('d-M-Y', $request->initial_depreciation_date)->format('Y-m-d');
            if ($request->new_asset == null) {
                $asset->status = 'purchased';
            }
            $asset->save();

            return response()->json([
                'status' => 200,
                'message' => 'Asset Saved Successfully',
                'data' => [
                    'asset_id' => $asset->id, // Retrieve actual saved asset id
                    'acquisition_cost' => $asset->acquisition_cost
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => 500,
                "message" => 'An error occurred while fetching Asset',
                "error" => $e->getMessage()  // Optional: include exception message
            ]);
        }
    }


    // Asset Type view Function 
    public function view()
    {
        try {
            // Fetch the AssetTypes based on user type (admin or branch)
            if (Auth::user()->id == 1) {
                $assets = Assets::with('assetType')->get();  // Fetch all for admin
            } else {
                $assets = Assets::with('assetType')->where('branch_id', Auth::user()->branch_id)->latest()->get();
            }

            // Return a successful response with data
            return response()->json([
                "status" => 200,
                "data" => $assets,
            ]);
        } catch (\Exception $e) {
            // Handle any exceptions that may occur
            return response()->json([
                "status" => 500,
                "message" => 'An error occurred while fetching Asset ',
                "error" => $e->getMessage()  // Optional: include exception message
            ]);
        }
    }
}
