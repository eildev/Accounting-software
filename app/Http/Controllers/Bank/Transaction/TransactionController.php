<?php

namespace App\Http\Controllers\Bank\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Bank\BankAccounts;
use App\Models\Bank\Cash;
use App\Models\Bank\Transaction\Transaction;
use App\Models\Investor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    public function transaction()
    {
        try {
            if (Auth::user()->id == 1) {
                $cashAccounts = Cash::all();
                $bankAccounts = BankAccounts::all();
                $investors = Investor::latest()->get();
            } else {
                $cashAccounts = Cash::where('branch_id', Auth::user()->branch_id)->latest()->get();
                $bankAccounts = BankAccounts::where('branch_id', Auth::user()->branch_id)->latest()->get();
                $investors = Investor::where('branch_id', Auth::user()->branch_id)->latest()->get();
            }

            return view('all_modules.transaction.transaction', compact('cashAccounts', 'bankAccounts', 'investors'));
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Transaction Error: ' . $e->getMessage());

            // Optionally, you can flash a message to the session to display it to the user
            return redirect()->back()->with('error', 'Something went wrong while processing the transaction.');

            // Alternatively, you can return a custom error view if required
            // return view('error_page')->with('message', 'Something went wrong!');
        }
    }


    // storeTransaction function 
    public function storeTransaction(Request $request)
    {
        // dd($request->all());
        try {
            $messages = [
                'payment_account_id.required' => 'The payment account is required.',
                'payment_account_id.integer' => 'The payment account must be an integer.',
                'transaction_type.required' => 'Something Went Wrong',
                'transaction_type.in' => 'Something Went Wrong. Someone pass The wrong Value',
                'description' => 'Note field must be a maximum of 99 characters long.',
            ];

            $validator = Validator::make($request->all(), [
                'account_type' => 'required',
                'payment_account_id' => 'required|integer',
                'transaction_date' => 'required|date',
                'amount' => 'required|numeric|between:0,999999999999.99',
                'transaction_type' => 'required|in:deposit,withdrawal',
                'description' => 'max:99',
            ], $messages);

            if ($validator->fails()) {
                return response()->json([
                    'status' => '500',
                    'error' => $validator->messages()
                ]);
            }

            // If validation passes, proceed with saving the Cash details
            $transaction = new Transaction;
            $transaction->branch_id = Auth::user()->branch_id;
            if ($request->account_type > 'cash') {
                $transaction->cash_account_id = $request->payment_account_id;
            } else {
                $transaction->bank_account_id = $request->payment_account_id;
            }
            $transaction->amount = $request->amount;
            if ($request->transaction_type == 'withdrawal') {
                $transaction->transaction_type = 'debit';
            } else {
                $transaction->transaction_type = 'credit';
            }
            $transaction->description = $request->description;
            $transaction->transaction_id = $request->description;
            $transaction->transaction_by = Auth::user()->id;
            $transaction->save();
            return response()->json([
                'status' => 200,
                'message' => 'Transaction Saved Successfully',
            ]);
        } catch (\Exception $e) {
        }
    } //

    // checkAccountType function 
    public function checkAccountType(Request $request)
    {
        try {
            $paymentType = $request->payment_type;

            if ($paymentType == 'cash') {
                if (Auth::user()->id == 1) {
                    $data = Cash::get();  // Fetch all for admin
                } else {
                    $data = Cash::where('branch_id', Auth::user()->branch_id)
                        ->latest()
                        ->get();  // Fetch only for the user's branch
                }
            } else if ($paymentType == 'bank') {
                if (Auth::user()->id == 1) {
                    $data = BankAccounts::get();  // Fetch all for admin
                } else {
                    $data = BankAccounts::where('branch_id', Auth::user()->branch_id)
                        ->latest()
                        ->get();  // Fetch only for the user's branch
                }
            }

            return response()->json([
                'status' => 200,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => 500,
                "message" => 'An error occurred while fetching bank accounts.',
                "error" => $e->getMessage()  // Optional: include exception message
            ]);
        }
    } //
}
