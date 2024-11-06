<?php

namespace App\Http\Controllers\EmployeePayroll;

use Illuminate\Http\Request;
use App\Models\EmployeePayroll\Employee;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\ConvenienceBill\Convenience;
use App\Models\Departments\Departments;
use App\Models\EmployeePayroll\EmployeeBonuse;
use App\Models\EmployeePayroll\SalarySturcture;
use Illuminate\Support\Facades\Validator;
class EmployeeController extends Controller
{
    public function view()
    {
        $employees = Employee::get();
        return view('all_modules.employee.view_employee', compact('employees'));
    } //
    public function index()
    {
        $departments = Departments::all();
        return view('all_modules.employee.add_employee',compact('departments'));
    } //
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'department_id' => 'required',
            'email' => 'required',
            'phone' => 'required|min:0|max:9999999999999',
            'salary' => 'nullable|numeric|min:0|max:9999999999999',
            'nid' => 'nullable|numeric|min:0|max:9999999999999',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($request->image) {
            $employee = new Employee;
            $imageName = rand() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/employee'), $imageName);
            $employee->pic = $imageName;
        }
        $employee = new Employee();
        $employee->branch_id = Auth::user()->branch_id;
        $employee->full_name = $request->full_name;
        $employee->department_id = $request->department_id;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->address = $request->address;
        $employee->salary = $request->salary;
        $employee->nid = $request->nid;
        $employee->designation = $request->designation;
        $employee->pic = $imageName ?? '';
        $employee->created_at = Carbon::now();
        $employee->save();
        $notification = array(
            'message' => 'Employee Added Successfully',
            'alert-type' => 'info'
        );
        return redirect()->route('employee.view')->with($notification);
    } //
    public function edit($id)
    {
        $departments = Departments::all();
        $employees = Employee::findOrFail($id);
        return view('all_modules.employee.edit_employee', compact('employees','departments'));
    } //
    public function update(Request $request, $id)
    {
        // dd($request->all());

        $employee = Employee::findOrFail($id);
        $employee->branch_id = Auth::user()->branch_id;
        $employee->full_name = $request->full_name;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->address = $request->address;
        $employee->salary = $request->salary;
        $employee->nid = $request->nid;
        $employee->designation = $request->designation;
        if ($request->image) {
            $imageName = rand() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/employee'), $imageName);
            $employee->pic = $imageName;
        }
        $employee->save();

        $notification = array(
            'message' => 'Employee Updated Successfully',
            'alert-type' => 'info'
        );
        return redirect()->route('employee.view')->with($notification);
    } //
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $path = public_path('uploads/employee/' . $employee->image);
        if (file_exists($path)) {
            @unlink($path);
        }
        $employee->delete();
        $notification = array(
            'message' => 'Employee Deleted Successfully',
            'alert-type' => 'info'
        );
        return redirect()->route('employee.view')->with($notification);
    }
    public function profile($id){
        $employee = Employee::findOrFail($id);
        $salaryStructure = SalarySturcture::where('employee_id', $employee->id)->first();
        $conveniences = Convenience::where('employee_id', $employee->id)->get();
        return view('all_modules.employee.employee_profile', compact('employee','salaryStructure','conveniences'));
    }
    //////////////////////////////////////////////// Employee Bonuse /////////////////////////////////
    public function indexBonus(){
        $departments = Departments::all();
        $employees =  Employee::all();
        return view('all_modules.employee.employee_bonuse.add_employee_bonuse',compact('employees','departments'));
    }
    public function bonusStore(Request $request){
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required',
            'bonus_type' => 'required',
            'bonus_amount' => 'required|numeric|between:0,999999999999.99',
        ]);
        if ($validator->passes()) {
            $employeeBomus = new EmployeeBonuse;
            $employeeBomus->employee_id  = $request->employee_id;
            $employeeBomus->bonus_type  = $request->bonus_type;
            $employeeBomus->bonus_amount  = $request->bonus_amount;
            $employeeBomus->bonus_reason  = $request->bonus_reason;
            $employeeBomus->bonus_date  = Carbon::now();
            $employeeBomus->status  = 'pending';
            $employeeBomus->save();
            return response()->json([
                'status' => 200,
                'message' => 'Bonus Submited Successfully',
            ]);
        } else {
            return response()->json([
                'status' => '500',
                'error' => $validator->messages()
            ]);
        }
    }
    public function bonusView(){
        $bonuses = EmployeeBonuse::with('employee')->get();
        return response()->json([
            "status" => 200,
            "data" => $bonuses,
        ]);
    }
    public function bonusEdit($id){
        $employeeBonus = EmployeeBonuse::findOrFail($id);
            return response()->json([
                'status' => 200,
                'employeeBonus' => $employeeBonus,
            ]);
    }

    public function bonusUpdate(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required',
            'bonus_type' => 'required',
            'bonus_amount' => 'required|numeric|between:0,999999999999.99',
        ]);
        if ($validator->passes()) {
        $employeeBomus = EmployeeBonuse::findOrFail($id);
        $employeeBomus->employee_id  = $request->employee_id;
        $employeeBomus->bonus_type  = $request->bonus_type;
        $employeeBomus->bonus_amount  = $request->bonus_amount;
        $employeeBomus->bonus_reason  = $request->bonus_reason;
        $employeeBomus->save();
        return response()->json([
            'status' => 200,
            'message' => 'Bonus Updated Successfully',
        ]);
    } else {
        return response()->json([
            'status' => '500',
            'error' => $validator->messages()
        ]);
    }
    }
    public function bonusDelete($id){
        $employeeBonuse = EmployeeBonuse::findOrFail($id);
        $employeeBonuse->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Employee Bonus Deleted Successfully',
        ]);
    }
}
