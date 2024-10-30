<?php

namespace App\Models\Bank\LoanManagement;

use App\Models\Bank\BankAccounts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function bankAccounts()
    {
        return $this->belongsTo(BankAccounts::class, 'bank_loan_account_id', 'id');
    } //
}
