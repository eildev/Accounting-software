<?php

namespace App\Models\Assets;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetTypes extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
}
