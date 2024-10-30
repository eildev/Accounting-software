<?php

namespace App\Http\Controllers\Bank\LoanManagement;

use App\Http\Controllers\Controller;
use App\Models\Bank\BankAccounts;
use App\Models\Bank\Cash;
use App\Models\Bank\LoanManagement\Loan;
use App\Models\Bank\LoanManagement\LoanRepayments;
use App\Models\Bank\Transaction\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class LoanRepaymentsController extends Controller
{
    public function store(Request $request)
    {
        try {
            // dd($request->all());
            $messages = [
                'data_id.required' => 'Something Went Wrong Data not found.',
                'data_id.integer' => 'Something Went Wrong. Someone pass The wrong Value',
                'payment_account_id.required' => 'The Payment Account is required.',
                'payment_account_id.integer' => 'Someone pass The wrong Value',
                'payment_balance.required' => 'Someone pass The wrong Value. required',
                'payment_balance.numeric' => 'Someone pass The wrong Value. numeric',
                'payment_balance.between' => 'Someone pass The wrong Value. between',
            ];
            $validator = Validator::make($request->all(), [
                'data_id' => 'required|integer',
                'account_type' => 'required|in:bank,cash',
                'payment_account_id' => 'required|integer',
                'repayment_date' => 'required',
                'payment_balance' => 'required|numeric|between:0,999999999999.99',
            ], $messages);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 500,
                    'error' => $validator->messages()
                ]);
            }

            if ($request->account_type == 'bank') {
                $account_balance =  BankAccounts::findOrFail($request->payment_account_id);
            } else {
                $account_balance =  Cash::findOrFail($request->payment_account_id);
            }

            if ($account_balance->current_balance > 0 && $account_balance->current_balance >= $request->payment_balance) {
                // loan repayments
                $loan_repayments = new LoanRepayments;
                $loan_repayments->branch_id =  Auth::user()->branch_id;
                $loan_repayments->loan_id =  $request->data_id;
                $loan_repayments->repayment_date =  date('Y-m-d', strtotime($request->repayment_date));
                $loan = Loan::findOrFail($request->data_id);
                $loan_principal = $loan->loan_principal;
                $loan_interest = $loan->loan_balance - $loan->loan_principal;
                if ($loan->repayment_schedule == 'daily') {
                    $total_duration = $loan->loan_duration * 365;
                } else if ($loan->repayment_schedule == 'weekly') {
                    $total_duration = $loan->loan_duration * 52;
                } else if ($loan->repayment_schedule == 'monthly') {
                    $total_duration = $loan->loan_duration * 12;
                } else {
                    $total_duration = $loan->loan_duration * 1;
                }
                $loan_repayments->principal_paid =  $loan_principal / $total_duration;
                $loan_repayments->interest_paid =  $loan_interest / $total_duration;
                $loan_repayments->total_paid =  $request->payment_balance;
                if ($request->account_type == 'bank') {
                    $loan_repayments->bank_account_id =  $request->payment_account_id;
                } else {
                    $loan_repayments->cash_account_id =  $request->payment_account_id;
                }
                $loan_repayments->save();


                // // Transaction 
                // $transaction = new Transaction;
                // $transaction->branch_id = Auth::user()->branch_id;
                // $transaction->source_id = Auth::user()->branch_id;
                // $transaction->source_type = Auth::user()->branch_id;
                // $transaction->transaction_date = Auth::user()->branch_id;
                // if ($request->account_type > 'bank') {
                //     $transaction->cash_account_id = $request->payment_account_id;
                // } else {
                //     $transaction->bank_account_id = $request->payment_account_id;
                // }
                // $transaction->amount = $payment_balance;
                // $transaction->transaction_type = 'debit';
                // $transaction->transaction_id = 
                // $transaction->transaction_by = Auth::user()->id;
                // $transaction->save();
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Your account Balance is low Please Select Another account or Add Balance on your Account',
                ]);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Successfully processed payment.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => 500,
                "message" => 'An error occurred while loan repayments.',
                "error" => $e->getMessage()  // Optional: include exception message
            ]);
        }
    }
}
