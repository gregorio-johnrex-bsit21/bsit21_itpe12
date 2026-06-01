<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserTbl;
use App\Models\Student;
use App\Models\Supervisor;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'user_id'  => 'required|string',
            'password' => 'required|string',
        ]);

        $userId = $request->user_id;
        $password = $request->password;

        // ── 1. Try supervisor ────────────────────────────────────────────────
        $supervisor = Supervisor::where('supervisor_id', $userId)
            ->with('user')
            ->first();

        if ($supervisor && $supervisor->user) {
            if (!Hash::check($password, $supervisor->user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid User ID or Password.',
                ]);
            }

            session(['supervisor' => $supervisor]);

            return response()->json([
                'success'  => true,
                'redirect' => '/supervisor/dashboard',
            ]);
        }

        // ── 2. Try student ───────────────────────────────────────────────────
        $student = Student::where('student_id', $userId)
            ->with('user')
            ->first();

        if ($student && $student->user) {
            $user = $student->user;

            if (!Hash::check($password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid User ID or Password.',
                ]);
            }

            if ($user->status === 'Inactive') {
    return response()->json([
        'success' => false,
        'message' => 'Your account is still pending approval.',
    ]);
}

if ($user->status === 'Rejected') {
    return response()->json([
        'success' => false,
        'message' => 'Your account has been rejected. Please contact your supervisor.',
    ]);
}

            session(['student' => $student]);

            return response()->json([
                'success'  => true,
                'redirect' => '/student',
            ]);
        }

        // ── 3. Try admin ─────────────────────────────────────────────────────
        $admin = Admin::where('admin_code', $userId)
            ->with('user')
            ->first();

        if ($admin && $admin->user) {
            if (!Hash::check($password, $admin->user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid User ID or Password.',
                ]);
            }

            session(['admin' => $admin]);

            return response()->json([
                'success'  => true,
                'redirect' => '/admin',
            ]);
        }

        // ── 4. No match ───────────────────────────────────────────────────────
        return response()->json([
            'success' => false,
            'message' => 'Invalid User ID or Password.',
        ]);
    }
}