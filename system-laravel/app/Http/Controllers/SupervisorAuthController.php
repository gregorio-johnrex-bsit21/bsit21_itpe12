<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserTbl;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SupervisorAuthController extends Controller
{
    public function showLogin()
    {
        return view('supervisor.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supervisor_id' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $supervisor = UserTbl::where('supervisor_id', $request->supervisor_id)
                             ->where('role', 'supervisor')
                             ->first();

        if (!$supervisor || !Hash::check($request->password, $supervisor->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Supervisor ID or Password.'
            ]);
        }

        // Store in session
        session(['supervisor' => $supervisor]);

        return response()->json([
            'success' => true,
            'redirect' => '/supervisor/dashboard'
        ]);
    }

                            



    public function students()
{
    $supervisor = session('supervisor');

    $pending = UserTbl::where('company_id', $supervisor->company_id)
                      ->where('role', 'student')
                      ->where('status', 'pending')
                      ->get();

    $active = UserTbl::where('company_id', $supervisor->company_id)
                     ->where('role', 'student')
                     ->where('status', 'approved')
                     ->get();

    return view('supervisor.students', compact('pending', 'active'));
}

public function acceptStudent(Request $request)
{
    UserTbl::where('student_id', $request->student_id)
           ->update(['status' => 'approved']);

    return response()->json(['success' => true]);
}

public function rejectStudent(Request $request)
{
    UserTbl::where('student_id', $request->student_id)
           ->update(['status' => 'rejected']);

    return response()->json(['success' => true]);
}

public function logout()
{
    session()->forget('supervisor');
    return response()->json(['success' => true, 'redirect' => '/supervisor/login']);
}

}