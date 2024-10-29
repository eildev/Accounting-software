<?php

namespace App\Http\Controllers\Bank;

use App\Http\Controllers\Controller;
use App\Models\Bank\Cash;
use App\Models\Branch;
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
            $cash->branch_id = Auth::user()->branch_id;
            $cash->cash_account_name = $request->cash_account_name;
            $cash->opening_balance = $request->opening_balance;
            $cash->current_balance = $request->opening_balance;
            $cash->save();
            return response()->json([
                'status' => 200,
                'message' => 'cash Account Saved Successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => 500,
                "message" => 'An error occurred while fetching Cash accounts.',
                "error" => $e->getMessage()  // Optional: include exception message
            ]);
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

            $total_cash = $cash->count();
            $total_opening_balance = $cash->sum('opening_balance');
            $total_current_balance = $cash->sum('current_balance');


            // Return a successful response with data
            return response()->json([
                "status" => 200,
                "data" => $cash,
                "total_cash" => $total_cash,
                "total_initial_balance" => number_format($total_opening_balance, 2),
                "total_current_balance" => number_format($total_current_balance, 2),
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

    // cash Details 
    public function cashDetails($id)
    {
        try {

            $data = Cash::findOrFail($id);
            $branch = Branch::findOrFail($data->branch_id);
            $isBank = false;
            return view('all_modules.bank.bank-details', compact('data', 'branch', 'isBank'));
        } catch (\Exception $e) {
            // Handle any exceptions that may occur
            Log::error('Cash Details Error: ' . $e->getMessage());

            // Redirect to custom 500 error page
            return response()->view('errors.500', [], 500);
        }
    }
}
