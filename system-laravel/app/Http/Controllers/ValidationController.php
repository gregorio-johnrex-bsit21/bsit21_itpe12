<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserTbl;
use Illuminate\Support\Facades\Hash;

class ValidationController extends Controller
{
    public function index(){
        return view('students.validation');
    }

   public function register(Request $request)
{
    // Check if student_id exists and is approved
$existingStudent = UserTbl::where('student_id', $request->student_id)
                          ->where('status', 'approved')
                          ->first();

if ($existingStudent) {
    return response()->json([
        'success' => false,
        'message' => 'This Student ID is already registered and approved.'
    ]);
}

// Delete old rejected/pending record so they can re-register
UserTbl::where('student_id', $request->student_id)
       ->whereIn('status', ['rejected', 'pending'])
       ->delete();

$validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
    'name' => 'required|string|max:255',
    'student_id' => 'required|string',
    'company_id' => 'required|string|exists:company_tbl,company_id',
    'password' => 'required|string|min:6|confirmed',
]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => $validator->errors()->first()
        ]);
    }

    UserTbl::create([
        'name' => $request->name,
        'student_id' => $request->student_id,
        'company_id' => $request->company_id,
        'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        'role' => 'student',
        'status' => 'pending',
    ]);

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

        $user = UserTbl::where('student_id', $request->student_id)
                       ->where('role', 'student')
                       ->first();

        // Check if user exists
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Student ID or Password.'
            ]);
        }

        // Check if approved
        if ($user->status === 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Your account is still pending approval.'
            ]);
        }

        if ($user->status === 'rejected') {
            return response()->json([
                'success' => false,
                'message' => 'Your account has been rejected.'
            ]);
        }

        // Store in session
        session(['student' => $user]);

        return response()->json([
            'success' => true,
            'redirect' => '/student'
        ]);
    }

    public function logout()
    {
        session()->forget('student');
        return response()->json([
        'success' => true,
        'redirect' => '/landing'
        ]);
    }

    public function getSupervisor()
{
    $student = session('student');
    $supervisor = UserTbl::where('company_id', $student->company_id)
                         ->where('role', 'supervisor')
                         ->first();

    return response()->json($supervisor);
}

public function dashboard()
{
    $student = session('student');
    $company = \App\Models\Company::where('company_id', $student->company_id)->first();
    return view('students.dashboard', compact('company'));
}

public function checkStatus(Request $request)
{
    $student = UserTbl::where('student_id', $request->student_id)
                      ->where('role', 'student')
                      ->first();

    if (!$student) {
        return response()->json(['status' => 'not_found']);
    }

    return response()->json(['status' => $student->status]);
}

}