<?php

namespace App\Http\Controllers\Expanse\ExpanseDashboard;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;
use Carbon\Carbon;
class ExpanseDashboardController extends Controller
{
    public function expanseDashboard(){
        $currentMonth = Carbon::now();
        $previousMonth = Carbon::now()->subMonth();

        $thisMonth = Expense::whereMonth('expense_date', $currentMonth->month)
            ->whereYear('expense_date', $currentMonth->year)
            ->sum('amount');

        $lastMonth = Expense::whereMonth('expense_date', $previousMonth->month)
            ->whereYear('expense_date', $previousMonth->year)
            ->sum('amount');
        $updateThisMonth =  $thisMonth - $lastMonth;
        return view('all_modules.expense.expanse_dashboard.expanse_dashboard',[
            'thisMonth' => $thisMonth,
            'lastMonth' => $lastMonth,
        ]);
    }
    public function expanseaAtivitiesFilter(Request $request){
        $perPage = $request->query('perPage', 5);                // Items per page
        $page = $request->query('page', 1);
        $month = $request->query('month', Carbon::now()->month); // Default to current month
        $year = $request->query('year', Carbon::now()->year);    // Default to current year

        $activities = Expense::with(['expenseCat', 'bank','cash'])
        ->whereMonth('expense_date', $month)
            ->whereYear('expense_date', $year)
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json($activities);
    }
}
