<?php

namespace App\Models\ConvenienceBill;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovementCost extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function movementDetails()
    {
        return $this->hasMany(MovementCostDetails::class, 'movement_cost_id', 'id');
    }
}
