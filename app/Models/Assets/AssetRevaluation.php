<?php

namespace App\Models\Assets;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetRevaluation extends Model
{
    use HasFactory;
    protected $guarded = [];

    function asset()
    {
        return $this->belongsTo(Assets::class, 'asset_id', 'id');
    }
}
