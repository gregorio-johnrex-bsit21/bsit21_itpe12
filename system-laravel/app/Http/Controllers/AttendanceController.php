<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\CompanyOjtRequirement;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Get the OJT schedule for a student's company.
     * Returns default times if no schedule is set.
     */
    private function getSchedule(Student $student): array
    {
        $company = \App\Models\Company::where('company_id', $student->company_id)->first();
        $ojt     = $company
            ? CompanyOjtRequirement::where('company_id', $company->id)->first()
            : null;

        return [
            'am_in'  => $ojt?->am_start_time ?? '08:00:00',
            'am_out' => $ojt?->am_end_time   ?? '12:00:00',
            'pm_in'  => $ojt?->pm_start_time ?? '13:00:00',
            'pm_out' => $ojt?->pm_end_time   ?? '17:00:00',
        ];
    }

    public function clockIn(Request $request)
    {
        $request->validate([
            'student_id' => 'required|string|exists:students,student_id',
            'session'    => 'required|in:am,pm',
            'date'       => 'required|date',
            'time'       => 'required',
        ]);

        $student = Student::where('student_id', $request->student_id)->first();

        $attendance = Attendance::firstOrCreate(
            [
                'student_id' => $student->id,
                'date'       => $request->date,
            ],
            ['total_hours' => 0]
        );

        $timeField = $request->session . '_time_in';

        if ($attendance->$timeField) {
            return response()->json([
                'success' => false,
                'message' => 'Already clocked in for ' . strtoupper($request->session) . ' session.',
            ]);
        }

        $attendance->update([$timeField => $request->time]);

        return response()->json([
            'success' => true,
            'message' => 'Clocked in successfully.',
            'time'    => Carbon::parse($request->time)->format('h:i A'),
        ]);
    }

    public function clockOut(Request $request)
    {
        $request->validate([
            'student_id' => 'required|string|exists:students,student_id',
            'session'    => 'required|in:am,pm',
            'date'       => 'required|date',
            'time'       => 'required',
        ]);

        $student = Student::where('student_id', $request->student_id)->first();

        $attendance = Attendance::where('student_id', $student->id)
            ->where('date', $request->date)
            ->first();

        if (!$attendance) {
            return response()->json([
                'success' => false,
                'message' => 'No clock-in record found for this date.'
            ], 404);
        }

        $timeInField  = $request->session . '_time_in';
        $timeOutField = $request->session . '_time_out';

        if (!$attendance->$timeInField) {
            return response()->json([
                'success' => false,
                'message' => 'No clock-in found for ' . strtoupper($request->session) . ' session.'
            ]);
        }

        if ($attendance->$timeOutField) {
            return response()->json([
                'success' => false,
                'message' => 'Already clocked out for ' . strtoupper($request->session) . ' session.'
            ]);
        }

        $attendance->update([$timeOutField => $request->time]);

        $schedule = $this->getSchedule($student);
        $this->calculateTotalHours($attendance, $schedule);

        return response()->json([
            'success'     => true,
            'message'     => 'Clocked out successfully.',
            'time'        => Carbon::parse($request->time)->format('h:i A'),
            'total_hours' => $attendance->fresh()->total_hours,
        ]);
    }

    private function calculateTotalHours(Attendance $attendance, array $schedule)
    {
        $total   = 0;
        $dateStr = Carbon::parse($attendance->date)->format('Y-m-d');

        // AM
        if ($attendance->am_time_in && $attendance->am_time_out) {
            $amIn       = Carbon::parse($dateStr . ' ' . $attendance->am_time_in);
            $amSched    = Carbon::parse($dateStr . ' ' . $schedule['am_in']);
            $amOut      = Carbon::parse($dateStr . ' ' . $attendance->am_time_out);
            $amOutSched = Carbon::parse($dateStr . ' ' . $schedule['am_out']);

            $effectiveIn  = $amIn->lt($amSched)      ? $amSched    : $amIn;
            $effectiveOut = $amOut->gt($amOutSched)   ? $amOutSched : $amOut;

            if ($effectiveOut->gt($effectiveIn)) {
                $total += $effectiveIn->diffInMinutes($effectiveOut) / 60;
            }
        }

        // PM
        if ($attendance->pm_time_in && $attendance->pm_time_out) {
            $pmIn       = Carbon::parse($dateStr . ' ' . $attendance->pm_time_in);
            $pmSched    = Carbon::parse($dateStr . ' ' . $schedule['pm_in']);
            $pmOut      = Carbon::parse($dateStr . ' ' . $attendance->pm_time_out);
            $pmOutSched = Carbon::parse($dateStr . ' ' . $schedule['pm_out']);

            $effectiveIn  = $pmIn->lt($pmSched)      ? $pmSched    : $pmIn;
            $effectiveOut = $pmOut->gt($pmOutSched)   ? $pmOutSched : $pmOut;

            if ($effectiveOut->gt($effectiveIn)) {
                $total += $effectiveIn->diffInMinutes($effectiveOut) / 60;
            }
        }

        $attendance->update(['total_hours' => round($total, 2)]);
    }

    public function getTodayAttendance()
    {
        $today = Carbon::now('Asia/Manila')->toDateString();

        $attendance = Attendance::with('student.user')
            ->where('date', $today)
            ->get()
            ->map(function ($record) {
                return [
                    'student_name' => $record->student->user->name ?? 'Unknown',
                    'student_id'   => $record->student->student_id,
                    'log_id'       => '#ATT-' . str_pad($record->id, 5, '0', STR_PAD_LEFT),
                    'am_time_in'   => $record->am_time_in  ? Carbon::parse($record->am_time_in)->format('h:i A')  : null,
                    'am_time_out'  => $record->am_time_out ? Carbon::parse($record->am_time_out)->format('h:i A') : null,
                    'pm_time_in'   => $record->pm_time_in  ? Carbon::parse($record->pm_time_in)->format('h:i A')  : null,
                    'pm_time_out'  => $record->pm_time_out ? Carbon::parse($record->pm_time_out)->format('h:i A') : null,
                    'total_hours'  => $record->total_hours,
                    'status'       => $this->getStatus($record),
                ];
            });

        return response()->json($attendance);
    }

    private function getStatus(Attendance $record)
    {
        if ($record->am_time_in && $record->am_time_out && $record->pm_time_in && $record->pm_time_out) {
            return 'Completed';
        }
        if ($record->am_time_in && $record->am_time_out && !$record->pm_time_in) {
            return 'Afternoon Pending';
        }
        if ($record->am_time_in && !$record->am_time_out) {
            return 'AM Ongoing';
        }
        if ($record->pm_time_in && !$record->pm_time_out) {
            return 'PM Ongoing';
        }
        return 'Pending';
    }

    public function getStudentLogs()
    {
        $student = session('student');
        if (!$student) return redirect('/login');

        $studentId    = $student->id ?? $student['id'];
        $studentModel = Student::where('id', $studentId)->first();
        $schedule     = $studentModel ? $this->getSchedule($studentModel) : [
            'am_in'  => '08:00:00',
            'am_out' => '12:00:00',
            'pm_in'  => '13:00:00',
            'pm_out' => '17:00:00',
        ];

        $logs = Attendance::where('student_id', $studentId)
            ->orderBy('date', 'desc')
            ->get()
            ->map(function ($record) use ($schedule) {
                $times = $this->getDisplayTimes($record, $schedule);

                return [
                    'date' => Carbon::parse($record->date)->format('M d, Y'),

                    // AM
                    'am_in_display'  => $times['am_in']['display'],
                    'am_in_raw'      => $times['am_in']['raw'],
                    'am_in_status'   => $times['am_in']['status'],
                    'am_out_display' => $times['am_out']['display'],
                    'am_out_raw'     => $times['am_out']['raw'],
                    'am_out_status'  => $times['am_out']['status'],

                    // PM
                    'pm_in_display'  => $times['pm_in']['display'],
                    'pm_in_raw'      => $times['pm_in']['raw'],
                    'pm_in_status'   => $times['pm_in']['status'],
                    'pm_out_display' => $times['pm_out']['display'],
                    'pm_out_raw'     => $times['pm_out']['raw'],
                    'pm_out_status'  => $times['pm_out']['status'],

                    'total_hours'     => $record->total_hours,
                    'total_formatted' => $this->formatDuration($record->total_hours),
                    'missed_minutes'  => $this->calculateMissed($record, $schedule),
                    'status'          => $this->getLogStatus($record, $schedule),
                ];
            });

        return view('students.logs', compact('logs'));
    }

    public function showAttendanceLogs()
    {
        $supervisor = session('supervisor');
        if (!$supervisor) return redirect('/supervisor/login');

        $today = Carbon::now('Asia/Manila')->toDateString();

        $todayLogs = Attendance::with('student.user')
            ->where('date', $today)
            ->orderBy('created_at', 'desc')
            ->get();

        $attendanceLogs = Attendance::with('student.user')
            ->orderBy('date', 'desc')
            ->get();

        return view('supervisor.attendance', compact('todayLogs', 'attendanceLogs'));
    }

    private function getDisplayTimes($record, array $schedule)
    {
        $schedules = [
            'am_in'  => $schedule['am_in'],
            'am_out' => $schedule['am_out'],
            'pm_in'  => $schedule['pm_in'],
            'pm_out' => $schedule['pm_out'],
        ];

        $result  = [];
        $dateStr = Carbon::parse($record->date)->format('Y-m-d');

        foreach ($schedules as $key => $schedTime) {
            $field  = str_replace('_', '_time_', $key);
            $actual = $record->$field;

            if (!$actual) {
                $result[$key] = ['display' => null, 'raw' => null, 'status' => null];
                continue;
            }

            $actualCarbon = Carbon::parse($dateStr . ' ' . $actual);
            $schedCarbon  = Carbon::parse($dateStr . ' ' . $schedTime);
            $isIn         = str_contains($key, '_in');

            if ($isIn) {
                $displayTime = $actualCarbon->lt($schedCarbon) ? $schedCarbon : $actualCarbon;
                $status      = $actualCarbon->lt($schedCarbon) ? 'early' : ($actualCarbon->gt($schedCarbon) ? 'late' : 'ontime');
            } else {
                $displayTime = $actualCarbon->lt($schedCarbon) ? $actualCarbon : $schedCarbon;
                $status      = $actualCarbon->lt($schedCarbon) ? 'early' : ($actualCarbon->gt($schedCarbon) ? 'late' : 'ontime');
            }

            $result[$key] = [
                'display' => $displayTime->format('h:i A'),
                'raw'     => $actualCarbon->format('h:i A'),
                'status'  => $status,
            ];
        }

        return $result;
    }

    private function formatDuration($hours)
    {
        $h = floor($hours);
        $m = round(($hours - $h) * 60);
        return "{$h}h " . str_pad($m, 2, '0', STR_PAD_LEFT) . "m";
    }

    private function calculateMissed($record, array $schedule)
    {
        $missed  = 0;
        $dateStr = Carbon::parse($record->date)->format('Y-m-d');

        if ($record->am_time_in) {
            $scheduledIn = Carbon::parse($dateStr . ' ' . $schedule['am_in']);
            $actualIn    = Carbon::parse($dateStr . ' ' . $record->am_time_in);
            if ($actualIn->gt($scheduledIn)) {
                $missed += $scheduledIn->diffInMinutes($actualIn);
            }
        }

        if ($record->am_time_out) {
            $scheduledOut = Carbon::parse($dateStr . ' ' . $schedule['am_out']);
            $actualOut    = Carbon::parse($dateStr . ' ' . $record->am_time_out);
            if ($actualOut->lt($scheduledOut)) {
                $missed += $actualOut->diffInMinutes($scheduledOut);
            }
        }

        if ($record->pm_time_in) {
            $scheduledIn = Carbon::parse($dateStr . ' ' . $schedule['pm_in']);
            $actualIn    = Carbon::parse($dateStr . ' ' . $record->pm_time_in);
            if ($actualIn->gt($scheduledIn)) {
                $missed += $scheduledIn->diffInMinutes($actualIn);
            }
        }

        if ($record->pm_time_out) {
            $scheduledOut = Carbon::parse($dateStr . ' ' . $schedule['pm_out']);
            $actualOut    = Carbon::parse($dateStr . ' ' . $record->pm_time_out);
            if ($actualOut->lt($scheduledOut)) {
                $missed += $actualOut->diffInMinutes($scheduledOut);
            }
        }

        return $missed;
    }

    private function getLogStatus($record, array $schedule)
    {
        if ($record->am_time_in && $record->am_time_out && $record->pm_time_in && $record->pm_time_out) {
            $missed = $this->calculateMissed($record, $schedule);
            return $missed > 0 ? 'has_missed' : 'perfect';
        }
        return 'incomplete';
    }

    public function showTodayAttendance()
    {
        return $this->showAttendanceLogs();
    }

    private function getAvatarColor(int $id): string
{
    $colors = [
        '#059669', '#0284c7', '#7c3aed',
        '#db2777', '#ea580c', '#65a30d',
    ];
    return $colors[$id % count($colors)];
}

