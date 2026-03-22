<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CompanyController;

Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/students', [StudentController::class, 'index'])->name('admin.students');
Route::get('/admin/supervisor', [CompanyController::class, 'index'])->name('admin.supervisor');
Route::get('/admin/report', [ReportController::class, 'index'])->name('admin.report');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::post('/admin/supervisor/store', [CompanyController::class, 'store'])->name('company.store');
Route::post('/admin/supervisor/store-supervisor', [CompanyController::class, 'storeSupervisor'])->name('supervisor.store');

Route::post('/admin/supervisor/reset-password', [CompanyController::class, 'resetPassword'])->name('supervisor.reset.password');