<?php

namespace App\Http\Controllers\Expanse\ExpanseDashboard;

use App\Http\Controllers\Controller;
use App\Models\ConvenienceBill\Convenience;
use App\Models\EmployeePayroll\PaySlip;
use App\Models\Expanse\RecurringExpense\RecurringExpense;
use App\Models\Expense;
use App\Models\Ledger\LedgerAccounts\LedgerAccounts;
use App\Models\Ledger\SubLedger\SubLedger;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ExpanseDashboardController extends Controller
{
    public function expanseDashboard()
    {
        $currentMonth = Carbon::now();
        $previousMonth = Carbon::now()->subMonth();
        ///////////////////////Expanse category Count////////////
        $expanseCatCount =  SubLedger::whereMonth('created_at', $currentMonth->month)->where('account_id', 4)
            ->whereYear('created_at', $currentMonth->year)->count();
        /////////Percentage //////////
        // $currentMonth = Carbon::now();
        // $previousMonth = Carbon::now()->subMonth();
        // $currentMonthExpanseCatCount = SubLedger::whereMonth('created_at', $currentMonth->month)
        // ->whereYear('created_at', $currentMonth->year)
        // ->count();

        // // Previous month's expense categories
        // $previousMonthExpanseCatCount = SubLedger::whereMonth('created_at', $previousMonth->month)
        //     ->whereYear('created_at', $previousMonth->year)
        //     ->count();

        //     if ($previousMonthExpanseCatCount > 0) {
        //         $expanseCatPercentageIncrease = (($currentMonthExpanseCatCount - $previousMonthExpanseCatCount) / $previousMonthExpanseCatCount) * 100;
        //     } else {
        //         // If the previous month's count is zero, handle as 100% increase or no baseline for percentage calculation
        //         $expanseCatPercentageIncrease = $currentMonthExpanseCatCount > 0 ? 100 : 0;
        //     }
        ///////////////////////Expanse category End////////////
        ///////////////////////Expanse ledger Start////////////
        $expanseledgerCount =  LedgerAccounts::whereMonth('created_at', $currentMonth->month)
            ->whereYear('created_at', $currentMonth->year)->where('group_id', 2)->count();
        ///////////////////////Expanse ledger End////////////
        ///////////////////////Expanse Invoice /////////////
        $expanseInvoiceCount = Expense::whereMonth('expense_date', $currentMonth->month)
            ->whereYear('expense_date', $currentMonth->year)->count();
        ///////////////////////Expanse InvoiceEnd  /////////////



        $thisMonth = Expense::whereMonth('expense_date', $currentMonth->month)
            ->whereYear('expense_date', $currentMonth->year)
            ->sum('amount');

        $lastMonth = Expense::whereMonth('expense_date', $previousMonth->month)
            ->whereYear('expense_date', $previousMonth->year)
            ->sum('amount');
        return view('all_modules.expense.expanse_dashboard.expanse_dashboard', [
            'thisMonth' => $thisMonth,
            'lastMonth' => $lastMonth,
            'expanseCatCount' => $expanseCatCount,
            'expanseledgerCount' => $expanseledgerCount,
            'expanseInvoiceCount' => $expanseInvoiceCount,


        ]);
    }
    public function expanseaAtivitiesFilter(Request $request)
    {
        $perPage = $request->query('perPage', 5);                // Items per page
        $page = $request->query('page', 1);
        $month = $request->query('month', Carbon::now()->month); // Default to current month
        $year = $request->query('year', Carbon::now()->year);    // Default to current year

        $activities = Expense::with(['expenseCat', 'bank', 'cash'])
            ->whereMonth('expense_date', $month)
            ->whereYear('expense_date', $year)
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json($activities);
    } //
    public function expanseaCategoryFilter(Request $request)
    {
        $month = $request->month;
        $year = $request->query('year', Carbon::now()->year);

        $thisMonthExpense = Expense::where('status', 'paid')->whereMonth('expense_date', $month)
            ->whereYear('expense_date',  $year)
            ->get();

        $thisMonthExpenseTotalSum = $thisMonthExpense->sum('amount');
        $expanseCats = SubLedger::where('account_id', 4)->get();

        $categoryPercentages = [];
        foreach ($expanseCats as $expanseCat) {
            $expanseCategoryWaysSum = $thisMonthExpense->where('expense_category_id', $expanseCat->id)->sum('amount');
            $percentage = $thisMonthExpenseTotalSum > 0
                ? ($expanseCategoryWaysSum / $thisMonthExpenseTotalSum) * 100
                : 0;

            $categoryPercentages[] = [
                'category' => $expanseCat->sub_ledger_name,
                'sum' => $expanseCategoryWaysSum,
                'percentage' => round($percentage, 2)
            ];
        }

        usort($categoryPercentages, function ($a, $b) {
            return $b['sum'] <=> $a['sum'];
        });

        // Take the top 4 largest categories
        $topCategories = array_slice($categoryPercentages, 0, 3);

        // Calculate "Others"
        $othersSum = array_reduce(array_slice($categoryPercentages, 3), function ($carry, $item) {
            return $carry + $item['sum'];
        }, 0);
        $othersPercentage = $thisMonthExpenseTotalSum > 0
            ? ($othersSum / $thisMonthExpenseTotalSum) * 100
            : 0;

        // Add "Others" to the result if applicable
        if ($othersSum > 0) {
            $topCategories[] = [
                'category' => 'Others',
                'sum' => $othersSum,
                'percentage' => round($othersPercentage, 2)
            ];
        }

        return response()->json([
            'totalExpense' => $thisMonthExpenseTotalSum,
            'categoryPercentages' => $topCategories
        ]);
    }


    public function moneyFlowExpanseChart(Request $request)
    {
        $month = $request->month;
        $year = $request->query('year', Carbon::now()->year);

        // Fetch expenses grouped by day
        $expenses = Expense::select(
            DB::raw('DAY(expense_date) as day'),
            DB::raw('SUM(amount) as total_expense')
        )
            ->whereMonth('expense_date', $month)
            ->whereYear('expense_date', $year)
            ->groupBy('day')
            ->orderBy('day', 'ASC')
            ->get();

        // Generate data for all days in the selected month
        $daysInMonth = Carbon::createFromDate($year, $month)->daysInMonth;
        $dailyExpenses = [];
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $dailyExpense = $expenses->firstWhere('day', $day);
            $dailyExpenses[] = [
                'date' => $day,
                'total_expense' => $dailyExpense ? $dailyExpense->total_expense : 0
            ];
        }

        return response()->json($dailyExpenses);
    }

    ///Expanse Paid ///
    public function expansePaymentPercentage(Request $request)
    {
        $month = $request->input('month');  // Get the month (integer)

        // Validate if the month is provided
        if (!$month) {
            return response()->json(['error' => 'Month parameter is required'], 400);
        }
        $year = now()->year;

        // $expanseBill = Expense::whereMonth('expense_date', $month)
        //     ->whereYear('expense_date', $year)
        //     ->get();

        // // Total bonuses
        // $expanseBillCount = $expanseBill->where('status', '!=', null)->count();
        // $expansePaid = $expanseBill->where('status', 'paid')->count();
        // $expansePending = $expanseBill->where('status', 'pending')->count();
        // $expanseUnpaid = $expanseBill->where('status', 'approved')->count();
        // $expanseProcess = $expanseBill->where('status', 'processing')->count();

        // // Calculate percentages
        // $expansePaidPercentage = $expanseBillCount > 0 ? ($expansePaid / $expanseBillCount) * 100 : 0;
        // $expansePendingPercentage = $expanseBillCount > 0 ? ($expansePending / $expanseBillCount) * 100 : 0;
        // $expanseUnpaidPercentage = $expanseBillCount > 0 ? ($expanseUnpaid / $expanseBillCount) * 100 : 0;
        // $expanseProcessPercentage = $expanseBillCount > 0 ? ($expanseProcess / $expanseBillCount) * 100 : 0;

        // Prepare the result
        //////////////////////////////////////////////All Paid Expense percentage////////////////////////////

        $expansePaidBill = Expense::whereMonth('expense_date', $month)
            ->whereYear('expense_date', $year)
            ->get();
        $conviencePaidBill = Convenience::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
           ->get();
        $salaryPaidBill = PaySlip::whereMonth('pay_period_date', $month)
            ->whereYear('pay_period_date', $year)
            ->get();
        $recurringPaidBill = RecurringExpense::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();

            $allExpansePaidCount = $expansePaidBill->where('status', '!=', null)->count();
            $allConviencePaidCount = $conviencePaidBill->where('status', '!=', null)->count();
            $allSalaryPaidCount = $salaryPaidBill->where('status', '!=', null)->count();
            $allRecurringPaidCount = $recurringPaidBill->where('status', '!=', null)->count();

            $expansePaidCount = $expansePaidBill->where('status', 'paid')->count();
            $conviencePaidCount = $conviencePaidBill->where('status', 'paid')->count();
            $salaryPaidCount = $salaryPaidBill->where('status', 'paid')->count();
            $recurringPaidCount = $recurringPaidBill->where('status', 'paid')->count();

            $expansesPaidPercentage = $allExpansePaidCount > 0 ? ($expansePaidCount / $allExpansePaidCount) * 100 : 0;
            $conviencePaidPercentage = $allConviencePaidCount > 0 ? ($conviencePaidCount / $allConviencePaidCount) * 100 : 0;
            $salaryPaidPercentage = $allSalaryPaidCount > 0 ? ($salaryPaidCount / $allSalaryPaidCount) * 100 : 0;
            $recurringPaidPercentage = $allRecurringPaidCount > 0 ? ($recurringPaidCount / $allRecurringPaidCount) * 100 : 0;

        //////////////////////////////////////////////All Expense percentage////////////////////////////
        // $expansePercentage = [
        //     'expansePaid' => round($expansePaidPercentage, 2),
        //     'expansePending' => round($expansePendingPercentage, 2),
        //     'expanseUnpaid' => round($expanseUnpaidPercentage, 2),
        //     'expanseProcessing' => round($expanseProcessPercentage, 2),
        // ];
        $expansePercentage = [
            'expansePaid' => round($expansesPaidPercentage, 2),
            'conviencePaid' => round($conviencePaidPercentage, 2),
            'salaryPaid' => round($salaryPaidPercentage, 2),
            'recurringPaid' => round($recurringPaidPercentage, 2),
        ];

        return response()->json($expansePercentage);
    }
}
