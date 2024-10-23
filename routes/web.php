<?php

use App\Http\Controllers\Bank\BankAccountsController;
use App\Http\Controllers\Bank\CashTransactionController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeePayroll\EmployeeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PosSettingsController;
use App\Http\Controllers\EmployeeSalaryController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\CompanyBalanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeePayroll\DepartmentsController;
use App\Http\Controllers\EmployeePayroll\SalaryStructureController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('dashboard.blank');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {

    //Profile Route
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
        Route::get('/user/profile', 'UserProfileEdit')->name('user.profile.edit');
        Route::get('profile', 'UserProfile')->name('user.profile');
        Route::post('user/profile/update', 'UserProfileUpdate')->name('user.profile.update');
        /////////////////////////Change Password//////////////////////
        Route::get('/change-password', 'ChangePassword')->name('user.change.password');
        Route::post('/update-password', 'updatePassword')->name('user.update.password');
    });


    // Branch related route(n)
    Route::controller(BranchController::class)->group(function () {
        Route::get('/branch', 'index')->name('branch');
        Route::post('/branch/store', 'store')->name('branch.store');
        Route::get('/branch/view', 'BranchView')->name('branch.view');
        Route::get('/branch/edit/{id}', 'BranchEdit')->name('branch.edit');
        Route::post('/branch/update/{id}', 'BranchUpdate')->name('branch.update');
        Route::get('/branch/delete/{id}', 'BranchDelete')->name('branch.delete');
    });

    // // Customer related route(n)
    Route::controller(CustomerController::class)->group(function () {
        Route::get('/customer/add', 'AddCustomer')->name('customer.add');
        Route::post('/customer/store', 'CustomerStore')->name('customer.store');
        Route::get('/customer/view', 'CustomerView')->name('customer.view');
        Route::get('/customer/edit/{id}', 'CustomerEdit')->name('customer.edit');
        Route::post('/customer/update/{id}', 'CustomerUpdate')->name('customer.update');
        Route::get('/customer/delete/{id}', 'CustomerDelete')->name('customer.delete');
        // customer profiling
        Route::get('/customer/profile/{id}', 'CustomerProfile')->name('customer.profile');
    });

    // // Employee related route(n)
    Route::controller(EmployeeController::class)->group(function () {
        Route::get('/employee', 'index')->name('employee');
        Route::post('/employee/store', 'store')->name('employee.store');
        Route::get('/employee/view', 'view')->name('employee.view');
        Route::get('/employee/edit/{id}', 'edit')->name('employee.edit');
        Route::post('/employee/update/{id}', 'update')->name('employee.update');
        Route::get('/employee/delete/{id}', 'destroy')->name('employee.delete');
    });

    // Banks related route
    Route::controller(BankAccountsController::class)->group(function () {
        Route::get('/bank', 'index')->name('bank');
        Route::post('/bank/store', 'store')->name('bank.store');
        Route::get('/bank/view', 'view')->name('bank.view');
        // Route::get('/bank/edit/{id}', 'edit')->name('bank.edit');
        // Route::post('/bank/update/{id}', 'update')->name('bank.update');
        // Route::get('/bank/destroy/{id}', 'destroy')->name('bank.destroy');
        // Route::post('/add/bank/balance/{id}', 'BankBalanceAdd');
    });

    // Cash related route
    Route::controller(CashTransactionController::class)->group(function () {
        Route::post('/cash-account/store', 'store')->name('cash.account.store');
        Route::get('/cash-account/view', 'view')->name('cash.account.view');
        // Route::get('/bank/edit/{id}', 'edit')->name('bank.edit');
        // Route::post('/bank/update/{id}', 'update')->name('bank.update');
        // Route::get('/bank/destroy/{id}', 'destroy')->name('bank.destroy');
        // Route::post('/add/bank/balance/{id}', 'BankBalanceAdd');
    });


    // Expense related route(n)
    Route::controller(ExpenseController::class)->group(function () {
        //Expense category route(n)
        Route::post('/expense/category/store', 'ExpenseCategoryStore')->name('expense.category.store');
        Route::get('/expense/category/delete/{id}', 'ExpenseCategoryDelete')->name('expense.category.delete');
        Route::get('/expense/category/edit/{id}', 'ExpenseCategoryEdit')->name('expense.category.edit');
        Route::post('/expense/category/update/{id}', 'ExpenseCategoryUpdate')->name('expense.category.update');
        //Expense route
        Route::get('/expense/add', 'ExpenseAdd')->name('expense.add');
        Route::post('/expense/store', 'ExpenseStore')->name('expense.store');
        Route::get('/expense/view', 'ExpenseView')->name('expense.view');
        Route::get('/expense/edit/{id}', 'ExpenseEdit')->name('expense.edit');
        Route::post('/expense/update/{id}', 'ExpenseUpdate')->name('expense.update');
        Route::get('/expense/delete/{id}', 'ExpenseDelete')->name('expense.delete');
        ///expense Filter route//
        Route::get('/expense/filter/rander', 'ExpenseFilterView')->name('expense.filter.view');
    });

    // Tax related route(n)
    Route::controller(TaxController::class)->group(function () {
        Route::get('/tax/add', 'TaxAdd')->name('product.tax.add');
        Route::post('/tax/store', 'TaxStore')->name('tax.store');
        Route::get('/tax/view', 'TaxView')->name('tax.view');
        Route::get('/tax/edit/{id}', 'TaxEdit')->name('tax.edit');
        Route::post('/tax/update/{id}', 'TaxUpdate')->name('tax.update');
        Route::get('/tax/delete/{id}', 'TaxDelete')->name('tax.delete');
    });
    // Payment Method related route(n)
    Route::controller(PaymentMethodController::class)->group(function () {
        Route::get('/payment/method/add', 'PaymentMethodAdd')->name('payment.method.add');
        Route::post('/payment/method/store', 'PaymentMethodStore')->name('payment.method.store');
        Route::get('/payment/method/view', 'PaymentMethodView')->name('payment.method.view');
        Route::get('/payment/method/edit/{id}', 'PaymentMethodEdit')->name('payment.method.edit');
        Route::post('/payment/method/update/{id}', 'PaymentMethodUpdate')->name('payment.method.update');
        Route::get('/payment/method/delete/{id}', 'PaymentMethodDelete')->name('payment.method.delete');
    });
    // Transaction related route(n)
    Route::controller(TransactionController::class)->group(function () {
        Route::get('/transaction/add', 'TransactionAdd')->name('transaction.add');
        Route::post('/transaction/store', 'TransactionStore')->name('transaction.store');
        // Route::get('/transaction/view', 'TransactionView')->name('transaction.view');
        // Route::get('/transaction/edit/{id}', 'TransactionEdit')->name('transaction.edit');
        Route::post('/transaction/update/{id}', 'TransactionUpdate')->name('transaction.update');
        Route::get('/transaction/delete/{id}', 'TransactionDelete')->name('transaction.delete');
        Route::get('/getDataForAccountId', 'getDataForAccountId');
        /////Filer Transaction////
        Route::get('/transaction/filter/rander', 'TransactionFilterView')->name('transaction.filter.view');
        ////////Invoice///////////
        Route::get('/transaction/invoice/receipt/{id}', 'TransactionInvoiceReceipt')->name('transaction.invoice.receipt');
        ////////Investment Route ////
        Route::post('/add/investor', 'InvestmentStore');
        Route::get('/get/investor', 'GetInvestor');
        Route::get('/get/invoice/{id}', 'InvestorInvoice')->name('investor.invoice');

        //
        Route::post('/due/invoice/payment/transaction', 'invoicePaymentStore');
    });
    // pos setting related route
    Route::controller(PosSettingsController::class)->group(function () {
        Route::get('/pos/settings/add', 'PosSettingsAdd')->name('pos.settings.add');
        Route::post('/pos/settings/store', 'PosSettingsStore')->name('pos.settings.store');
        Route::get('/pos/settings/view', 'PosSettingsView')->name('pos.settings.view');
        Route::get('/pos/settings/edit/{id}', 'PosSettingsEdit')->name('pos.settings.edit');
        Route::post('/pos/settings/update/{id}', 'PosSettingsUpdate')->name('pos.settings.update');
        Route::get('/pos/settings/delete/{id}', 'PosSettingsDelete')->name('pos.settings.delete');
        Route::post('/pos/switch_mode', 'switch_mode')->name('switch_mode');
        Route::get('/invoice/settings', 'PosSettingsInvoice')->name('invoice.settings');
        Route::get('/invoice2/settings', 'PosSettingsInvoice2')->name('invoice2.settings');
        Route::get('/invoice3/settings', 'PosSettingsInvoice3')->name('invoice3.settings');
        Route::get('/invoice4/settings', 'PosSettingsInvoice4')->name('invoice4.settings');
    });

    // Transaction related route(n)
    Route::controller(EmployeeSalaryController::class)->group(function () {
        Route::get('/employee/salary/add', 'EmployeeSalaryAdd')->name('employee.salary.add');
        Route::get('/employee/salary/view', 'EmployeeSalaryView')->name('employee.salary.view');
        Route::post('/employee/salary/store', 'EmployeeSalaryStore')->name('employee.salary.store');
        Route::get('/employee/salary/edit/{id}', 'EmployeeSalaryEdit')->name('employee.salary.edit');
        Route::post('/employee/salary/update/{id}', 'EmployeeSalaryUpdate')->name('employee.salary.update');
        Route::get('/employee/salary/delete/{id}', 'EmployeeSalaryDelete')->name('employee.salary.delete');
        Route::get('/employee/branch/{branch_id}', 'BranchAjax'); //dependency
        Route::get('/employee/info/{employee_id}', 'getEmployeeInfo');
        /////////////////Employ Salary Advanced ////////////
        Route::get('/advanced/employee/salary/add', 'EmployeeSalaryAdvancedAdd')->name('advanced.employee.salary.add');
        Route::post('/advanced/employee/salary/store', 'EmployeeSalaryAdvancedStore')->name('advanced.employee.salary.store');
        Route::get('/advanced/employee/salary/view', 'EmployeeSalaryAdvancedView')->name('employee.salary.advanced.view');
        Route::get('/advanced/employee/salary/edit/{id}', 'EmployeeSalaryAdvancedEdit')->name('employee.salary.advanced.edit');
        Route::post('/advanced/employee/salary/update/{id}', 'EmployeeSalaryAdvancedUpdate')->name('employee.salary.advanced.update');
        Route::get('/advanced/employee/salary/delete/{id}', 'EmployeeSalaryAdvancedDelete')->name('employee.salary.advanced.delete');
    });

