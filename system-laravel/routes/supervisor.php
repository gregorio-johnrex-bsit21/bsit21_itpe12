<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupervisorAuthController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\SupervisorDashboardController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\TaskController;


// Supervisor Login routes
Route::get('/supervisor/login', [SupervisorAuthController::class, 'showLogin'])->name('supervisor.login');
Route::post('/supervisor/login', [SupervisorAuthController::class, 'login'])->name('supervisor.login.post');

Route::post('/supervisor/students/accept', [SupervisorAuthController::class, 'acceptStudent'])->name('supervisor.accept');
Route::post('/supervisor/students/reject', [SupervisorAuthController::class, 'rejectStudent'])->name('supervisor.reject');
Route::get('/supervisor/students', [SupervisorAuthController::class, 'students'])->name('supervisor.students');

Route::prefix('supervisor')->group(function () {

    // 🔥 ENTRY POINT (only place without middleware)
    Route::get('/', function () {
        return session('supervisor')
            ? redirect('/supervisor/dashboard')
            : redirect('/login');
    });

    // 🔐 PROTECTED ROUTES
    Route::middleware('supervisor')->group(function () {

    Route::get('/dashboard', [SupervisorDashboardController::class, 'index'])->name('supervisor.dashboard');
    Route::get('/attendance', [AttendanceController::class, 'showAttendanceLogs'])->name('supervisor.attendance'); 
    Route::view('/tasks', 'supervisor.tasks')->name('supervisor.tasks');
    Route::get('/evaluation', [SupervisorController::class, 'evaluation'])->name('supervisor.evaluation');

    Route::get('/tasks', [TaskController::class, 'index'])->name('supervisor.tasks');
    Route::post('/tasks', [TaskController::class, 'store'])->name('supervisor.tasks.store');
    Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('supervisor.tasks.update');
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('supervisor.tasks.destroy');
    Route::post('/submissions/{id}/review', [TaskController::class, 'reviewSubmission'])->name('supervisor.submissions.review');
    Route::get('/notifications', [TaskController::class, 'notifications'])->name('supervisor.notifications');

});

});





Route::get('/supervisor/chat/students', [SupervisorAuthController::class, 'getStudents']);

Route::post('/supervisor/change-password', [SupervisorAuthController::class, 'changePassword'])->name('supervisor.change.password');



