<?php

namespace App\Http\Controllers\AccountPayable;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
// use Validator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    public function index()
    {
        return view('all_modules.account_payable.supplier.supplier');
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:250',
            'phone' => 'required|max:100',
        ]);


        if ($validator->passes()) {
            $supplier = new Supplier;
            $supplier->name =  $request->name;
            $supplier->branch_id =  Auth::user()->branch_id;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->address = $request->address;
            $supplier->opening_receivable = 0;
            $opening_receivable = $request->opening_receivable ?? 0;
            $supplier->total_receivable = $opening_receivable;
            $supplier->wallet_balance = $opening_receivable;
            $supplier->opening_payable = $opening_receivable;
            $supplier->total_payable = 0;
            $supplier->save();


            return response()->json([
                'status' => 200,
                'message' => 'Supplier Save Successfully',
            ]);
        } else {
            return response()->json([
                'status' => '500',
                'error' => $validator->messages()
            ]);
        }
    }
    public function view()
    {
        $suppliers = Supplier::get();
        return response()->json([
            "status" => 200,
            "data" => $suppliers
        ]);
    }
    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        if ($supplier) {
            return response()->json([
                'status' => 200,
                'supplier' => $supplier
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => "Data Not Found"
            ]);
        }
    }
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:250',
            'phone' => 'required|max:100',
        ]);
        if ($validator->passes()) {
            $supplier = Supplier::findOrFail($id);
            $supplier->name =  $request->name;
            $supplier->branch_id =  Auth::user()->branch_id;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->address = $request->address;
            $supplier->save();
            return response()->json([
                'status' => 200,
                'message' => 'Supplier Update Successfully',
            ]);
        } else {
            return response()->json([
                'status' => '500',
                'error' => $validator->messages()
            ]);
        }
    }
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Supplier Deleted Successfully',
        ]);
    }

    public function SupplierProfile($id)
    {
        $data = Supplier::findOrFail($id);
        $purchaseReport = Purchase::where('supplier_id', $data->id)->get();
        $branch = Branch::findOrFail($data->branch_id);

        return view('all_modules.account_payable.supplier.profile', compact('data', 'purchaseReport', 'branch'));
    }
}
