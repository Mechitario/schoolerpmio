<?php

use App\Http\Controllers\AcademicController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/admin/login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/admin/logout', [LoginController::class, 'logout'])->name('logout');
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/report', [DashboardController::class, 'report'])->name('dashboard.report');
        Route::get('/dashboard/export', [DashboardController::class, 'export'])->name('dashboard.export');
        Route::get('/students', [StudentController::class, 'index'])->name('students.index');
        Route::get('/students/export', [StudentController::class, 'export'])->name('students.export');
        Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
        Route::post('/students', [StudentController::class, 'store'])->name('students.store');
        Route::get('/students/import', [StudentController::class, 'importForm'])->name('students.import');
        Route::post('/students/import', [StudentController::class, 'importProcess'])->name('students.import.process');
        Route::get('/students/import/template', [StudentController::class, 'importTemplate'])->name('students.import.template');
        Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
        Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');
        Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
        Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
        Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
        Route::get('/staff/salaries', [StaffController::class, 'salaries'])->name('staff.salaries');
        Route::post('/staff/salaries', [StaffController::class, 'storeSalary'])->name('staff.salaries.store');
        Route::get('/staff/{staff}/edit', [StaffController::class, 'edit'])->name('staff.edit');
        Route::put('/staff/{staff}', [StaffController::class, 'update'])->name('staff.update');
        Route::get('/fees', [FeeController::class, 'index'])->name('fees.index');
        Route::get('/fees/create', [FeeController::class, 'create'])->name('fees.create');
        Route::post('/fees', [FeeController::class, 'store'])->name('fees.store');
        Route::get('/fees/import', [FeeController::class, 'importForm'])->name('fees.import');
        Route::post('/fees/import', [FeeController::class, 'importProcess'])->name('fees.import.process');
        Route::get('/fees/import/template', [FeeController::class, 'importTemplate'])->name('fees.import.template');
        Route::get('/academics', [AcademicController::class, 'index'])->name('academics.index');
        Route::get('/academics/result/{result}/report', [AcademicController::class, 'report'])->name('academics.report');
        Route::get('/academics/create', [AcademicController::class, 'create'])->name('academics.create');
        Route::post('/academics', [AcademicController::class, 'store'])->name('academics.store');
        Route::get('/academics/import', [AcademicController::class, 'importForm'])->name('academics.import');
        Route::post('/academics/import', [AcademicController::class, 'importProcess'])->name('academics.import.process');
        Route::get('/academics/import/template', [AcademicController::class, 'importTemplate'])->name('academics.import.template');
    });
});
