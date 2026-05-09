<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'admin_code' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $admin = Admin::where('admin_code', $request->admin_code)
            ->with('user')
            ->first();

        if (!$admin || !$admin->user || !Hash::check($request->password, $admin->user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Admin Code or Password.'
            ]);
        }

        session(['admin' => $admin]);

        return response()->json([
            'success' => true,
            'redirect' => '/admin/dashboard'
        ]);
    }

    public function logout()
    {
        session()->forget('admin');
        return response()->json(['success' => true, 'redirect' => '/admin/login']);
    }
}