<?php

namespace App\Http\Controllers\Bank;

use App\Http\Controllers\Controller;
use App\Models\Bank\BankAccounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class BankAccountsController extends Controller
{
    // index function 
    public function index()
    {
        try {
            // Attempt to return the view
            return view('all_modules.bank.bank');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error loading the bank view: ' . $e->getMessage());

            // Optionally return a custom error view or a simple error message
            return response()->view('errors.custom', [], 500);
        }
    }


    public function store(Request $request)
    {
        try {
            // Validate the incoming request
            $validator = Validator::make($request->all(), [
                'account_name' => 'max:99',
                'account_number' => 'required|max:49',
                'bank_name' => 'required|max:99',
                'bank_branch_name' => 'max:99',
                'initial_balance' => 'numeric|between:0,999999999999.99',
                'currency_code' => 'max:3',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => '500',
                    'error' => $validator->messages()
                ]);
            }

            // If validation passes, proceed with saving the bank details
            $bank = new BankAccounts;
            $bank->branch_id = Auth::user()->branch_id;
            $bank->account_name = $request->account_name;
            $bank->account_number = $request->account_number;
            $bank->bank_name = $request->bank_name;
            $bank->bank_branch_name = $request->bank_branch_name;
            $bank->initial_balance = $request->initial_balance;
            $bank->current_balance = $request->initial_balance;
            $bank->currency_code = $request->currency_code;
            $bank->save();
            return response()->json([
                'status' => 200,
                'message' => 'Bank Account Saved Successfully',
            ]);
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Error to saving bank details: ' . $e->getMessage());

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
                $banks = BankAccounts::get();  // Fetch all for admin
            } else {
                $banks = BankAccounts::where('branch_id', Auth::user()->branch_id)
                    ->latest()
                    ->get();  // Fetch only for the user's branch
            }

            // Return a successful response with data
            return response()->json([
                "status" => 200,
                "data" => $banks
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
