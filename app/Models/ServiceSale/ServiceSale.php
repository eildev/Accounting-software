<?php

namespace App\Models\ServiceSale;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceSale extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function customer() {
        return $this->belongsTo(Customer::class,'customer_id', 'id');
    }
}
