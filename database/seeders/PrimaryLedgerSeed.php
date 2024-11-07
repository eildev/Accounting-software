<?php

namespace Database\Seeders;

use App\Models\Ledger\PrimaryLedger\PrimaryLedgerGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrimaryLedgerSeed extends Seeder
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
                'group_name' => 'Asset',
            ],
            [
                'id' => 2,
                'branch_id' => 1,
                'group_name' => 'Expanse',
            ],
            [
                'id' => 3,
                'branch_id' => 1,
                'group_name' => 'Income',
            ],
            [
                'id' => 4,
                'branch_id' => 1,
                'group_name' => 'Liabilities',
            ],
        ];

        foreach ($ledgers as $ledger) {
            PrimaryLedgerGroup::create($ledger);
        }
    }
}
