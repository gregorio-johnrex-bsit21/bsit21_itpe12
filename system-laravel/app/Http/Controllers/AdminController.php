<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Student;
use App\Models\UserTbl;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\CompanyOjtRequirement;

class AdminController extends Controller
{
    public function dashboard()
{
    $totalCompanies = Company::count();
    $totalStudents = Student::count();
    $totalHours = Attendance::sum('total_hours') ?? 0;
    
    $avgMinutes = Attendance::whereNotNull('am_time_in')
        ->whereNotNull('am_time_out')
        ->get()
        ->avg(function ($att) {
            $amIn = Carbon::parse($att->am_time_in);
            $amOut = Carbon::parse($att->am_time_out);
            return $amIn->diffInMinutes($amOut);
        });
    $avgTime = $avgMinutes ? round($avgMinutes / 60, 1) . 'h' : '0h';

    $studentProgress = Student::with(['user', 'company'])->get()->map(function ($student) {
        $hours = Attendance::where('student_id', $student->id)->sum('total_hours');
        $target = CompanyOjtRequirement::where('company_id', $student->company_id)->value('required_hours') ?? 500;
        return [
            'name' => $student->user->name ?? 'Unknown',
            'company' => $student->company->name ?? 'N/A',
            'hours' => round($hours, 1),
            'target' => $target,
            'progress' => $target > 0 ? min(100, round(($hours / $target) * 100, 1)) : 0,
        ];
    });

    $taskCompletionRate = 75;

    $companyStudentData = Company::all()->map(function($company) {
        $count = Student::where('company_id', $company->company_id)->count();
        return ['name' => $company->name, 'count' => $count];
    })->filter(fn($item) => $item['count'] > 0);

    $attendanceTrend = ['labels' => [], 'hours' => []];
    foreach (range(6, 0) as $days) {
        $date = now()->subDays($days);
        $attendanceTrend['labels'][] = $date->format('D');
        $hours = Attendance::whereDate('date', $date->format('Y-m-d'))->sum('total_hours');
        $attendanceTrend['hours'][] = round($hours, 1);
    }

    return view('admin.dashboard', compact(
        'totalCompanies', 'totalStudents', 'totalHours', 'avgTime',
        'studentProgress', 'taskCompletionRate', 'companyStudentData', 'attendanceTrend'
    ));
}
    
}