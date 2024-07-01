<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\DashboardContrller;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PaymentToController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReceiveController;
use App\Http\Controllers\ReceiveReportController;
use App\Http\Controllers\Report\ExpenseReportController;
use App\Http\Controllers\Report\IncomeReportController;
use App\Http\Controllers\Report\PaymentReportController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\UserController;
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

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');



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

    Route::group(['prefix' => 'report'], function () {
        //expense
        Route::get('expense', [ExpenseReportController::class, 'index'])->name('report.expense');
        Route::get('expense-print', [ExpenseReportController::class, 'print'])->name('report.expense.print');

        //expense
        Route::get('income', [IncomeReportController::class, 'index'])->name('report.income');
        Route::get('income-print', [IncomeReportController::class, 'print'])->name('report.income.print');

        // receive
        Route::get('receive', [ReceiveReportController::class, 'index'])->name('report.receive');
        Route::get('receive-print', [ReceiveReportController::class, 'print'])->name('report.receive.print');
        // payment
        Route::get('payment', [PaymentReportController::class, 'index'])->name('report.payment');
        Route::get('payment-print', [PaymentReportController::class, 'print'])->name('report.payment.print');
    });

    // ************************** new ************************************\\

    /**
     * user
     */
    Route::get('user-list', [UserController::class, 'index'])->name('user.list');
    Route::get('user-create', [UserController::class, 'create'])->name('user.create');
    Route::post('user-store', [UserController::class, 'store'])->name('user.store');
    Route::get('user-edit/{id?}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('user-update', [UserController::class, 'update'])->name('user.update');
    Route::get('user-delete/{id?}', [UserController::class, 'delete'])->name('user.delete');

    /**
     * receive
     */
    Route::get('receive-list', [ReceiveController::class, 'index'])->name('receive.list');
    Route::get('receive-create', [ReceiveController::class, 'create'])->name('receive.create');
    Route::get('receive-approved/{id?}', [ReceiveController::class, 'approved'])->name('receive.approved');
    Route::post('receive-store', [ReceiveController::class, 'store'])->name('receive.store');
    Route::get('receive-edit/{id?}', [ReceiveController::class, 'edit'])->name('receive.edit');
    Route::post('receive-update', [ReceiveController::class, 'update'])->name('receive.update');
    Route::get('receive-delete/{id?}', [ReceiveController::class, 'delete'])->name('receive.delete');

    /**
     * payment
     */
    Route::get('payment-list', [PaymentController::class, 'index'])->name('payment.list');
    Route::get('payment-create', [PaymentController::class, 'create'])->name('payment.create');
    Route::post('payment-store', [PaymentController::class, 'store'])->name('payment.store');
    Route::get('payment-edit/{id?}', [PaymentController::class, 'edit'])->name('payment.edit');
    Route::post('payment-update', [PaymentController::class, 'update'])->name('payment.update');
    Route::get('payment-delete/{id?}', [PaymentController::class, 'delete'])->name('payment.delete');

    /**
     * Official Expense
     */
    Route::get('expense-list', [ExpenseController::class, 'index'])->name('expense.list');
    Route::get('expense-create', [ExpenseController::class, 'create'])->name('expense.create');
    Route::post('expense-store', [ExpenseController::class, 'store'])->name('expense.store');
    Route::get('expense-edit/{id?}', [ExpenseController::class, 'edit'])->name('expense.edit');
    Route::post('expense-update', [ExpenseController::class, 'update'])->name('expense.update');
    Route::get('expense-delete/{id?}', [ExpenseController::class, 'delete'])->name('expense.delete');


    /**
     * payment to
     */
    Route::get('payment-to-list', [PaymentToController::class, 'index'])->name('payment_to.list');
    Route::get('payment-to-create', [PaymentToController::class, 'create'])->name('payment_to.create');
    Route::post('payment-to-store', [PaymentToController::class, 'store'])->name('payment_to.store');
    Route::get('payment-to-edit/{id?}', [PaymentToController::class, 'edit'])->name('payment_to.edit');
    Route::post('payment-to-update', [PaymentToController::class, 'update'])->name('payment_to.update');
    Route::get('payment-to-delete/{id?}', [PaymentToController::class, 'delete'])->name('payment_to.delete');


    /**
     * site/ partner name
     */
    Route::get('site/partner-list', [SiteController::class, 'index'])->name('site.list');
    Route::post('site/partner-store-update', [SiteController::class, 'storeUpdate'])->name('site.store_update');
    Route::get('site/partner-edit/{id?}', [SiteController::class, 'edit'])->name('site.edit');
    Route::get('site/partner-delete/{id?}', [SiteController::class, 'delete'])->name('site.delete');
    Route::get('site/{id?}', [SiteController::class, 'details'])->name('site.details');


    /**
     * bank
     */
    Route::get('category/bank-list', [BankAccountController::class, 'index'])->name('bank_account.list');
    Route::post('category/bank-store-update', [BankAccountController::class, 'storeUpdate'])->name('bank_account.store_update');
    Route::get('category/bank-edit/{id?}', [BankAccountController::class, 'edit'])->name('bank_account.edit');
    Route::get('category/bank-delete/{id?}', [BankAccountController::class, 'delete'])->name('bank_account.delete');
    Route::get('bank-account/{id?}', [BankAccountController::class, 'details']);

    /**
     * paymnet method
     */
    Route::get('category/payment-method-list', [PaymentMethodController::class, 'index'])->name('payment_method.list');
    Route::post('category/payment-method-store-update', [PaymentMethodController::class, 'storeUpdate'])->name('payment_method.store_update');
    Route::get('category/payment-method-edit/{id?}', [PaymentMethodController::class, 'edit'])->name('payment_method.edit');
    Route::get('category/payment-method-delete/{id?}', [PaymentMethodController::class, 'delete'])->name('payment_method.delete');


    /**
     * Employee
     */
    Route::get('employee-list', [EmployeeController::class, 'index'])->name('employee.list');
    Route::get('employee-create', [EmployeeController::class, 'create'])->name('employee.create');
    Route::post('employee-store', [EmployeeController::class, 'store'])->name('employee.store');
    Route::get('employee-edit/{id?}', [EmployeeController::class, 'edit'])->name('employee.edit');
    Route::post('employee-update', [EmployeeController::class, 'update'])->name('employee.update');
    Route::get('employee-delete/{id?}', [EmployeeController::class, 'delete'])->name('employee.delete');
    Route::get('employee/{id?}', [EmployeeController::class, 'details'])->name('employee.details');

    /**
     * Employee
     */
    Route::get('salary-list', [SalaryController::class, 'index'])->name('salary.list');
    Route::get('salary-create', [SalaryController::class, 'create'])->name('salary.create');
    Route::post('salary-store', [SalaryController::class, 'store'])->name('salary.store');
    Route::get('salary-edit/{id?}', [SalaryController::class, 'edit'])->name('salary.edit');
    Route::post('salary-update', [SalaryController::class, 'update'])->name('salary.update');
    Route::get('salary-delete/{id?}', [SalaryController::class, 'delete'])->name('salary.delete');
});
