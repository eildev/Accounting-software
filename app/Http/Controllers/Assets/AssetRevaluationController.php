<?php

namespace App\Http\Controllers\Assets;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class AssetRevaluationController extends Controller
{
    // index function for Asset Revaluation 
    public function index()
    {
        try {
            // Attempt to return the view
            return view('all_modules.assets.asset-revaluations');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error loading the Asset Type: ' . $e->getMessage());

            // Optionally return a custom error view or a simple error message
            return response()->view('errors.500', [], 500);
        }
    }
}
