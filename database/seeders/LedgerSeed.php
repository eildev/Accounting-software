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
                'account_name' => 'Banks',
                'slug' => 'banks',
            ],
            [
                'id' => 2,
                'branch_id' => 1,
                'group_id' => 1,
                'account_name' => 'Cash',
                'slug' => 'cash',
            ],
            [
                'id' => 3,
                'branch_id' => 1,
                'group_id' => 4,
                'account_name' => 'Loans',
                'slug' => 'loans',
            ],
            [
                'id' => 4,
                'branch_id' => 1,
                'group_id' => 2,
                'account_name' => 'Expanse',
                'slug' => 'regular-expanse',
            ],
            [
                'id' => 5,
                'branch_id' => 1,
                'group_id' => 2,
                'account_name' => 'Convenience Bill',
                'slug' => 'convenience-bill',
            ],
            [
                'id' => 6,
                'branch_id' => 1,
                'group_id' => 1,
                'account_name' => 'Fixed Asset',
                'slug' => 'fixed-asset',
            ],
            [
                'id' => 7,
                'branch_id' => 1,
                'group_id' => 2,
                'account_name' => 'Recurring Expanse',
                'slug' => 'recurring-expanse',
            ],
        ];

        foreach ($ledgers as $ledger) {
            LedgerAccounts::create($ledger);
        }
    }
}
