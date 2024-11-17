<?php

namespace Database\Seeders;

use App\Models\Bank\Cash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CashSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cashes = [
            [
                'id' => 1,
                'branch_id' => 1,
                'cash_account_name' => 'Cash Account',
                'opening_balance' => 100000,
                'current_balance' => 100000,
            ],
        ];
        foreach ($cashes as $cash) {
            Cash::create($cash);
        }
    }
}
