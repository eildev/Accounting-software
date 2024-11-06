<?php

namespace App\Http\Controllers\EmployeePayroll;

use Illuminate\Http\Request;
use App\Models\EmployeePayroll\Employee;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Departments\Departments;
use App\Models\EmployeePayroll\SalarySturcture;

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
        return view('all_modules.employee.employee_profile', compact('employee','salaryStructure'));
    }
}
