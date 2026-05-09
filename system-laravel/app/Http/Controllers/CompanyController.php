<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\UserTbl;
use App\Models\Supervisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $company = Company::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'success' => true,
            'company_id' => $company->company_id,
            'name' => $company->name,
        ]);
    }

    public function index()
    {
        $companies = Company::all();
        $supervisors = Supervisor::with('user', 'company')->get();
        return view('admin.supervisor', compact('companies', 'supervisors'));
    }

    public function storeSupervisor(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'company_id' => 'required|string',
        ]);

        // Check if company already has a supervisor
        $existingSupervisor = Supervisor::where('company_id', $request->company_id)->first();

        if ($existingSupervisor) {
            return response()->json([
                'success' => false,
                'message' => 'This company already has a supervisor assigned!'
            ]);
        }

        // Generate unique supervisor_id
        $supervisorId = strtoupper(str()->random(8));

        // Generate password
        $rawPassword = strtoupper(str()->random(10));

        DB::transaction(function () use ($request, $supervisorId, $rawPassword) {
            $user = UserTbl::create([
                'name' => $request->name,
                'password' => Hash::make($rawPassword),
                'role' => 'Supervisor',
                'status' => 'Active',
            ]);

            Supervisor::create([
                'user_id' => $user->id,
                'supervisor_id' => $supervisorId,
                'company_id' => $request->company_id,
            ]);
        });

        return response()->json([
            'success' => true,
            'supervisor_id' => $supervisorId,
            'password' => $rawPassword,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $rawPassword = strtoupper(str()->random(10));

        $supervisor = Supervisor::where('supervisor_id', $request->supervisor_id)->first();

        if (!$supervisor) {
            return response()->json([
                'success' => false,
                'message' => 'Supervisor not found.'
            ]);
        }

        $supervisor->user->update([
            'password' => Hash::make($rawPassword)
        ]);

        return response()->json([
            'success' => true,
            'supervisor_id' => $request->supervisor_id,
            'password' => $rawPassword,
        ]);
    }
}