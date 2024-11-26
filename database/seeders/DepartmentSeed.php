<?php

namespace Database\Seeders;

use App\Models\Departments\Departments;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'id' => 1,
                'branch_id' => 1,
                'name' => 'IT Department',
            ],
            [
                'id' => 2,
                'branch_id' => 1,
                'name' => 'Sales Department',
            ],
        ];
        foreach ($departments as $department) {
            Departments::create($department);
        }
    }
}
