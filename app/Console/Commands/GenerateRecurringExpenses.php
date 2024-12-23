<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Expanse\RecurringExpense;
use Carbon\Carbon;

class GenerateRecurringExpenses extends Command
{
    protected $signature = 'recurring-expenses:generate';
    protected $description = 'Generate invoices for active recurring expenses';

    public function handle()
    {
        $today = Carbon::today();

        $expenses = RecurringExpense::where('status', 'active')
            ->where('next_due_date', '<=', $today)
            ->get();

        foreach ($expenses as $expense) {
            // Logic to generate invoice (e.g., save to an invoices table)
            // Invoice::create([...]);

            // Update next_due_date based on recurrence_period
            $next_due_date = match ($expense->recurrence_period) {
                'monthly' => Carbon::parse($expense->next_due_date)->addMonth(),
                'quarterly' => Carbon::parse($expense->next_due_date)->addMonths(3),
                'annually' => Carbon::parse($expense->next_due_date)->addYear(),
            };

            $expense->update(['next_due_date' => $next_due_date]);
            $this->info("Invoice generated for expense ID: {$expense->id}");
        }

        return Command::SUCCESS;
    }
}
