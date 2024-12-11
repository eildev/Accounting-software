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

    //Dashboard Profit Loss api controller
    public function profitLoss()
    {
        try {
            $data = [
                ['name' => 'Jan', 'profit' => 1200, 'loss' => 500],
                ['name' => 'Feb', 'profit' => 899, 'loss' => 100],
                ['name' => 'Mar', 'profit' => 1700, 'loss' => 300],
                ['name' => 'Apr', 'profit' => 400, 'loss' => 700],
                ['name' => 'May', 'profit' => 1500, 'loss' => 800],
                ['name' => 'Jun', 'profit' => 2000, 'loss' => 400],
                ['name' => 'Jul', 'profit' => 1300, 'loss' => 900],
                ['name' => 'Aug', 'profit' => 1800, 'loss' => 600],
                ['name' => 'Sep', 'profit' => 1100, 'loss' => 500],
                ['name' => 'Oct', 'profit' => 1400, 'loss' => 700],
                ['name' => 'Nov', 'profit' => 1700, 'loss' => 300],
                ['name' => 'Dec', 'profit' => 1900, 'loss' => 400],
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
    } //End Method
    public function costInAndOut()
    {
        try {
            $receivableData = [
                8000,
                2000,
                2780,
                1890,
                2390,
                3490,
                6778,
                3490,
                9283,
                2347,
                3490,
                6778,
            ];
            $payableData = [
                2400,
                1398,
                9800,
                3908,
                4800,
                3800,
                4300,
                3490,
                3763,
                1247,
                4589,
                2346,
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

    //Dashboard sale Analytics api controller
    public function saleAnalytics()
    {
        try {
            $data = [
                ['value' => 1200, 'label' => "Graphics"],
                ['value' => 899, 'label' => "Website"],
                ['value' => 1700, 'label' => 'E-commerce'],
            ];

            $total = number_format(3799, 2);

            return response()->json([
                'status' => 200,
                'data' => $data,
                'total' => $total,
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
    }
    public function purchaseReport()
    {
        try {
            $data = [
                ["name" => "Jan", "uv" => 4000, "pv" => 2400,],
                ["name" => "Mar", "uv" => 3000, "pv" => 1398,],
                ["name" => "May", "uv" => 2000, "pv" => 9800,],
                ["name" => "Jul", "uv" => 2780, "pv" => 3908,],
                ["name" => "Sep", "uv" => 1890, "pv" => 4800,],
                ["name" => "Nov", "uv" => 2390, "pv" => 3800,],
            ];

            $total = number_format(3799, 2);

            return response()->json([
                'status' => 200,
                'data' => $data,
                'total' => $total,
            ]);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Dashboard Footer Data Error: ' . $e->getMessage());

            // Return a generic error response
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while fetching the dashboard Purchase Report',
                'error' => $e->getMessage(), // Optional: include this for debugging purposes
            ]);
        }
    }
}//Main End