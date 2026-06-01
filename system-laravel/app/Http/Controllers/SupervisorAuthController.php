<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserTbl;
use App\Models\Supervisor;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SupervisorAuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
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

        $supervisor = Supervisor::where('supervisor_id', $request->supervisor_id)
            ->with('user')
            ->first();

        if (!$supervisor || !$supervisor->user || !Hash::check($request->password, $supervisor->user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Supervisor ID or Password.'
            ]);
        }

        session(['supervisor' => $supervisor]);

        return response()->json([
            'success' => true,
            'redirect' => '/supervisor/dashboard'
        ]);
    }

    public function students()
    {
        $supervisor = session('supervisor');

        if (!$supervisor) {
            return redirect('/supervisor/login');
        }

        $pending = Student::where('company_id', $supervisor->company_id)
            ->whereHas('user', function ($q) {
                $q->where('status', 'Inactive');
            })
            ->with('user', 'profile')
            ->get();

        $active = Student::where('company_id', $supervisor->company_id)
            ->whereHas('user', function ($q) {
                $q->where('status', 'Active');
            })
            ->with('user', 'profile', 'company.ojtRequirement')
            ->get();

        return view('supervisor.students', compact('pending', 'active'));
    }

    public function acceptStudent(Request $request)
    {
        $student = Student::where('student_id', $request->student_id)
            ->with('user')
            ->first();

        if (!$student || !$student->user) {
            return response()->json(['success' => false, 'message' => 'Student not found.']);
        }

        $student->user->update(['status' => 'Active']);

        return response()->json(['success' => true]);
    }

    public function rejectStudent(Request $request)
{
    $student = Student::where('student_id', $request->student_id)
        ->with('user')
        ->first();

    if (!$student || !$student->user) {
        return response()->json(['success' => false, 'message' => 'Student not found.']);
    }

    $student->user->update(['status' => 'Rejected']);

    return response()->json(['success' => true]);
}

    public function logout()
    {
        session()->forget('supervisor');
        return response()->json(['success' => true, 'redirect' => '/login']);
    }

    public function getStudents()
    {
        $supervisor = session('supervisor');

        if (!$supervisor) {
            return response()->json([]);
        }

        $students = Student::where('company_id', $supervisor->company_id)
            ->whereHas('user', function ($q) {
                $q->where('status', 'Active');
            })
            ->with('user')
            ->get()
            ->map(function ($student) {
                return [
                    'name' => $student->user->name,
                    'student_id' => $student->student_id,
                    'avatar' => $student->user->avatar ?? null,
                    'company_id' => $student->company_id,
                ];
            });

        return response()->json($students);
    }

    public function changePassword(Request $request)
    {
        $supervisor = session('supervisor');

        if (!$supervisor || !$supervisor->user) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired.'
            ]);
        }

        $user = $supervisor->user;

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect.'
            ]);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        session(['supervisor' => $supervisor]);

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully!'
        ]);
    }
}