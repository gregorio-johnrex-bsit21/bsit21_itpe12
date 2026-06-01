<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserTbl;
use App\Models\Student;
use App\Models\Supervisor;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ValidationController extends Controller
{
    public function index()
    {
        return view('students.validation');
    }

    public function register(Request $request)
{
    // Check if student_id exists and is approved (Active)
    $existingStudent = Student::where('student_id', $request->student_id)
        ->whereHas('user', function ($q) {
            $q->where('status', 'Active');
        })
        ->first();

    if ($existingStudent) {
        return response()->json([
            'success' => false,
            'message' => 'This Student ID is already registered and approved.'
        ]);
    }

    // Check if student_id is rejected
    $rejectedStudent = Student::where('student_id', $request->student_id)
    ->where('company_id', $request->company_id)
    ->whereHas('user', function ($q) {
        $q->where('status', 'Rejected');
    })
    ->first();

if ($rejectedStudent) {
    return response()->json([
        'success' => false,
        'message' => 'This Student ID has been rejected by this company. Please try a different company.'
    ]);
}

    // Delete old pending records (Inactive) so they can re-register
    $oldStudents = Student::where('student_id', $request->student_id)
        ->whereHas('user', function ($q) {
            $q->where('status', 'Inactive');
        })
        ->with('user')
        ->get();

    foreach ($oldStudents as $old) {
        if ($old->user) {
            $old->user->delete();
        }
        $old->delete();
    }

    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'student_id' => 'required|string|unique:students,student_id',
        'company_id' => 'required|string|exists:company_tbl,company_id',
        'password' => 'required|string|min:6|confirmed',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => $validator->errors()->first()
        ]);
    }

    DB::transaction(function () use ($request) {
        $user = UserTbl::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'role' => 'student',
            'status' => 'Inactive',
        ]);

        Student::create([
            'user_id' => $user->id,
            'student_id' => $request->student_id,
            'company_id' => $request->company_id,
        ]);
    });

    return response()->json([
        'success' => true,
        'message' => 'Registration submitted! Please wait for supervisor approval.'
    ]);
}

    public function login(Request $request)
    {
        $request->validate([
            'student_id' => 'required|string',
            'password' => 'required|string',
        ]);

        $student = Student::where('student_id', $request->student_id)
            ->with('user')
            ->first();

        if (!$student || !$student->user) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Student ID or Password.'
            ]);
        }

        $user = $student->user;

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Student ID or Password.'
            ]);
        }

        if ($user->status === 'Inactive') {
    return response()->json([
        'success' => false,
        'message' => 'Your account is still pending approval.'
    ]);
}

if ($user->status === 'Rejected') {
    return response()->json([
        'success' => false,
        'message' => 'Your account has been rejected. Please contact your supervisor.'
    ]);
}

        session(['student' => $student]);

        return response()->json([
            'success' => true,
            'redirect' => '/student'
        ]);
    }

    public function logout(Request $request)
    {
        $role = null;

        if (session()->has('student')) {
            $role = 'student';
        } elseif (session()->has('supervisor')) {
            $role = 'supervisor';
        } elseif (session()->has('admin')) {
            $role = 'admin';
        }

        session()->forget(['student', 'supervisor', 'admin']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($role === 'student') {
            $redirect = '/landing';
        } else {
            $redirect = '/login';
        }

        return response()->json([
            'success' => true,
            'redirect' => $redirect,
        ]);
    }

    public function getSupervisor()
    {
        $student = session('student');

        if (!$student) {
            return response()->json(null);
        }

        $supervisor = Supervisor::where('company_id', $student->company_id)
            ->with('user')
            ->first();

        if (!$supervisor || !$supervisor->user) {
            return response()->json(null);
        }

        // Return flat structure for JS compatibility
        return response()->json([
            'name' => $supervisor->user->name,
            'supervisor_id' => $supervisor->supervisor_id,
            'company_id' => $supervisor->company_id,
            'avatar' => $supervisor->user->avatar ?? null,
        ]);
    }

    public function dashboard()
{
    $student = session('student');
    if (!$student) return redirect('/landing');

    $company = Company::where('company_id', $student->company_id)->first();
    $profile = \App\Models\StudentProfile::where('student_id', $student->id)->first();

    session([
        'profile_complete' => $profile?->is_complete ?? false,
        'has_seen_tutorial' => $profile?->has_seen_tutorial ?? false,
    ]);

    return view('students.dashboard', compact('company', 'profile'));
}

    public function checkStatus(Request $request)
    {
        $student = Student::where('student_id', $request->student_id)
            ->with('user')
            ->first();

        if (!$student || !$student->user) {
            return response()->json(['status' => 'not_found']);
        }

        return response()->json(['status' => $student->user->status]);
    }
}