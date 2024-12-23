<?php

namespace App\Http\Controllers\LeaveApplication;

use App\Http\Controllers\Controller;
use App\Models\LeaveApplication\LeaveLimits;
use App\Models\LeaveApplication\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class LeaveLimitsController extends Controller
{
    public function index(){
        return view('all_modules.leave_application.leave_limit.leave_limit');
    }
    public function store(Request $request ){
        $validator = Validator::make($request->all(), [
            'employee_name' => 'required',
            'leaveType_name' => 'required',
            'leavelimit' => 'required',
        ]);

        if ($validator->passes()) {
            $leaveLimits = new LeaveLimits();
            $leaveLimits->employee_id =  $request->employee_name;
            $leaveLimits->leave_types_id =  $request->leaveType_name;
            $leaveLimits->leave_limits =  $request->leavelimit;
            $leaveLimits->branch_id = Auth::user()->branch_id;
            $leaveLimits->save();
            return response()->json([
                'status' => 200,
                'message' => 'leave Limit Save Successfully',
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
        $Leavelimits = LeaveLimits::with(['leaveType','employee'])->get();
        // dd( $Leavelimits);
        return response()->json([
            "status" => 200,
            "data" => $Leavelimits
        ]);
    }//Method End
    public function edit($id){

        $leavelimits = LeaveLimits::findOrFail($id);
        if ($leavelimits) {
            return response()->json([
                'status' => 200,
                'leavelimits' => $leavelimits
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
            'employee_name' => 'required',
            'leaveType_name' => 'required',
            'leavelimit' => 'required',
        ]);
        if ($validator->passes()) {
            $leaveLimits =  LeaveLimits::findOrFail($id);;
            $leaveLimits->employee_id =  $request->employee_name;
            $leaveLimits->leave_types_id =  $request->leaveType_name;
            $leaveLimits->leave_limits =  $request->leavelimit;
            $leaveLimits->save();
            return response()->json([
                'status' => 200,
                'message' => 'leave Limit Update Successfully',
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
        $leavelimits = LeaveLimits::findOrFail($id);
        $leavelimits->delete();
        return response()->json([
            'status' => 200,
            'message' => 'leave Limit Deleted Successfully',
        ]);
    }//Method End
    public function getAvailableLeaveTypes($employeeId)
{
    // Get all leave types
    $allLeaveTypes = LeaveType::where('status', 'active')->get();

    // Get leave types already assigned to the employee

    $assignedLeaveTypes = LeaveLimits::where('employee_id', $employeeId)->pluck('leave_types_id')->toArray();;

    // Filter out assigned leave types
    $availableLeaveTypes = $allLeaveTypes->whereNotIn('id', $assignedLeaveTypes);

    return response()->json([
        'leaveTypes' =>  $availableLeaveTypes->values()
    ]);
}

}
