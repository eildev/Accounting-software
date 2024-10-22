<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BranchSeed::class,
            UserSeed::class,
            SettingSeed::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            RoleHasPermission::class,
            ModelHasRolesSeeder::class,
            ExpenseCategorySeeder::class,
        ]);
    }
}
