<?php

namespace App\Http\Controllers\leaveApplication;

use App\Http\Controllers\Controller;
use App\Models\LeaveApplication\LeaveLimits;
use App\Models\LeaveApplication\LeaveType;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class leaveTypeController extends Controller
{
    public function index(){
        return view('all_modules.leave_application.leave_type.leave_type');
    }
    //End Method
    public function store(Request $request ){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:250|unique:leave_types,name',
        ]);

        if ($validator->passes()) {
            $leaveType = new LeaveType();
            $leaveType->name =  $request->name;
            $leaveType->branch_id = Auth::user()->branch_id;
            $leaveType->save();
            return response()->json([
                'status' => 200,
                'message' => 'leave Type Save Successfully',
            ]);
        } else {
            return response()->json([
                'status' => '500',
                'error' => $validator->messages()
            ]);
        }
    }//End Method
    public function view()
    {
        $leaveTypes = LeaveType::all();
        return response()->json([
            "status" => 200,
            "data" => $leaveTypes
        ]);
    }//Method End
    public function edit($id){

        $leaveTypes = LeaveType::findOrFail($id);
        if ($leaveTypes) {
            return response()->json([
                'status' => 200,
                'leaveTypes' => $leaveTypes
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => "Data Not Found"
            ]);
        }
    }//Method End
    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:250|unique:leave_types,name',
        ]);

        if ($validator->passes()) {
            $leaveType = LeaveType::findOrFail($id);
            $leaveType->name =  $request->name;
            $leaveType->save();
            return response()->json([
                'status' => 200,
                'message' => 'leave Type Update Successfully',
            ]);
        } else {
            return response()->json([
                'status' => '500',
                'error' => $validator->messages()
            ]);
        }
    }//End MEthod
    public function destroy($id)
    {
        $leaveType = LeaveType::findOrFail($id);
        $leaveType->delete();
        return response()->json([
            'status' => 200,
            'message' => 'leave Type Deleted Successfully',
        ]);
    }//Method End
    public function status($id){
        $leaveTypes = LeaveType::findOrFail($id);
        $newStatus = $leaveTypes->status == 'active' ? 'inactive' : 'active';
        $leaveTypes->update([
            'status' => $newStatus
        ]);

        $leaveTypes->save();
        return response()->json([
            "status" => 200,
            "data" => $leaveTypes
        ]);
    }
    public function getlimitLeaveData($leaveTypeId, $employeeId)
    {
        // dd($leaveTypeId, $employeeId);
        $leaveLimit = LeaveLimits::with('leaveType')
            ->where('leave_types_id', $leaveTypeId)
            ->where('employee_id', $employeeId)
            ->first();
                // dd($leaveLimit);
        if (!$leaveLimit) {
            return response()->json(['success' => false, 'message' => 'Leave data not found.']);
        }

        return response()->json([
            'success' => true,
            'leaveType' => $leaveLimit->leaveType,
            'limit' => $leaveLimit->leave_limits,
            'remaining' => $leaveLimit->remaining,
        ]);
    }


}//End Main
