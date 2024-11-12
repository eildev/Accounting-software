<?php

namespace App\Models\Assets;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assets extends Model
{
    use HasFactory;
    protected $guarded = [];

    function assetType()
    {
        return $this->belongsTo(AssetTypes::class, 'asset_type_id', 'id');
    }
}
