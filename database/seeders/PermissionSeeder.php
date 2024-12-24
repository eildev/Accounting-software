<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['id' => 1, 'name' => 'pos.menu', 'guard_name' => 'web', 'group_name' => 'pos'],

            ['id' => 2, 'name' => 'pos-manage.menu', 'guard_name' => 'web', 'group_name' => 'pos-manage'],
            ['id' => 3, 'name' => 'pos-manage.invoice', 'guard_name' => 'web', 'group_name' => 'pos-manage'],
            ['id' => 4, 'name' => 'pos-manage.edit', 'guard_name' => 'web', 'group_name' => 'pos-manage'],
            ['id' => 5, 'name' => 'pos-manage.delete', 'guard_name' => 'web', 'group_name' => 'pos-manage'],

            ['id' => 6, 'name' => 'products.menu', 'guard_name' => 'web', 'group_name' => 'products'],
            ['id' => 7, 'name' => 'products.list', 'guard_name' => 'web', 'group_name' => 'products'],
            ['id' => 8, 'name' => 'products.edit', 'guard_name' => 'web', 'group_name' => 'products'],
            ['id' => 9, 'name' => 'products.delete', 'guard_name' => 'web', 'group_name' => 'products'],

            ['id' => 10, 'name' => 'category.menu', 'guard_name' => 'web', 'group_name' => 'category'],
            ['id' => 11, 'name' => 'category.edit', 'guard_name' => 'web', 'group_name' => 'category'],
            ['id' => 12, 'name' => 'category.delete', 'guard_name' => 'web', 'group_name' => 'category'],

            ['id' => 13, 'name' => 'subcategory.menu', 'guard_name' => 'web', 'group_name' => 'sub-category'],
            ['id' => 14, 'name' => 'subcategory.edit', 'guard_name' => 'web', 'group_name' => 'sub-category'],
            ['id' => 15, 'name' => 'subcategory.delete', 'guard_name' => 'web', 'group_name' => 'sub-category'],

            ['id' => 16, 'name' => 'brand.menu', 'guard_name' => 'web', 'group_name' => 'brand'],
            ['id' => 17, 'name' => 'brand.edit', 'guard_name' => 'web', 'group_name' => 'brand'],
            ['id' => 18, 'name' => 'brand.delete', 'guard_name' => 'web', 'group_name' => 'brand'],

            ['id' => 19, 'name' => 'unit.menu', 'guard_name' => 'web', 'group_name' => 'unit'],
            ['id' => 20, 'name' => 'unit.edit', 'guard_name' => 'web', 'group_name' => 'unit'],
            ['id' => 21, 'name' => 'unit.delete', 'guard_name' => 'web', 'group_name' => 'unit'],

            ['id' => 22, 'name' => 'products-size.menu', 'guard_name' => 'web', 'group_name' => 'product-size'],
            ['id' => 23, 'name' => 'products-size.add', 'guard_name' => 'web', 'group_name' => 'product-size'],
            ['id' => 24, 'name' => 'products-size.edit', 'guard_name' => 'web', 'group_name' => 'product-size'],
            ['id' => 25, 'name' => 'products-size.delete', 'guard_name' => 'web', 'group_name' => 'product-size'],

            ['id' => 26, 'name' => 'tax.menu', 'guard_name' => 'web', 'group_name' => 'taxes'],
            ['id' => 27, 'name' => 'tax.edit', 'guard_name' => 'web', 'group_name' => 'taxes'],
            ['id' => 28, 'name' => 'tax.delete', 'guard_name' => 'web', 'group_name' => 'taxes'],

            ['id' => 29, 'name' => 'products.add', 'guard_name' => 'web', 'group_name' => 'products'],

            ['id' => 30, 'name' => 'supplier.menu', 'guard_name' => 'web', 'group_name' => 'supplier'],
            ['id' => 31, 'name' => 'supplier.edit', 'guard_name' => 'web', 'group_name' => 'supplier'],
            ['id' => 32, 'name' => 'supplier.delete', 'guard_name' => 'web', 'group_name' => 'supplier'],

            ['id' => 33, 'name' => 'purchase.menu', 'guard_name' => 'web', 'group_name' => 'purchase'],
            ['id' => 34, 'name' => 'purchase.add', 'guard_name' => 'web', 'group_name' => 'purchase'],
            ['id' => 35, 'name' => 'purchase.list', 'guard_name' => 'web', 'group_name' => 'purchase'],
            ['id' => 36, 'name' => 'purchase.edit', 'guard_name' => 'web', 'group_name' => 'purchase'],
            ['id' => 37, 'name' => 'purchase.delete', 'guard_name' => 'web', 'group_name' => 'purchase'],

            ['id' => 38, 'name' => 'promotion.menu', 'guard_name' => 'web', 'group_name' => 'promotion'],
            ['id' => 39, 'name' => 'promotion.add', 'guard_name' => 'web', 'group_name' => 'promotion'],
            ['id' => 40, 'name' => 'promotion.edit', 'guard_name' => 'web', 'group_name' => 'promotion'],
            ['id' => 41, 'name' => 'promotion.delete', 'guard_name' => 'web', 'group_name' => 'promotion'],



            ['id' => 46, 'name' => 'damage.menu', 'guard_name' => 'web', 'group_name' => 'damage'],
            ['id' => 47, 'name' => 'damage.add', 'guard_name' => 'web', 'group_name' => 'damage'],
            ['id' => 48, 'name' => 'damage.edit', 'guard_name' => 'web', 'group_name' => 'damage'],
            ['id' => 49, 'name' => 'damage.delete', 'guard_name' => 'web', 'group_name' => 'damage'],

            ['id' => 50, 'name' => 'bank.menu', 'guard_name' => 'web', 'group_name' => 'bank'],
            ['id' => 51, 'name' => 'bank.edit', 'guard_name' => 'web', 'group_name' => 'bank'],
            ['id' => 52, 'name' => 'bank..delete', 'guard_name' => 'web', 'group_name' => 'bank'],

            ['id' => 53, 'name' => 'expense.menu', 'guard_name' => 'web', 'group_name' => 'expense'],
            ['id' => 54, 'name' => 'expense.edit', 'guard_name' => 'web', 'group_name' => 'expense'],
            ['id' => 55, 'name' => 'expense.delete', 'guard_name' => 'web', 'group_name' => 'expense'],

            ['id' => 56, 'name' => 'transaction.menu', 'guard_name' => 'web', 'group_name' => 'transaction'],
            ['id' => 57, 'name' => 'transaction.history', 'guard_name' => 'web', 'group_name' => 'transaction'],
            ['id' => 58, 'name' => 'transaction.delete', 'guard_name' => 'web', 'group_name' => 'transaction'],

            ['id' => 59, 'name' => 'customer.menu', 'guard_name' => 'web', 'group_name' => 'customer'],
            ['id' => 60, 'name' => 'customer.add', 'guard_name' => 'web', 'group_name' => 'customer'],
            ['id' => 61, 'name' => 'customer.edit', 'guard_name' => 'web', 'group_name' => 'customer'],
            ['id' => 62, 'name' => 'customer.delete', 'guard_name' => 'web', 'group_name' => 'customer'],

            ['id' => 63, 'name' => 'employee.menu', 'guard_name' => 'web', 'group_name' => 'employee-payroll'],
            ['id' => 64, 'name' => 'employee.add', 'guard_name' => 'web', 'group_name' => 'employee-payroll'],
            ['id' => 65, 'name' => 'employee.edit', 'guard_name' => 'web', 'group_name' => 'employee-payroll'],
            ['id' => 66, 'name' => 'employee.delete', 'guard_name' => 'web', 'group_name' => 'employee-payroll'],

            ['id' => 67, 'name' => 'employee.payroll.menu', 'guard_name' => 'web', 'group_name' => 'employee-payroll'],
            ['id' => 68, 'name' => 'departments.menu', 'guard_name' => 'web', 'group_name' => 'employee-payroll'],
            ['id' => 69, 'name' => 'salary.structure.menu', 'guard_name' => 'web', 'group_name' => 'employee-payroll'],
            ['id' => 70, 'name' => 'conveyance.bill.menu', 'guard_name' => 'web', 'group_name' => 'employee-payroll'],
            ['id' => 71, 'name' => 'conveyance.report', 'guard_name' => 'web', 'group_name' => 'employee-payroll'],
            ['id' => 72, 'name' => 'conveyance.bill', 'guard_name' => 'web', 'group_name' => 'employee-payroll'],

            ['id' => 42, 'name' => 'employee.list', 'guard_name' => 'web', 'group_name' => 'employee-payroll'],
            ['id' => 43, 'name' => 'employee.bonuses.menu', 'guard_name' => 'web', 'group_name' => 'employee-payroll'],
            ['id' => 44, 'name' => 'salary.sheet.menu', 'guard_name' => 'web', 'group_name' => 'employee-payroll'],
            ['id' => 45, 'name' => 'service.sale.menu', 'guard_name' => 'web', 'group_name' => 'service-sale'],

            ['id' => 73, 'name' => 'crm.menu', 'guard_name' => 'web', 'group_name' => 'crm'],
            ['id' => 74, 'name' => 'crm.customize-customer', 'guard_name' => 'web', 'group_name' => 'crm'],
            ['id' => 75, 'name' => 'crm.email-marketing', 'guard_name' => 'web', 'group_name' => 'crm'],
            ['id' => 76, 'name' => 'crm.sms-marketing', 'guard_name' => 'web', 'group_name' => 'crm'],

            ['id' => 77, 'name' => 'role-and-permission.menu', 'guard_name' => 'web', 'group_name' => 'role-and-permissions'],
            ['id' => 78, 'name' => 'role-and-permission.all-permission', 'guard_name' => 'web', 'group_name' => 'role-and-permissions'],
            ['id' => 79, 'name' => 'role-and-permission.all-permission.add', 'guard_name' => 'web', 'group_name' => 'role-and-permissions'],
            ['id' => 80, 'name' => 'role-and-permission.all-permission.edit', 'guard_name' => 'web', 'group_name' => 'role-and-permissions'],
            ['id' => 81, 'name' => 'role-and-permission.all-permission.delete', 'guard_name' => 'web', 'group_name' => 'role-and-permissions'],
            ['id' => 82, 'name' => 'role-and-permission.all-role', 'guard_name' => 'web', 'group_name' => 'role-and-permissions'],
            ['id' => 83, 'name' => 'role-and-permission.all-role.add', 'guard_name' => 'web', 'group_name' => 'role-and-permissions'],
            ['id' => 84, 'name' => 'role-and-permission.all-role.edit', 'guard_name' => 'web', 'group_name' => 'role-and-permissions'],
            ['id' => 85, 'name' => 'role-and-permission.all-role.delete', 'guard_name' => 'web', 'group_name' => 'role-and-permissions'],
            ['id' => 86, 'name' => 'role-and-permission.role-in-permission', 'guard_name' => 'web', 'group_name' => 'role-and-permissions'],
            ['id' => 87, 'name' => 'role-and-permission-check-role-permission', 'guard_name' => 'web', 'group_name' => 'role-and-permissions'],
            ['id' => 88, 'name' => 'role-and-permission-check-role-permission.edit', 'guard_name' => 'web', 'group_name' => 'role-and-permissions'],
            ['id' => 89, 'name' => 'role-and-permission-check-role-permission.delete', 'guard_name' => 'web', 'group_name' => 'role-and-permissions'],

            ['id' => 90, 'name' => 'admin-manage.menu', 'guard_name' => 'web', 'group_name' => 'admin-manage'],
            ['id' => 91, 'name' => 'admin-manage.add', 'guard_name' => 'web', 'group_name' => 'admin-manage'],
            ['id' => 92, 'name' => 'admin-manage.edit', 'guard_name' => 'web', 'group_name' => 'admin-manage'],
            ['id' => 93, 'name' => 'admin-manage.delete', 'guard_name' => 'web', 'group_name' => 'admin-manage'],
            ['id' => 94, 'name' => 'admin-manage.list', 'guard_name' => 'web', 'group_name' => 'admin-manage'],

            ['id' => 95, 'name' => 'settings.menu', 'guard_name' => 'web', 'group_name' => 'settings'],

            ['id' => 96, 'name' => 'branch.menu', 'guard_name' => 'web', 'group_name' => 'branch'],
            ['id' => 97, 'name' => 'branch.add', 'guard_name' => 'web', 'group_name' => 'branch'],
            ['id' => 98, 'name' => 'branch.edit', 'guard_name' => 'web', 'group_name' => 'branch'],
            ['id' => 99, 'name' => 'branch.delete', 'guard_name' => 'web', 'group_name' => 'branch'],

            ['id' => 100, 'name' => 'report.menu', 'guard_name' => 'web', 'group_name' => 'report'],
            ['id' => 101, 'name' => 'return.menu', 'guard_name' => 'web', 'group_name' => 'return'],
            //Dashboard Permissison
            ['id' => 102, 'name' => 'main.dashboard', 'guard_name' => 'web', 'group_name' => 'dashboard'],
            ['id' => 103, 'name' => 'sale.dashboard', 'guard_name' => 'web', 'group_name' => 'dashboard'],
            ['id' => 104, 'name' => 'customer.dashboard', 'guard_name' => 'web', 'group_name' => 'dashboard'],
            ['id' => 105, 'name' => 'payroll.dashboard', 'guard_name' => 'web', 'group_name' => 'dashboard'],
            ['id' => 106, 'name' => 'expanse.dashboard', 'guard_name' => 'web', 'group_name' => 'dashboard'],
            ['id' => 107, 'name' => 'menu.dashboard', 'guard_name' => 'web', 'group_name' => 'dashboard'],
            ['id' => 108, 'name' => 'accounting.menu', 'guard_name' => 'web', 'group_name' => 'accounting'],
            ['id' => 109, 'name' => 'menu.loan.managment', 'guard_name' => 'web', 'group_name' => 'accounting'],
            ['id' => 110, 'name' => 'ledger.menu', 'guard_name' => 'web', 'group_name' => 'ledger'],
            ['id' => 111, 'name' => 'all.ledger', 'guard_name' => 'web', 'group_name' => 'ledger'],
            ['id' => 112, 'name' => 'sub.ledger', 'guard_name' => 'web', 'group_name' => 'ledger'],
            ['id' => 113, 'name' => 'assets.menu', 'guard_name' => 'web', 'group_name' => 'assets'],
            ['id' => 114, 'name' => 'asset.managment', 'guard_name' => 'web', 'group_name' => 'assets'],
            ['id' => 115, 'name' => 'asset.revaluation', 'guard_name' => 'web', 'group_name' => 'assets'],
            ['id' => 116, 'name' => 'setting.and.customize.menu', 'guard_name' => 'web', 'group_name' => 'settings'],
            ['id' => 117, 'name' => 'genarate.payslip.single', 'guard_name' => 'web', 'group_name' => 'other'],
            ['id' => 118, 'name' => 'genarate.payslip.all', 'guard_name' => 'web', 'group_name' => 'other'],
            ['id' => 119, 'name' => 'salary.sheet1', 'guard_name' => 'web', 'group_name' => 'employee-payroll'],
            ['id' => 120, 'name' => 'salary.sheet2', 'guard_name' => 'web', 'group_name' => 'employee-payroll'],
            ['id' => 121, 'name' => 'leave.application.menu', 'guard_name' => 'web', 'group_name' => 'leave-application'],
            ['id' => 122, 'name' => 'leave.application.add', 'guard_name' => 'web', 'group_name' => 'leave-application'],
            ['id' => 123, 'name' => 'leave.application.view', 'guard_name' => 'web', 'group_name' => 'leave-application'],
            ['id' => 124, 'name' => 'leave.application.status', 'guard_name' => 'web', 'group_name' => 'leave-application'],
            ['id' => 125, 'name' => 'leave.limit', 'guard_name' => 'web', 'group_name' => 'leave-application'],
            ['id' => 126, 'name' => 'leave.type', 'guard_name' => 'web', 'group_name' => 'leave-application'],
            // add more permissions as needed
        ];

        // Insert permissions into the database
        DB::table('permissions')->insert($permissions);
    }
}
