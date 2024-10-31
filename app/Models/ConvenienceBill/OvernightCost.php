<?php

namespace App\Models\ConvenienceBill;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OvernightCost extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function overnightDetails()
    {
        return $this->hasMany(OvernightCostDetails::class, 'overnight_cost_id', 'id');
    }
}
