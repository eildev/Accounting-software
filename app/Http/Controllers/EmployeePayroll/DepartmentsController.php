<?php

namespace App\Http\Controllers\EmployeePayroll;

use App\Http\Controllers\Controller;
use App\Models\Departments\Departments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class DepartmentsController extends Controller
{
    public function index(){
        return view('pos.departments.departments');
    }//Method End
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:250',
        ]);
        if ($validator->passes()) {
            $departments = new Departments();
            $departments->name =  $request->name;
            $departments->branch_id = Auth::user()->branch_id;
            $departments->save();
            return response()->json([
                'status' => 200,
                'message' => 'Departments Save Successfully',
            ]);
        } else {
            return response()->json([
                'status' => '500',
                'error' => $validator->messages()
            ]);
        }
    }//Method End
    public function view()
    {
        $departments = Departments::all();
        return response()->json([
            "status" => 200,
            "data" => $departments
        ]);
    }//Method End
    public function edit($id)
    {
        $departments = Departments::findOrFail($id);
        if ($departments) {
            return response()->json([
                'status' => 200,
                'departments' => $departments
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => "Data Not Found"
            ]);
        }
    }//Method End
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:250',
        ]);
        if ($validator->passes()) {
            $departments = Departments::findOrFail($id);
            $departments->name =  $request->name;
            $departments->save();
            return response()->json([
                'status' => 200,
                'message' => 'Departments Update Successfully',
            ]);
        } else {
            return response()->json([
                'status' => '500',
                'error' => $validator->messages()
            ]);
        }

    }//Method End
    public function destroy($id)
    {
        $departments = Departments::findOrFail($id);
        $departments->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Departments Deleted Successfully',
        ]);
    }//Method End
}
