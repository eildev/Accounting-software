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
    public function convenience()
    {
        $departments = Departments::all();
        $employees =  Employee::all();
        return view('all_modules.convenience_bill.convenience_bill', compact('departments', 'employees'));
    } //Method End
    public function getEmployeesByDepartment($department_id)
    {
        $employees = Employee::where('department_id', $department_id)->get();
        return response()->json($employees);
    }
    public function convenienceStore(Request $request)
    {
        //  dd($request->employee_id);
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required',
        ]);

        // Check if validation fails
        $branchId = Auth::user()->branch_id;

        $moveTotal = floatval($request->movementCostsTotal) ?? 0;

        $foodTotal = floatval($request->foodingCostsTotal) ?? 0;
        $overnightTotal = floatval($request->overnightStayCostTotal) ?? 0;

        $otherTotal = floatval($request->otherExpensesCostsTotal) ?? 0;
        $sumTotal = $moveTotal + $foodTotal + $overnightTotal + $otherTotal;
        if ($validator->passes()) {
            if ($request->movementDate || $request->foodingDate || $request->overnightDate || $request->otherExpensesDate) {
                $convenience =  Convenience::create([
                    'branch_id' => $branchId,
                    'bill_number' => rand(100000, 999999),
                    'employee_id' => $request->employee_id,
                    'entry_by' => Auth::user()->name,
                    'total_amount' =>  $sumTotal,
                ]); //
                $convenienceId = $convenience->id;

                if ($request->has('movementDate') && !empty($request->movementDate)) {

                    $imageName = null;
                    if ($request->hasFile('movementCostsFile')) {
                        $file = $request->file('movementCostsFile');
                        // dd($file);
                        $imageName = rand() . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('uploads/movement_costs'), $imageName);
                    }
                    $movementCost =  MovementCost::create([
                        'branch_id' => $branchId,
                        'convenience_id' => $convenienceId,
                        'image' =>  $imageName,
                        'total_amount' =>  floatval($request->movementCostsTotal),
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
                } //

                if ($request->has('foodingDate') && !empty($request->foodingDate)) {

                    $imageName = null;
                    if ($request->hasFile('foodingCostFile')) {
                        $file = $request->file('foodingCostFile');
                        $imageName = rand() . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('uploads/fooding_costs'), $imageName);
                    }
                    $foodingCost =  FoodingCost::create([
                        'branch_id' => $branchId,
                        'convenience_id' => $convenienceId,
                        'image' =>  $imageName,
                        'total_amount' => floatval($request->foodingCostsTotal),
                    ]);
                    $foodingCostId = $foodingCost->id;
                    foreach ($request->foodingDate as $index => $date) {
                        FoodingCostDetails::create([
                            'branch_id' => $branchId,
                            'fooding_date' => $date,
                            'fooding_cost_id' => $foodingCostId,
                            'fooding_place_of_visit' => $request->foodingPlceofvisit[$index],
                            'fooding_purpose' => $request->foodingPurpose[$index],
                            'fooding_time' => $request->foodingtime[$index],
                            'fooding_amount' => $request->foodingAmount[$index],
                            'fooding_assigned' => $request->foodingAssigned[$index],
                        ]);
                    }
                } //

                if ($request->has('overnightDate') && !empty($request->overnightDate)) {
                    $imageName = null;
                    if ($request->hasFile('overnightStayCostFile')) {
                        $file = $request->file('overnightStayCostFile');
                        $imageName = rand() . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('uploads/overnight_costs'), $imageName);
                    }
                    $overnightCost =  OvernightCost::create([
                        'branch_id' => $branchId,
                        'convenience_id' => $convenienceId,
                        'image' =>  $imageName,
                        'total_amount' => floatval($request->overnightStayCostTotal),
                    ]);
                    $overnightCostId = $overnightCost->id;

                    foreach ($request->overnightDate as $index => $date) {
                        OvernightCostDetails::create([
                            'branch_id' => $branchId,
                            'overnight_cost_id' => $overnightCostId,
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
                    $imageName = null;
                    if ($request->hasFile('otherExpensesCostFile')) {
                        $file = $request->file('otherExpensesCostFile');
                        $imageName = rand() . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('uploads/other_expense_costs'), $imageName);
                    }
                    $otherExpenseCost =  OtherExpenseCost::create([
                        'branch_id' => $branchId,
                        'convenience_id' => $convenienceId,
                        'image' =>  $imageName,
                        'total_amount' =>  floatval($request->otherExpensesCostsTotal),
                    ]);
                    $otherExpenseCostId = $otherExpenseCost->id;

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
            }else{
                return response()->json([
                    'status' => '500',
                    'error' => 'Convenience Fail to Added',
                ]);
            }
        } else {
            return response()->json([
                'status' => '500',
                'error' => 'Convenience Fail to Added',
            ]);
        }
    }
}
