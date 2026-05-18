<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyOjtRequirement;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OjtRequirementController extends Controller
{
    private function formatRequirement($requirement): array
    {
        return [
            'company_id'     => $requirement->company_id,
            'am_start_time'  => $requirement->am_start_time
                ? \Carbon\Carbon::parse($requirement->am_start_time)->format('H:i') : null,
            'am_end_time'    => $requirement->am_end_time
                ? \Carbon\Carbon::parse($requirement->am_end_time)->format('H:i') : null,
            'pm_start_time'  => $requirement->pm_start_time
                ? \Carbon\Carbon::parse($requirement->pm_start_time)->format('H:i') : null,
            'pm_end_time'    => $requirement->pm_end_time
                ? \Carbon\Carbon::parse($requirement->pm_end_time)->format('H:i') : null,
            'required_hours' => $requirement->required_hours,
            'start_date'     => $requirement->start_date
                ? \Carbon\Carbon::parse($requirement->start_date)->format('Y-m-d') : null,
            'end_date'       => $requirement->end_date
                ? \Carbon\Carbon::parse($requirement->end_date)->format('Y-m-d') : null,
            'daily_hours'    => $requirement->daily_hours,
            'am_hours'       => $requirement->am_hours,
            'pm_hours'       => $requirement->pm_hours,
        ];
    }

    // GET: Fetch requirements for a company
    public function show($companyId): JsonResponse
    {
        $company     = Company::findOrFail($companyId);
        $requirement = $company->ojtRequirement;

        return response()->json([
            'success' => true,
            'data'    => $requirement ? $this->formatRequirement($requirement) : null,
        ]);
    }

    // POST: Save/update requirements
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'company_id'     => 'required|exists:company_tbl,id',
            'am_start_time'  => 'nullable|date_format:H:i',
            'am_end_time'    => 'nullable|date_format:H:i',
            'pm_start_time'  => 'nullable|date_format:H:i',
            'pm_end_time'    => 'nullable|date_format:H:i',
            'required_hours' => 'required|integer|min:1|max:2000',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
        ]);

        $requirement = CompanyOjtRequirement::updateOrCreate(
            ['company_id' => $validated['company_id']],
            $validated
        );

        return response()->json([
            'success' => true,
            'message' => 'OJT requirements saved successfully',
            'data'    => $this->formatRequirement($requirement),
        ]);
    }
}