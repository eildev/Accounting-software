<?php

use App\Http\Controllers\Assets\AssetController;
use App\Http\Controllers\Assets\AssetRevaluationController;
use App\Http\Controllers\Assets\AssetTypesController;
use App\Http\Controllers\Bank\BankAccountsController;
use App\Http\Controllers\Bank\CashTransactionController;
use App\Http\Controllers\Bank\LoanManagement\LoanController;
use App\Http\Controllers\Bank\LoanManagement\LoanRepaymentsController;
use App\Http\Controllers\Bank\Transaction\TransactionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeePayroll\EmployeeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PosSettingsController;
use App\Http\Controllers\EmployeeSalaryController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeePayroll\DepartmentsController;
use App\Http\Controllers\EmployeePayroll\SalaryStructureController;
use App\Http\Controllers\ConvenienceBill\ConvenienceBillController;
use App\Http\Controllers\Expanse\RecurringExpanse\RecurringExpanseController;
use App\Http\Controllers\Ledgers\LedgerController;
use App\Http\Controllers\Ledgers\SubLedger\SubLedgerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeePayroll\PayrollDashboardController;

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
        Route::get('/employee/profile/{id}', 'profile')->name('employee.profile');
        Route::get('/employee/profile/edit/{id}/{payslip_id}', 'editProfile');
        Route::post('/employee/profile/payslip/update', 'updateProfilepaySlip');
        ///////////////////////Employee Bonuse////////////////////////
        Route::get('/employee/bonus', 'indexBonus')->name('employee.bonus');
        Route::post('/employee/bonus/store', 'bonusStore');
        Route::get('/employee/bonus/view', 'bonusView');
        Route::get('/employee/bonuses/edit/{id}', 'bonusEdit');
        Route::post('/employee/bonus/update/{id}', 'bonusUpdate');
        Route::get('/employee/bonus/destroy/{id}', 'bonusDelete');
        Route::post('/update-status-bonus', 'updateStatusBonus');
        /////////////////////Employe single PaySlip ////////////////////////
        Route::post('/employee/payslip/store', 'paySlipStore');
        Route::get('/employee/{employeeId}/slip/view', 'singlePaySlipView');

        /////////////////////Employe Multiple Slip PaySlip ////////////////////////
        Route::post('/employe/multilple/slip/store', 'multiplePaySlipStore');
        Route::get('/employe/all/slip/view', 'allPaySlipView');
        Route::post('/update-status-payslip', 'PaySlipStatusUpdate');
    });

    // Banks related route
    Route::controller(BankAccountsController::class)->group(function () {
        Route::get('/bank', 'index')->name('bank');
        Route::post('/bank/store', 'store')->name('bank.store');
        Route::get('/bank/view', 'view')->name('bank.view');
        Route::get('/bank/details/{id}', 'bankDetails')->name('bank.details');
    });

    // Cash related route//
    Route::controller(CashTransactionController::class)->group(function () {
        Route::post('/cash-account/store', 'store')->name('cash.account.store');
        Route::get('/cash-account/view', 'view')->name('cash.account.view');
        Route::get('/cash/details/{id}', 'cashDetails')->name('cash.details');
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

    Route::prefix('expense')->controller(RecurringExpanseController::class)->group(function () {
        Route::get('/recurring', 'index')->name('expense.recurring');
        Route::post('/recurring/store', 'store');
        Route::get('/recurring/view', 'view');
        Route::get('/category/view', 'viewExpenseCategory');
    });

    // Transaction related route(n)
    Route::controller(TransactionController::class)->group(function () {
        Route::get('/transaction', 'transaction')->name('transaction');
        Route::post('/transaction/store', 'storeTransaction');
        Route::get('/transaction/view', 'view');
        Route::get('/transaction/view-details/{id}', 'viewDetails');
        Route::get('/check-account-type', 'checkAccountType');
    });

    // Transaction related route(n)
    Route::controller(LoanController::class)->group(function () {
        Route::get('/loan', 'index')->name('loan');
        Route::post('/loan/store', 'store');
        Route::get('/loan/view', 'view');
        Route::get('/loan/view/{id}', 'viewLoan');
    });


    // Transaction related route(n)
    Route::controller(LoanRepaymentsController::class)->group(function () {
        Route::post('/loan-repayments/store', 'store');
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

    // Employee Salary related route(n)
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
        Route::get('/departments/view', 'view');
        Route::get('/departments/edit/{id}', 'edit');
        Route::post('/departments/update/{id}', 'update');
        Route::get('/departments/destroy/{id}', 'destroy');
    }); //End
    // Salary Structure related route(n)
    Route::controller(SalaryStructureController::class)->group(function () {
        Route::get('/salary/structure', 'index')->name('salary.structure');
        Route::post('/salary/structure/store', 'store');
        Route::get('/salary/structure/view', 'view');
        Route::get('/salary/structure/edit/{id}', 'edit');
        Route::post('/salary/structure/update/{id}', 'update');
        Route::get('/salary/structure/destroy/{id}', 'destroy');
        Route::get('/employees-without-salary-structure', 'getEmployeesWithoutSalaryStructure');
        Route::get('/employees-without-salary-structure-edit', 'getEmployeesWithoutSalaryStructureEdit');
    }); //End
    // Convenience Bill  related route(n)
    Route::controller(ConvenienceBillController::class)->group(function () {
        Route::get('/convenience', 'convenience')->name('convenience');
        Route::get('/employees-by-department/{department_id}', 'getEmployeesByDepartment');
        Route::post('convenience/store', 'convenienceStore')->name('convenience.store');
        Route::get('/convenience/view', 'convenienceView')->name('convenience.view');
        Route::get('/convenience/invoice/{id}', 'convenienceInvoice')->name('convenience.invoice');
        Route::post('/update-status', 'updateStatus')->name('update-status');
    }); //End

    // Payroll Dashboard related route(n)
    Route::controller(PayrollDashboardController::class)->group(function () {
        Route::get('/payroll/dashboard', 'payrollDashboard')->name('payroll.dashboard');
    }); //End

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

    // Ledger related route
    Route::controller(LedgerController::class)->group(function () {
        Route::get('/ledger', 'index')->name('ledger');
        Route::post('/ledger/store', 'store')->name('ledger.store');
        Route::get('/ledger/view', 'view')->name('ledger.view');
        Route::get('/ledger/details/{id}', 'ledgerDetails');

        // all-ledger related route
        Route::post('/all-ledger/store', 'storeAllLedger');
        Route::get('/all-ledger/view', 'viewAllLedger');
        Route::get('/all-ledger/view/category-wise/{id}', 'viewAllLedgerCategoryWise');
        Route::get('/all-ledger/details/{id}', 'allLedgerDetails');
        Route::get('/sub-ledger/view/category-wise/{id}', 'viewSubLedgerCategoryWise');
    });
    // Sub Ledger related route
    Route::controller(SubLedgerController::class)->group(function () {
        Route::get('/sub-ledger', 'index')->name('ledger.sub');
        Route::post('/sub-ledger/store', 'store');
        Route::get('/sub-ledger/view', 'view');
        // Route::get('/all-ledger/view/select-tag', 'view');
        Route::get('/sub-ledger/details/{id}', 'details');
    });

    // Asset Types related route
    Route::controller(AssetTypesController::class)->group(function () {
        Route::post('/asset-type/store', 'store');
        Route::get('/asset-type/view', 'view');
        // Route::get('/all-ledger/view/select-tag', 'view');
        // Route::get('/sub-ledger/details/{id}', 'details');
    });
    Route::controller(AssetController::class)->group(function () {
        Route::get('/asset-management', 'index')->name('asset.management');
        Route::post('/asset/store', 'store');
        Route::get('/asset/view', 'view');
        // Route::get('/all-ledger/view/select-tag', 'view');
        // Route::get('/sub-ledger/details/{id}', 'details');
    });
    Route::controller(AssetRevaluationController::class)->group(function () {
        Route::get('/asset-revaluation', 'index')->name('asset.revaluation');
        Route::post('/asset-revaluation/store', 'store');
        Route::get('/asset-revaluation/view', 'view');
        // Route::get('/all-ledger/view/select-tag', 'view');
        // Route::get('/sub-ledger/details/{id}', 'details');
    });
});

require __DIR__ . '/auth.php';
