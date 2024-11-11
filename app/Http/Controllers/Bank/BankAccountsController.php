<?php

namespace App\Http\Controllers\Bank;

use App\Http\Controllers\Controller;
use App\Models\Bank\BankAccounts;
use App\Models\Bank\Transaction\Transaction;
use App\Models\Branch;
use App\Models\Ledger\LedgerAccounts\LedgerEntries;
use App\Models\Ledger\SubLedger\SubLedger;
use Carbon\Carbon;
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
            return response()->view('errors.500', [], 500);
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

            // create SubLedger 
            $subLedger = new SubLedger;
            $subLedger->branch_id = Auth::user()->branch_id;
            $subLedger->account_id = 1;
            $subLedger->sub_ledger_name = $request->bank_name;
            $subLedger->save();

            // transaction info save
            $transaction = new Transaction;
            $transaction->branch_id = Auth::user()->branch_id;
            $transaction->source_type = 'Bank AC Opening';
            $transaction->transaction_date = Carbon::now();
            $transaction->bank_account_id = $bank->id;
            $transaction->amount = $request->initial_balance;
            $transaction->transaction_type = 'credit';
            $transaction->transaction_id = $this->generateUniqueTransactionId();
            $transaction->transaction_by = Auth::user()->id;
            $transaction->save();

            // Ledger Entry info save
            $ledgerEntries = new LedgerEntries;
            $ledgerEntries->branch_id = Auth::user()->branch_id;
            $ledgerEntries->transaction_id = $transaction->id;
            $ledgerEntries->group_id = 1;
            $ledgerEntries->account_id = 1;
            $ledgerEntries->sub_ledger_id = $subLedger->id;
            $ledgerEntries->entry_amount = $request->initial_balance;
            $ledgerEntries->transaction_date = Carbon::now();
            $ledgerEntries->transaction_by = Auth::user()->id;
            $ledgerEntries->save();


            return response()->json([
                'status' => 200,
                'message' => 'Bank Account Saved Successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => 500,
                "message" => 'An error occurred while fetching bank accounts.',
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
            // Fetch the bank accounts based on user type (admin or branch)
            if (Auth::user()->id == 1) {
                $banks = BankAccounts::get();  // Fetch all for admin
            } else {
                $banks = BankAccounts::where('branch_id', Auth::user()->branch_id)
                    ->latest()
                    ->get();
            }

            $total_bank = $banks->count();
            $total_initial_balance = $banks->sum('initial_balance');
            $total_current_balance = $banks->sum('current_balance');

            // Return a successful response with data
            return response()->json([
                "status" => 200,
                "data" => $banks,
                "total_bank" => $total_bank,
                "total_initial_balance" => $total_initial_balance,
                "total_current_balance" => $total_current_balance,
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
    public function bankDetails($id)
    {
        try {

            $data = BankAccounts::findOrFail($id);
            $branch = Branch::findOrFail($data->branch_id);
            $transactions = Transaction::where('bank_account_id', '=', $id)->get();
            $isBank = true;
            return view('all_modules.bank.bank-details', compact('data', 'branch', 'isBank', 'transactions'));
        } catch (\Exception $e) {
            // Handle any exceptions that may occur
            Log::error('Bank Details Error: ' . $e->getMessage());

            // Redirect to custom 500 error page
            return response()->view('errors.500', [], 500);
        }
    }
}
