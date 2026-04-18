<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ReportController;


Route::middleware(['admin'])->group(function () {
    
    // This provides the URL '/admin' AND the name 'admin.dashboard'
    Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/students', [StudentController::class, 'index'])->name('admin.students');
    Route::get('/admin/supervisor', [CompanyController::class, 'index'])->name('admin.supervisor');
    Route::get('/admin/report', [ReportController::class, 'index'])->name('admin.report');
    
   // POST routes
    
    // 1. Route for creating the Company (calling the 'store' method)
    Route::post('/admin/company/store', [CompanyController::class, 'store'])->name('company.store');

    // 2. Route for creating the Supervisor (calling the 'storeSupervisor' method)
    // This fixes the "Route [supervisor.store] not defined" error
    Route::post('/admin/supervisor/store', [CompanyController::class, 'storeSupervisor'])->name('supervisor.store');

    // 3. Route for resetting password
    Route::post('/admin/supervisor/reset-password', [CompanyController::class, 'resetPassword'])->name('supervisor.reset.password');
});