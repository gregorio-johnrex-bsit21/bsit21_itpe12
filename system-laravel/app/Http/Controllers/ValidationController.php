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
    $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'student_id' => 'required|string|unique:users_tbl,student_id',
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
}