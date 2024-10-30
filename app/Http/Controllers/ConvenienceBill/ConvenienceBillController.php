<?php

namespace App\Http\Controllers\ConvenienceBill;

use App\Http\Controllers\Controller;
use App\Models\ConvenienceBill\Convenience;
use App\Models\ConvenienceBill\FoodingCost;
use App\Models\ConvenienceBill\FoodingCostDetails;
use App\Models\ConvenienceBill\MovementCost;
use App\Models\ConvenienceBill\MovementCostDetails;
use App\Models\ConvenienceBill\OtherExpenseCost;
use App\Models\ConvenienceBill\OtherExpenseCostDetails;
use App\Models\ConvenienceBill\OvernightCost;
use App\Models\ConvenienceBill\OvernightCostDetails;
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
            $branchId = Auth::user()->branch_id;
            // if ($validator->passes()) {
            if($request->movementDate || $request->foodingDate ||$request->overnightDate ||$request->otherExpensesDate){
                $convenience =  Convenience::create([
                    'branch_id' => $branchId,
                    'bill_number' => rand(100000, 999999),
                    'employee_id' => 1,
                    'entry_by' => Auth::user()->name,
                    'total_amount' =>  0,
                ]);
                $convenienceId = $convenience->id;

            if ($request->has('movementDate') && !empty($request->movementDate)) {

                // dd($request->hasFile('movementCostsFile'));

                $imageName =null;
                if ($request->hasFile('movementCostsFile')) {
                    $file = $request->file('movementCostsFile');
                    // dd($file);
                    $imageName = rand() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/movement_costs'), $imageName);
                }
                $movementCost =  MovementCost::create([
                    'branch_id' => $branchId,
                    'convenience_id' => $convenienceId,
                    'image' =>  $imageName ,
                    'total_amount' =>  0,
                ]);
                $movementCostId = $movementCost->id;
                foreach ($request->movementDate as $index => $date) {
                    MovementCostDetails::create([
                        'branch_id' => $branchId,
                        'movement_date' => $date,
                        'movement_cost_id' => $movementCostId,
                        'movement_from' => $request->movementFrom[$index],
                        'movement_to' => $request->movementTo[$index],
                        'movement_purpose' => $request->movementPurpose[$index],
                        'mode_of_transport' => $request->movementMode_of_Transport[$index],
                        'movement_amount' => $request->movementAmount[$index],
                        'movement_assigned' => $request->movementAssigned[$index],
                    ]);
                }

            }//

            if ($request->has('foodingDate') && !empty($request->foodingDate)) {

                $imageName =null;
                // if ($request->hasFile('foodingCostsFile')) {
                //     $file = $request->file('foodingCostsFile');
                //     $imageName = rand() . '.' . $file->getClientOriginalExtension();
                //     $file->move(public_path('uploads/fooding_costs'), $imageName);
                // }
                $foodingCost =  FoodingCost::create([
                    'branch_id' => $branchId,
                    'convenience_id' => $convenienceId,
                    'image' =>  $imageName ,
                    'total_amount' =>  0,
                ]);
                $foodingCostId = $foodingCost->id;
                foreach ($request->foodingDate as $index => $date) {
                    FoodingCostDetails::create([
                        'branch_id' => $branchId,
                        'fooding_date' => $date,
                        'fooding_cost_id' =>$foodingCostId,
                        'fooding_place_of_visit' => $request->foodingPlceofvisit[$index],
                        'fooding_purpose' => $request->foodingPurpose[$index],
                        'fooding_time' => $request->foodingtime[$index],
                        'fooding_amount' => $request->foodingAmount[$index],
                        'fooding_assigned' => $request->foodingAssigned[$index],
                    ]);
                }


            }//

        if ($request->has('overnightDate') && !empty($request->overnightDate)) {
            $imageName =null;
            // if ($request->hasFile('foodingCostsFile')) {
            //     $file = $request->file('foodingCostsFile');
            //     $imageName = rand() . '.' . $file->getClientOriginalExtension();
            //     $file->move(public_path('uploads/fooding_costs'), $imageName);
            // }
            $overnightCost =  OvernightCost::create([
                'branch_id' => $branchId,
                'convenience_id' => $convenienceId,
                'image' =>  $imageName ,
                'total_amount' =>  0,
            ]);
            $overnightCostId = $overnightCost->id;

            foreach ($request->overnightDate as $index => $date) {
                OvernightCostDetails::create([
                    'branch_id' => $branchId,
                    'overnight_cost_id' =>$overnightCostId,
                    'overnight_date' => $date,
                    'overnight_place_of_visit' => $request->overnightPlceofvisit[$index],
                    'overnight_purpose' => $request->overnightPurpose[$index],
                    'overnight_stay_period' => $request->overnightStayperiod[$index],
                    'overnight_amount' => $request->overnightAmount[$index],
                    'overnight_assigned' => $request->overnightAssigned[$index],
                ]);
            }

        }
        if ($request->has('otherExpensesDate') && !empty($request->otherExpensesDate)) {
            $imageName =null;
            // if ($request->hasFile('foodingCostsFile')) {
            //     $file = $request->file('foodingCostsFile');
            //     $imageName = rand() . '.' . $file->getClientOriginalExtension();
            //     $file->move(public_path('uploads/fooding_costs'), $imageName);
            // }
            $otherExpenseCost =  OtherExpenseCost::create([
                'branch_id' => $branchId,
                'convenience_id' => $convenienceId,
                'image' =>  $imageName ,
                'total_amount' =>  0,
            ]);
            $otherExpenseCostId = $otherExpenseCost->id ;

            foreach ($request->otherExpensesDate as $index => $date) {
                OtherExpenseCostDetails::create([
                    'branch_id' => $branchId,
                    'other_expense_cost_id' => $otherExpenseCostId,
                    'other_expense_date' => $date,
                    'other_expense_purpose' => $request->otherExpensesPurpose[$index],
                    'other_expense_amount' => $request->otherExpensesAmount[$index],
                    'other_expense_assigned' => $request->otherExpensesAssigned[$index],
                ]);
            }

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
