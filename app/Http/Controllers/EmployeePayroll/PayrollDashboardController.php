<?php

namespace App\Http\Controllers\EmployeePayroll;

use App\Http\Controllers\Controller;
use App\Models\ConvenienceBill\Convenience;
use App\Models\Departments\Departments;
use App\Models\EmployeePayroll\Employee;
use App\Models\EmployeePayroll\EmployeeBonuse;
use App\Models\EmployeePayroll\PaySlip;
use App\Models\EmployeeSalary;
use Illuminate\Http\Request;

class PayrollDashboardController extends Controller
{
    public function payrollDashboard(){
        /////////////////////////Bonus///////////////////////
        //performance, festival, other Bonus Count
        $performanceBonusesCount = EmployeeBonuse::where('bonus_type', 'performance')->count();
        $festivalBonusesCount = EmployeeBonuse::where('bonus_type', 'festival')->count();
        $otherBonusesCount = EmployeeBonuse::where('bonus_type', 'other')->count();
        //Paid Bonus Sum
        $totalPaidBonusSum = EmployeeBonuse::where('status', 'paid')->sum('bonus_amount');
        //Pending Bonus Sum
        $totalPendingBonusSum = EmployeeBonuse::where('status', 'pending')->sum('bonus_amount');
         //Due Bonus Sum
         $totalDueBonusSum = EmployeeBonuse::where('status', 'due')->sum('bonus_amount');
         //////////////////////////Salary /////////////////////////
         //Invoice Count
         $salaryInvoiceCount = PaySlip::count();
         //All Salary  Amount Sum
         $allSalaryAmountSum = PaySlip::sum('total_net_salary');
         //all Paid Salary
         $allPaidSalarySum = PaySlip::where('status', 'paid')->sum('total_net_salary');
          //all pending Salary
         $allPendingSalarySum = PaySlip::where('status', 'pending')->sum('total_net_salary');
          //all Due Salary
         $allDueSalarySum = PaySlip::where('status','due')->sum('total_net_salary');
           ////////////////////////// Convinience //////////////////////
         //all Convinience Bill
          $convenienceCount = Convenience::count();
          //All paid Convenience
          $allPaidConveniencSum = Convenience::where('status', 'paid')->sum('total_amount');
          $allDueConveniencSum = Convenience::where('status','due')->sum('total_amount');
            $data = [
                'departmentsCount' => Departments::count(),
                'employeesCount' => Employee::count(),
                'performanceBonusesCount' => $performanceBonusesCount,
                'festivalBonusesCount' => $festivalBonusesCount,
                'otherBonusesCount' => $otherBonusesCount,
                'totalPaidBonusSum' => $totalPaidBonusSum,
                'totalPendingBonusSum' => $totalPendingBonusSum,
                'totalDueBonusSum' => $totalDueBonusSum,
                'salaryInvoiceCount' => $salaryInvoiceCount,
                'allSalaryAmountSum' => $allSalaryAmountSum,
                'allPaidSalarySum' => $allPaidSalarySum,
                'allPendingSalarySum' => $allPendingSalarySum,
                'allDueSalarySum' => $allDueSalarySum,
                'convenienceCount' => $convenienceCount,
                'allPaidConveniencSum' => $allPaidConveniencSum,
                'allDueConveniencSum' => $allDueConveniencSum,
            ];
        return view('all_modules.payroll_dashboard.payroll_dashboard', compact('data')) ;
    }
}//Main End
