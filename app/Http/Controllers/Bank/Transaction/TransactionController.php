<?php

namespace App\Http\Controllers\Bank\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Bank\BankAccounts;
use App\Models\Bank\Cash;
use App\Models\Investor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    public function transaction()
    {
        try {
            if (Auth::user()->id == 1) {
                $cashAccounts = Cash::all();
                $bankAccounts = BankAccounts::all();
                $investors = Investor::latest()->get();
            } else {
                $cashAccounts = Cash::where('branch_id', Auth::user()->branch_id)->latest()->get();
                $bankAccounts = BankAccounts::where('branch_id', Auth::user()->branch_id)->latest()->get();
                $investors = Investor::where('branch_id', Auth::user()->branch_id)->latest()->get();
            }

            return view('all_modules.transaction.transaction', compact('cashAccounts', 'bankAccounts', 'investors'));
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Transaction Error: ' . $e->getMessage());

            // Optionally, you can flash a message to the session to display it to the user
            return redirect()->back()->with('error', 'Something went wrong while processing the transaction.');

            // Alternatively, you can return a custom error view if required
            // return view('error_page')->with('message', 'Something went wrong!');
        }
    }


    // storeTransaction function 
    public function storeTransaction()
    {
        try {
        } catch (\Exception $e) {
        }
    } //

    // checkAccountType function 
    public function checkAccountType(Request $request)
    {
        try {
            $paymentType = $request->payment_type;

            if ($paymentType == 'cash') {
                if (Auth::user()->id == 1) {
                    $data = Cash::get();  // Fetch all for admin
                } else {
                    $data = Cash::where('branch_id', Auth::user()->branch_id)
                        ->latest()
                        ->get();  // Fetch only for the user's branch
                }
            } else if ($paymentType == 'bank') {
                if (Auth::user()->id == 1) {
                    $data = BankAccounts::get();  // Fetch all for admin
                } else {
                    $data = BankAccounts::where('branch_id', Auth::user()->branch_id)
                        ->latest()
                        ->get();  // Fetch only for the user's branch
                }
            }

            return response()->json([
                'status' => 200,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => 500,
                "message" => 'An error occurred while fetching bank accounts.',
                "error" => $e->getMessage()  // Optional: include exception message
            ]);
        }
    } //
}
