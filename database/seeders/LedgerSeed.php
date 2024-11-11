<?php

namespace Database\Seeders;

use App\Models\Ledger\LedgerAccounts\LedgerAccounts;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LedgerSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ledgers = [
            [
                'id' => 1,
                'branch_id' => 1,
                'group_id' => 1,
                'account_name' => 'Bank',
            ],
            [
                'id' => 2,
                'branch_id' => 1,
                'group_id' => 1,
                'account_name' => 'Cash',
            ],
            [
                'id' => 3,
                'branch_id' => 1,
                'group_id' => 4,
                'account_name' => 'Loan',
            ],
        ];

        foreach ($ledgers as $ledger) {
            LedgerAccounts::create($ledger);
        }
    }
}
