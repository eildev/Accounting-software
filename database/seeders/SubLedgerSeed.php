<?php

namespace Database\Seeders;

use App\Models\Ledger\SubLedger\SubLedger;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubLedgerSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subLedgers = [
            [
                'id' => 1,
                'branch_id' => 1,
                'account_id' => 1,
                'sub_ledger_name' => 'UCB Bank',
                'slug' => 'ucb-bank',
            ],
            [
                'id' => 2,
                'branch_id' => 1,
                'account_id' => 1,
                'sub_ledger_name' => 'City Bank',
                'slug' => 'city-bank',
            ],
            [
                'id' => 3,
                'branch_id' => 1,
                'account_id' => 2,
                'sub_ledger_name' => 'Cash Account',
                'slug' => 'cash-bank',
            ],
        ];
        foreach ($subLedgers as $subLedger) {
            SubLedger::create($subLedger);
        }
    }
}
