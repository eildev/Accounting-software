<?php

namespace App\Http\Controllers\Assets;

use App\Http\Controllers\Controller;
use App\Models\Assets\AssetRevaluation;
use App\Models\Assets\Assets;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class AssetRevaluationController extends Controller
{
    // index function for Asset Revaluation 
    public function index()
    {
        try {
            if (Auth::user()->id == 1) {
                $assets = Assets::latest()->get();  // Fetch all for admin
            } else {
                $assets = Assets::where('branch_id', Auth::user()->branch_id)
                    ->latest()
                    ->get();  // Fetch only for the user's branch
            }
            // Attempt to return the view
            return view('all_modules.assets.asset-revaluations', compact('assets'));
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error loading the Asset Type: ' . $e->getMessage());

            // Optionally return a custom error view or a simple error message
            return response()->view('errors.500', [], 500);
        }
    }


    // Asset Revaluation Data saved using store Functions
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'asset_id' => 'required|integer',
                'revaluation_date' => 'required',
                'revaluation_amount' => 'required|numeric|between:0,999999999999.99',
                'new_book_value' => 'required|numeric|between:0,999999999999.99',
                'reason' => 'required|string|max:250',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => '500',
                    'error' => $validator->messages()
                ]);
            }
            // If validation passes, proceed with saving the Cash details
            $assetRevaluation = new AssetRevaluation;
            $assetRevaluation->branch_id = Auth::user()->branch_id;
            $assetRevaluation->asset_id = $request->asset_id;
            $assetRevaluation->revaluation_date = Carbon::createFromFormat('d-M-Y', $request->revaluation_date)->format('Y-m-d');
            $assetRevaluation->revaluation_amount = $request->revaluation_amount;
            $assetRevaluation->new_book_value = $request->new_book_value;
            $assetRevaluation->reason = $request->reason;
            $assetRevaluation->save();

            return response()->json([
                'status' => 200,
                'message' => 'Asset Revaluation Saved Successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => 500,
                "message" => 'An error occurred while fetching Asset Revaluation.',
                "error" => $e->getMessage()  // Optional: include exception message
            ]);
        }
    }

    // Asset Revaluation Data view Function 
    public function view()
    {
        try {
            // Fetch the AssetTypes based on user type (admin or branch)
            if (Auth::user()->id == 1) {
                $assetRevaluations = AssetRevaluation::with('asset')->get();  // Fetch all for admin
            } else {
                $assetRevaluations = AssetRevaluation::with('asset')->where('branch_id', Auth::user()->branch_id)->latest()->get();
            }

            // Return a successful response with data
            return response()->json([
                "status" => 200,
                "data" => $assetRevaluations,
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