public function adminLogs(Request $request)
{
    $companies = \App\Models\Company::orderBy('name')->get();

    $attendances = Attendance::with(['student.user', 'student.company'])
        ->orderBy('date', 'desc')
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function ($attendance) {
            $student = $attendance->student;
            $user = $student?->user;
            $company = $student?->company;

            $schedule = $this->getSchedule($student);
            $missedMinutes = $this->calculateMissed($attendance, $schedule);

            $hasAllTimes = $attendance->am_time_in && $attendance->am_time_out 
                        && $attendance->pm_time_in && $attendance->pm_time_out;
            
            $status = 'Regular Day';
            $statusClass = 'badge-opacity-success';
            $hoursClass = 'text-dark';
            
            if (!$hasAllTimes) {
                $status = 'Incomplete';
                $statusClass = 'badge-opacity-danger';
                $hoursClass = 'text-danger';
            } elseif ($attendance->total_hours < 8) {
                $status = 'Half Day';
                $statusClass = 'badge-opacity-warning';
                $hoursClass = 'text-warning';
            } elseif ($missedMinutes > 0) {
                $status = 'Has Missed';
                $statusClass = 'badge-opacity-warning';
            }

            $name = $user?->name ?? 'Unknown';
            $initials = collect(explode(' ', $name))
                ->map(fn($part) => strtoupper(substr($part, 0, 1)))
                ->take(2)
                ->join('');

            return [
                'student_name' => $name,
                'initials' => $initials,
                'company_name' => $company?->name ?? 'N/A',
                'date' => $attendance->date?->format('M d, Y'),
                'am_time_in' => $attendance->am_time_in ? Carbon::parse($attendance->am_time_in)->format('h:i A') : null,
                'am_time_out' => $attendance->am_time_out ? Carbon::parse($attendance->am_time_out)->format('h:i A') : null,
                'pm_time_in' => $attendance->pm_time_in ? Carbon::parse($attendance->pm_time_in)->format('h:i A') : null,
                'pm_time_out' => $attendance->pm_time_out ? Carbon::parse($attendance->pm_time_out)->format('h:i A') : null,
                'total_hours' => round($attendance->total_hours, 1),
                'status' => $status,
                'status_class' => $statusClass,
                'hours_class' => $hoursClass,
                'avatar_bg' => $this->getAvatarColor($company?->id ?? 0),
            ];
        });

    return view('admin.students', compact('attendances', 'companies'));
}
}