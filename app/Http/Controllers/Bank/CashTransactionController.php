<?php

namespace App\Http\Controllers\Bank;

use App\Http\Controllers\Controller;
use App\Models\Bank\Cash;
use App\Models\Bank\CashTransaction;
use App\Models\Bank\Transaction\Transaction;
use App\Models\Branch;
use App\Models\Ledger\LedgerAccounts\LedgerEntries;
use App\Models\Ledger\SubLedger\SubLedger;
use Carbon\Carbon;
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

            // create SubLedger 
            $subLedger = new SubLedger;
            $subLedger->branch_id = Auth::user()->branch_id;
            $subLedger->account_id = 2;
            $subLedger->sub_ledger_name = $request->cash_account_name;
            $subLedger->save();


            // cash Transaction info save 
            $cashTransaction = new CashTransaction;
            $cashTransaction->branch_id = Auth::user()->branch_id;
            $cashTransaction->cash_id = $cash->id;
            $cashTransaction->transaction_date = Carbon::now();
            $cashTransaction->amount = $request->opening_balance;
            $cashTransaction->transaction_type = 'deposit';
            $cashTransaction->process_by = Auth::user()->id;
            $cashTransaction->save();


            // transaction info save
            $transaction = new Transaction;
            $transaction->branch_id = Auth::user()->branch_id;
            $transaction->source_type = 'Cash AC Opening';
            $transaction->transaction_date = Carbon::now();
            $transaction->cash_account_id = $cash->id;
            $transaction->amount = $request->opening_balance;
            $transaction->transaction_type = 'credit';
            $transaction->transaction_id = $this->generateUniqueTransactionId();
            $transaction->transaction_by = Auth::user()->id;
            $transaction->save();

            // Ledger Entry info save
            $ledgerEntries = new LedgerEntries;
            $ledgerEntries->branch_id = Auth::user()->branch_id;
            $ledgerEntries->transaction_id = $transaction->id;
            $ledgerEntries->group_id = 1;
            $ledgerEntries->account_id = 2;
            $ledgerEntries->sub_ledger_id = $subLedger->id;
            $ledgerEntries->entry_amount = $request->opening_balance;
            $ledgerEntries->transaction_date = Carbon::now();
            $ledgerEntries->transaction_by = Auth::user()->id;
            $ledgerEntries->save();


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
            $transactions = Transaction::where('cash_account_id', '=', $id)->get();
            $isBank = false;
            return view('all_modules.bank.bank-details', compact('data', 'branch', 'isBank', 'transactions'));
        } catch (\Exception $e) {
            // Handle any exceptions that may occur
            Log::error('Cash Details Error: ' . $e->getMessage());

            // Redirect to custom 500 error page
            return response()->view('errors.500', [], 500);
        }
    }
}
