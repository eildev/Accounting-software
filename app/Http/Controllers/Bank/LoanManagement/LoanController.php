<?php

namespace App\Http\Controllers\Bank\LoanManagement;

use App\Http\Controllers\Controller;
use App\Models\Bank\BankAccounts;
use App\Models\Bank\LoanManagement\Loan;
use App\Models\Bank\LoanManagement\LoanRepayments;
use App\Models\Bank\Transaction\Transaction;
use App\Models\Branch;
use App\Models\Ledger\LedgerAccounts\LedgerEntries;
use App\Models\Ledger\SubLedger\SubLedger;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
                'loan_name' => 'required|max:99',
                'loan_duration' => 'required|integer|between:0,26',
                'bank_loan_account_id' => 'required|integer',
                'loan_principal' => 'required|numeric|between:0,999999999999.99',
                'interest_rate' => 'required|numeric|between:0,99.99',
                'repayment_schedule' => 'required|in:yearly,monthly,weekly,daily',
                'start_date' => 'required|date',
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
            $loan->loan_name = $request->loan_name;
            $loan->loan_duration = $request->loan_duration;
            $loan->loan_principal = $request->loan_principal;
            $loan->interest_rate = $request->interest_rate;
            $interestValue = $request->loan_principal * ($request->interest_rate / 100);
            $TotalInterestValue = $interestValue * $request->loan_duration;
            $loan->loan_balance = $loan->loan_principal + $TotalInterestValue;
            $loan->repayment_schedule = $request->repayment_schedule;
            $loan->start_date = $request->start_date;
            $loan->end_date = Carbon::parse($request->start_date)->copy()->addYears($request->loan_duration);
            $loan->status = 'defaulted';
            $loan->save();

            // create SubLedger
            $subLedger = new SubLedger;
            $subLedger->branch_id = Auth::user()->branch_id;
            $subLedger->account_id = 3;
            $subLedger->sub_ledger_name = $request->loan_name;
            $subLedger->slug = Str::slug($request->loan_name);
            $subLedger->save();

            // transaction info save
            $transaction = new Transaction;
            $transaction->branch_id = Auth::user()->branch_id;
            $transaction->source_id = $loan->id;
            $transaction->source_type = 'Loan';
            $transaction->transaction_date = Carbon::now();
            $transaction->bank_account_id = $request->bank_loan_account_id;
            $transaction->amount = $request->loan_principal;
            $transaction->transaction_type = 'credit';
            $transaction->transaction_id = $this->generateUniqueTransactionId();
            $transaction->transaction_by = Auth::user()->id;
            $transaction->save();

            $bank = BankAccounts::findOrFail($request->bank_loan_account_id);
            $bank->current_balance += $request->loan_principal;
            $bank->save();

            // Ledger Entry info save
            $ledgerEntries = new LedgerEntries;
            $ledgerEntries->branch_id = Auth::user()->branch_id;
            $ledgerEntries->transaction_id = $transaction->id;
            $ledgerEntries->group_id = 4;
            $ledgerEntries->account_id = 3;
            $ledgerEntries->sub_ledger_id = $subLedger->id;
            $ledgerEntries->entry_amount = $request->loan_principal;
            $ledgerEntries->transaction_date = Carbon::now();
            $ledgerEntries->transaction_by = Auth::user()->id;
            $ledgerEntries->save();

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

    // generate uniqid transaction Id Function
    private function generateUniqueTransactionId()
    {
        $allTransactionIds = Transaction::pluck('transaction_id')->toArray();
        do {
            $transactionId = substr(bin2hex(random_bytes(4)), 0, 8);
        } while (in_array($transactionId, $allTransactionIds));

        return $transactionId;
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
    // view Loan Function
    public function viewLoan($id)
    {
        try {

            $loan = Loan::findOrFail($id);  // Fetch only for the user's branch
            $branch = Branch::findOrFail($loan->branch_id);
            $banks = BankAccounts::latest()->get();
            $loan_repayments = LoanRepayments::where('loan_id', $loan->id)->get();

            return view('all_modules.bank.loan.loan-profile', compact('loan', 'branch', 'banks', 'loan_repayments'));
        } catch (\Exception $e) {
            // / Log the error
            Log::error('Error loading the Loan view: ' . $e->getMessage());

            // Optionally return a custom error view or a simple error message
            return response()->view('errors.custom', [], 500);
        }
    }
    public function loanInstalmentInvoice($id){
        $loanRepayments = LoanRepayments::findOrFail($id);
        return view('all_modules.bank.loan.loan-instalment-invoice', compact('loanRepayments'));
    }
    public function loanInvoicePrint($id){
        $loanRepayments = LoanRepayments::findOrFail($id);
        // dd($id);
        return view('all_modules.bank.loan.loan-instalment-invoice', compact('loanRepayments'));
    }
}
