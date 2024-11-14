<?php

namespace App\Http\Controllers\Bank\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Assets\Assets;
use App\Models\Bank\BankAccounts;
use App\Models\Bank\Cash;
use App\Models\Bank\CashTransaction;
use App\Models\Bank\Transaction\Transaction;
use App\Models\Branch;
use App\Models\Ledger\LedgerAccounts\LedgerEntries;
use Carbon\Carbon;
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
            } else {
                $cashAccounts = Cash::where('branch_id', Auth::user()->branch_id)->latest()->get();
                $bankAccounts = BankAccounts::where('branch_id', Auth::user()->branch_id)->latest()->get();
            }

            return view('all_modules.transaction.transaction', compact('cashAccounts', 'bankAccounts'));
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Transaction Error: ' . $e->getMessage());

            // Optionally, you can flash a message to the session to display it to the user
            return redirect()->back()->with('error', 'Something went wrong while processing the transaction.');

            // Alternatively, you can return a custom error view if required
            // return view('error_page')->with('message', 'Something went wrong!');
        }
    }


    // TODO: Ledger Entries Create is Not yet implemented
    // storeTransaction function 
    public function storeTransaction(Request $request)
    {
        try {
            $messages = [
                'payment_account_id.required' => 'The payment account is required.',
                'payment_account_id.integer' => 'The payment account must be an integer.',
                'transaction_type.required' => 'The transaction type is required.',
                'transaction_type.in' => 'Invalid transaction type provided.',
                'description.max' => 'Note field must be a maximum of 99 characters long.',
                'source_type.string' => 'Purpose must be a string value.',
                'source_type.max' => 'Purpose must be a maximum of 99 characters.',
            ];

            $validator = Validator::make($request->all(), [
                'account_type' => 'required|in:cash,bank',
                'payment_account_id' => 'required|integer',
                'transaction_date' => 'required|date',
                'amount' => 'required|numeric|between:0,999999999999.99',
                'transaction_type' => 'required|in:deposit,withdrawal',
                'description' => 'string|max:99',
                'source_type' => 'string|max:99',
            ], $messages);

            if ($validator->fails()) {
                return response()->json([
                    'status' => '500',
                    'error' => $validator->messages()
                ]);
            }

            // Initialize Transaction
            $transaction = new Transaction;
            $transaction->fill([
                'branch_id' => Auth::user()->branch_id,
                'amount' => $request->amount,
                'transaction_date' => Carbon::parse($request->transaction_date)->format('Y-m-d'),
                'source_type' => $request->source_type,
                'description' => $request->description,
                'transaction_by' => Auth::user()->id,
                'transaction_id' => $this->generateUniqueTransactionId()
            ]);

            $accountModel = $request->account_type === 'cash' ? Cash::class : BankAccounts::class;
            $accounts = $accountModel::findOrFail($request->payment_account_id);

            if ($request->transaction_type === 'withdrawal' && $request->amount > $accounts->current_balance) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Insufficient balance. Please add funds or select another account.'
                ]);
            }

            $transaction->transaction_type = $request->transaction_type === 'withdrawal' ? 'debit' : 'credit';

            if ($request->account_type === 'cash') {
                $transaction->cash_account_id = $request->payment_account_id;
                $this->saveCashTransaction($transaction, $request);
            } else {
                $transaction->bank_account_id = $request->payment_account_id;
            }

            // Update balance based on transaction type
            $accounts->current_balance += $request->transaction_type === 'withdrawal' ? -$request->amount : $request->amount;
            $transaction->save();
            $accounts->save();

            // Ledger Entry info save
            $ledgerEntries = new LedgerEntries;
            $ledgerEntries->branch_id = Auth::user()->branch_id;
            $ledgerEntries->transaction_id = $transaction->id;
            $ledgerEntries->group_id = 1;
            $ledgerEntries->account_id = 1;
            $ledgerEntries->sub_ledger_id = 1;
            $ledgerEntries->entry_amount = $request->initial_balance;
            $ledgerEntries->transaction_date = Carbon::now();
            $ledgerEntries->transaction_by = Auth::user()->id;
            $ledgerEntries->save();

            return response()->json([
                'status' => 200,
                'message' => 'Transaction Saved Successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => 500,
                "message" => 'An error occurred while processing the transaction.',
                "error" => $e->getMessage()
            ]);
        }
    }



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

    public function view()
    {
        try {
            if (Auth::user()->id == 1) {
                $withdraw = Transaction::with(['bank', 'cash'])
                    ->where('transaction_type', 'debit')
                    ->latest()
                    ->get();
                $deposit = Transaction::with(['bank', 'cash'])
                    ->where('transaction_type', 'credit')
                    ->latest()
                    ->get();
            } else {
                $withdraw = Transaction::with(['bank', 'cash'])
                    ->where('branch_id', Auth::user()->branch_id)
                    ->where('transaction_type', 'debit')
                    ->latest()
                    ->get();
                $deposit = Transaction::with(['bank', 'cash'])
                    ->where('branch_id', Auth::user()->branch_id)
                    ->where('transaction_type', 'credit')
                    ->latest()
                    ->get();
            }

            return response()->json([
                'status' => 200,
                'withdraw' => $withdraw,
                'deposit' => $deposit,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => 500,
                "message" => 'An error occurred while fetching Transaction Data.',
                "error" => $e->getMessage()  // Optional: include exception message
            ]);
        }
    }

    // transaction view Details Function 
    public function viewDetails($id)
    {
        try {
            $transaction = Transaction::findOrFail($id);
            $branch = Branch::findOrFail($transaction->branch_id);
            return view('all_modules.transaction.view-details', compact('transaction', 'branch'));
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Transaction Error: ' . $e->getMessage());

            // Optionally, you can flash a message to the session to display it to the user
            return redirect()->back()->with('error', 'Something went wrong while processing the transaction.');
        }
    }


    // SttoreTransaction with Ledger function 
    public function storeTransactionWithLedger(Request $request)
    {
        // dd($request->all());
        try {
            $validator = Validator::make($request->all(), [
                'account_type' => 'required|in:cash,bank',
                'data_id' => 'required|integer',
                'payment_account_id' => 'required|integer',
                'payment_balance' => 'required|numeric|between:0,999999999999.99',
                'purpose' => 'required',
                'transaction_type' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => '500',
                    'error' => $validator->messages()
                ]);
            }

            // Initialize Transaction
            $transaction = new Transaction;
            $transaction->fill([
                'branch_id' => Auth::user()->branch_id,
                'amount' => $request->payment_balance,
                'transaction_date' => Carbon::now(),
                'source_type' => $request->purpose,
                'description' => $request->description,
                'transaction_by' => Auth::user()->id,
                'transaction_id' => $this->generateUniqueTransactionId()
            ]);

            $accountModel = $request->account_type === 'cash' ? Cash::class : BankAccounts::class;
            $accounts = $accountModel::findOrFail($request->payment_account_id);

            if ($request->transaction_type === 'withdraw' && $request->payment_balance > $accounts->current_balance) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Insufficient balance. Please add funds or select another account.'
                ]);
            }

            $transaction->transaction_type = $request->transaction_type === 'withdraw' ? 'debit' : 'credit';

            if ($request->account_type === 'cash') {
                $transaction->cash_account_id = $request->payment_account_id;
                $this->saveCashTransaction($request);
            } else {
                $transaction->bank_account_id = $request->payment_account_id;
            }

            // Update balance based on transaction type
            $accounts->current_balance += $request->transaction_type === 'withdraw' ? -$request->amount : $request->amount;
            $transaction->save();
            $accounts->save();

            if ($request->purpose == "Fixed Asset Purchase") {
                $asset = Assets::findOrFail($request->data_id);
                $asset->status = 'purchased';
                $asset->save();
            }

            // Ledger Entry info save
            // $ledgerEntries = new LedgerEntries;
            // $ledgerEntries->branch_id = Auth::user()->branch_id;
            // $ledgerEntries->transaction_id = $transaction->id;
            // $ledgerEntries->group_id = 1;
            // $ledgerEntries->account_id = 1;
            // $ledgerEntries->sub_ledger_id = 1;
            // $ledgerEntries->entry_amount = $request->initial_balance;
            // $ledgerEntries->transaction_date = Carbon::now();
            // $ledgerEntries->transaction_by = Auth::user()->id;
            // $ledgerEntries->save();

            return response()->json([
                'status' => 200,
                'message' => 'Payment Completed Successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => 500,
                "message" => 'An error occurred while processing the transaction.',
                "error" => $e->getMessage()
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

    // saveCashTransaction function using for save cash transaction information 
    private function saveCashTransaction($request)
    {
        $cashTransaction = new CashTransaction;
        $cashTransaction->fill([
            'branch_id' => Auth::user()->branch_id,
            'cash_id' => $request->payment_account_id,
            'transaction_date' => Carbon::now(),
            'amount' => $request->payment_balance,
            'description' => $request->description ?? "",
            'transaction_type' => $request->transaction_type === 'withdraw' ? 'withdraw' : 'deposit',
            'process_by' => Auth::user()->id,
        ]);

        $cashTransaction->save();
    }
}
