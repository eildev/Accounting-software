<?php

namespace App\Http\Controllers\Assets;

use App\Http\Controllers\Controller;
use App\Models\Assets\AssetTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class AssetTypesController extends Controller
{

    // asset Type Store Data using store Functions
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:99',
                'depreciation_rate' => 'required|numeric|between:0,99.99',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => '500',
                    'error' => $validator->messages()
                ]);
            }
            // If validation passes, proceed with saving the Cash details
            $assetType = new AssetTypes;
            $assetType->branch_id = Auth::user()->branch_id;
            $assetType->name = $request->name;
            $assetType->depreciation_rate = $request->depreciation_rate;
            $assetType->save();

            return response()->json([
                'status' => 200,
                'message' => 'Asset Type Saved Successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => 500,
                "message" => 'An error occurred while fetching Asset Type.',
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
                $assetTypes = AssetTypes::get();  // Fetch all for admin
            } else {
                $assetTypes = AssetTypes::where('branch_id', Auth::user()->branch_id)
                    ->latest()
                    ->get();
            }

            // Return a successful response with data
            return response()->json([
                "status" => 200,
                "data" => $assetTypes,
            ]);
        } catch (\Exception $e) {
            // Handle any exceptions that may occur
            return response()->json([
                "status" => 500,
                "message" => 'An error occurred while fetching Asset types.',
                "error" => $e->getMessage()  // Optional: include exception message
            ]);
        }
    }
}