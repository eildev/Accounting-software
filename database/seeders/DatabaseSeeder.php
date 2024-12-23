<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Bank\BankAccounts;
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
            PrimaryLedgerSeed::class,
            LedgerSeed::class,
            SubLedgerSeed::class,
            BanksAccountSeed::class,
            CashSeed::class,
            CashTransactionSeed::class,
            TransactionSeed::class,
            LedgerEntriesSeed::class,
            DepartmentSeed::class,
            CustomerSeed::class,
            SupplierSeed::class,
            EmployeeSeed::class,

        ]);
    }
}
