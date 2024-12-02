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
use Illuminate\Support\Facades\Log;

class MainDashboardApiController extends Controller
{
    public function mainDashboardData()
    {
        try {
            // Top 4 card Data //
            // Asset
            $assetTableAsset = Assets::sum('acquisition_cost');
            $bankAsset = BankAccounts::sum('current_balance');
            $cashAsset = Cash::sum('current_balance');
            $totalAsset = $assetTableAsset + $bankAsset + $cashAsset;

            // Liabilities
            $totalLiabilities = Loan::sum('loan_balance');

            // Income
            $totalIncome = 0; // Update with logic if necessary

            // Expense
            $expanseTableExpense = Expense::sum('amount');
            $convenienceExpense = Convenience::sum('total_amount');
            $salaryExpense = PaySlip::sum('total_net_salary');
            $recurringExpense = RecurringExpense::sum('amount');
            $totalExpense = $expanseTableExpense + $convenienceExpense + $salaryExpense + $recurringExpense;

            // Top 4 Card Data
            $data = [
                [
                    'id' => 1,
                    'title' => 'Asset',
                    'value' => number_format($totalAsset, 2),
                ],
                [
                    'id' => 2,
                    'title' => 'Liabilities',
                    'value' => number_format($totalLiabilities, 2),
                ],
                [
                    'id' => 3,
                    'title' => 'Income',
                    'value' => number_format($totalIncome, 2),
                ],
                [
                    'id' => 4,
                    'title' => 'Expense',
                    'value' => number_format($totalExpense, 2),
                ],
            ];

            return response()->json([
                'status' => 200,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error fetching dashboard data: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            // Return a JSON response with error information
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while fetching dashboard data.',
                'error' => $e->getMessage(), // Optional: Include for debugging (avoid in production)
            ]);
        }
    }


    //Dashboard Footer Left
    public function DashboardFooterData()
    {
        try {
            //Bank Balance
            $bankBalance = BankAccounts::sum('current_balance');
            $bankRevenue = 13.56;
            //Cash Balance
            $cashBalance = Cash::sum('current_balance');
            $cashRevenue = -13.56;
            //Assets Purchase
            $assetPurchase = Assets::where('status', 'purchased')->sum('acquisition_cost');
            $assetRevenue = 54.56;
            // Marketing Cost
            $marketingCost = 0;
            $marketingRevenue = -54.56;

            $data = [
                [
                    'id' => 1,
                    'title' => 'Cash Balance',
                    'value' => number_format($bankBalance, 2),
                    'revenue' => number_format($bankRevenue, 2),
                ],
                [
                    'id' => 2,
                    'title' => 'Bank Balance',
                    'value' => number_format($cashBalance, 2),
                    'revenue' => number_format($cashRevenue, 2),
                ],
                [
                    'id' => 3,
                    'title' => 'Assets Purchase',
                    'value' => number_format($assetPurchase, 2),
                    'revenue' => number_format($assetRevenue, 2),
                ],
                [
                    'id' => 4,
                    'title' => 'Marketing Cost',
                    'value' => number_format($marketingCost, 2),
                    'revenue' => number_format($marketingRevenue, 2),
                ],
            ];

            return response()->json([
                'status' => 200,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Dashboard Footer Data Error: ' . $e->getMessage());

            // Return a generic error response
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while fetching the dashboard footer data.',
                'error' => $e->getMessage(), // Optional: include this for debugging purposes
            ]);
        }
    }
    //Method End
}//Main End