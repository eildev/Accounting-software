<?php

namespace App\Observers\RecurringExpense;

use App\Models\Expanse\RecurringExpense\RecurringExpense;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class RecurringExpenseObserver
{
    public function created(RecurringExpense $recurringExpense)
    {
        $this->handleRecurringExpense($recurringExpense);
    }

    public function updated(RecurringExpense $recurringExpense)
    {
        $this->handleRecurringExpense($recurringExpense);
    }

    protected function handleRecurringExpense(RecurringExpense $recurringExpense)
    {
        $now = Carbon::now();

        // Ensure the expense is active
        if ($recurringExpense->status === 'active' && $recurringExpense->next_due_date <= $now) {
            // Create an expense record
            Expense::create([
                'branch_id' => Auth::user()->branch_id, // Set appropriate branch_id if dynamic
                'expense_category_id' => $recurringExpense->expense_category_id,
                'purpose' => $recurringExpense->description,
                'amount' => $recurringExpense->amount,
                'note' => 'Recurring expense',
            ]);

            // Update the next_due_date based on the recurrence period
            $nextDueDate = $this->calculateNextDueDate($recurringExpense->next_due_date, $recurringExpense->recurrence_period);
            $recurringExpense->update(['next_due_date' => $nextDueDate]);
        }
    }

    protected function calculateNextDueDate($currentDate, $period)
    {
        $current = Carbon::parse($currentDate);

        return match ($period) {
            'daily' => $current->addDay(),
            'monthly' => $current->addMonth(),
            'quarterly' => $current->addMonths(3),
            'annually' => $current->addYear(),
            default => $current
        };
    }
}
