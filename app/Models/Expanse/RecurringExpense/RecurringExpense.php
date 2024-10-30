<?php

namespace App\Models\Expanse\RecurringExpense;

use App\Models\ExpenseCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecurringExpense extends Model
{
    protected $fillable = [
        'expense_category_id',
        'amount',
        'name',
        'start_date',
        'recurrence_period',
        'next_due_date',
        'status'
    ];

    protected $casts = [
        'start_date' => 'date',
        'next_due_date' => 'date'
    ];


    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expanse_category_id', 'id');
    } //
}
