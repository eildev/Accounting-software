<?php

namespace App\Http\Controllers\leaveApplication;

use App\Http\Controllers\Controller;
use App\Models\LeaveApplication\LeaveApplication;
use App\Models\LeaveApplication\LeaveApplicationDetails;
use App\Models\LeaveApplication\LeaveLimits;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\alert;

class leaveApplicationController extends Controller
{
    public function index(){
        return view('all_modules.leave_application.leave_application.leave_application');
    }//End Method
    public function store(Request $request ){
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'subject' => 'required',
            'employee_name' => 'required|exists:employees,id',
            'leaveType_name' => 'required|exists:leave_types,id',
            'start_date' => 'required',
            'end_date' => 'required',
            'total_day' => 'required',
            'subject' => 'required|string|max:255',

        ]);
        $validator->after(function ($validator) use ($request) {
            if ($request->start_date && $request->end_date && $request->total_day) {
                $startDate = Carbon::parse($request->start_date);
                $endDate = Carbon::parse($request->end_date);
                $calculatedDays = $startDate->diffInDays($endDate) + 1; // Include both start and end dates

                if ($request->total_day > $calculatedDays) {
                    $validator->errors()->add('total_day', 'Total days cannot be greater than the days between the start date and end date.');
                }
            }
        });
        if ($validator->passes()) {
             // Create Leave Application
             $formattedStartDate = Carbon::parse($request->start_date)->format('Y-m-d');
             $formattedEndDate = Carbon::parse($request->end_date)->format('Y-m-d');
             $submittedDate = Carbon::now()->format('Y-m-d');
            $leaveApplication = LeaveApplication::create([
                'branch_id' => Auth::user()->branch_id,
                'employee_id' => $request->employee_name,
                'leave_types_id' => $request->leaveType_name,
                'submited_date' => $submittedDate,
                'subject' => $request->subject,
            ]);
            // Create Leave Application Details
            LeaveApplicationDetails::create([
                'leave_application_id' => $leaveApplication->id,
                'total_day' => $request->total_day,
                'start_date' => $formattedStartDate,
                'end_date' => $formattedEndDate,
                'message' => $request->message,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'leave Application Save Successfully',
            ]);
        } else {
            return response()->json([
                'status' => '500',
                'error' => $validator->messages()
            ]);
        }
    }//end Method
    public function view()
    {
        if(Auth::user()->employee_id){
            $LeaveApplication = LeaveApplication::where('employee_id',Auth::user()->employee_id)->with(['leaveType','employee','leaveApplicationDetails'])->get();
        }
        else{
            $LeaveApplication = LeaveApplication::with(['leaveType','employee','leaveApplicationDetails'])->get();
        }
        return response()->json([
            "status" => 200,
            "data" => $LeaveApplication
        ]);
    }//Method End
    public function leaveStatusUpdate(Request $request){

        $LeaveApplication = LeaveApplication::findOrFail($request->id);

        if ($request->status == 'approved') {
            $LeaveApplicationDetails = LeaveApplicationDetails::where('leave_application_id', $LeaveApplication->id)->get();

            $leaveLimits = LeaveLimits::where('employee_id', $LeaveApplication->employee_id)
                ->where('leave_types_id', $LeaveApplication->leave_types_id )
                ->first();
                // dd($leaveLimits);
            if ($leaveLimits) {
                $leaveLimits->leave_limits -= $LeaveApplicationDetails->sum('total_day'); // Sum total days if multiple details
                $leaveLimits->save();
            }
            $LeaveApplication->status = $request->status;
        }else{
                $LeaveApplication->status = $request->status;
            }
        $LeaveApplication->save();
        return response()->json([
            'success' => true,
            'message' => 'Status updated Successfully!',
            'status' => $LeaveApplication->status,
        ]);
    }//Method End
}
