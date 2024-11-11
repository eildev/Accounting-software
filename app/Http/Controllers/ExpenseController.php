<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\AccountTransaction;
use App\Models\Bank\BankAccounts;
use App\Models\Bank\Cash;
use App\Models\Bank\CashTransaction;
use App\Models\Bank\Transaction\Transaction;
use App\Models\Ledger\LedgerAccounts\LedgerAccounts;
use App\Models\Ledger\LedgerAccounts\LedgerEntries;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function ExpenseCategoryStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ], [
            'name' => 'required Expense Category Name'
        ]);
        $expenseCategory = new ExpenseCategory;
        if ($validator->passes()) {
            $expenseCategory->name =  $request->name;
            $expenseCategory->save();
            return response()->json([
                'status' => 200,
                'message' => "Expense Category Added Successfully"
            ]);
        }
    } //End Method
    public function ExpenseAdd()
    {
        if (Auth::user()->id == 1) {
            $bank = BankAccounts::latest()->get();
        } else {
            $bank = BankAccounts::where('branch_id', Auth::user()->branch_id)->latest()->get();
        }
        $expenseCategory = ExpenseCategory::latest()->get();
        return view('all_modules.expense.add_expanse', compact('expenseCategory', 'bank'));
    } //
    public function ExpenseStore(Request $request)
    {
        $request->validate([
            'purpose' => 'required|max:99',
            'amount' => 'required|numeric|between:0,999999999999.99',
            'spender' => 'required|max:99',
            'expense_category_id' => 'required|integer',
            'expense_date' => 'required',
            'bank_account_id' => 'required|integer',
            'account_type' => 'required|in:cash,bank',
        ]);


        if ($request->account_type == 'bank') {
            $account_balance =  BankAccounts::findOrFail($request->bank_account_id);
        } else {
            $account_balance =  Cash::findOrFail($request->bank_account_id);
        }

        if ($account_balance->current_balance > 0 && $account_balance->current_balance >= $request->amount) {

            $expense = new Expense;
            $expense->branch_id =  Auth::user()->branch_id;
            $expense->expense_date =  $request->expense_date;
            $expense->expense_category_id =  $request->expense_category_id;
            $expense->amount =  $request->amount;
            $expense->purpose =  $request->purpose;
            $expense->spender =  $request->spender;
            if ($request->account_type == 'bank') {
                $expense->bank_account_id =  $request->bank_account_id;
            } else {
                $expense->cash_account_id =  $request->bank_account_id;
            }
            $expense->note =  $request->note;
            if ($request->image) {
                $imageName = rand() . '.' . $request->image->extension();
                $request->image->move(public_path('uploads/expense/'), $imageName);
                $expense->image = $imageName;
            }
            $expense->save();

            if ($request->account_type == 'bank') {
                $bank =  BankAccounts::findOrFail($request->bank_account_id);
                $bank->current_balance -= $request->amount;
                $bank->save();
            } else {
                $cash =  Cash::findOrFail($request->bank_account_id);
                $cash->current_balance -= $request->amount;
                $cash->save();

                // cash Transaction info save 
                $cashTransaction = new CashTransaction;
                $cashTransaction->branch_id = Auth::user()->branch_id;
                $cashTransaction->cash_id = $cash->id;
                $cashTransaction->transaction_date = Carbon::now();
                $cashTransaction->amount = $request->amount;
                $cashTransaction->transaction_type = 'withdraw';
                $cashTransaction->process_by = Auth::user()->id;
                $cashTransaction->save();
            }

            // transaction info save
            $transaction = new Transaction;
            $transaction->branch_id = Auth::user()->branch_id;
            $transaction->source_id = $expense->id;
            $transaction->source_type = 'Expanse';
            $transaction->transaction_date = Carbon::now();
            if ($request->account_type == 'bank') {
                $transaction->bank_account_id =  $request->bank_account_id;
            } else {
                $transaction->cash_account_id =  $request->bank_account_id;
            }
            $transaction->amount = $request->amount;
            $transaction->transaction_type = 'debit';
            $transaction->transaction_id = $this->generateUniqueTransactionId();
            $transaction->transaction_by = Auth::user()->id;
            $transaction->save();

            $ledgerAccounts = new LedgerAccounts;
            $ledgerAccounts->branch_id = Auth::user()->branch_id;
            $ledgerAccounts->group_id = 2;
            $ledgerAccounts->account_name = $request->purpose;
            $ledgerAccounts->save();

            // // Ledger Entry info save
            $ledgerEntries = new LedgerEntries;
            $ledgerEntries->branch_id = Auth::user()->branch_id;
            $ledgerEntries->transaction_id = $transaction->id;
            $ledgerEntries->group_id = 2;
            $ledgerEntries->account_id = $ledgerAccounts->id;
            $ledgerEntries->entry_amount = $request->amount;
            $ledgerEntries->transaction_date = Carbon::now();
            $ledgerEntries->transaction_by = Auth::user()->id;
            $ledgerEntries->save();

            $notification = [
                'message' => 'Expense Added Successfully',
                'alert-type' => 'info'
            ];
            return redirect()->route('expense.view')->with($notification);
        } else {
            $notification = [
                'warning' => 'Your account Balance is low Please Select Another account',
                'alert-type' => 'warning'
            ];
            return redirect()->back()->with($notification);
        }
    } //



    // generate uniqid transaction Id Function 
    private function generateUniqueTransactionId()
    {
        $allTransactionIds = Transaction::pluck('transaction_id')->toArray();
        do {
            $transactionId = substr(bin2hex(random_bytes(4)), 0, 8);
        } while (in_array($transactionId, $allTransactionIds));

        return $transactionId;
    }

    public function ExpenseView()
    {
        $expenseCat = ExpenseCategory::latest()->get();
        $expenseCategory = ExpenseCategory::latest()->get();
        if (Auth::user()->id == 1) {
            $bank = BankAccounts::latest()->get();
            $expense = Expense::latest()->get();
        } else {
            $bank = BankAccounts::where('branch_id', Auth::user()->branch_id)->latest()->get();
            $expense = Expense::where('branch_id', Auth::user()->branch_id)->latest()->get();
        }
        return view('all_modules.expense.view_expense', compact('expense', 'expenseCat', 'bank', 'expenseCategory'));
    } //

    public function ExpenseEdit($id)
    {
        $expense = Expense::findOrFail($id);
        $bank = BankAccounts::latest()->get();
        $expenseCategory = ExpenseCategory::latest()->get();
        return view('all_modules.expense.edit_expense', compact('expense', 'expenseCategory', 'bank'));
    } //
    public function ExpenseUpdate(Request $request, $id)
    {
        $oldBalance = AccountTransaction::where('account_id', $request->bank_account_id)->latest('created_at')->first();
        if ($oldBalance && $oldBalance->balance > 0 && $oldBalance->balance >= $request->amount) {
            $expense = Expense::findOrFail($id);

            if ($expense->amount != $request->amount) {
                $accountTransaction = new AccountTransaction;
                $accountTransaction->branch_id =  Auth::user()->branch_id;
                $accountTransaction->reference_id = $expense->id;
                $accountTransaction->purpose =  'Expanse Update';
                $accountTransaction->account_id =  $request->bank_account_id;
                if ($expense->amount > $request->amount) {
                    $accountTransaction->credit = $request->amount;
                    $accountTransaction->balance = $oldBalance->balance + ($request->amount - $expense->amount);
                } else {
                    $accountTransaction->debit = $request->amount - $expense->amount;
                    $accountTransaction->balance = $oldBalance->balance - ($request->amount - $expense->amount);
                }
                $accountTransaction->created_at = Carbon::now();
                $accountTransaction->save();
            }

            $expense->branch_id =  Auth::user()->branch_id;
            $expense->expense_date =  $request->expense_date;
            $expense->expense_category_id =  $request->expense_category_id;
            $expense->amount =  $request->amount;
            $expense->purpose =  $request->purpose;
            $expense->spender = $request->spender;
            $expense->bank_account_id =  $request->bank_account_id;
            $expense->note =  $request->note;
            if ($request->image) {
                $imageName = rand() . '.' . $request->image->extension();
                $request->image->move(public_path('uploads/expense/'), $imageName);
                $expense->image = $imageName;
            }
            $expense->save();

            $notification = [
                'message' => 'Expense Updated Successfully',
                'alert-type' => 'info'
            ];
            return redirect()->route('expense.view')->with($notification);
        } else {
            $notification = [
                'warning' => 'Your account Balance is low Please Select Another account',
                'alert-type' => 'warning'
            ];
            return redirect()->back()->with($notification);
        }
    } //
    public function ExpenseDelete($id)
    {

        $expense = Expense::findOrFail($id);
        if ($expense->image) {
            $previousImagePath = public_path('uploads/expense/') . $expense->image;
            if (file_exists($previousImagePath)) {
                unlink($previousImagePath);
            }
        }
        $oldExpanse = AccountTransaction::where('reference_id', $id)->where('purpose', 'Expanse')->orWhere('purpose', 'Expanse Update')->first();
        $oldBalance = AccountTransaction::where('account_id', $oldExpanse->account_id)->latest('created_at')->first();
        // dd($oldBalance->balance + $expense->amount);
        $accountTransaction = new AccountTransaction;
        $accountTransaction->reference_id = $expense->id;
        $accountTransaction->branch_id =  Auth::user()->branch_id;
        $accountTransaction->purpose =  'Expanse Delete';
        $accountTransaction->account_id = $oldExpanse->account_id;
        $accountTransaction->credit = $expense->amount;
        $accountTransaction->balance = $oldBalance->balance + $expense->amount;
        $accountTransaction->created_at = Carbon::now();
        $accountTransaction->save();

        $expense->delete();
        $notification = [
            'message' => 'Expense Deleted Successfully',
            'alert-type' => 'info'
        ];
        return redirect()->route('expense.view')->with($notification);
    } //
    public function ExpenseCategoryDelete($id)
    {
        $expenseCategory = ExpenseCategory::findOrFail($id);
        $expenseCategory->delete();
        $notification = [
            'message' => 'Expense Category Deleted Successfully',
            'alert-type' => 'info'
        ];
        return redirect()->route('expense.view')->with($notification);
    } //
    public function ExpenseCategoryEdit($id)
    {
        $category = ExpenseCategory::findOrFail($id);
        if ($category) {
            return response()->json([
                'status' => 200,
                'category' => $category
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => "Data Not Found"
            ]);
        }
    } //
    public function ExpenseCategoryUpdate(Request $request, $id)
    {

        $category = ExpenseCategory::findOrFail($id)->update([
            'name' => $request->name
        ]);
        // dd($category);
        // Return success response
        return response()->json([
            'status' => 200,
            'message' => 'Expense Category updated successfully',
        ]);
    } //
    ///Expense Filter view //
    public function ExpenseFilterView(Request $request)
    {
        $expenseCat = ExpenseCategory::latest()->get();
        // $expenseCategory  = ExpenseCategory::latest()->get();
        $expense =  Expense::when($request->startDate && $request->endDate, function ($query) use ($request) {
            return $query->whereBetween('expense_date', [$request->startDate, $request->endDate]);
        })->get();

        return view('all_modules.expense.expense-filter-rander-table', compact('expense', 'expenseCat'))->render();
    }
}
