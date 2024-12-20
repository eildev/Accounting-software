<?php

namespace App\Http\Controllers\EmployeePayroll;

use App\Http\Controllers\Controller;
use App\Models\ConvenienceBill\Convenience;
use App\Models\ConvenienceBill\FoodingCost;
use App\Models\ConvenienceBill\MovementCost;
use App\Models\ConvenienceBill\OtherExpenseCost;
use App\Models\ConvenienceBill\OvernightCost;
use App\Models\Departments\Departments;
use App\Models\EmployeePayroll\Employee;
use App\Models\EmployeePayroll\EmployeeBonuse;
use App\Models\EmployeePayroll\PaySlip;
use App\Models\EmployeeSalary;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PayrollDashboardController extends Controller
{
    public function payrollDashboard()
    {
        /////////////////////////////////////////////Bonus////////////////////////////////////////////////////
        //performance, festival, other Bonus Sum
        //performance
        $performanceBonusesSum = EmployeeBonuse::whereYear('bonus_date', Carbon::now()->year)
            ->whereMonth('bonus_date', Carbon::now()->month)
            ->where('bonus_type', 'performance')
            ->sum('bonus_amount');
        ///festival//
        $festivalBonusesSum = EmployeeBonuse::whereYear('bonus_date', Carbon::now()->year)
            ->whereMonth('bonus_date', Carbon::now()->month)
            ->where('bonus_type', 'festival')
            ->sum('bonus_amount');
        //other
        $otherBonusesSum = EmployeeBonuse::whereYear('bonus_date', Carbon::now()->year)
            ->whereMonth('bonus_date', Carbon::now()->month)
            ->where('bonus_type', 'other')
            ->sum('bonus_amount');
        //Paid Bonus Sum
        $totalPaidBonusSum = EmployeeBonuse::where('status', 'paid')->sum('bonus_amount');
        //Pending Bonus Sum
        $totalPendingBonusSum = EmployeeBonuse::where('status', 'pending')->sum('bonus_amount');
        //Due Bonus Sum
        $totalDueBonusSum = EmployeeBonuse::where('status', 'due')->sum('bonus_amount');

        //PERCENTAGE MONTH BONUS
        $festivalBonuses = EmployeeBonuse::whereMonth('bonus_date', Carbon::now())
            ->where('bonus_type', 'festival')
            ->get();

        // Total bonuses
        $totalBonusesCount = $festivalBonuses->count();
        // Group bonuses by status
        $successfullyPaid = $festivalBonuses->where('status', 'paid')->count();
        $pending = $festivalBonuses->where('status', 'pending')->count();
        $unpaid = $festivalBonuses->where('status', 'approved')->count();
        $processing = $festivalBonuses->where('status', 'processing')->count();
        $canceled = $festivalBonuses->where('status', 'canceled')->count();
        // Calculate percentages
        $successfullyPaidPercentage = $totalBonusesCount > 0 ? ($successfullyPaid / $totalBonusesCount) * 100 : 0;
        $pendingPercentage = $totalBonusesCount > 0 ? ($pending / $totalBonusesCount) * 100 : 0;
        $unpaidPercentage = $totalBonusesCount > 0 ? ($unpaid / $totalBonusesCount) * 100 : 0;
        $processingPercentage = $totalBonusesCount > 0 ? ($processing / $totalBonusesCount) * 100 : 0;
        $canceledPercentage = $totalBonusesCount > 0 ? ($canceled / $totalBonusesCount) * 100 : 0;

        // Prepare the result
        $result = [
            'Paid' => round($successfullyPaidPercentage, 2) . '%',
            'Pending' => round($pendingPercentage, 2) . '%',
            'Unpaid' => round($unpaidPercentage, 2) . '%',
            'Processing' => round($processingPercentage, 2) . '%',
            'Canceled' => round($canceledPercentage, 2) . '%',
        ];
        ////////////////////////////////////////////////Salary Donut Chart///////////////////////////////////////////////////////

        //pending percentage
        $paySlipAll = PaySlip::whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->get();

        $paySlipBillCount = $paySlipAll->count();
        // Group bonuses by status
        $paySlipPaid = $paySlipAll->where('status', 'paid')->count();
        $paySlipPending = $paySlipAll->where('status', 'pending')->count();
        $paySlipUnpaid = $paySlipAll->where('status', 'approved')->count();
        $paySlipProcess = $paySlipAll->where('status', 'processing')->count();

        // Calculate percentages
        $paySlipPaidPercentage = $paySlipBillCount > 0 ? ($paySlipPaid / $paySlipBillCount) * 100 : 0;
        $paySlipPendingPercentage = $paySlipBillCount > 0 ? ($paySlipPending / $paySlipBillCount) * 100 : 0;
        $paySlipUnpaidPercentage = $paySlipBillCount > 0 ? ($paySlipUnpaid / $paySlipBillCount) * 100 : 0;
        $paySlipProcessPercentage = $paySlipBillCount > 0 ? ($paySlipProcess / $paySlipBillCount) * 100 : 0;

        // Prepare the result
        $paySlipsPercentage = [
           'paySlipPaid' => round($paySlipPaidPercentage, 2),
            'paySlipPending' => round($paySlipPendingPercentage, 2),
            'paySlipUnpaid' => round($paySlipUnpaidPercentage, 2),
            'paySlipProcessing' => round($paySlipProcessPercentage, 2),
        ];
        /////////////////////////Salary Area Chart ///////////////////////

        /////////////////////////////////////////////// Convinience ////////////////////////////////////////////////////
        //all Convinience Bill
        $convenienceDataSum = Convenience::whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->sum('total_amount');
        $movementCost = MovementCost::whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->get();
        $movementCostSum = MovementCost::sum('total_amount');
        $overNightCost = OvernightCost::whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->get();
        $overNightCostSum = OvernightCost::sum('total_amount');
        $foodingCost = FoodingCost::whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->get();
        $foodingCostSum = FoodingCost::sum('total_amount');
        $otherCost = OtherExpenseCost::whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->get();
        $otherCostSum = OtherExpenseCost::sum('total_amount');

        $convenienceBill = Convenience::whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->get();

        // Total bonuses
        $convenienceBillCount = $convenienceBill->count();
        // Group bonuses by status
        $conveniencePaid = $convenienceBill->where('status', 'paid')->count();
        $conveniencePending = $convenienceBill->where('status', 'pending')->count();
        $convenienceUnpaid = $convenienceBill->where('status', 'approved')->count();
        $convenienceProcess = $convenienceBill->where('status', 'processing')->count();
        $convenienceCanceled = $convenienceBill->where('status', 'canceled')->count();

        // Calculate percentages
        $conveniencePaidPercentage = $convenienceBillCount > 0 ? ($conveniencePaid / $convenienceBillCount) * 100 : 0;
        $conveniencePendingPercentage = $convenienceBillCount > 0 ? ($conveniencePending / $convenienceBillCount) * 100 : 0;
        $convenienceUnpaidPercentage = $convenienceBillCount > 0 ? ($convenienceUnpaid / $convenienceBillCount) * 100 : 0;
        $convenienceProcessPercentage = $convenienceBillCount > 0 ? ($convenienceProcess / $convenienceBillCount) * 100 : 0;
        $convenienceCanceledPercentage = $convenienceBillCount > 0 ? ($convenienceCanceled / $convenienceBillCount) * 100 : 0;

        // Prepare the result
        $conveniencePercentage = [
            'conveniencePaid' => round($conveniencePaidPercentage, 2) . '%',
            'conveniencePending' => round($conveniencePendingPercentage, 2) . '%',
            'convenienceUnpaid' => round($convenienceUnpaidPercentage, 2) . '%',
            'conveniencePrecessing' => round($convenienceProcessPercentage, 2) . '%',
            'convenienceCanceled' => round($convenienceCanceledPercentage, 2) . '%',
        ];
        /////////////////////////////////////////////// Net Salary table (Payslip)  ////////////////////////////////////////////////////
        //All Net Salary
        $netSalarys = PaySlip::whereMonth('pay_period_date', Carbon::now()->month)
        ->whereYear('pay_period_date', Carbon::now()->year)
        ->get();

        $data = [
            'departmentsCount' => Departments::count(),
            'employeesCount' => Employee::count(),
            'performanceBonusesSum' => $performanceBonusesSum,
            'festivalBonusesSum' => $festivalBonusesSum,
            'otherBonusesSum' => $otherBonusesSum,
            'totalPaidBonusSum' => $totalPaidBonusSum,
            'totalPendingBonusSum' => $totalPendingBonusSum,
            'totalDueBonusSum' => $totalDueBonusSum,
            'netSalarys' => $netSalarys,
            'result' =>  $result,
            'movementCostSum' => $movementCostSum,
            'overNightCostSum' => $overNightCostSum,
            'foodingCostSum' => $foodingCostSum,
            'otherCostSum' => $otherCostSum,
            'convenienceDataSum' => $convenienceDataSum,
            'conveniencePercentage' => $conveniencePercentage,
            'paySlipsPercentage' => $paySlipsPercentage,
            // 'paySlipsArea' => $paySlipsArea,
        ];
        return view('all_modules.payroll_dashboard.payroll_dashboard', compact('data'));
    }

    public function getMonthBonus(Request $request)
    {
        $month = $request->input('month');

        // Fetch data based on the selected month (example query)
        $festivalBonusesSum = EmployeeBonuse::whereYear('bonus_date', Carbon::now()->year)
            ->whereMonth('bonus_date',  $month)
            ->where('bonus_type', 'festival')
            ->sum('bonus_amount');

        $performanceBonusesSum = EmployeeBonuse::whereYear('bonus_date', Carbon::now()->year)
            ->whereMonth('bonus_date', $month)
            ->where('bonus_type', 'performance')
            ->sum('bonus_amount');

        $otherBonusesSum = EmployeeBonuse::whereYear('bonus_date', Carbon::now()->year)
            ->whereMonth('bonus_date', $month)
            ->where('bonus_type', 'other')
            ->sum('bonus_amount');

        return response()->json([
            'festivalBonusesSum' => $festivalBonusesSum,
            'performanceBonusesSum' => $performanceBonusesSum,
            'otherBonusesSum' => $otherBonusesSum,
            'month' => $month,

        ]);
    }
    ///Percentage  Festival
    public function getFestivalPercentage(Request $request)
    {
        $month = $request->input('month');
        $festivalBonuses = EmployeeBonuse::whereMonth('bonus_date', $month)
            ->where('bonus_type', 'festival')
            ->get();

        // Total bonuses
        $totalBonusesCount = $festivalBonuses->count();

        // Group bonuses by status
        $successfullyPaid = $festivalBonuses->where('status', 'paid')->count();
        $pending = $festivalBonuses->where('status', 'pending')->count();
        $unpaid = $festivalBonuses->where('status', 'approved')->count();
        $processing = $festivalBonuses->where('status', 'processing')->count();
        $canceled = $festivalBonuses->where('status', 'canceled')->count();
        // Calculate percentages
        $successfullyPaidPercentage = $totalBonusesCount > 0 ? ($successfullyPaid / $totalBonusesCount) * 100 : 0;
        $pendingPercentage = $totalBonusesCount > 0 ? ($pending / $totalBonusesCount) * 100 : 0;
        $unpaidPercentage = $totalBonusesCount > 0 ? ($unpaid / $totalBonusesCount) * 100 : 0;
        $processsingPercentage = $totalBonusesCount > 0 ? ($processing / $totalBonusesCount) * 100 : 0;
        $canceledPercentage = $totalBonusesCount > 0 ? ($canceled / $totalBonusesCount) * 100 : 0;

        // Prepare the result
        $result = [
            'Paid' => round($successfullyPaidPercentage, 2) . '%',
            'Pending' => round($pendingPercentage, 2) . '%',
            'Unpaid' => round($unpaidPercentage, 2) . '%',
            'Processing' => round($processsingPercentage, 2) . '%',
            'Canceled' => round($canceledPercentage, 2) . '%',
        ];

        // Return the response
        return response()->json([
            'result' => $result
        ]);
    }
    //Percentage  Performance
    public function getperformancePercentage(Request $request)
    {
        $month = $request->input('month');

        $performanceBonuses = EmployeeBonuse::whereMonth('bonus_date', $month)
            ->where('bonus_type', 'performance')
            ->get();

        // Total bonuses
        $totalBonusesCount = $performanceBonuses->count();

        // Group bonuses by status
        $successfullyPaid = $performanceBonuses->where('status', 'paid')->count();
        $pending = $performanceBonuses->where('status', 'pending')->count();
        $unpaid = $performanceBonuses->where('status', 'approved')->count();
        $processing = $performanceBonuses->where('status', 'processing')->count();
        $canceled = $performanceBonuses->where('status', 'canceled')->count();
        // Calculate percentages
        $successfullyPaidPercentage = $totalBonusesCount > 0 ? ($successfullyPaid / $totalBonusesCount) * 100 : 0;
        $pendingPercentage = $totalBonusesCount > 0 ? ($pending / $totalBonusesCount) * 100 : 0;
        $unpaidPercentage = $totalBonusesCount > 0 ? ($unpaid / $totalBonusesCount) * 100 : 0;
        $processsingPercentage = $totalBonusesCount > 0 ? ($processing / $totalBonusesCount) * 100 : 0;
        $canceledPercentage = $totalBonusesCount > 0 ? ($canceled / $totalBonusesCount) * 100 : 0;
        // Prepare the result
        $result = [
            'Paid' => round($successfullyPaidPercentage, 2) . '%',
            'Pending' => round($pendingPercentage, 2) . '%',
            'Unpaid' => round($unpaidPercentage, 2) . '%',
            'Processing' => round($processsingPercentage, 2) . '%',
            'Canceled' => round($canceledPercentage, 2) . '%',
        ];

        // Return the response
        return response()->json([
            'result' => $result
        ]);
    }
    //performance Other
    public function getOtherPercentage(Request $request)
    {
        $month = $request->input('month');

        $otherBonuses = EmployeeBonuse::whereMonth('bonus_date', $month)
            ->where('bonus_type', 'other')
            ->get();

        // Total bonuses
        $totalBonusesCount = $otherBonuses->count();

        // Group bonuses by status
        $successfullyPaid = $otherBonuses->where('status', 'paid')->count();
        $pending = $otherBonuses->where('status', 'pending')->count();
        $unpaid = $otherBonuses->where('status', 'approved')->count();
        $processing = $otherBonuses->where('status', 'processing')->count();
        $canceled = $otherBonuses->where('status', 'canceled')->count();
        // Calculate percentages
        $successfullyPaidPercentage = $totalBonusesCount > 0 ? ($successfullyPaid / $totalBonusesCount) * 100 : 0;
        $pendingPercentage = $totalBonusesCount > 0 ? ($pending / $totalBonusesCount) * 100 : 0;
        $unpaidPercentage = $totalBonusesCount > 0 ? ($unpaid / $totalBonusesCount) * 100 : 0;
        $processsingPercentage = $totalBonusesCount > 0 ? ($processing / $totalBonusesCount) * 100 : 0;
        $canceledPercentage = $totalBonusesCount > 0 ? ($canceled / $totalBonusesCount) * 100 : 0;
        // Prepare the result
        $result = [
            'Paid' => round($successfullyPaidPercentage, 2) . '%',
            'Pending' => round($pendingPercentage, 2) . '%',
            'Unpaid' => round($unpaidPercentage, 2) . '%',
            'Processing' => round($processsingPercentage, 2) . '%',
            'Canceled' => round($canceledPercentage, 2) . '%',
        ];

        // Return the response
        return response()->json([
            'result' => $result
        ]);
    }
    public function getConvenienceMonth(Request $request){

        $month = $request->input('month');
        // Fetch data based on the selected month (example query)
        $movementCost = MovementCost::whereMonth('created_at', $month)
        ->whereYear('created_at', Carbon::now()->year)
        ->sum('total_amount');

        $overNightCost = OvernightCost::whereMonth('created_at', $month)
        ->whereYear('created_at', Carbon::now()->year)
        ->sum('total_amount');

        $foodingCost = FoodingCost::whereMonth('created_at', $month)
        ->whereYear('created_at', Carbon::now()->year)
        ->sum('total_amount');
        $otherCost = OtherExpenseCost::whereMonth('created_at',$month)
        ->whereYear('created_at', Carbon::now()->year)
        ->sum('total_amount');

        return response()->json([
            'movementCost' => $movementCost,
            'overNightCost' => $overNightCost,
            'foodingCost' => $foodingCost,
            'otherCost' => $otherCost,
        ]);
    }
    //donut chart
    public function getPaySlipsMonthData(Request $request)
    {
        $selectedMonth = $request->month ?? Carbon::now()->month;

        $paySlipAll = PaySlip::whereMonth('created_at', $selectedMonth)
            ->whereYear('created_at', Carbon::now()->year)
            ->get();

        $paySlipBillCount = $paySlipAll->count();
        $paySlipPaid = $paySlipAll->where('status', 'paid')->count();
        $paySlipPending = $paySlipAll->where('status', 'pending')->count();
        $paySlipUnpaid = $paySlipAll->where('status', 'approved')->count();
        $paySlipProcess = $paySlipAll->where('status', 'processing')->count();
        $paySlipCanceled = $paySlipAll->where('status', 'canceled')->count();
        return response()->json([
            'paySlipPaid' => $paySlipBillCount > 0 ? round(($paySlipPaid / $paySlipBillCount) * 100, 2) : 0,
            'paySlipPending' => $paySlipBillCount > 0 ? round(($paySlipPending / $paySlipBillCount) * 100, 2) : 0,
            'paySlipUnpaid' => $paySlipBillCount > 0 ? round(($paySlipUnpaid / $paySlipBillCount) * 100, 2) : 0,
            'paySlipProcessing' => $paySlipBillCount > 0 ? round(($paySlipProcess / $paySlipBillCount) * 100, 2) : 0,
            'paySlipCanceled' => $paySlipBillCount > 0 ? round(($paySlipCanceled / $paySlipBillCount) * 100, 2) : 0,
        ]);
    }

    public function fetchYearlyAreaChart(Request $request)
    {
        $year = $request->input('year');  // Get the selected year

        // Fetch the salary data for the selected year
        $paySlipsArea = PaySlip::selectRaw('MONTH(pay_period_date) as month, SUM(total_net_salary) as total_paid')
                                ->where('status', 'paid')
                                ->whereYear('pay_period_date', $year)
                                ->groupBy('month')
                                ->orderBy('month', 'asc')
                                ->get();

        // Prepare data for chart (monthly totals)
        $months = $paySlipsArea->pluck('month')->toArray();
        $totals = $paySlipsArea->pluck('total_paid')->toArray();

        // Return data as JSON
        return response()->json([
            'months' => $months,
            'totals' => $totals
        ]);
    }

    public function FilterSalariesTable(Request $request){
        $perPage = $request->query('perPage', 5);                // Items per page
        $page = $request->query('page', 1);
        $month = $request->month;
        $year = Carbon::now()->year;
        $page = $request->query('page', 1);
        // Fetch salaries filtered by month and year
        $netSalarys = PaySlip::whereMonth('pay_period_date', $month)
            ->whereYear('pay_period_date', $year)
            ->with('employee') // Load employee data for display
            ->paginate($perPage, ['*'], 'page', $page);
        // Return JSON response
        return response()->json([
            'netSalarys' => $netSalarys,
            'current_page' => $netSalarys->currentPage(),
            'last_page' => $netSalarys->lastPage(),
            'per_page' => $perPage,
        ]);
    }
}//Main End
