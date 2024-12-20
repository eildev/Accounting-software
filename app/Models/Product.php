<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id', 'id');
    }
    function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }
    function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }
    function size()
    {
        return $this->belongsTo(Psize::class, 'size_id', 'id');
    }
    //
    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class, 'product_id');
    }
    public function stockQuantity()
    {
        return $this->hasMany(Stock::class, 'product_id');
    }
}
