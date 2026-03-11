<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SupervisorController;
use Illuminate\Support\Facades\Auth;

Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/students', [StudentController::class, 'index'])->name('admin.students');
Route::get('/admin/supervisor', [SupervisorController::class, 'index'])->name('admin.supervisor');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

