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
use App\Http\Controllers\AccountReceivable\CustomerController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ProductsSizeController;
use App\Http\Controllers\ProductsController;
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
use App\Http\Controllers\EmployeePayroll\PaySlipController;
use App\Http\Controllers\Expanse\ExpanseDashboard\ExpanseDashboardController;
use App\Http\Controllers\AccountPayable\SupplierController;
use App\Http\Controllers\AssetDashboard\AssetDashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ServiceSale\ServiceSaleController;
use  App\Http\Controllers\CustomerPayableDashboard\CustomerPayableDashboardController;
use App\Http\Controllers\SaleDashboard\SaleDashboardController;
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


Route::get('/', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


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
        Route::get('/employe/salary/sheet/view', 'allSalarySheetiew')->name('salary.sheet');
    });
    // PaySlip related route
    Route::controller(PaySlipController::class)->group(function () {
        Route::get('/pay-slip/{id}', 'paySlip');
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
        Route::get('/expenses/invoice/{id}', 'expensesInvoice')->name('expenses.invoice');
        Route::get('/expanse/invoice/receipt/print/{id}', 'expensesPrintInvoice');
        Route::get('/expanse/report-payment/{id}', 'expensesPaymentsReport');
    });

    Route::controller(RecurringExpanseController::class)->group(function () {
        Route::get('/expense/recurring', 'index')->name('expense.recurring');
        Route::post('/expense/recurring/store', 'store');
        Route::get('/expense/recurring/view', 'view');
        Route::get('/expense/category/view', 'viewExpenseCategory');
        Route::post('/recurring-expanse/category/store', 'recurringExpenseCategoryStore');
    });

    // Transaction related route(n)
    Route::controller(TransactionController::class)->group(function () {
        Route::get('/transaction', 'transaction')->name('transaction');
        Route::post('/transaction/store', 'storeTransaction');
        Route::post('/transaction/store/with-ledger', 'storeTransactionWithLedger');
        Route::get('/transaction/view', 'view');
        Route::get('/transaction/view-details/{id}', 'viewDetails');
        Route::get('/check-account-type', 'checkAccountType');
        Route::post('/transaction/balance-transfer', 'balanceTransfer');
        // Route::get('/transaction/balance-transfer/view', 'balanceTransferView');
    });

    // Transaction related route(n)
    Route::controller(LoanController::class)->group(function () {
        Route::get('/loan', 'index')->name('loan');
        Route::post('/loan/store', 'store');
        Route::get('/loan/view', 'view');
        Route::get('/loan/view/{id}', 'viewLoan');
        Route::get('/loan/instalment/invoice{id}', 'loanInstalmentInvoice')->name('loan.instalment.invoice');
        ////////Single Print Invoice///////////
        Route::get('/loan/invoice/receipt/print/{id}', 'loanInvoicePrint');
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
        Route::get('/convenience/view-details/{id}', 'convenienceViewDetails');
        Route::get('/convenience/invoice/{id}', 'convenienceInvoice')->name('convenience.invoice');
        Route::post('/update-status', 'updateStatus')->name('update-status');
        Route::get('/convenience/money/receipt/{type}/{id}', 'convenienceMoneyReceipt')->name('convenience.money.receipt');
        // Route::get('/movement-cost/image/{id}', 'imageToPdf')->name('movementcost.image');
        // Route::get('/fooding-cost/image//{id}', 'FoodingimageToPdf');
        //  Route::get('/{type}-cost/image/{id}/pdf', 'imageToPdf');



    }); //End

    // Payroll Dashboard related route(n)
    Route::controller(PayrollDashboardController::class)->group(function () {
        Route::get('/payroll/dashboard', 'payrollDashboard')->name('payroll.dashboard');
        Route::get('/get-month-bonus-data', 'getMonthBonus');
        Route::get('/get-festival-percentage-data', 'getFestivalPercentage');
        Route::get('/get-performance-percentage-data', 'getperformancePercentage');
        Route::get('/get-other-percentage-data', 'getOtherPercentage');
        Route::get('/get-month-convenience-data', 'getConvenienceMonth');
        Route::get('/get-pay-slips-month-data', 'getPaySlipsMonthData');
        Route::get('/fetch-yearly-data', 'fetchYearlyAreaChart')->name('fetchYearlyData');
        Route::get('/get-salaries-filter-month', 'FilterSalariesTable');
    }); //End
    // Expanse Dashboard related route(n)
    Route::controller(ExpanseDashboardController::class)->group(function () {
        Route::get('/expanse/dashboard', 'expanseDashboard')->name('expanse.dashboard');
        Route::get('/expanse/activities/filter', 'expanseaAtivitiesFilter');
        Route::get('/get-monthly-expanse-category-data', 'expanseaCategoryFilter');
        Route::get('/expenses-chart-data-money-flow', 'moneyFlowExpanseChart');
        Route::get('/get-expanse-payment-percentage-data', 'expansePaymentPercentage');
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
        Route::get('/get-employee-data/{id}', 'EmployeedData');
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
        Route::get('/asset-type/details/{id}', 'details');
        Route::get('/asset-type/edit/{id}', 'edit');
        Route::post('/asset-type/update/{id}', 'update');
        Route::get('/asset-type/delete/{id}', 'delete');
        Route::get('/asset-type/trash/delete/view', 'assetTypeDeleteView');
        Route::get('/asset-type/trash/restore/{id}', 'assetTypeRestore');
        Route::get('/asset-type/trash/delete/{id}', 'assetTypeDelete');
    });
    Route::controller(AssetController::class)->group(function () {
        Route::get('/asset-management', 'index')->name('asset.management');
        Route::post('/asset/store', 'store');
        Route::get('/asset/view', 'view');
        // Route::get('/all-ledger/view/select-tag', 'view');
        // Route::get('/sub-ledger/details/{id}', 'details');
    });
    // Supplier related route
    Route::controller(SupplierController::class)->group(function () {
        Route::get('/supplier', 'index')->name('supplier');
        Route::post('/supplier/store', 'store')->name('supplier.store');
        Route::get('/supplier/view', 'view')->name('supplier.view');
        Route::get('/supplier/edit/{id}', 'edit')->name('supplier.edit');
        Route::post('/supplier/update/{id}', 'update')->name('supplier.update');
        Route::get('/supplier/destroy/{id}', 'destroy')->name('supplier.destroy');
    });
    // Unit related route
    Route::controller(UnitController::class)->group(function () {
        Route::get('/unit', 'index')->name('product.unit');
        Route::post('/unit/store', 'store')->name('unit.store');
        Route::get('/unit/view', 'view')->name('unit.view');
        Route::get('/unit/edit/{id}', 'edit')->name('unit.edit');
        Route::post('/unit/update/{id}', 'update')->name('unit.update');
        Route::get('/unit/destroy/{id}', 'destroy')->name('unit.destroy');
    });

    // Product Size related route(n)
    Route::controller(ProductsSizeController::class)->group(function () {
        Route::get('/product/size/add', 'ProductSizeAdd')->name('product.size.add');
        Route::post('/product/size/store', 'ProductSizeStore')->name('product.size.store');
        Route::get('/product/size/view', 'ProductSizeView')->name('product.size.view');
        Route::get('/product/size/edit/{id}', 'ProductSizeEdit')->name('product.size.edit');
        Route::post('/product/size/update/{id}', 'ProductSizeUpdate')->name('product.size.update');
        Route::get('/product/size/delete/{id}', 'ProductSizeDelete')->name('product.size.delete');
    });

    // Product  related route(n)
    Route::controller(ProductsController::class)->group(function () {
        Route::get('/product', 'index')->name('product');
        Route::post('/product/store', 'store')->name('product.store');
        Route::get('/product/view', 'view')->name('product.view');
        Route::get('/product/edit/{id}', 'edit')->name('product.edit');
        Route::post('/product/update/{id}', 'update')->name('product.update');
        Route::get('/product/destroy/{id}', 'destroy')->name('product.destroy');
        Route::get('/product/find/{id}', 'find')->name('product.find');
        Route::get('/product/barcode/{id}', 'ProductBarcode')->name('product.barcode');
        Route::get('/search/{value}', 'globalSearch');
    });
    // category related route
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/category', 'index')->name('product.category');
        Route::post('/category/store', 'store')->name('category.store');
        Route::get('/category/view', 'view')->name('category.view');
        Route::get('/category/edit/{id}', 'edit')->name('category.edit');
        Route::post('/category/update/{id}', 'update')->name('category.update');
        Route::post('/category/status/{id}', 'status')->name('category.status');
        Route::get('/category/destroy/{id}', 'destroy')->name('category.destroy');
        // Route::get('/categories/all', 'categoryAll')->name('categories.all');
    });

    // subcategory related route(n)
    Route::controller(SubCategoryController::class)->group(function () {
        Route::get('/subcategory', 'index')->name('product.subcategory');
        Route::post('/subcategory/store', 'store')->name('subcategory.store');
        Route::get('/subcategory/view', 'view')->name('subcategory.view');
        Route::get('/subcategory/edit/{id}', 'edit')->name('subcategory.edit');
        Route::post('/subcategory/update/{id}', 'update')->name('subcategory.update');
        Route::get('/subcategory/destroy/{id}', 'destroy')->name('subcategory.destroy');
        Route::post('/subcategory/status/{id}', 'status')->name('subcategory.status');
        Route::get('/subcategory/find/{id}', 'find')->name('subcategory.find');
    });
    // Brand related route
    Route::controller(BrandController::class)->group(function () {
        Route::get('/brand', 'index')->name('product.brand');
        Route::post('/brand/store', 'store')->name('brand.store');
        Route::get('/brand/view', 'view')->name('brand.view');
        Route::get('/brand/edit/{id}', 'edit')->name('brand.edit');
        Route::post('/brand/update/{id}', 'update')->name('brand.update');
        Route::post('/brand/status/{id}', 'status')->name('brand.status');
        Route::get('/brand/destroy/{id}', 'destroy')->name('brand.destroy');
    });
    Route::controller(PurchaseController::class)->group(function () {
        Route::get('/purchase', 'index')->name('purchase');
        Route::post('/purchase/store', 'store')->name('purchase.store');
        Route::get('/purchase/view', 'view')->name('purchase.view');
        Route::get('/purchase/supplier/{id}', 'supplierName')->name('purchase.supplier.name');
        Route::get('/purchase/item/{id}', 'purchaseItem')->name('purchase.item');
        Route::get('/purchase/edit/{id}', 'edit')->name('purchase.edit');
        Route::post('/purchase/update/{id}', 'update')->name('purchase.update');
        Route::get('/purchase/destroy/{id}', 'destroy')->name('purchase.destroy');
        Route::get('/purchase/invoice/{id}', 'invoice')->name('purchase.invoice');
        Route::get('/purchase/money-receipt/{id}', 'moneyReceipt')->name('purchase.money.receipt');
        Route::get('/purchase/image/{id}', 'imageToPdf')->name('purchase.image');
        Route::get('/purchase/filter', 'filter')->name('purchase.filter');
    });
    Route::controller(AssetRevaluationController::class)->group(function () {
        Route::get('/asset-revaluation', 'index')->name('asset.revaluation');
        Route::post('/asset-revaluation/store', 'store');
        Route::get('/asset-revaluation/view', 'view');
        // Route::get('/all-ledger/view/select-tag', 'view');
        // Route::get('/sub-ledger/details/{id}', 'details');
    });
    Route::controller(ServiceSaleController::class)->group(function () {
        Route::get('/service-sale', 'index')->name('service.sale');
        Route::post('/service/sale/store', 'store')->name('service.sale.store');
        Route::get('/service/sale/view', 'view')->name('service.sale.view');
        Route::get('/service/sale/invoice/{id}', 'invoice')->name('service.sale.invoice');
    });

    Route::controller(CustomerPayableDashboardController::class)->group(function () {
        Route::get('/customer-payable-dashboard', 'customerPayableDashboard')->name('customer.payable.dashboard');
    });
    Route::controller(SaleDashboardController::class)->group(function () {
        Route::get('/sale-dashboard', 'SaleDashboard')->name('sale.dashboard');
    });
    Route::controller(AssetDashboardController::class)->group(function () {
        Route::get('/asset-dashboard/card-data', 'getTopData');
        Route::get('/asset-dashboard/total-leisure', 'totalLeisure');
        Route::get('/asset-dashboard/bank-transaction', 'bankTransaction');
    });
});

require __DIR__ . '/auth.php';
