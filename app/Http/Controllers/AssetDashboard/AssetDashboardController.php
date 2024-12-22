<?php

namespace App\Http\Controllers\AssetDashboard;

use App\Http\Controllers\Controller;
use App\Models\Assets\Assets;
use App\Models\Bank\BankAccounts;
use App\Models\Bank\Cash;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;

class AssetDashboardController extends Controller
{
    public function getTopData()
    {
        try {
            // Fetch the AssetTypes based on user type (admin or branch)
            $bank = BankAccounts::sum('current_balance');
            $cash = Cash::sum('current_balance');
            $asset = Assets::sum('acquisition_cost');
            $totalStockValue = Product::with('stockQuantity') // Load stock relationship
                ->get() // Get all products
                ->sum(function ($product) {
                    return $product->cost * $product->stockQuantity->sum('stock_quantity'); // Calculate total stock value for each product
                });
            $receivableAmount = Customer::sum('wallet_balance');
            $openingCapital = BankAccounts::sum('initial_balance') + Cash::sum('opening_balance');



            // Return a successful response with data
            return response()->json([
                "status" => 200,
                "bank" => $bank,
                "cash" => $cash,
                "asset" => $asset,
                "totalStockValue" => $totalStockValue,
                "receivableAmount" => $receivableAmount,
                "openingCapital" => $openingCapital,
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
