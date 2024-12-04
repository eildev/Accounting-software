<?php

namespace App\Http\Controllers\SaleDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SaleDashboardController extends Controller
{
 public function SaleDashboard(){
    return view('all_modules.sale_dashboard.sale_dashboard');
 }
}
