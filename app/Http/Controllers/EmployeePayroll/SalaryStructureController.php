<?php

namespace App\Http\Controllers\EmployeePayroll;

use App\Http\Controllers\Controller;
use App\Models\EmployeePayroll\Employee;
use App\Models\EmployeePayroll\SalarySturcture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class SalaryStructureController extends Controller
{
    public function index(){
        // $existingEmployeeIds = SalarySturcture::pluck('employee_id');
        // $employees = Employee::whereNotIn('id', $existingEmployeeIds)->get();
           $employees = Employee::all();
            return view('all_modules.salary_structure.salary_structure',compact('employees'));
    }//Method End
    public function getEmployeesWithoutSalaryStructure()
        {
            $existingEmployeeIds = SalarySturcture::pluck('employee_id');
            $employees = Employee::whereNotIn('id', $existingEmployeeIds)->get();

            return response()->json($employees);
        }
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required',
            'base_salary' => 'required|numeric|between:0,999999999999.99',
        ]);
        if ($validator->passes()) {
            $salaryStructure = new SalarySturcture();
            $salaryStructure->employee_id =  $request->employee_id;
            $salaryStructure->branch_id = Auth::user()->branch_id;
            $salaryStructure->base_salary =  $request->base_salary;
            $salaryStructure->house_rent =  $request->house_rent;
            $salaryStructure->transport_allowance =  $request->transport_allowance;
            $salaryStructure->other_fixed_allowances =  $request->other_fixed_allowances;
            $salaryStructure->deductions =  $request->deductions;
            $salaryStructure->save();
            return response()->json([
                'status' => 200,
                'message' => 'Salary Structure Save Successfully',
            ]);
        } else {
            return response()->json([
                'status' => '500',
                'error' => $validator->messages()
            ]);
        }
    }//
    public function view(){
        // $salaryStructure = SalarySturcture::all();
        $salaryStructure = SalarySturcture::with('employee')->get();
        return response()->json([
            "status" => 200,
            "data" => $salaryStructure,
        ]);
    }//
    public function edit($id){
        $salarySturcture = SalarySturcture::findOrFail($id);
        if ($salarySturcture) {
            return response()->json([
                'status' => 200,
                'salarySturcture' => $salarySturcture
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => "Data Not Found"
            ]);
        }
    }//
    public function update(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required',
            'base_salary' => 'required|numeric|between:0,999999999999.99',
            'house_rent' => 'nullable|numeric|between:0,999999999999.99',
            'transport_allowance' => 'nullable|numeric|between:0,999999999999.99',
            'other_fixed_allowances' => 'nullable|numeric|between:0,999999999999.99',
            'deductions' => 'nullable|numeric|between:0,999999999999.99',
        ]);
        if ($validator->passes()) {
            $salaryStructure = SalarySturcture::findOrFail($id);
            $salaryStructure->employee_id =  $request->employee_id;
            $salaryStructure->base_salary =  $request->base_salary;
            $salaryStructure->house_rent =  $request->house_rent;
            $salaryStructure->transport_allowance =  $request->transport_allowance;
            $salaryStructure->other_fixed_allowances =  $request->other_fixed_allowances;
            $salaryStructure->deductions =  $request->deductions;
            $salaryStructure->save();
            return response()->json([
                'status' => 200,
                'message' => 'Salary Structure Update Successfully',
            ]);
        } else {
            return response()->json([
                'status' => '500',
                'error' => $validator->messages()
            ]);
        }
    }//
    public function destroy($id)
    {
        $salarySturcture = SalarySturcture::findOrFail($id);
        $salarySturcture->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Salary Sturcture Deleted Successfully',
        ]);
    }//Method End
}
