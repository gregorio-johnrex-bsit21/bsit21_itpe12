<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\Task;
use App\Models\CompanyOjtRequirement;
use Illuminate\Support\Facades\DB;

class StudentDashboardController extends Controller
{
    public function index()
    {
        // Get student from session (matches your existing pattern)
        $student = session('student');
        if (!$student) return redirect('/student/login');

        $studentId = $student->id ?? $student['id'];
        $companyId = $student->company_id ?? $student['company_id'];

        // Get required hours for this student's company
        $company = \App\Models\Company::where('company_id', $companyId)->first();
        $ojt = CompanyOjtRequirement::where('company_id', $company?->id)->first();
        $requiredHours = $ojt?->required_hours ?? 486; // fallback to 486 if not set

        // === OJT PROGRESS CALCULATION ===
        $completedHours = Attendance::where('student_id', $studentId)->sum('total_hours') ?? 0;
        
        $percentage = $requiredHours > 0
            ? min(100, round(($completedHours / $requiredHours) * 100, 1))
            : 0;
        
        $remainingHours = max(0, $requiredHours - $completedHours);

        // Color based on progress (same thresholds as supervisor view)
        $color = match(true) {
            $percentage >= 90  => '#2E7D32',   // Green
            $percentage >= 75  => '#185FA5',   // Blue
            $percentage >= 50  => '#FF8C00',   // Orange
            $percentage >= 25  => '#FF4500',   // Red-Orange
            default            => '#D50000',   // Red
        };

        $status = match(true) {
            $percentage >= 100 => 'Completed',
            $percentage >= 75  => 'Advanced',
            $percentage >= 50  => 'Midway',
            $percentage >= 25  => 'Progressing',
            default            => 'Starting',
        };

        // Task stats for student
        $totalTasks = Task::where('student_id', $studentId)->count();
        $completedTasks = Task::where('student_id', $studentId)
            ->where('status', 'completed')
            ->count();
        $taskProgress = $totalTasks > 0
            ? round(($completedTasks / $totalTasks) * 100)
            : 0;

        return view('student.dashboard', compact(
            'student',
            'completedHours',
            'requiredHours',
            'percentage',
            'remainingHours',
            'color',
            'status',
            'totalTasks',
            'completedTasks',
            'taskProgress',
        ));
    }
}