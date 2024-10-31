<?php

namespace App\Models\Bank\Transaction;

use App\Models\Bank\BankAccounts;
use App\Models\Bank\Cash;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function bank()
    {
        return $this->belongsTo(BankAccounts::class, 'bank_account_id', 'id');
    } //

    public function cash()
    {
        return $this->belongsTo(Cash::class, 'cash_account_id', 'id');
    } //
}
