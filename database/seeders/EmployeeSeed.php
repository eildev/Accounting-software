<?php

namespace Database\Seeders;

use App\Models\EmployeePayroll\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = [
            [
                'id' => 1,
                'branch_id' => 1,
                'full_name' => 'Jane Smith',
                'department_id' => 1,
                'address' => '456 Elm Street, Townsville',
                'phone' => '9876543210',
                'email' => 'jane.smith@example.com',
                'nid' => '1234567890123',
                'designation' => 'Software Engineer',
            ],
            [
                'id' => 2,
                'branch_id' => 1,
                'full_name' => 'John Doe',
                'department_id' => 1,
                'address' => '123 Main Street, Cityville',
                'phone' => '1234567890',
                'email' => 'john.doe@example.com',
                'nid' => '9876543210987',
                'designation' => 'Network Administrator',
            ],
            [
                'id' => 3,
                'branch_id' => 1,
                'full_name' => 'Alice Brown',
                'department_id' => 1,
                'address' => '789 Oak Lane, Villagetown',
                'phone' => '5551234567',
                'email' => 'alice.brown@example.com',
                'nid' => '1122334455667',
                'designation' => 'System Analyst',
            ],
            [
                'id' => 4,
                'branch_id' => 1,
                'full_name' => 'Mike Johnson',
                'department_id' => 2,
                'address' => '321 Pine Avenue, Metropolis',
                'phone' => '7778889990',
                'email' => 'mike.johnson@example.com',
                'nid' => '2233445566778',
                'designation' => 'HR Manager',
            ],
            [
                'id' => 5,
                'branch_id' => 1,
                'full_name' => 'Emily Davis',
                'department_id' => 2,
                'address' => '654 Cedar Road, Citystate',
                'phone' => '6665554443',
                'email' => 'emily.davis@example.com',
                'nid' => '3344556677889',
                'designation' => 'Finance Officer',
            ],
        ];

        foreach ($employees as $employee) {
            Employee::create($employee);
        }
    }
}
