<?php

namespace App\Http\Controllers\Ledgers\SubLedger;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Ledger\LedgerAccounts\LedgerAccounts;
use App\Models\Ledger\PrimaryLedger\PrimaryLedgerGroup;
use App\Models\Ledger\SubLedger\SubLedger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class SubLedgerController extends Controller
{
    // This is Index function 
    public function index()
    {
        try {
            // Attempt to return the view
            return view('all_modules.ledgers.sub-ledgers.index');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error loading the bank view: ' . $e->getMessage());

            // Optionally return a custom error view or a simple error message
            return response()->view('errors.500', [], 500);
        }
    }


    public function store(Request $request)
    {
        try {
            // Validate the incoming request
            $validator = Validator::make($request->all(), [
                'account_id' => 'required|integer|max:10',
                'sub_ledger_name' => 'required|max:99',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => '500',
                    'error' => $validator->messages()
                ]);
            }

            // If validation passes, proceed with saving the Primary Ledger details
            $subLedger = new SubLedger;
            $subLedger->branch_id = Auth::user()->branch_id;
            $subLedger->account_id = $request->account_id;
            $subLedger->sub_ledger_name = $request->sub_ledger_name;
            $subLedger->save();
            return response()->json([
                'status' => 200,
                'message' => 'Sub Ledger Saved Successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => 500,
                "message" => 'An error occurred while Save Sub Ledger',
                "error" => $e->getMessage()  // Optional: include exception message
            ]);
        }
    }


    public function view()
    {
        try {
            // Fetch the bank accounts based on user type (admin or branch)
            if (Auth::user()->id == 1) {
                $subLedger = SubLedger::with('ledger')->latest()->get();  // Fetch all for admin
            } else {
                $subLedger = SubLedger::with('ledger')->where('branch_id', Auth::user()->branch_id)
                    ->latest()
                    ->get();
            }
            // Return a successful response with data
            return response()->json([
                "status" => 200,
                "data" => $subLedger,
            ]);
        } catch (\Exception $e) {
            // Handle any exceptions that may occur
            return response()->json([
                "status" => 500,
                "message" => 'An error occurred while fetching Sub Ledger.',
                "error" => $e->getMessage()  // Optional: include exception message
            ]);
        }
    }


    public function details($id)
    {
        try {
            $subLedger = SubLedger::findOrFail($id);
            $primaryLedger = PrimaryLedgerGroup::findOrFail($subLedger->ledger->group_id);
            $branch = Branch::findOrFail($subLedger->branch_id);
            // Attempt to return the view
            return view('all_modules.ledgers.sub-ledgers.details', compact('subLedger', 'branch', 'primaryLedger'));
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error loading the bank view: ' . $e->getMessage());

            // Optionally return a custom error view or a simple error message
            return response()->view('errors.500', [], 500);
        }
    }
}
