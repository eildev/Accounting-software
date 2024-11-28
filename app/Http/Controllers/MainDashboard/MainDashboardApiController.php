<?php

namespace App\Http\Controllers\MainDashboard;

use App\Http\Controllers\Controller;
use App\Models\Assets\Assets;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Http\Request;

class MainDashboardApiController extends Controller
{
    public function mainDashboardData(){
                 //Top 4 card Data //
        $totalAsset = Assets::sum('acquisition_cost');
        // $totalLiabilities = ::sum('');
        // $totalIncome = ::sum('');
        $totalExpense= Expense::sum('amount');
                //Top 4 card Data End//
        return response()->json([
            'totalAsset' => $totalAsset,
            'totalExpense' => $totalExpense
        ]);
    }
}
