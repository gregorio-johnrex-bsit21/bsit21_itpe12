<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;

class SupervisorController extends Controller
{
    public function index()
    {
        return view('admin.supervisor');
    }

    public function evaluation()
{
    $supervisor   = session('supervisor');
    $companyId    = $supervisor->company_id;
    $supervisorId = $supervisor->id;

    $company = \App\Models\Company::where('company_id', $companyId)->first();
    $ojt     = \App\Models\CompanyOjtRequirement::where('company_id', $company?->id)->first();
    $required = $ojt?->required_hours ?? 0;
    $required = $ojt?->required_hours ?? 0;

    $students = Student::with(['user'])
        ->where('company_id', $companyId)
        ->get();

    $studentData = $students->map(function ($student) use ($required) {
        $accumulated = Attendance::where('student_id', $student->id)->sum('total_hours');
        $accumulated = round($accumulated, 1);
        $remaining   = max(0, $required - $accumulated);
        $progressPct = $required > 0 ? min(100, round(($accumulated / $required) * 100)) : 0;

        // Missed hours
        $missedMinutes = Attendance::where('student_id', $student->id)->get()
            ->sum(function ($record) {
                $missed  = 0;
                $dateStr = \Carbon\Carbon::parse($record->date)->format('Y-m-d');
                if ($record->am_time_in) {
                    $sched  = \Carbon\Carbon::parse($dateStr . ' 08:00:00');
                    $actual = \Carbon\Carbon::parse($dateStr . ' ' . $record->am_time_in);
                    if ($actual->gt($sched)) $missed += $sched->diffInMinutes($actual);
                }
                if ($record->am_time_out) {
                    $sched  = \Carbon\Carbon::parse($dateStr . ' 12:00:00');
                    $actual = \Carbon\Carbon::parse($dateStr . ' ' . $record->am_time_out);
                    if ($actual->lt($sched)) $missed += $actual->diffInMinutes($sched);
                }
                if ($record->pm_time_in) {
                    $sched  = \Carbon\Carbon::parse($dateStr . ' 13:00:00');
                    $actual = \Carbon\Carbon::parse($dateStr . ' ' . $record->pm_time_in);
                    if ($actual->gt($sched)) $missed += $sched->diffInMinutes($actual);
                }
                if ($record->pm_time_out) {
                    $sched  = \Carbon\Carbon::parse($dateStr . ' 17:00:00');
                    $actual = \Carbon\Carbon::parse($dateStr . ' ' . $record->pm_time_out);
                    if ($actual->lt($sched)) $missed += $actual->diffInMinutes($sched);
                }
                return $missed;
            });

        $missedHours = round($missedMinutes / 60, 1);

        // Status based on progress
        $status = $progressPct >= 75 ? 'on_track' : ($progressPct >= 40 ? 'in_progress' : 'behind');

        return [
            'name'        => $student->user->name ?? 'Unknown',
            'status'      => $status,
            'required'    => $required,
            'accumulated' => $accumulated,
            'remaining'   => $remaining,
            'missed'      => $missedHours,
            'progress'    => $progressPct,
        ];
    });

    return view('supervisor.evaluation', compact('studentData'));
}
}