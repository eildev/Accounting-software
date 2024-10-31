<?php

namespace App\Models\ConvenienceBill;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodingCost extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function foodingDetails()
    {
        return $this->hasMany(FoodingCostDetails::class, 'fooding_cost_id', 'id');
    }


}
