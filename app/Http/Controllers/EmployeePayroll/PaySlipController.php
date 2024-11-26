<?php

namespace App\Http\Controllers\EmployeePayroll;

use App\Http\Controllers\Controller;
use App\Models\EmployeePayroll\PaySlip;
use Illuminate\Http\Request;

class PaySlipController extends Controller
{

    public function paySlip($id)
    {
        $paySlip = PaySlip::findOrFail($id);

        return response()->json([
            'status' => 200,
            'paySlip' => $paySlip,
        ]);
    }
}
