<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ValidationController;

Route::get('/validation', [ValidationController::class, 'index'])->name('students.validation');
Route::post('/validation/login', [ValidationController::class, 'login'])->name('students.login');
Route::post('/validation/register', [ValidationController::class, 'register'])->name('students.register');