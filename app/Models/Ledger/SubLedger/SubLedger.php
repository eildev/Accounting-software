<?php

namespace App\Models\Ledger\SubLedger;
use App\Models\Expense;
use App\Models\Ledger\LedgerAccounts\LedgerAccounts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubLedger extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function ledger()
    {
        return $this->belongsTo(LedgerAccounts::class, 'account_id', 'id');
    }
    public function expanses()
    {
        return $this->hasMany(Expense::class, 'expense_category_id', 'id');
    }
}