// Departments related route(n)
Route::controller(DepartmentsController::class)->group(function () {
    Route::get('/departments', 'index')->name('departments');
    Route::post('/departments/store', 'store');
    Route::get('/depertments/view', 'view');
    Route::get('/departments/edit/{id}', 'edit');
    Route::post('/departments/update/{id}', 'update');
    Route::get('/departments/destroy/{id}', 'destroy');

});//End
// Salary Structure related route(n)
Route::controller(SalaryStructureController::class)->group(function () {
    Route::get('/salary/structure', 'index')->name('salary.structure');
    Route::post('/salary/structure/store', 'store');
    Route::get('/salary/structure/view', 'view');
    Route::get('/salary/structure/edit/{id}', 'edit');
    Route::post('/salary/structure/update/{id}', 'update');
    Route::get('/salary/structure/destroy/{id}', 'destroy');

});//End

    Route::controller(CompanyBalanceController::class)->group(function () {
        Route::group(['prefix' => 'daily'], function () {
            Route::get('/balance', 'dailyBalance')->name('balance');
        });
    });

    ////////////////////Role And Permission Route /////////////////
    Route::controller(RolePermissionController::class)->group(function () {
        ///Permission///
        Route::get('/all/permission/view', 'AllPermissionView')->name('all.permission');
        Route::get('/add/permission', 'AddPermission')->name('add.permission');
        Route::post('/store/permission', 'StorePermission')->name('store.permission');
        Route::get('/edit/permission/{id}', 'EditPermission')->name('permission.edit');
        Route::post('/update/permission', 'updatePermission')->name('permission.update');
        Route::get('/delete/permission/{id}', 'DeletePermission')->name('permission.delete');
        ///Role///
        Route::get('/all/role/view', 'AllRoleView')->name('all.role');
        Route::get('/add/role', 'AddRole')->name('add.role');
        Route::post('/store/role', 'StoreRole')->name('store.role');
        Route::get('/edit/role/{id}', 'EditRole')->name('role.edit');
        Route::post('/update/role', 'updateRole')->name('role.update');
        Route::get('/delete/role/{id}', 'DeleteRole')->name('role.delete');
        ///Role In Permission///
        Route::get('/add/role/permission', 'AddRolePermission')->name('add.role.permission');
        Route::post('/store/role/permission', 'StoreRolePermission')->name('store.role.permission');
        Route::get('/edit/role/permission/{id}', 'EditRolePermission')->name('role.permission.edit');
        Route::post('/update/role/permission', 'updateRolePermission')->name('role.permission.update');
        Route::get('/delete/role/permission/{id}', 'DeleteRolePermission')->name('role.permission.delete');
        Route::post('/store/role/permission', 'StoreRolePermission')->name('role.permission.store');
        Route::get('/all/role/permission', 'AllRolePermission')->name('all.role.permission');
        Route::get('/admin/role/edit/{id}', 'AdminRoleEdit')->name('admin.role.edit');
        Route::post('/admin/role/update/{id}', 'AdminRoleUpdate')->name('admin.role.update');
        Route::get('/admin/role/delete/{id}', 'AdminRoleDelete')->name('admin.role.delete');
        Route::get('/admin/role/view', 'AdminRoleView')->name('admin.role.view');
        ///Admin Manage Route ///
        Route::get('/all/admin/view', 'AllAdminView')->name('admin.all');
        Route::get('/add/admin', 'AddAdmin')->name('admin.add');
        Route::post('/admin/store', 'AdminStore')->name('admin.store');
        Route::get('/admin/manage/edit/{id}', 'AdminManageEdit')->name('admin.manage.edit');
        Route::get('/admin/manage/delete/{id}', 'AdminManageDelete')->name('admin.manage.delete');
        Route::post('/admin/manage/update/{id}', 'AdminManageUpdate')->name('update.admin.manage');
    });
});

require __DIR__ . '/auth.php';
