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
        return view('admin.supervisor', compact('companies'));
    }

   public function storeSupervisor(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'company_id' => 'required|string',
    ]);

    // Generate unique supervisor_id
    do {
        $supervisorId = strtoupper(str()->random(8));
    } while (\App\Models\UserTbl::where('supervisor_id', $supervisorId)->exists());

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
}