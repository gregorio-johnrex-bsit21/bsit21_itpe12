<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

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
    $supervisors = \App\Models\UserTbl::where('role', 'supervisor')
                                      ->with('company')
                                      ->get();
    return view('admin.supervisor', compact('companies', 'supervisors'));
}
   public function storeSupervisor(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'company_id' => 'required|string',
    ]);

    // Check if company already has a supervisor
    $existingSupervisor = \App\Models\UserTbl::where('company_id', $request->company_id)
                                             ->where('role', 'supervisor')
                                             ->first();

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

    // Save to DB
    \App\Models\UserTbl::create([
        'supervisor_id' => $supervisorId,
        'company_id' => $request->company_id,
        'name' => $request->name,
        'password' => \Illuminate\Support\Facades\Hash::make($rawPassword),
        'role' => 'supervisor',
        'status' => 'approved',
    ]);

    return response()->json([
        'success' => true,
        'supervisor_id' => $supervisorId,
        'password' => $rawPassword,
    ]);
}

public function resetPassword(Request $request)
{
    $rawPassword = strtoupper(str()->random(10));

    \App\Models\UserTbl::where('supervisor_id', $request->supervisor_id)
                       ->update(['password' => \Illuminate\Support\Facades\Hash::make($rawPassword)]);

    return response()->json([
        'success' => true,
        'supervisor_id' => $request->supervisor_id,
        'password' => $rawPassword,
    ]);
}

}