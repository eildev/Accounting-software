<?php

namespace Database\Seeders;

use App\Models\Ledger\LedgerAccounts\LedgerEntries;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LedgerEntriesSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ledgerEntries = [
            [
                'id' => 1,
                'branch_id' => 1,
                'transaction_id' => 1,
                'group_id' => 1,
                'account_id' => 1,
                'sub_ledger_id' => 1,
                'entry_amount' => 100000,
                'transaction_date' => Carbon::now(),
                'transaction_by' => 1,
            ],
            [
                'id' => 2,
                'branch_id' => 1,
                'transaction_id' => 2,
                'group_id' => 1,
                'account_id' => 1,
                'sub_ledger_id' => 2,
                'entry_amount' => 100000,
                'transaction_date' => Carbon::now(),
                'transaction_by' => 1,
            ],
            [
                'id' => 3,
                'branch_id' => 1,
                'transaction_id' => 3,
                'group_id' => 1,
                'account_id' => 2,
                'sub_ledger_id' => 3,
                'entry_amount' => 100000,
                'transaction_date' => Carbon::now(),
                'transaction_by' => 1,
            ],
        ];
        foreach ($ledgerEntries as $entries) {
            LedgerEntries::create($entries);
        }
    }
}
