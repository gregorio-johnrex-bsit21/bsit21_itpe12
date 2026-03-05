<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/tasks', function () {
    return view('tasks');
})->name('tasks');

Route::get('/profile', function () {
    return view('profile');
})->name('profile');


