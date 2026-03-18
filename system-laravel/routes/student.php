<?php

use Illuminate\Support\Facades\Route;

// Added ->name('students.') here
Route::prefix('student')->name('students.')->group(function () {

    Route::get('/', function () {
        return view('students.dashboard');
    })->name('dashboard'); // This is now 'students.dashboard'

    Route::get('/tasks', function () {
        return view('students.tasks');
    })->name('tasks'); // This is now 'students.tasks'

     Route::get('/logs', function () {
        return view('students.logs');
    })->name('logs'); 

    Route::get('/profile', function () {
        return view('students.profile');
    })->name('profile'); // This is now 'students.profile'

});