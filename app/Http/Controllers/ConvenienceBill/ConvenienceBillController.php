<?php

namespace App\Http\Controllers\ConvenienceBill;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Departments\Departments;
use App\Models\EmployeePayroll\Employee;
class ConvenienceBillController extends Controller
{
       //Audit
       public function convenience(){
        $departments = Departments::all();
       $employees =  Employee::all();
        return view('all_modules.convenience_bill.convenience_bill',compact('departments','employees'));
    }//Method End
    public function getEmployeesByDepartment($department_id)
        {

            $employees = Employee::where('department_id', $department_id)->get();

            return response()->json($employees);
        }
        public function convenienceStore(Request $request){
            dd($request->all());
        }
}
