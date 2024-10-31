<?php

namespace App\Models\ConvenienceBill;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherExpenseCost extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function otherExpensetDetails()
    {
        return $this->hasMany(OtherExpenseCostDetails::class, 'other_expense_cost_id', 'id');
    }
}
