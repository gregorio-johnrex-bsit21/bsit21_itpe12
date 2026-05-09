<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function clockIn(Request $request)
    {
        $request->validate([
            'student_id' => 'required|string|exists:students,student_id',
            'session' => 'required|in:am,pm',
            'date' => 'required|date',
            'time' => 'required',
        ]);

        $student = Student::where('student_id', $request->student_id)->first();

        $attendance = Attendance::firstOrCreate(
            [
                'student_id' => $student->id,
                'date' => $request->date,
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
            'time' => Carbon::parse($request->time)->format('h:i A'),
        ]);
    }

    public function clockOut(Request $request)
    {
        $request->validate([
            'student_id' => 'required|string|exists:students,student_id',
            'session' => 'required|in:am,pm',
            'date' => 'required|date',
            'time' => 'required',
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

        $timeInField = $request->session . '_time_in';
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
        $this->calculateTotalHours($attendance);

        return response()->json([
            'success' => true,
            'message' => 'Clocked out successfully.',
            'time' => Carbon::parse($request->time)->format('h:i A'),
            'total_hours' => $attendance->total_hours,
        ]);
    }

    private function calculateTotalHours(Attendance $attendance)
    {
        $total = 0;

        if ($attendance->am_time_in && $attendance->am_time_out) {
            $amIn = Carbon::parse($attendance->am_time_in);
            $amOut = Carbon::parse($attendance->am_time_out);
            $total += $amIn->diffInMinutes($amOut) / 60;
        }

        if ($attendance->pm_time_in && $attendance->pm_time_out) {
            $pmIn = Carbon::parse($attendance->pm_time_in);
            $pmOut = Carbon::parse($attendance->pm_time_out);
            $total += $pmIn->diffInMinutes($pmOut) / 60;
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
                    'student_id' => $record->student->student_id,
                    'log_id' => '#ATT-' . str_pad($record->id, 5, '0', STR_PAD_LEFT),
                    'am_time_in' => $record->am_time_in ? Carbon::parse($record->am_time_in)->format('h:i A') : null,
                    'am_time_out' => $record->am_time_out ? Carbon::parse($record->am_time_out)->format('h:i A') : null,
                    'pm_time_in' => $record->pm_time_in ? Carbon::parse($record->pm_time_in)->format('h:i A') : null,
                    'pm_time_out' => $record->pm_time_out ? Carbon::parse($record->pm_time_out)->format('h:i A') : null,
                    'total_hours' => $record->total_hours,
                    'status' => $this->getStatus($record),
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
    
    $studentId = $student->id ?? $student['id'];
    
    $logs = Attendance::where('student_id', $studentId)
        ->orderBy('date', 'desc')
        ->get()
        ->map(function ($record) {
            $times = $this->getDisplayTimes($record);
            
            return [
                'date' => Carbon::parse($record->date)->format('M d, Y'),
                
                // AM
                'am_in_display' => $times['am_in']['display'],
                'am_in_raw' => $times['am_in']['raw'],
                'am_in_status' => $times['am_in']['status'],
                'am_out_display' => $times['am_out']['display'],
                'am_out_raw' => $times['am_out']['raw'],
                'am_out_status' => $times['am_out']['status'],
                
                // PM
                'pm_in_display' => $times['pm_in']['display'],
                'pm_in_raw' => $times['pm_in']['raw'],
                'pm_in_status' => $times['pm_in']['status'],
                'pm_out_display' => $times['pm_out']['display'],
                'pm_out_raw' => $times['pm_out']['raw'],
                'pm_out_status' => $times['pm_out']['status'],
                
                'total_hours' => $record->total_hours,
                'total_formatted' => $this->formatDuration($record->total_hours),
                'missed_minutes' => $this->calculateMissed($record),
                'status' => $this->getLogStatus($record),
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

private function getDisplayTimes($record)
{
    $schedules = [
        'am_in' => '08:00:00',
        'am_out' => '12:00:00',
        'pm_in' => '13:00:00',
        'pm_out' => '17:00:00',
    ];
    
    $result = [];
    $dateStr = Carbon::parse($record->date)->format('Y-m-d');
    
    foreach ($schedules as $key => $schedTime) {
        $field = str_replace('_', '_time_', $key);
        $actual = $record->$field;
        
        if (!$actual) {
            $result[$key] = ['display' => null, 'raw' => null, 'status' => null];
            continue;
        }
        
        $actualCarbon = Carbon::parse($dateStr . ' ' . $actual);
        $schedCarbon = Carbon::parse($dateStr . ' ' . $schedTime);
        
        $isIn = str_contains($key, '_in');
        
        if ($isIn) {
            // Clock in: display scheduled if early, actual if late
            $displayTime = $actualCarbon->lt($schedCarbon) ? $schedCarbon : $actualCarbon;
            $status = $actualCarbon->lt($schedCarbon) ? 'early' : ($actualCarbon->gt($schedCarbon) ? 'late' : 'ontime');
        } else {
            // Clock out: display actual if early, scheduled if late/ontime
            $displayTime = $actualCarbon->lt($schedCarbon) ? $actualCarbon : $schedCarbon;
            $status = $actualCarbon->lt($schedCarbon) ? 'early' : ($actualCarbon->gt($schedCarbon) ? 'late' : 'ontime');
        }
        
        $result[$key] = [
            'display' => $displayTime->format('h:i A'),
            'raw' => $actualCarbon->format('h:i A'),
            'status' => $status,
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

private function calculateMissed($record)
{
    $missed = 0;
    $dateStr = Carbon::parse($record->date)->format('Y-m-d');
    
    // AM In: scheduled 08:00
    if ($record->am_time_in) {
        $scheduledIn = Carbon::parse($dateStr . ' 08:00:00');
        $actualIn = Carbon::parse($dateStr . ' ' . $record->am_time_in);
        if ($actualIn->gt($scheduledIn)) {
            $missed += $scheduledIn->diffInMinutes($actualIn);
        }
    }
    
    // AM Out: scheduled 12:00
    if ($record->am_time_out) {
        $scheduledOut = Carbon::parse($dateStr . ' 12:00:00');
        $actualOut = Carbon::parse($dateStr . ' ' . $record->am_time_out);
        if ($actualOut->lt($scheduledOut)) {
            $missed += $actualOut->diffInMinutes($scheduledOut);
        }
    }
    
    // PM In: scheduled 13:00
    if ($record->pm_time_in) {
        $scheduledIn = Carbon::parse($dateStr . ' 13:00:00');
        $actualIn = Carbon::parse($dateStr . ' ' . $record->pm_time_in);
        if ($actualIn->gt($scheduledIn)) {
            $missed += $scheduledIn->diffInMinutes($actualIn);
        }
    }
    
    // PM Out: scheduled 17:00
    if ($record->pm_time_out) {
        $scheduledOut = Carbon::parse($dateStr . ' 17:00:00');
        $actualOut = Carbon::parse($dateStr . ' ' . $record->pm_time_out);
        if ($actualOut->lt($scheduledOut)) {
            $missed += $actualOut->diffInMinutes($scheduledOut);
        }
    }
    
    return $missed;
}

private function getLogStatus($record)
{
    if ($record->am_time_in && $record->am_time_out && $record->pm_time_in && $record->pm_time_out) {
        $missed = $this->calculateMissed($record);
        return $missed > 0 ? 'has_missed' : 'perfect';
    }
    return 'incomplete';
}



}