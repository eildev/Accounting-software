<?php

namespace App\Http\Controllers\Expanse\ExpanseDashboard;

use App\Http\Controllers\Controller;
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

    public function expansePaymentPercentage(Request $request){
        $month = $request->input('month');



        $data = [
            'series' => [
                rand(10, 100), // Random percentage for category 1
                rand(10, 100), // Random percentage for category 2
                rand(10, 100), // Random percentage for category 3
                rand(10, 100), // Random percentage for category 4
            ],
            'month' => $month
        ];

        return response()->json($data);
    }
}
