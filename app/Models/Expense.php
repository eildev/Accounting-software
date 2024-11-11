<?php

namespace App\Models;

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
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id', 'id');
    } //


}
