<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\AccountTransaction;
use App\Models\Bank\BankAccounts;
use App\Models\Ledger\LedgerAccounts\LedgerAccounts;
use App\Models\Ledger\LedgerAccounts\LedgerEntries;
use App\Models\Ledger\SubLedger\SubLedger;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ExpenseController extends Controller
{
    public function ExpenseCategoryStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ], [
            'name' => 'required Expense Category Name'
        ]);

        if ($validator->passes()) {

            $subLedger = new SubLedger;
            $subLedger->branch_id = Auth::user()->branch_id;
            $subLedger->account_id = 4;
            $subLedger->sub_ledger_name = $request->name;
            $subLedger->slug = Str::slug($request->name);
            $subLedger->save();

            return response()->json([
                'status' => 200,
                'message' => "Expense Category Added Successfully"
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'error' => $validator->messages()
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
        // dd($request->all());
        try {

            $validator = Validator::make($request->all(), [
                'purpose' => 'required|max:99',
                'amount' => 'required|numeric|between:0,999999999999.99',
                'spender' => 'required|max:99',
                'expense_category_id' => 'required|integer',
                'expense_date' => 'required',
                'image' => 'file|mimes:jpg,pdf,png,svg,webp,jpeg,gif|max:5120',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => '500',
                    'error' => $validator->messages()
                ]);
            }

            $expense = new Expense;
            $expense->branch_id =  Auth::user()->branch_id;
            $expense->expense_date =  $request->expense_date;
            $expense->expense_category_id =  $request->expense_category_id;
            $expense->amount =  $request->amount;
            $expense->purpose =  $request->purpose;
            $expense->spender =  $request->spender;
            $expense->note =  $request->note;
            if ($request->image) {
                $imageName = rand() . '.' . $request->image->extension();
                $request->image->move(public_path('uploads/expense/'), $imageName);
                $expense->image = $imageName;
            }
            $expense->save();

            return response()->json([
                'status' => 200,
                'message' => 'Expense Saved Successfully',
                'data' => [
                    'expanse_id' => $expense->id, // Retrieve actual saved asset id
                    'amount' => $expense->amount,
                    'subLedger_id' => $request->expense_category_id,
                ]
            ]);
        } catch (\Exception $e) {
            // Handle any exceptions that may occur
            return response()->json([
                "status" => 500,
                "message" => 'An error occurred while Save Expense.',
                "error" => $e->getMessage()  // Optional: include exception message
            ]);
        }
    } //


    public function ExpenseView()
    {
        $subLedger = SubLedger::where('account_id', 4)->latest()->get();
        $testData = LedgerEntries::where('account_id', 4)->latest()->get();
        if (Auth::user()->id == 1) {
            $expense = Expense::latest()->get();
        } else {
            $expense = Expense::where('branch_id', Auth::user()->branch_id)->latest()->get();
        }
        return view('all_modules.expense.expanse-management', compact('expense', 'subLedger', 'testData'));
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
                $accountTransaction->purpose =  'Expense Update';
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
        $oldExpanse = AccountTransaction::where('reference_id', $id)->where('purpose', 'Expense')->orWhere('purpose', 'Expanse Update')->first();
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
        $expenseCategory = LedgerAccounts::findOrFail($id);
        $expenseCategory->delete();
        $notification = [
            'message' => 'Expense Category Deleted Successfully',
            'alert-type' => 'info'
        ];
        return redirect()->route('expense.view')->with($notification);
    } //
    public function ExpenseCategoryEdit($id)
    {
        $category = LedgerAccounts::findOrFail($id);
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

        LedgerAccounts::findOrFail($id)->update([
            'name' => $request->account_name
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
        $expenseCat = LedgerAccounts::where('group_id', 2)->latest()->get();
        // $expenseCategory  = ExpenseCategory::latest()->get();
        $expense =  Expense::when($request->startDate && $request->endDate, function ($query) use ($request) {
            return $query->whereBetween('expense_date', [$request->startDate, $request->endDate]);
        })->get();

        return view('all_modules.expense.expense-filter-rander-table', compact('expense', 'expenseCat'))->render();
    }//
    public function expensesInvoice($id){
        $expanses = Expense::findOrFail($id);
        return view('all_modules.expense.expanse-invoice', compact('expanses'));
    }
    public function expensesPrintInvoice($id){
        // dd($id);
        $expanses = Expense::findOrFail($id);
        return view('all_modules.expense.expanse-invoice', compact('expanses'));
    }
}
