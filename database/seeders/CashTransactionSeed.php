<?php

namespace Database\Seeders;

use App\Models\Bank\CashTransaction;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CashTransactionSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cashTransaction = [
            [
                'id' => 1,
                'branch_id' => 1,
                'cash_id' => 1,
                'transaction_date' => Carbon::now(),
                'amount' => 100000,
                'transaction_type' => 'deposit',
                'process_by' => 1,
            ],
        ];
        foreach ($cashTransaction as $cash) {
            CashTransaction::create($cash);
        }
    }
}
