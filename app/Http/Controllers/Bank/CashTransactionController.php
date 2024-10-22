<?php

namespace App\Http\Controllers\Bank;

use App\Http\Controllers\Controller;
use App\Models\Bank\Cash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class CashTransactionController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validate the incoming request
            $validator = Validator::make($request->all(), [
                'cash_account_name' => 'required|max:99',
                'opening_balance' => 'required|numeric|between:0,999999999999.99',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => '500',
                    'error' => $validator->messages()
                ]);
            }

            // If validation passes, proceed with saving the Cash details
            $cash = new Cash;
            $cash->cash_account_name = $request->cash_account_name;
            $cash->opening_balance = $request->opening_balance;
            $cash->current_balance = $request->opening_balance;
            $cash->save();
            return response()->json([
                'status' => 200,
                'message' => 'cash Account Saved Successfully',
            ]);
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Error to saving cash details: ' . $e->getMessage());

            // Return the errors.500 view for internal server errors
            return response()->view('errors.500', [], 500);
        }
    }


    // view function 
    public function view()
    {
        try {
            // Fetch the bank accounts based on user type (admin or branch)
            if (Auth::user()->id == 1) {
                $cash = Cash::get();  // Fetch all for admin
            } else {
                $cash = Cash::where('branch_id', Auth::user()->branch_id)
                    ->latest()
                    ->get();  // Fetch only for the user's branch
            }

            // Return a successful response with data
            return response()->json([
                "status" => 200,
                "data" => $cash
            ]);
        } catch (\Exception $e) {
            // Handle any exceptions that may occur
            return response()->json([
                "status" => 500,
                "message" => 'An error occurred while fetching bank accounts.',
                "error" => $e->getMessage()  // Optional: include exception message
            ]);
        }
    }
}
