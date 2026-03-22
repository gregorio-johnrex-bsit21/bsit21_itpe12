<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ValidationController;

Route::prefix('student')->name('students.')->middleware('student')->group(function () {

    Route::get('/', [ValidationController::class, 'dashboard'])->name('dashboard');

    Route::get('/tasks', function () {
        return view('students.tasks');
    })->name('tasks');

    Route::get('/logs', function () {
        return view('students.logs');
    })->name('logs');

    Route::get('/profile', function () {
        return view('students.profile');
    })->name('profile');

});