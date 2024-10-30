<?php

namespace App\Http\Controllers\Expanse\RecurringExpanse;

use App\Http\Controllers\Controller;
use App\Models\Bank\BankAccounts;
use App\Models\Expanse\RecurringExpense\RecurringExpense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

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
            Log::error('Error loading the bank view: ' . $e->getMessage());

            // Optionally return a custom error view or a simple error message
            return response()->view('errors.500', [], 500);
        }
    }

    // this is store function 
    public function store(Request $request)
    {
        // dd($request->all());
        // tomader vai emon vab ze sobkicu jana thaka lagbe. na janle tumi ekta bokachoda.
        try {
            // Validate the incoming request
            $validator = Validator::make($request->all(), [
                'expanse_category_id' => 'required|integer',
                'amount' => 'required|numeric|between:0,999999999999.99',
                'start_date' => 'required|date',
                'next_due_date' => 'required|date',
                'recurrence_period' => 'required|in:monthly,quarterly,annually',
                'name' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => '500',
                    'error' => $validator->messages()
                ]);
            }


            $expanse = new RecurringExpense;
            $expanse->expanse_category_id = $request->expanse_category_id;
            $expanse->amount = $request->amount;
            $expanse->name = $request->name;
            $expanse->start_date = $request->start_date;
            $expanse->recurrence_period = $request->recurrence_period;
            $expanse->next_due_date = $request->next_due_date;
            $expanse->status = 'active';
            $expanse->save();
            return response()->json([
                'status' => 200,
                'message' => 'Recurring Expanse.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => 500,
                "message" => 'An error occurred while fetching Recurring Expanse.',
                "error" => $e->getMessage()  // Optional: include exception message
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

            $data = ExpenseCategory::latest()->get();

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
}
