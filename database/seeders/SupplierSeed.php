<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'id' => 1,
                'branch_id' => 1,
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'phone' => '9876543210',
                'address' => '456 Elm Street, Townsville',
                'opening_receivable' => 3000,
                'opening_payable' => 800,
                'wallet_balance' => 500,
                'total_receivable' => 3500,
                'total_payable' => 1200,
            ],
            [
                'id' => 2,
                'branch_id' => 1,
                'name' => 'Mike Johnson',
                'email' => 'mike.johnson@example.com',
                'phone' => '5551234567',
                'address' => '789 Oak Lane, Villagetown',
                'opening_receivable' => 4500,
                'opening_payable' => 1200,
                'wallet_balance' => 100,
                'total_receivable' => 4800,
                'total_payable' => 1300,
            ],
            [
                'id' => 3,
                'branch_id' => 1,
                'name' => 'Alice Brown',
                'email' => 'alice.brown@example.com',
                'phone' => '7778889990',
                'address' => '321 Pine Avenue, Metropolis',
                'opening_receivable' => 2500,
                'opening_payable' => 700,
                'wallet_balance' => 300,
                'total_receivable' => 2900,
                'total_payable' => 1000,
            ],
            [
                'id' => 4,
                'branch_id' => 1,
                'name' => 'Robert Green',
                'email' => 'robert.green@example.com',
                'phone' => '6665554443',
                'address' => '654 Cedar Road, Citystate',
                'opening_receivable' => 5200,
                'opening_payable' => 1400,
                'wallet_balance' => 400,
                'total_receivable' => 5700,
                'total_payable' => 1700,
            ],
            [
                'id' => 5,
                'branch_id' => 1,
                'name' => 'Emily Davis',
                'email' => 'emily.davis@example.com',
                'phone' => '4445556667',
                'address' => '987 Maple Street, Uptown',
                'opening_receivable' => 4000,
                'opening_payable' => 900,
                'wallet_balance' => 250,
                'total_receivable' => 4300,
                'total_payable' => 1100,
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
