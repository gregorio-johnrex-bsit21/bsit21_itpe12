<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ValidationController;
use App\Http\Controllers\TaskSubmissionController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\StudentProfileController;


Route::prefix('student')->name('students.')->middleware('student')->group(function () {

    Route::get('/', [ValidationController::class, 'dashboard'])->name('dashboard');

    Route::get('/tasks', [TaskSubmissionController::class, 'index'])->name('tasks');
    Route::post('/tasks/submit', [TaskSubmissionController::class, 'submit'])->name('tasks.submit');

    Route::get('/logs', function () {
        return view('students.logs');
    })->name('logs');

    // Updated: profile page now passes $profile to view
    Route::get('/profile', function () {
        $student = session('student');
        $profile = \App\Models\StudentProfile::where('student_id', $student->id)->first();
        return view('students.profile', compact('profile'));
    })->name('profile');

    // New: save profile
    Route::post('/profile/save', [StudentProfileController::class, 'store'])->name('profile.save');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.read-all');
    Route::post('/tutorial-seen', [StudentProfileController::class, 'markTutorialSeen'])->name('tutorial.seen');

});



