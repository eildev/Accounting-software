<?php

namespace App\Http\Controllers\Bank\LoanManagment;

use App\Http\Controllers\Controller;
use App\Models\Bank\BankAccounts;
use App\Models\Bank\LoanManagment\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class LoanController extends Controller
{
    // index function 
    public function index()
    {
        try {
            if (Auth::user()->id == 1) {
                $banks = BankAccounts::get();  // Fetch all for admin
            } else {
                $banks = BankAccounts::where('branch_id', Auth::user()->branch_id)
                    ->latest()
                    ->get();  // Fetch only for the user's branch
            }
            // Attempt to return the view
            return view('all_modules.bank.loan.loan-management', compact('banks'));
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error loading the Loan view: ' . $e->getMessage());

            // Optionally return a custom error view or a simple error message
            return response()->view('errors.custom', [], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $messages = [
                'bank_loan_account_id.required' => 'The Loan account is required.',
                'bank_loan_account_id.integer' => 'The Loan account must be an integer.',
                'loan_principal.required' => 'The Loan Amount is required.',
                'loan_principal.numeric' => 'The Loan Amount must be a valid number.',
                'loan_principal.between' => 'The Loan Amount must be between 0 and 999999999999.99.',
            ];

            $validator = Validator::make($request->all(), [
                'bank_loan_account_id' => 'required|integer',
                'loan_principal' => 'required|numeric|between:0,999999999999.99',
                'interest_rate' => 'required|numeric|between:0,99.99',
                'repayment_schedule' => 'required|in:yearly,monthly,weekly,daily',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
            ], $messages);

            if ($validator->fails()) {
                return response()->json([
                    'status' => '500',
                    'error' => $validator->messages()
                ]);
            }

            // If validation passes, proceed with saving the Cash details
            $loan = new Loan;
            $loan->branch_id = Auth::user()->branch_id;
            $loan->bank_loan_account_id = $request->bank_loan_account_id;
            $loan->loan_principal = $request->loan_principal;
            $loan->interest_rate = $request->interest_rate;
            $loan->repayment_schedule = $request->repayment_schedule;
            $loan->start_date = $request->start_date;
            $loan->end_date = $request->end_date;
            $loan->status = 'active';
            $loan->save();
            return response()->json([
                'status' => 200,
                'message' => 'loan Saved Successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => 500,
                "message" => 'An error occurred while fetching Loan loan.',
                "error" => $e->getMessage()  // Optional: include exception message
            ]);
        }
    }

    // view function 
    public function view()
    {
        try {
            if (Auth::user()->id == 1) {
                $data = Loan::latest()->get();
            } else {
                $data = Loan::where('branch_id', Auth::user()->branch_id)
                    ->latest()
                    ->get();  // Fetch only for the user's branch
            }
            return response()->json([
                'status' => 200,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => 500,
                "message" => 'An error occurred while fetching Loans.',
                "error" => $e->getMessage()  // Optional: include exception message
            ]);
        }
    }
}
