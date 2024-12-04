<?php

namespace App\Http\Controllers\CustomerPayableDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerPayableDashboardController extends Controller
{

    public function customerPayableDashboard(){
        return view('all_modules.customer_payable_dashboard.customer_payable_dashboard');
    }
    //End Method
}//Main End
