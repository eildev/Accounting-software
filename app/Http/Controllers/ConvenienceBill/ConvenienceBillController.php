<?php

namespace App\Http\Controllers\ConvenienceBill;

use App\Http\Controllers\Controller;
use App\Models\ConvenienceBill\FoodingCost;
use App\Models\ConvenienceBill\MovementCost;
use App\Models\ConvenienceBill\OtherExpenseCost;
use App\Models\ConvenienceBill\OvernightStayCost;
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
            // dd($request->all());
            // $validator = Validator::make($request->all(), [

                // 'movementDate' => 'date',
                // 'movementFrom' => 'string',
                // 'movementTo' => 'string',
                // 'movementMode_of_Transport' => 'string',
                // 'movementAmount.*' => 'numeric',

                // 'foodingDate' => 'date',
                // 'foodingtime' => 'string',
                // 'foodingAmount' => 'numeric',

                // 'overnightDate' => 'date',
                // 'overnightPlceofvisit' => 'string',
                // 'overnightStayperiod' => 'numeric',
                // 'overnightAmount' => 'numeric',

                // 'otherExpensesDate' => 'date',
                // 'otherExpensesPurpose' => 'string',
                // 'otherExpensesAmount' => 'numeric',

            // ]);

            // Check if validation fails

            // if ($validator->passes()) {
            $branchId = Auth::user()->branch_id;
            if ($request->has('movementDate') && !empty($request->movementDate)) {
                foreach ($request->movementDate as $index => $date) {
                    MovementCost::create([
                        'branch_id' => $branchId,
                        'movement_date' => $date,
                        'movement_from' => $request->movementFrom[$index],
                        'movement_to' => $request->movementTo[$index],
                        'movement_purpose' => $request->movementPurpose[$index],
                        'mode_of_transport' => $request->movementMode_of_Transport[$index],
                        'movement_amount' => $request->movementAmount[$index],
                        'movement_assigned' => $request->movementAssigned[$index],
                    ]);
                }
                return response()->json([
                    'status' => 200,
                    'message' => 'Convenience Bil Added Successfully',
                ]);
            }
            if ($request->has('foodingDate') && !empty($request->foodingDate)) {
                foreach ($request->foodingDate as $index => $date) {
                    FoodingCost::create([
                        'branch_id' => $branchId,
                        'fooding_date' => $date,
                        'fooding_place_of_visit' => $request->foodingPlceofvisit[$index],
                        'fooding_purpose' => $request->foodingPurpose[$index],
                        'fooding_time' => $request->foodingtime[$index],
                        'fooding_amount' => $request->foodingAmount[$index],
                        'fooding_assigned' => $request->foodingAssigned[$index],
                    ]);
                }
                return response()->json([
                    'status' => 200,
                    'message' => 'Convenience Bil Added Successfully',
                ]);
            }
        if ($request->has('overnightDate') && !empty($request->overnightDate)) {
            foreach ($request->overnightDate as $index => $date) {
                OvernightStayCost::create([
                    'branch_id' => $branchId,
                    'overnight_date' => $date,
                    'overnight_place_of_visit' => $request->overnightPlceofvisit[$index],
                    'overnight_purpose' => $request->overnightPurpose[$index],
                    'overnight_stay_period' => $request->overnightStayperiod[$index],
                    'overnight_amount' => $request->overnightAmount[$index],
                    'overnight_assigned' => $request->overnightAssigned[$index],
                ]);
            }
            return response()->json([
                'status' => 200,
                'message' => 'Convenience Bil Added Successfully',
            ]);
        }
        if ($request->has('otherExpensesDate') && !empty($request->otherExpensesDate)) {
            foreach ($request->otherExpensesDate as $index => $date) {
                OtherExpenseCost::create([
                    'branch_id' => $branchId,
                    'other_expense_date' => $date,
                    'other_expense_purpose' => $request->otherExpensesPurpose[$index],
                    'other_expense_amount' => $request->otherExpensesAmount[$index],
                    'other_expense_assigned' => $request->otherExpensesAssigned[$index],
                ]);
            }
            return response()->json([
                'status' => 200,
                'message' => 'Convenience Bil Added Successfully',
            ]);
        }

    // } else {
        return response()->json([
            'status' => '500',
            'error' => 'Convenience Fail to Added',
        ]);
    // }
}
}
