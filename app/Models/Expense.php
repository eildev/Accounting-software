<?php

namespace App\Models;

use App\Models\Bank\BankAccounts;
use App\Models\Bank\Cash;
use App\Models\Ledger\LedgerAccounts\LedgerAccounts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'branch_id',
        'expense_date',
        'expense_category_id',
        'purpose',
        'amount',
        'image',
        'spender',
        'bank_account_id',
        'cash_account_id',
        'note'
    ];

    protected $casts = [
        'expense_date' => 'date'
    ];

    public function expenseCat()
    {
        return $this->belongsTo(LedgerAccounts::class, 'expense_category_id', 'id');
    } //

    public function bank()
    {
        return $this->belongsTo(BankAccounts::class, 'bank_account_id', 'id');
    } //

    public function cash()
    {
        return $this->belongsTo(Cash::class, 'cash_account_id', 'id');
    } //


}
