<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardContrller;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\LaborController;
use App\Http\Controllers\LabourSalaryController;
use App\Http\Controllers\OfficialExpenseController;
use App\Http\Controllers\PaymentToController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Report\ExpenseController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\TenderController;
use App\Http\Controllers\TenderExpenseController;
use App\Http\Controllers\TenderPaymentController;
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

Route::get('/', [AuthController::class, 'home'])->name('home');
Route::get('/login', [AuthController::class, 'login'])->name('admin.login');
Route::post('/login-process', [AuthController::class, 'loginProcess'])->name('admin.login.process');




Route::group(['middleware' => ['admin', 'lang']], function () {

    Route::get('/dashboard', [DashboardContrller::class, 'index'])->name('admin.dashboard');
    Route::get('change-language/{lang?}', [DashboardContrller::class, 'changeLanguage'])->name('lang.change');

    /**
     * profile
     */

    Route::get('profile', [ProfileController::class, 'profile'])->name('profile');
    Route::post('profile-update', [ProfileController::class, 'profileUpdate'])->name('profile.update');


    Route::get('password', [ProfileController::class, 'password'])->name('password');
    Route::post('password-update', [ProfileController::class, 'passwordUpdate'])->name('password.update');

    /**
     * Official Expense
     */
    Route::get('official-expense-list', [OfficialExpenseController::class, 'index'])->name('expense.official.list');
    Route::get('official-expense-create', [OfficialExpenseController::class, 'create'])->name('expense.official.create');
    Route::post('official-expense-store', [OfficialExpenseController::class, 'store'])->name('expense.official.store');
    Route::get('official-expense-edit/{id?}', [OfficialExpenseController::class, 'edit'])->name('expense.official.edit');
    Route::post('official-expense-update', [OfficialExpenseController::class, 'update'])->name('expense.official.update');
    Route::get('official-expense-delete/{id?}', [OfficialExpenseController::class, 'delete'])->name('expense.official.delete');

    /**
     * Official Expense
     */
    Route::get('tender-expense-list', [TenderExpenseController::class, 'index'])->name('expense.tender.list');
    Route::get('tender-expense-create', [TenderExpenseController::class, 'create'])->name('expense.tender.create');
    Route::post('tender-expense-store', [TenderExpenseController::class, 'store'])->name('expense.tender.store');
    Route::get('tender-expense-edit/{id?}', [TenderExpenseController::class, 'edit'])->name('expense.tender.edit');
    Route::post('tender-expense-update', [TenderExpenseController::class, 'update'])->name('expense.tender.update');
    Route::get('tender-expense-delete/{id?}', [TenderExpenseController::class, 'delete'])->name('expense.tender.delete');


    /**
     * District
     */
    Route::get('district-list', [DistrictController::class, 'index'])->name('district.list');
    Route::get('district-create', [DistrictController::class, 'create'])->name('district.create');
    Route::post('district-store', [DistrictController::class, 'store'])->name('district.store');
    Route::get('district-edit/{id?}', [DistrictController::class, 'edit'])->name('district.edit');
    Route::post('district-update', [DistrictController::class, 'update'])->name('district.update');
    Route::get('district-delete/{id?}', [DistrictController::class, 'delete'])->name('district.delete');

    /**
     * category
     */
    Route::get('category-list', [CategoryController::class, 'index'])->name('category.list');
    Route::get('category-create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('category-store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('category-edit/{id?}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('category-update', [CategoryController::class, 'update'])->name('category.update');
    Route::get('category-delete/{id?}', [CategoryController::class, 'delete'])->name('category.delete');


    Route::get('tender-list', [TenderController::class, 'index'])->name('tender.list');
    Route::get('tender-create', [TenderController::class, 'create'])->name('tender.create');
    Route::post('tender-store', [TenderController::class, 'store'])->name('tender.store');
    Route::get('tender-edit/{id?}', [TenderController::class, 'edit'])->name('tender.edit');
    Route::post('tender-update', [TenderController::class, 'update'])->name('tender.update');
    Route::get('tender-delete/{id?}', [TenderController::class, 'delete'])->name('tender.delete');

    Route::get('tender-details/{id?}', [TenderController::class, 'details'])->name('tender.details');
    Route::get('tender-invoice/{id?}', [TenderController::class, 'invoice'])->name('tender.invoice.create');

    /**
     * labour
     */
    Route::get('labour-list', [LaborController::class, 'index'])->name('labour.list');
    Route::get('/employee/pdf', [LaborController::class, 'createPDF']);
    Route::get('labour-create', [LaborController::class, 'create'])->name('labour.create');
    Route::post('labour-store', [LaborController::class, 'store'])->name('labour.store');
    Route::get('labour-edit/{id?}', [LaborController::class, 'edit'])->name('labour.edit');
    Route::post('labour-update', [LaborController::class, 'update'])->name('labour.update');
    Route::get('labour-delete/{id?}', [LaborController::class, 'delete'])->name('labour.delete');


    /**
     * labour salary
     */
    Route::get('labour-salary-list', [LabourSalaryController::class, 'index'])->name('salary.list');
    Route::get('tender-labour-list', [LabourSalaryController::class, 'labourList'])->name('tender.labour.list');
    Route::get('labour-salary-create', [LabourSalaryController::class, 'create'])->name('salary.create');
    Route::post('labour-salary-store', [LabourSalaryController::class, 'store'])->name('salary.store');
    Route::get('labour-salary-edit/{id?}', [LabourSalaryController::class, 'edit'])->name('salary.edit');
    Route::post('labour-salary-update', [LabourSalaryController::class, 'update'])->name('salary.update');
    Route::get('labour-salary-delete/{id?}', [LabourSalaryController::class, 'delete'])->name('salary.delete');
    Route::get('labour/{tenderId}', [LabourSalaryController::class, 'getLaboursByTender']);


    /**
     * payment received
     */
    Route::get('payment-list', [TenderPaymentController::class, 'index'])->name('payment.list');
    Route::get('tender-labour-list', [TenderPaymentController::class, 'labourList'])->name('tender.labour.list');
    Route::get('payment-create', [TenderPaymentController::class, 'create'])->name('payment.create');
    Route::post('payment-store', [TenderPaymentController::class, 'store'])->name('payment.store');
    Route::get('payment-edit/{id?}', [TenderPaymentController::class, 'edit'])->name('payment.edit');
    Route::post('payment-update', [TenderPaymentController::class, 'update'])->name('payment.update');
    Route::get('payment-delete/{id?}', [TenderPaymentController::class, 'delete'])->name('payment.delete');


    Route::group(['prefix' => 'report'], function () {
        // official expense
        Route::get('official-expepense', [ExpenseController::class, 'officialExpense'])->name('report.official.expense');
        Route::post('official-expepense', [ExpenseController::class, 'officialExpense'])->name('report.official.expense.report');

        // tender expense
        Route::get('tender-expepense', [ExpenseController::class, 'tenderExpense'])->name('report.tender.expense');
        Route::post('tender-expepense', [ExpenseController::class, 'tenderExpense'])->name('report.tender.expense.report');
    });

    // ************************** new ************************************\\

    /**
     * payment received
     */
    Route::get('payment-to-list', [PaymentToController::class, 'index'])->name('payment.to.list');
    Route::get('payment-to-create', [PaymentToController::class, 'create'])->name('payment.to.create');
    Route::post('payment-to-store', [PaymentToController::class, 'store'])->name('payment.to.store');
    Route::get('payment-to-edit/{id?}', [PaymentToController::class, 'edit'])->name('payment.to.edit');
    Route::post('payment-to-update', [PaymentToController::class, 'update'])->name('payment.to.update');
    Route::get('payment-to-delete/{id?}', [PaymentToController::class, 'delete'])->name('payment.to.delete');


    /**
     * site/ partner name
     */
    Route::get('site/partner-list', [SiteController::class, 'index'])->name('site.list');
    Route::post('site/partner-store-update', [SiteController::class, 'storeUpdate'])->name('site.store_update');
    Route::get('site/partner-edit/{id?}', [SiteController::class, 'edit'])->name('site.edit');
    Route::get('site/partner-delete/{id?}', [SiteController::class, 'delete'])->name('site.delete');

    /**
     * bank
     */
    Route::get('category/bank-list', [BankAccountController::class, 'index'])->name('bank_account.list');
    Route::post('category/bank-store-update', [BankAccountController::class, 'storeUpdate'])->name('bank_account.store_update');
    Route::get('category/bank-edit/{id?}', [BankAccountController::class, 'edit'])->name('bank_account.edit');
    Route::get('category/bank-delete/{id?}', [BankAccountController::class, 'delete'])->name('bank_account.delete');

});
