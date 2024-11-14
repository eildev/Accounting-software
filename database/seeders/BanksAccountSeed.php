<?php

namespace Database\Seeders;

use App\Models\Bank\BankAccounts;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BanksAccountSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banks = [
            [
                'id' => 1,
                'branch_id' => 1,
                'account_name' => 'UCB Account',
                'account_number' => "45869542",
                'bank_name' => 'UCB Bank',
                'bank_branch_name' => 'Dhaka',
                'initial_balance' => 100000,
                'current_balance' => 100000,
                'currency_code' => 'bdt',
            ],
            [
                'id' => 2,
                'branch_id' => 1,
                'account_name' => 'City Bank Account',
                'account_number' => "59869585",
                'bank_name' => 'City Bank',
                'bank_branch_name' => 'Dhaka',
                'initial_balance' => 100000,
                'current_balance' => 100000,
                'currency_code' => 'bdt',
            ],
        ];
        foreach ($banks as $bank) {
            BankAccounts::create($bank);
        }
    }
}
