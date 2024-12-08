<?php

namespace App\Http\Controllers\SaleDashboard;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\ServiceSale\ServiceSale;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SaleDashboardController extends Controller
{
 public function SaleDashboard(){
    $totalSalesAmount = ServiceSale::whereDate('date', Carbon::today())->sum('total');
    $totalOrderCount = ServiceSale::whereDate('date', Carbon::today())->count();
    $todayCutomer =  Customer::whereDate('created_at', Carbon::today())->count();
    $data = [
        [
        'totalSalesAmount' => $totalSalesAmount,
        'totalOrderCount' => $totalOrderCount,
        'todayCutomer' => $todayCutomer,
        ]
    ];
    return view('all_modules.sale_dashboard.sale_dashboard',compact('data'));
 }
}
