<?php

namespace App\Models\Ledger\LedgerAccounts;

use App\Models\Ledger\PrimaryLedger\PrimaryLedgerGroup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LedgerAccounts extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function ledgerGroup()
    {
        return $this->belongsTo(PrimaryLedgerGroup::class, 'group_id', 'id');
    }
}
