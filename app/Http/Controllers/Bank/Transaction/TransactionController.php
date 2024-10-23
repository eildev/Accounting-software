<?php

namespace App\Http\Controllers\Bank\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Bank\BankAccounts;
use App\Models\Bank\Cash;
use App\Models\Investor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function transaction()
    {
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
    } //
}
