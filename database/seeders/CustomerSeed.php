<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'id' => 1,
                'branch_id' => 1,
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'phone' => '1234567890',
                'address' => '123 Main Street, Cityville',

            ],
            [
                'id' => 2,
                'branch_id' => 1,
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'phone' => '9876543210',
                'address' => '456 Elm Street, Townsville',

            ],
            [
                'id' => 3,
                'branch_id' => 1,
                'name' => 'Mike Johnson',
                'email' => 'mike.johnson@example.com',
                'phone' => '5551234567',
                'address' => '789 Oak Lane, Villagetown',

            ],
            [
                'id' => 4,
                'branch_id' => 1,
                'name' => 'Alice Brown',
                'email' => 'alice.brown@example.com',
                'phone' => '7778889990',
                'address' => '321 Pine Avenue, Metropolis',

            ],
            [
                'id' => 5,
                'branch_id' => 1,
                'name' => 'Robert Green',
                'email' => 'robert.green@example.com',
                'phone' => '6665554443',
                'address' => '654 Cedar Road, Citystate',

            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
