<?php

use App\Http\Controllers\AcademicController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ParentLoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\ParentDashboardController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Parent login routes (separate from admin)
Route::middleware('guest:parent')->group(function () {
    Route::get('/parent/login', [ParentLoginController::class, 'showLoginForm'])->name('parent.login');
    Route::post('/parent/login', [ParentLoginController::class, 'login']);
});

// Parent dashboard routes
Route::middleware('auth:parent')->group(function () {
    Route::get('/parent/dashboard', [ParentDashboardController::class, 'index'])->name('parent.dashboard');
    Route::post('/parent/logout', [ParentLoginController::class, 'logout'])->name('parent.logout');
});

// Admin login routes
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/admin/login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/admin/logout', [LoginController::class, 'logout'])->name('logout');
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::middleware('can.section:dashboard')->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
            Route::get('/dashboard/report', [DashboardController::class, 'report'])->name('dashboard.report');
            Route::get('/dashboard/export', [DashboardController::class, 'export'])->name('dashboard.export');
        });
        Route::middleware('can.section:students')->group(function () {
            Route::get('/students', [StudentController::class, 'index'])->name('students.index');
            Route::get('/students/export', [StudentController::class, 'export'])->name('students.export');
            Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
            Route::post('/students', [StudentController::class, 'store'])->name('students.store');
            Route::get('/students/import', [StudentController::class, 'importForm'])->name('students.import');
            Route::post('/students/import', [StudentController::class, 'importProcess'])->name('students.import.process');
            Route::get('/students/import/template', [StudentController::class, 'importTemplate'])->name('students.import.template');
            Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
            Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');
        });
        Route::middleware('can.section:parents')->group(function () {
            Route::get('/parents', [ParentController::class, 'index'])->name('parents.index');
            Route::get('/parents/create', [ParentController::class, 'create'])->name('parents.create');
            Route::post('/parents', [ParentController::class, 'store'])->name('parents.store');
            Route::get('/parents/{parent}/edit', [ParentController::class, 'edit'])->name('parents.edit');
            Route::put('/parents/{parent}', [ParentController::class, 'update'])->name('parents.update');
        });
        Route::middleware('can.section:staff')->group(function () {
            Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
            Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
            Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
            Route::get('/staff/salaries', [StaffController::class, 'salaries'])->name('staff.salaries');
            Route::post('/staff/salaries', [StaffController::class, 'storeSalary'])->name('staff.salaries.store');
            Route::get('/staff/{staff}/edit', [StaffController::class, 'edit'])->name('staff.edit');
            Route::put('/staff/{staff}', [StaffController::class, 'update'])->name('staff.update');
        });
        Route::middleware('can.section:fees')->group(function () {
            Route::get('/fees', [FeeController::class, 'index'])->name('fees.index');
            Route::get('/fees/create', [FeeController::class, 'create'])->name('fees.create');
            Route::post('/fees', [FeeController::class, 'store'])->name('fees.store');
            Route::get('/fees/{fee}/edit', [FeeController::class, 'edit'])->name('fees.edit');
            Route::put('/fees/{fee}', [FeeController::class, 'update'])->name('fees.update');
            Route::get('/fees/import', [FeeController::class, 'importForm'])->name('fees.import');
            Route::post('/fees/import', [FeeController::class, 'importProcess'])->name('fees.import.process');
            Route::get('/fees/import/template', [FeeController::class, 'importTemplate'])->name('fees.import.template');
        });
        Route::middleware('can.section:inventory')->group(function () {
            Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
            Route::get('/inventory/create', [InventoryController::class, 'create'])->name('inventory.create');
            Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
            Route::get('/inventory/{inventory}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
            Route::put('/inventory/{inventory}', [InventoryController::class, 'update'])->name('inventory.update');
        });
        Route::middleware('can.section:academics')->group(function () {
            Route::get('/academics', [AcademicController::class, 'index'])->name('academics.index');
            Route::get('/academics/result/{result}/report', [AcademicController::class, 'report'])->name('academics.report');
            Route::get('/academics/create', [AcademicController::class, 'create'])->name('academics.create');
            Route::post('/academics', [AcademicController::class, 'store'])->name('academics.store');
            Route::get('/academics/import', [AcademicController::class, 'importForm'])->name('academics.import');
            Route::post('/academics/import', [AcademicController::class, 'importProcess'])->name('academics.import.process');
            Route::get('/academics/import/template', [AcademicController::class, 'importTemplate'])->name('academics.import.template');
        });
        Route::middleware('can.section:users')->group(function () {
            Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
            Route::get('/users/create', [UserManagementController::class, 'create'])->name('users.create');
            Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
            Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
            Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');
        });
    });
});
