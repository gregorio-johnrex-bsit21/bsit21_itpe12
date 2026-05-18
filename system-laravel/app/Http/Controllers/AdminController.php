<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Student;
use App\Models\UserTbl;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Total Companies
        $totalCompanies = Company::count();

        // Total OJT Students (users with role = student)
        $totalStudents = UserTbl::where('role', 'student')->count();

        // Total Sessions = total attendance records
        $totalSessions = Attendance::count();

        // Total hours rendered across all students
        $totalHours = Attendance::sum('total_hours') ?? 0;

        // Avg. Time per session (in minutes)
        $avgTimeMinutes = Attendance::where('total_hours', '>', 0)
            ->avg('total_hours') * 60; // convert hours to minutes

        $avgMinutes = floor($avgTimeMinutes);
        $avgSeconds = floor(($avgTimeMinutes - $avgMinutes) * 60);
        $avgTime = sprintf('%dm:%02ds', $avgMinutes, $avgSeconds);

        // Task Completion Rate (if you have Task model)
        $totalTasks = \App\Models\Task::count();
        $completedTasks = \App\Models\Task::where('status', 'completed')->count();
        $taskCompletionRate = $totalTasks > 0
            ? round(($completedTasks / $totalTasks) * 100)
            : 0;

        // Recent student progress for the list/chart
        $studentProgress = Student::with(['user', 'company'])
            ->limit(10)
            ->get()
            ->map(function ($student) {
                $hours = Attendance::where('student_id', $student->id)->sum('total_hours');
                $target = $student->company?->ojtRequirement?->total_hours ?? 500;
                $progress = $target > 0 ? min(100, round(($hours / $target) * 100)) : 0;

                return [
                    'name' => $student->name ?? 'Unknown',
                    'hours' => round($hours, 1),
                    'target' => $target,
                    'progress' => $progress,
                    'company' => $student->company?->name ?? 'N/A',
                ];
            });

        return view('admin.dashboard', compact(
            'totalCompanies',
            'totalStudents',
            'totalSessions',
            'totalHours',
            'avgTime',
            'taskCompletionRate',
            'studentProgress'
        ));
    }
}