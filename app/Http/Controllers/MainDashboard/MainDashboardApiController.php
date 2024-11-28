<?php

namespace App\Http\Controllers\MainDashboard;

use App\Http\Controllers\Controller;
use App\Models\Assets\Assets;
use App\Models\Bank\BankAccounts;
use App\Models\Bank\Cash;
use App\Models\Bank\LoanManagement\Loan;
use App\Models\ConvenienceBill\Convenience;
use App\Models\EmployeePayroll\PaySlip;
use App\Models\Expanse\RecurringExpense\RecurringExpense;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Http\Request;

class MainDashboardApiController extends Controller
{
    public function mainDashboardData()
    {
        //Top 4 card Data //
        //Asset
        $assetTableAseet = Assets::sum('acquisition_cost');
        $bankAsset = BankAccounts::sum('current_balance');
        $cashAsset = Cash::sum('current_balance');
        $totalAsset = $assetTableAseet + $bankAsset + $cashAsset;
        //Liabilities
        $totalLiabilities = Loan::sum('loan_balance');
        //Income
        $totalIncome = 00;
        //Expanse
        $expanseTableExpense = Expense::sum('amount');
        $convenienceExpanse = Convenience::sum('total_amount');
        $salaryExpanse = PaySlip::sum('total_net_salary');
        $recurringExpanse = RecurringExpense::sum('amount');
        $totalExpanse = $expanseTableExpense + $convenienceExpanse + $salaryExpanse + $recurringExpanse;
        //Top 4 Card Data End//
        //Assets Purchase
        $assetPurchase = Assets::where('status','purchased')->sum('acquisition_cost');

        return response()->json([
            [
                'id' => 1,
                'name' => 'Asset',
                'value' => number_format($totalAsset,2),
            ],
            [
                'id' => 2,
                'name' => 'Liabilities',
                'value' => number_format($totalLiabilities,2),
            ],
            [
                'id' => 3,
                'name' => 'Income',
                'value' => number_format($totalIncome,2),
            ],
            [
                'id' => 4,
                'name' => 'Expense',
                'value' => number_format($totalExpanse,2),
            ],
            [
                'id' => 5,
                'name' => 'Cash Balance',
                'value' => number_format($cashAsset,2),
            ],
            [
                'id' => 6,
                'name' => 'Bank Balance',
                'value' => number_format($bankAsset,2),
            ],
            [
                'id' => 7,
                'name' => 'Assets Purchase',
                'value' => number_format($assetPurchase,2),
            ],
        ]);
    }//Method End
}//Main End
