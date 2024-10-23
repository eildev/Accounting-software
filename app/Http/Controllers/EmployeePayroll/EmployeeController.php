<?php

namespace App\Http\Controllers\EmployeePayroll;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Departments\Departments;

class EmployeeController extends Controller
{
    public function view()
    {
        $employees = Employee::get();
        return view('all_modules.employee.view_employee', compact('employees'));
    } //
    public function index()
    {
        return view('all_modules.employee.add_employee');
    } //
    public function store(Request $request)
    {

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
        $employee->status = 0;
        $employee->pic = $imageName?? '';
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
<<<<<<< HEAD:app/Http/Controllers/EmployeeController.php
        $employees =  $this->employee_repo->EditEmployee($id);
        return view('all_modules.employee.edit_employee', compact('employees'));
=======
        $employees =  Employee::findOrFail($id);
        return view('pos.employee.edit_employee', compact('employees'));
>>>>>>> 5a9b5461a8fec6cb607d5bb6b6d9cc88ffe51a83:app/Http/Controllers/EmployeePayroll/EmployeeController.php
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
        $employee->status = 0;
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
}