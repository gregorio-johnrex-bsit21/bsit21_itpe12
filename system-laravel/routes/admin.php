<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;

Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

