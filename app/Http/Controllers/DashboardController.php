<?php

namespace App\Http\Controllers;

use App\Models\Assets\Assets;
use App\Models\Bank\LoanManagement\Loan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $assetValue = Assets::sum('acquisition_cost');
        $liabilities = Loan::sum('loan_balance');
        $income = Assets::sum('acquisition_cost');
        $expanse = Assets::sum('acquisition_cost');
        return view('dashboard.blank', compact('assetValue', 'liabilities', 'expanse', 'income'));
    }
}
