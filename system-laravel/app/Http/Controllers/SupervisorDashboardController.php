<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\Task;
use Carbon\Carbon;

class SupervisorDashboardController extends Controller
{
    public function index()
    {
        $supervisor = session('supervisor');
        if (!$supervisor) return redirect('/supervisor/login');

        $supervisorId = $supervisor->id ?? $supervisor['id'];
        $companyId    = $supervisor->company_id ?? $supervisor['company_id'];

        // Students assigned to this supervisor's company
        $students = Student::with(['user'])
            ->where('company_id', $companyId)
            ->get();

        $studentIds    = $students->pluck('id');
        $totalStudents = $students->count();

        // Total hours rendered by all students
        $totalHours = Attendance::whereIn('student_id', $studentIds)
            ->sum('total_hours');
        $totalHours = number_format($totalHours, 0);

        // Pending tasks assigned by this supervisor
        $pendingTasks = Task::where('supervisor_id', $supervisorId)
            ->where('status', 'pending')
            ->count();

        // Overall success rate: % of tasks completed
        $totalTasks     = Task::where('supervisor_id', $supervisorId)->count();
        $completedTasks = Task::where('supervisor_id', $supervisorId)
            ->where('status', 'completed')
            ->count();
        $successRate = $totalTasks > 0
            ? round(($completedTasks / $totalTasks) * 100)
            : 0;

        // Student completion progress
        $company = \App\Models\Company::where('company_id', $companyId)->first();   
        $ojt     = \App\Models\CompanyOjtRequirement::where('company_id', $company?->id)->first();
        $requiredHours = $ojt?->required_hours ?? 0;

        $studentProgress = $students->map(function ($student) use ($supervisorId, $requiredHours) {
            $accumulated  = Attendance::where('student_id', $student->id)->sum('total_hours');
            $totalTasks   = Task::where('student_id', $student->id)
                ->where('supervisor_id', $supervisorId)->count();
            $doneTasks    = Task::where('student_id', $student->id)
                ->where('supervisor_id', $supervisorId)
                ->where('status', 'completed')->count();
            $progressPct  = $requiredHours > 0
                ? min(100, round(($accumulated / $requiredHours) * 100))
                : 0;

            return [
                'name'        => $student->user->name ?? 'Unknown',
                'tasks_done'  => $doneTasks,
                'tasks_total' => $totalTasks,
                'progress'    => $progressPct,
                'hours'       => round($accumulated, 1),
            ];
        })->sortByDesc('progress')->values();

        return view('supervisor.dashboard', compact(
            'totalStudents',
            'totalHours',
            'pendingTasks',
            'successRate',
            'completedTasks',  
            'totalTasks', 
            'studentProgress',
        ));
    }
}