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

            ],
            [
                'id' => 2,
                'branch_id' => 1,
                'name' => 'Mike Johnson',
                'email' => 'mike.johnson@example.com',
                'phone' => '5551234567',
                'address' => '789 Oak Lane, Villagetown',

            ],
            [
                'id' => 3,
                'branch_id' => 1,
                'name' => 'Alice Brown',
                'email' => 'alice.brown@example.com',
                'phone' => '7778889990',
                'address' => '321 Pine Avenue, Metropolis',

            ],
            [
                'id' => 4,
                'branch_id' => 1,
                'name' => 'Robert Green',
                'email' => 'robert.green@example.com',
                'phone' => '6665554443',
                'address' => '654 Cedar Road, Citystate',

            ],
            [
                'id' => 5,
                'branch_id' => 1,
                'name' => 'Emily Davis',
                'email' => 'emily.davis@example.com',
                'phone' => '4445556667',
                'address' => '987 Maple Street, Uptown',

            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
