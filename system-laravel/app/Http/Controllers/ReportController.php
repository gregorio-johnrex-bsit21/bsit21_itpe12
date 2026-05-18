<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\CompanyOjtRequirement;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $companies = Company::orderBy('name')->get();
        return view('admin.report', compact('companies'));
    }

    public function getStudents(Request $request)
{
    $students = Student::with('user')
        ->where('company_id', $request->company_id)
        ->whereHas('user', fn($q) => $q->where('status', 'Active'))
        ->get()
        ->map(fn($s) => [
            'id'   => $s->id,
            'name' => $s->user->name ?? 'Unknown',
        ]);

    return response()->json($students);
}

    public function getReport(Request $request)
    {
        $student = Student::with(['user', 'company'])
            ->findOrFail($request->student_id);

        $company = $student->company;
        $ojt     = $company
            ? \App\Models\CompanyOjtRequirement::where('company_id', $company->id)->first()
            : null;

        $schedule = [
            'am_in'  => $ojt?->am_start_time ?? '08:00:00',
            'am_out' => $ojt?->am_end_time   ?? '12:00:00',
            'pm_in'  => $ojt?->pm_start_time ?? '13:00:00',
            'pm_out' => $ojt?->pm_end_time   ?? '17:00:00',
        ];

        $attendances = Attendance::where('student_id', $student->id)
            ->orderBy('date', 'desc')
            ->get();

        $totalHours    = round($attendances->sum('total_hours'), 2);
        $requiredHours = $ojt?->required_hours ?? 0;
        $progressPct   = $requiredHours > 0
            ? min(100, round(($totalHours / $requiredHours) * 100, 1))
            : 0;

        // Missed minutes
        $totalMissed = $attendances->sum(function ($record) use ($schedule) {
            return $this->calculateMissed($record, $schedule);
        });

        // Late days
        $lateDays = $attendances->filter(function ($record) use ($schedule) {
            return $this->calculateMissed($record, $schedule) > 0;
        })->count();

        // Attendance rate
        $completeDays    = $attendances->filter(fn($r) =>
            $r->am_time_in && $r->am_time_out && $r->pm_time_in && $r->pm_time_out
        )->count();
        $totalDays       = $attendances->count();
        $attendanceRate  = $totalDays > 0
            ? round(($completeDays / $totalDays) * 100, 1)
            : 0;

        // DTR logs
        $logs = $attendances->map(function ($record) use ($schedule) {
            $missed  = $this->calculateMissed($record, $schedule);
            $hasAll  = $record->am_time_in && $record->am_time_out
                    && $record->pm_time_in && $record->pm_time_out;

            $status = 'Incomplete';
            if ($hasAll) {
                $status = $missed > 0 ? 'Has Missed' : 'Complete';
                if ($record->total_hours < 8) $status = 'Half Day';
            }

            return [
                'date'        => Carbon::parse($record->date)->format('M d, Y'),
                'am_time_in'  => $record->am_time_in  ? Carbon::parse($record->am_time_in)->format('h:i A')  : null,
                'am_time_out' => $record->am_time_out ? Carbon::parse($record->am_time_out)->format('h:i A') : null,
                'pm_time_in'  => $record->pm_time_in  ? Carbon::parse($record->pm_time_in)->format('h:i A')  : null,
                'pm_time_out' => $record->pm_time_out ? Carbon::parse($record->pm_time_out)->format('h:i A') : null,
                'total_hours' => round($record->total_hours, 2),
                'missed_mins' => $missed,
                'status'      => $status,
            ];
        });

        $name     = $student->user->name ?? 'Unknown';
        $initials = collect(explode(' ', $name))
            ->map(fn($p) => strtoupper(substr($p, 0, 1)))
            ->take(2)->join('');

        return response()->json([
            'student' => [
                'name'            => $name,
                'initials'        => $initials,
                'student_id'      => $student->student_id,
                'company'         => $company?->name ?? 'N/A',
                'total_hours'     => $totalHours,
                'required_hours'  => $requiredHours,
                'progress_pct'    => $progressPct,
                'attendance_rate' => $attendanceRate,
                'late_days'       => $lateDays,
                'total_missed_h'  => round($totalMissed / 60, 1),
                'total_days'      => $totalDays,
                'complete_days'   => $completeDays,
            ],
            'logs' => $logs,
        ]);
    }

    public function exportCsv(Request $request)
    {
        $student = Student::with(['user', 'company'])->findOrFail($request->student_id);
        $ojt     = $student->company
            ? \App\Models\CompanyOjtRequirement::where('company_id', $student->company->id)->first()
            : null;

        $schedule = [
            'am_in'  => $ojt?->am_start_time ?? '08:00:00',
            'am_out' => $ojt?->am_end_time   ?? '12:00:00',
            'pm_in'  => $ojt?->pm_start_time ?? '13:00:00',
            'pm_out' => $ojt?->pm_end_time   ?? '17:00:00',
        ];

        $attendances = Attendance::where('student_id', $student->id)
            ->orderBy('date', 'desc')
            ->get();

        $filename = 'OJT_Report_' . str_replace(' ', '_', $student->user->name) . '_' . now()->format('Ymd') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($attendances, $student, $schedule, $ojt) {
            $handle = fopen('php://output', 'w');

            // Header info
            fputcsv($handle, ['OJT Performance Report']);
            fputcsv($handle, ['Student', $student->user->name ?? '']);
            fputcsv($handle, ['Company', $student->company?->name ?? '']);
            fputcsv($handle, ['Required Hours', $ojt?->required_hours ?? 0]);
            fputcsv($handle, ['Generated', now()->format('M d, Y h:i A')]);
            fputcsv($handle, []);

            // Table headers
            fputcsv($handle, ['Date', 'AM In', 'AM Out', 'PM In', 'PM Out', 'Total Hours', 'Missed (mins)', 'Status']);

            foreach ($attendances as $record) {
                $missed = $this->calculateMissed($record, $schedule);
                $hasAll = $record->am_time_in && $record->am_time_out
                       && $record->pm_time_in && $record->pm_time_out;
                $status = 'Incomplete';
                if ($hasAll) {
                    $status = $missed > 0 ? 'Has Missed' : 'Complete';
                    if ($record->total_hours < 8) $status = 'Half Day';
                }

                fputcsv($handle, [
                    Carbon::parse($record->date)->format('M d, Y'),
                    $record->am_time_in  ? Carbon::parse($record->am_time_in)->format('h:i A')  : '--',
                    $record->am_time_out ? Carbon::parse($record->am_time_out)->format('h:i A') : '--',
                    $record->pm_time_in  ? Carbon::parse($record->pm_time_in)->format('h:i A')  : '--',
                    $record->pm_time_out ? Carbon::parse($record->pm_time_out)->format('h:i A') : '--',
                    round($record->total_hours, 2),
                    $missed,
                    $status,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function calculateMissed($record, array $schedule): int
    {
        $missed  = 0;
        $dateStr = Carbon::parse($record->date)->format('Y-m-d');

        if ($record->am_time_in) {
            $sched  = Carbon::parse($dateStr . ' ' . $schedule['am_in']);
            $actual = Carbon::parse($dateStr . ' ' . $record->am_time_in);
            if ($actual->gt($sched)) $missed += $sched->diffInMinutes($actual);
        }
        if ($record->am_time_out) {
            $sched  = Carbon::parse($dateStr . ' ' . $schedule['am_out']);
            $actual = Carbon::parse($dateStr . ' ' . $record->am_time_out);
            if ($actual->lt($sched)) $missed += $actual->diffInMinutes($sched);
        }
        if ($record->pm_time_in) {
            $sched  = Carbon::parse($dateStr . ' ' . $schedule['pm_in']);
            $actual = Carbon::parse($dateStr . ' ' . $record->pm_time_in);
            if ($actual->gt($sched)) $missed += $sched->diffInMinutes($actual);
        }
        if ($record->pm_time_out) {
            $sched  = Carbon::parse($dateStr . ' ' . $schedule['pm_out']);
            $actual = Carbon::parse($dateStr . ' ' . $record->pm_time_out);
            if ($actual->lt($sched)) $missed += $actual->diffInMinutes($sched);
        }

        return $missed;
    }
}