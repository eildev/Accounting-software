<?php

namespace App\Http\Controllers\Expanse\RecurringExpanse;

use App\Http\Controllers\Controller;
use App\Models\Bank\BankAccounts;
use App\Models\Expanse\RecurringExpense\RecurringExpense;
use App\Models\ExpenseCategory;
use App\Models\Ledger\SubLedger\SubLedger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RecurringExpanseController extends Controller
{
    // this is my index function
    public function index()
    {
        // tomader vai emon vab ze sobkicu jana thaka lagbe. na janle tumi ekta bokachoda.
        try {
            $expenseCategory = ExpenseCategory::get();
            return view('all_modules.expense.recurring-expanse.index', compact('expenseCategory'));
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error loading the expense view: ' . $e->getMessage());

            // Optionally return a custom error view or a simple error message
            return response()->view('errors.500', [], 500);
        }
    }

    // this is store function
    // public function store(Request $request)
    // {
    //     // dd($request->all());
    //     // tomader vai emon vab ze sobkicu jana thaka lagbe. na janle tumi ekta bokachoda.
    //     try {
    //         // Validate the incoming request
    //         $validator = Validator::make($request->all(), [
    //             'expanse_category_id' => 'required|integer',
    //             'amount' => 'required|numeric|between:0,999999999999.99',
    //             'start_date' => 'required|date',
    //             'next_due_date' => 'required|date',
    //             // 'recurrence_period' => 'required|in:monthly,quarterly,annually',
    //             'name' => 'required|string',
    //         ]);

    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'status' => '500',
    //                 'error' => $validator->messages()
    //             ]);
    //         }


    //         $expanse = new RecurringExpense;
    //         $expanse->expanse_category_id = $request->expanse_category_id;
    //         $expanse->amount = $request->amount;
    //         $expanse->name = $request->name;
    //         $expanse->start_date = $request->start_date;
    //         $expanse->recurrence_period = $request->recurrence_period;
    //         $expanse->next_due_date = $request->next_due_date;
    //         $expanse->status = 'active';
    //         $expanse->save();
    //         return response()->json([
    //             'status' => 200,
    //             'message' => 'Recurring Expanse.',
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             "status" => 500,
    //             "message" => 'An error occurred while fetching Recurring Expanse.',
    //             "error" => $e->getMessage()  // Optional: include exception message
    //         ]);
    //     }
    // }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'expanse_category_id' => 'required|integer',
                'amount' => 'required|numeric|between:0,999999999999.99',
                'start_date' => 'required|date',
                'recurrence_period' => 'required|in:monthly,quarterly,annually',
                'name' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 500,
                    'error' => $validator->messages(),
                ]);
            }

            // Calculate the next_due_date based on recurrence_period
            $start_date = Carbon::parse($request->start_date);
            $next_due_date = match ($request->recurrence_period) {
                'monthly' => $start_date->addMonth(),
                'quarterly' => $start_date->addMonths(3),
                'annually' => $start_date->addYear(),
            };

            $expanse = RecurringExpense::create([
                'expanse_category_id' => $request->expanse_category_id,
                'amount' => $request->amount,
                'name' => $request->name,
                'start_date' => $request->start_date,
                'recurrence_period' => $request->recurrence_period,
                'next_due_date' => $next_due_date,
                'status' => 'active',
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Recurring Expense Added Successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while saving Recurring Expense.',
                'error' => $e->getMessage(),
            ]);
        }
    }



    public function view()
    {
        try {
            if (Auth::user()->id == 1) {
                // Admin: Fetch all records with expense category data
                $data = RecurringExpense::with('expenseCategory')->latest()->get();
            } else {
                // Non-admin: Fetch only records for the user's branch with expense category data
                $data = RecurringExpense::with('expenseCategory')
                    ->where('branch_id', Auth::user()->branch_id)
                    ->latest()
                    ->get();
            }

            return response()->json([
                'status' => 200,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => 500,
                "message" => 'An error occurred while fetching recurring expenses.',
                "error" => $e->getMessage()  // Optional: include exception message
            ]);
        }
    }
    public function viewExpenseCategory()
    {
        try {

            $data = SubLedger::where('account_id', 7)->latest()->get();

            return response()->json([
                'status' => 200,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => 500,
                "message" => 'An error occurred while fetching Expanse Category.',
                "error" => $e->getMessage()  // Optional: include exception message
            ]);
        }
    }
    public function recurringExpenseCategoryStore(Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
            ], [
                'name.required' => 'Expense Category Name is required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 400, // Unprocessable Entity
                    'error' => $validator->messages()
                ]);
            }
            $subLedger = new SubLedger();
            $subLedger->branch_id = Auth::user()->branch_id;
            $subLedger->account_id = 7;
            $subLedger->sub_ledger_name = $request->name;
            $subLedger->slug = Str::slug($request->name);
            $subLedger->save();

            return response()->json([
                'status' => 200,
                'message' => "Expense Category Added Successfully"
            ]);
        } catch (\Exception $e) {
            // Handle unexpected errors
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while adding the Expense Category',
                'error' => $e->getMessage()
            ]);
        }
    }
}
