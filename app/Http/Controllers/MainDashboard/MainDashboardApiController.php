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
            $totalAsset = Assets::sum('acquisition_cost')
                + BankAccounts::sum('current_balance')
                + Cash::sum('current_balance');

            $totalLiabilities = Loan::sum('loan_balance');
            $totalIncome = 0; // Update as needed
            $totalExpense = Expense::sum('amount')
                + Convenience::sum('total_amount')
                + PaySlip::sum('total_net_salary')
                + RecurringExpense::sum('amount');

            $data = [
                ['id' => 1, 'title' => 'Asset', 'value' => number_format($totalAsset, 2)],
                ['id' => 2, 'title' => 'Liabilities', 'value' => number_format($totalLiabilities, 2)],
                ['id' => 3, 'title' => 'Income', 'value' => number_format($totalIncome, 2)],
                ['id' => 4, 'title' => 'Expense', 'value' => number_format($totalExpense, 2)],
            ];

            return response()->json(['status' => 200, 'data' => $data]);
        } catch (\Exception $e) {
            Log::error('Dashboard error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);

            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while fetching dashboard data.',
            ]);
        }
    }



    //Dashboard Footer Left
    public function DashboardFooterData()
    {
        try {
            $data = [
                [
                    'id' => 1,
                    'title' => 'Cash Balance',
                    'value' => number_format(BankAccounts::sum('current_balance'), 2),
                    'revenue' => number_format(13.56, 2),
                ],
                [
                    'id' => 2,
                    'title' => 'Bank Balance',
                    'value' => number_format(Cash::sum('current_balance'), 2),
                    'revenue' => number_format(-13.56, 2),
                ],
                [
                    'id' => 3,
                    'title' => 'Assets Purchase',
                    'value' => number_format(Assets::where('status', 'purchased')->sum('acquisition_cost'), 2),
                    'revenue' => number_format(54.56, 2),
                ],
                [
                    'id' => 4,
                    'title' => 'Marketing Cost',
                    'value' => number_format(0, 2),
                    'revenue' => number_format(-54.56, 2),
                ],
            ];

            return response()->json(['status' => 200, 'data' => $data]);
        } catch (\Exception $e) {
            Log::error('Dashboard Footer Data Error: ' . $e->getMessage());

            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while fetching the dashboard footer data.',
            ]);
        }
    }



    public function profitLoss()
    {
        try {
            $data = [
                ['name' => 'Jan', 'profit' => number_format(1200, 2), 'loss' => number_format(500, 2)],
                ['name' => 'Feb', 'profit' => number_format(899, 2), 'loss' => number_format(100, 2)],
                ['name' => 'Mar', 'profit' => number_format(1700, 2), 'loss' => number_format(300, 2)],
                ['name' => 'Apr', 'profit' => number_format(400, 2), 'loss' => number_format(700, 2)],
                ['name' => 'May', 'profit' => number_format(1500, 2), 'loss' => number_format(800, 2)],
                ['name' => 'Jun', 'profit' => number_format(2000, 2), 'loss' => number_format(400, 2)],
                ['name' => 'Jul', 'profit' => number_format(1300, 2), 'loss' => number_format(900, 2)],
                ['name' => 'Aug', 'profit' => number_format(1800, 2), 'loss' => number_format(600, 2)],
                ['name' => 'Sep', 'profit' => number_format(1100, 2), 'loss' => number_format(500, 2)],
                ['name' => 'Oct', 'profit' => number_format(1400, 2), 'loss' => number_format(700, 2)],
                ['name' => 'Nov', 'profit' => number_format(1700, 2), 'loss' => number_format(300, 2)],
                ['name' => 'Dec', 'profit' => number_format(1900, 2), 'loss' => number_format(400, 2)],
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
                'message' => 'An error occurred while fetching the dashboard profit Loss data.',
                'error' => $e->getMessage(), // Optional: include this for debugging purposes
            ]);
        }
    }//End Method
    public function costInAndOut(){
        try {
             $receivableData = [
                8000, 2000, 2780, 1890, 2390, 3490, 6778, 3490, 9283, 2347, 3490, 6778,
              ];
            $payableData = [
                2400, 1398, 9800, 3908, 4800, 3800, 4300, 3490, 3763, 1247, 4589, 2346,
              ];
            return response()->json([
                'status' => 200,
                'receivableData' => $receivableData,
                'payableData' => $payableData,
            ]);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Dashboard Footer Data Error: ' . $e->getMessage());

            // Return a generic error response
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while fetching the dashboard cost in and out.',
                'error' => $e->getMessage(), // Optional: include this for debugging purposes
            ]);
        }
    }

}//Main End
