<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\OjtRequirementController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;


Route::middleware(['admin'])->group(function () {
    
    // This provides the URL '/admin' AND the name 'admin.dashboard'
    

    Route::get('/admin/students', [AttendanceController::class, 'adminLogs'])->name('admin.students');
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

    Route::get('/admin/ojt-requirements/{company}', [OjtRequirementController::class, 'show'])->name('ojt.requirements.show');
    Route::post('/admin/ojt-requirements', [OjtRequirementController::class, 'store'])->name('ojt.requirements.store');

    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard.full');

    Route::get('/admin/attendance', [AttendanceController::class, 'adminLogs'])->name('admin.attendance');

    

    Route::get('/admin/report', [ReportController::class, 'index'])->name('admin.report');
    Route::get('/admin/report/students', [ReportController::class, 'getStudents'])->name('admin.report.students');
    Route::get('/admin/report/data', [ReportController::class, 'getReport'])->name('admin.report.data');
    Route::get('/admin/report/export', [ReportController::class, 'exportCsv'])->name('admin.report.export');
});