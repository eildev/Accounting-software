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

        // Calculate percentages
        $successfullyPaidPercentage = $totalBonusesCount > 0 ? ($successfullyPaid / $totalBonusesCount) * 100 : 0;
        $pendingPercentage = $totalBonusesCount > 0 ? ($pending / $totalBonusesCount) * 100 : 0;
        $unpaidPercentage = $totalBonusesCount > 0 ? ($unpaid / $totalBonusesCount) * 100 : 0;

        // Prepare the result
        $result = [
            'Paid' => round($successfullyPaidPercentage, 2) . '%',
            'Pending' => round($pendingPercentage, 2) . '%',
            'Unpaid' => round($unpaidPercentage, 2) . '%',
        ];
        ////////////////////////////////////////////////Salary ///////////////////////////////////////////////////////
        //Invoice Count
        $salaryInvoiceCount = PaySlip::count();
        //All Salary  Amount Sum
        $allSalaryAmountSum = PaySlip::sum('total_net_salary');
        //all Paid Salary
        $allPaidSalarySum = PaySlip::where('status', 'paid')->sum('total_net_salary');
        //all pending Salary
        $allPendingSalarySum = PaySlip::where('status', 'pending')->sum('total_net_salary');
        //all Due Salary
        $allDueSalarySum = PaySlip::where('status', 'due')->sum('total_net_salary');
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
        /////////////////////////////////////////////// Net Salary(Payslip)  ////////////////////////////////////////////////////
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
            'salaryInvoiceCount' => $salaryInvoiceCount,
            'allSalaryAmountSum' => $allSalaryAmountSum,
            'allPaidSalarySum' => $allPaidSalarySum,
            'allPendingSalarySum' => $allPendingSalarySum,
            'allDueSalarySum' => $allDueSalarySum,
            'netSalarys' => $netSalarys,
            'result' =>  $result,
            'movementCostSum' => $movementCostSum,
            'overNightCostSum' => $overNightCostSum,
            'foodingCostSum' => $foodingCostSum,
            'otherCostSum' => $otherCostSum,
            'convenienceDataSum' => $convenienceDataSum,
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

        // Calculate percentages
        $successfullyPaidPercentage = $totalBonusesCount > 0 ? ($successfullyPaid / $totalBonusesCount) * 100 : 0;
        $pendingPercentage = $totalBonusesCount > 0 ? ($pending / $totalBonusesCount) * 100 : 0;
        $unpaidPercentage = $totalBonusesCount > 0 ? ($unpaid / $totalBonusesCount) * 100 : 0;

        // Prepare the result
        $result = [
            'Paid' => round($successfullyPaidPercentage, 2) . '%',
            'Pending' => round($pendingPercentage, 2) . '%',
            'Unpaid' => round($unpaidPercentage, 2) . '%',
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

        // Calculate percentages
        $successfullyPaidPercentage = $totalBonusesCount > 0 ? ($successfullyPaid / $totalBonusesCount) * 100 : 0;
        $pendingPercentage = $totalBonusesCount > 0 ? ($pending / $totalBonusesCount) * 100 : 0;
        $unpaidPercentage = $totalBonusesCount > 0 ? ($unpaid / $totalBonusesCount) * 100 : 0;

        // Prepare the result
        $result = [
            'Paid' => round($successfullyPaidPercentage, 2) . '%',
            'Pending' => round($pendingPercentage, 2) . '%',
            'Unpaid' => round($unpaidPercentage, 2) . '%',
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

        // Calculate percentages
        $successfullyPaidPercentage = $totalBonusesCount > 0 ? ($successfullyPaid / $totalBonusesCount) * 100 : 0;
        $pendingPercentage = $totalBonusesCount > 0 ? ($pending / $totalBonusesCount) * 100 : 0;
        $unpaidPercentage = $totalBonusesCount > 0 ? ($unpaid / $totalBonusesCount) * 100 : 0;

        // Prepare the result
        $result = [
            'Paid' => round($successfullyPaidPercentage, 2) . '%',
            'Pending' => round($pendingPercentage, 2) . '%',
            'Unpaid' => round($unpaidPercentage, 2) . '%',
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


}//Main End
