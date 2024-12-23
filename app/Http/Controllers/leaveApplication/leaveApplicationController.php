<?php

namespace App\Http\Controllers\leaveApplication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class leaveApplicationController extends Controller
{
    public function index(){
        return view('all_modules.leave_application.leave_application.leave_application');
    }//End Method
}
