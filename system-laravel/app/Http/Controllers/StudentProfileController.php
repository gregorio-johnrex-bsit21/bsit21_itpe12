<?php

namespace App\Http\Controllers;

use App\Models\StudentProfile;
use Illuminate\Http\Request;

class StudentProfileController extends Controller
{
    public function store(Request $request)
{
    $student = session('student');

    $request->validate([
        'course' => 'required|string|max:255',
        'section' => 'required|string|max:255',
        'year_level' => 'required|string|max:255',
        'school_name' => 'required|string|max:255',
        'school_address' => 'required|string|max:500',
        'home_address' => 'required|string|max:500',
        'contact_number' => 'required|string|max:20',
        'emergency_contact' => 'required|string|max:20',
    ]);

    $profile = StudentProfile::updateOrCreate(
        ['student_id' => $student->id],
        $request->only([
            'course', 'section', 'year_level', 'school_name',
            'school_address', 'home_address', 'contact_number', 'emergency_contact'
        ])
    );

    $profile->is_complete = $profile->checkIsComplete();
    $profile->save();

    session([
        'profile_complete' => $profile->is_complete,
        'has_seen_tutorial' => $profile->has_seen_tutorial,
    ]);

    return back()->with('success', 'Profile saved successfully!');
}

public function markTutorialSeen(Request $request)
{
    $student = session('student');
    
    $profile = StudentProfile::where('student_id', $student->id)->first();
    
    if ($profile) {
        $profile->update(['has_seen_tutorial' => true]);
    }

    session(['has_seen_tutorial' => true]);

    return response()->json(['success' => true]);
}
}