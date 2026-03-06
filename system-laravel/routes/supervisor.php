<?php

use Illuminate\Support\Facades\Route;

Route::prefix('supervisor')->group(function () {
    Route::view('/dashboard', 'supervisor.dashboard')->name('supervisor.dashboard');
    Route::view('/attendance', 'supervisor.attendance')->name('supervisor.attendance');
    Route::view('/tasks', 'supervisor.tasks')->name('supervisor.tasks');
    Route::view('/evaluation', 'supervisor.evaluation')->name('supervisor.evaluation');
    Route::view('/students', 'supervisor.students')->name('supervisor.students');
});