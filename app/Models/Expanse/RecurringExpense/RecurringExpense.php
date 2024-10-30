<?php

namespace App\Models\Expanse\RecurringExpense;

use App\Models\ExpenseCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecurringExpense extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expanse_category_id', 'id');
    } //
}
