<?php

namespace App\Http\Controllers\Ledgers;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Ledger\LedgerAccounts\LedgerAccounts;
use App\Models\Ledger\LedgerAccounts\LedgerEntries;
use App\Models\Ledger\PrimaryLedger\PrimaryLedgerGroup;
use App\Models\Ledger\SubLedger\SubLedger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LedgerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Attempt to return the view
            return view('all_modules.ledgers.index');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error loading the bank view: ' . $e->getMessage());

            // Optionally return a custom error view or a simple error message
            return response()->view('errors.500', [], 500);
        }
    }


    /**
     * Store a Primary Ledger Information.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        try {
            // Validate the incoming request
            $validator = Validator::make($request->all(), [
                'group_name' => 'required|max:99',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => '500',
                    'error' => $validator->messages()
                ]);
            }

            // If validation passes, proceed with saving the Primary Ledger details
            $ledger = new PrimaryLedgerGroup();
            $ledger->branch_id = Auth::user()->branch_id;
            $ledger->group_name = $request->group_name;
            $ledger->slug = Str::slug($request->group_name);
            $ledger->save();
            return response()->json([
                'status' => 200,
                'message' => 'Primary Ledger Saved Successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => 500,
                "message" => 'An error occurred while fetching Primary Ledger',
                "error" => $e->getMessage()  // Optional: include exception message
            ]);
        }
    }

    /**
     * View a Primary Ledger Information.
     */
    public function view()
    {
        try {
            // Fetch the bank accounts based on user type (admin or branch)
            if (Auth::user()->id == 1) {
                $primaryLedgers = PrimaryLedgerGroup::latest()->get();  // Fetch all for admin
            } else {
                $primaryLedgers = PrimaryLedgerGroup::where('branch_id', Auth::user()->branch_id)
                    ->latest()
                    ->get();
            }
            // Return a successful response with data
            return response()->json([
                "status" => 200,
                "data" => $primaryLedgers,
            ]);
        } catch (\Exception $e) {
            // Handle any exceptions that may occur
            return response()->json([
                "status" => 500,
                "message" => 'An error occurred while fetching bank accounts.',
                "error" => $e->getMessage()  // Optional: include exception message
            ]);
        }
    }


    public function storeAllLedger(Request $request)
    {
        try {
            // Validate the incoming request
            $validator = Validator::make($request->all(), [
                'group_id' => 'required|integer|max:10',
                'account_name' => 'required|max:99',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => '500',
                    'error' => $validator->messages()
                ]);
            }

            // If validation passes, proceed with saving the Primary Ledger details
            $ledger = new LedgerAccounts;
            $ledger->branch_id = Auth::user()->branch_id;
            $ledger->group_id = $request->group_id;
            $ledger->account_name = $request->account_name;
            $ledger->slug = Str::slug($request->account_name);

            $ledger->save();
            return response()->json([
                'status' => 200,
                'message' => 'Ledger Saved Successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => 500,
                "message" => 'An error occurred while fetching Ledger',
                "error" => $e->getMessage()  // Optional: include exception message
            ]);
        }
    }

    /** 
     * View a Primary Ledger Information.
     */
    public function viewAllLedger()
    {
        try {
            // Fetch the bank accounts based on user type (admin or branch)
            if (Auth::user()->id == 1) {
                $ledgers = LedgerAccounts::with('ledgerGroup')->latest()->get();  // Fetch all for admin
            } else {
                $ledgers = LedgerAccounts::with('ledgerGroup')->where('branch_id', Auth::user()->branch_id)
                    ->latest()
                    ->get();
            }
            // Return a successful response with data
            return response()->json([
                "status" => 200,
                "data" => $ledgers,
            ]);
        } catch (\Exception $e) {
            // Handle any exceptions that may occur
            return response()->json([
                "status" => 500,
                "message" => 'An error occurred while fetching Ledger Info.',
                "error" => $e->getMessage()  // Optional: include exception message
            ]);
        }
    }


    // ledger details Function 
    public function ledgerDetails($id)
    {
        try {
            // Fetch the bank accounts based on user type (admin or branch)
            $primaryLedger = PrimaryLedgerGroup::findOrFail($id);
            $ledgers = LedgerAccounts::where('group_id', $id)->get();
            $branch = Branch::findOrFail($primaryLedger->branch_id);
            $totalAmount = LedgerEntries::where('group_id', $primaryLedger->id)->sum('entry_amount');
            // Return a successful response with data
            // Attempt to return the view
            return view('all_modules.ledgers.primary-ledgers-details', compact('primaryLedger', 'branch', 'ledgers', 'totalAmount'));
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error loading the Ledger details: ' . $e->getMessage());

            // Optionally return a custom error view or a simple error message
            return response()->view('errors.500', [], 500);
        }
    }


    // ledger details Function 
    public function viewAllLedgerCategoryWise($id)
    {
        try {
            $ledgers = LedgerAccounts::where('group_id', $id)->get();
            // Return a successful response with data
            // Attempt to return the view
            return response()->json([
                "status" => 200,
                "data" => $ledgers,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => 500,
                "message" => 'An error occurred while fetching Ledger Info.',
                "error" => $e->getMessage()  // Optional: include exception message
            ]);
        }
    }


    public function allLedgerDetails($id)
    {
        try {
            // Fetch the bank accounts based on user type (admin or branch)
            $ledger = LedgerAccounts::findOrFail($id);
            $branch = Branch::findOrFail($ledger->branch_id);
            $subLedgers = SubLedger::where('account_id', $id)->get();
            $totalAmount = LedgerEntries::where('account_id', $ledger->id)->sum('entry_amount');
            // Return a successful response with data
            // Attempt to return the view
            return view('all_modules.ledgers.ledger-details', compact('ledger', 'branch', 'subLedgers', 'totalAmount'));
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error loading the Ledger details: ' . $e->getMessage());

            // Optionally return a custom error view or a simple error message
            return response()->view('errors.500', [], 500);
        }
    }



    // ledger details Function 
    public function viewSubLedgerCategoryWise($id)
    {
        try {
            $subLedger = SubLedger::where('account_id', $id)->get();
            // Return a successful response with data
            // Attempt to return the view
            return response()->json([
                "status" => 200,
                "data" => $subLedger,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => 500,
                "message" => 'An error occurred while fetching Ledger Info.',
                "error" => $e->getMessage()  // Optional: include exception message
            ]);
        }
    }
}
