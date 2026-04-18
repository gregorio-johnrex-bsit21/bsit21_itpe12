<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserTbl;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Show the unified login page.
     */


    public function showLogin()
    {
        return view('login'); // resources/views/login.blade.php
    }

    /**
     * Unified login — detects role from users_tbl and redirects accordingly.
     *
     * How role detection works:
     *   - If user_id matches a row where supervisor_id = user_id  → role: supervisor
     *   - If user_id matches a row where student_id   = user_id  → role: student
     *   - If user_id matches a row where role = 'admin'           → role: admin
     *
     * The explicit `role` column on users_tbl is the source of truth.
     * We also check supervisor_id / student_id columns as the identifier.
     */
    public function login(Request $request)
    {
        $request->validate([
            'user_id'  => 'required|string',
            'password' => 'required|string',
        ]);

        $userId = $request->user_id;

        // ── 1. Try supervisor ────────────────────────────────────────────────
        $user = UserTbl::where('supervisor_id', $userId)
                       ->where('role', 'supervisor')
                       ->first();

        if ($user) {
            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid User ID or Password.',
                ]);
            }

            session(['supervisor' => $user]);

            return response()->json([
                'success'  => true,
                'redirect' => '/supervisor/dashboard',
            ]);
        }

        // ── 2. Try student ───────────────────────────────────────────────────
        $user = UserTbl::where('student_id', $userId)
                       ->where('role', 'student')
                       ->first();

        if ($user) {
            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid User ID or Password.',
                ]);
            }

            if ($user->status === 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Your account is still pending approval.',
                ]);
            }

            if ($user->status === 'rejected') {
                return response()->json([
                    'success' => false,
                    'message' => 'Your account has been rejected. Please contact your supervisor.',
                ]);
            }

            session(['student' => $user]);

            return response()->json([
                'success'  => true,
                'redirect' => '/student',
            ]);
        }

        // ── 3. Try admin ─────────────────────────────────────────────────────
        // Admin rows have role = 'admin'. Use the `student_id` or `supervisor_id`
        // column as their login identifier — whichever is filled.
        $user = UserTbl::where('role', 'admin')
                       ->where(function ($q) use ($userId) {
                           $q->where('student_id',    $userId)
                             ->orWhere('supervisor_id', $userId);
                       })
                       ->first();

        if ($user) {
            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid User ID or Password.',
                ]);
            }

            session(['admin' => $user]);

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