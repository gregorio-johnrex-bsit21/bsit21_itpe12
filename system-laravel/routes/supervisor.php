<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupervisorAuthController;
use App\Http\Controllers\AttendanceController;


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

    Route::get('/dashboard', [AttendanceController::class, 'showTodayAttendance'])->name('supervisor.dashboard');
    Route::get('/attendance', [AttendanceController::class, 'showAttendanceLogs'])->name('supervisor.attendance'); // ← fix this
    Route::view('/tasks', 'supervisor.tasks')->name('supervisor.tasks');
    Route::view('/evaluation', 'supervisor.evaluation')->name('supervisor.evaluation');

});

});





Route::get('/supervisor/chat/students', [SupervisorAuthController::class, 'getStudents']);

Route::post('/supervisor/change-password', [SupervisorAuthController::class, 'changePassword'])->name('supervisor.change.password');



