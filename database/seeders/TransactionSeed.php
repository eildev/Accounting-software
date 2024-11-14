<?php

namespace Database\Seeders;

use App\Models\Bank\Transaction\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use League\CommonMark\Extension\CommonMark\Parser\Inline\BangParser;

class TransactionSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transactions = [
            [
                'id' => 1,
                'branch_id' => 1,
                'source_type' => "Bank Transaction",
                'transaction_date' => Carbon::now(),
                'bank_account_id' => 1,
                'amount' => 100000,
                'transaction_type' => 'credit',
                'transaction_id' => "3uwy7273",
                'transaction_by' => 1,
            ],
            [
                'id' => 2,
                'branch_id' => 1,
                'source_type' => "Bank Transaction",
                'transaction_date' => Carbon::now(),
                'bank_account_id' => 2,
                'amount' => 100000,
                'transaction_type' => 'credit',
                'transaction_id' => "3e7r2d7w3",
                'transaction_by' => 1,
            ],
            [
                'id' => 3,
                'branch_id' => 1,
                'source_type' => "Cash Transaction",
                'transaction_date' => Carbon::now(),
                'cash_account_id' => 1,
                'amount' => 100000,
                'transaction_type' => 'credit',
                'transaction_id' => "4e1r6w8",
                'transaction_by' => 1,
            ],
        ];
        foreach ($transactions as $transaction) {
            Transaction::create($transaction);
        }
    }
}
