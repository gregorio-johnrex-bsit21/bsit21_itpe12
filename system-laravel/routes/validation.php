<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ValidationController;

Route::get('/validation', [ValidationController::class, 'index'])->name('students.validation');
Route::post('/validation/login', [ValidationController::class, 'login'])->name('students.login');
Route::post('/validation/register', [ValidationController::class, 'register'])->name('students.register');


Route::post('/logout', [ValidationController::class, 'logout'])->name('logout');

Route::get('/student/supervisor', [ValidationController::class, 'getSupervisor'])->name('students.supervisor');

Route::get('/validation/status', [ValidationController::class, 'checkStatus'])->name('students.status');