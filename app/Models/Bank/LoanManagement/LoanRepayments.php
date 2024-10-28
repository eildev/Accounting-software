<?php

namespace App\Models\Bank\LoanManagement;

use App\Models\Bank\BankAccounts;
use App\Models\Bank\Cash;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanRepayments extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function bankAccounts()
    {
        return $this->belongsTo(BankAccounts::class, 'bank_account_id', 'id');
    } //

    public function cashAccount()
    {
        return $this->belongsTo(Cash::class, 'cash_account_id', 'id');
    } //
}