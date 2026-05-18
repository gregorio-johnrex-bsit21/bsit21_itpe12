<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Student;
use App\Models\TaskSubmission;
use Illuminate\Http\Request;
use App\Models\Notification;

class TaskController extends Controller
{
    // Supervisor: view all tasks
    public function index()
    {
        $supervisor   = session('supervisor');
        $supervisorId = $supervisor->id;
        $companyId    = $supervisor->company_id;

        $students = Student::with('user')
            ->where('company_id', $companyId)
            ->get();

        $tasks = Task::with(['student.user', 'submissions'])
            ->where('supervisor_id', $supervisorId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($task) {
                $approved = $task->approvedSubmissions()->count();
                $progress = $task->total_steps > 0
                    ? min(100, (int) round(($approved / $task->total_steps) * 100))
                    : 0;

                return [
                    'id'           => $task->id,
                    'task_title'   => $task->task_title,
                    'description'  => $task->description,
                    'guidelines'   => $task->guidelines,
                    'deadline'     => $task->deadline?->format('M d, Y'),
                    'total_steps'  => $task->total_steps,
                    'status'       => $task->status,
                    'progress'     => $progress,
                    'approved'     => $approved,
                    'student_name' => $task->student->user->name ?? 'Unknown',
                    'student_id'   => $task->student_id,
                    'submissions'  => $task->submissions->map(fn($s) => [
                        'id'          => $s->id,
                        'step_number' => $s->step_number,
                        'proof_url'   => $s->proof_url,
                        'status'      => $s->status,
                        'notes'       => $s->notes,
                        'created_at'  => $s->created_at->format('M d, Y'),
                    ]),
                ];
            });

        return view('supervisor.tasks', compact('tasks', 'students'));
    }

    // Supervisor: create task
    public function store(Request $request)
{
    $request->validate([
        'student_id'  => 'required|exists:students,id',
        'task_title'  => 'required|string|max:255',
        'description' => 'nullable|string',
        'guidelines'  => 'nullable|string',
        'deadline'    => 'nullable|date',
        'total_steps' => 'required|integer|min:1|max:20',
    ]);

    $supervisor = session('supervisor');

    Task::create([
        'student_id'   => $request->student_id,
        'supervisor_id'=> $supervisor->id,
        'task_title'   => $request->task_title,
        'description'  => $request->description,
        'guidelines'   => $request->guidelines,
        'deadline'     => $request->deadline,
        'total_steps'  => $request->total_steps,
        'status'       => 'pending',
    ]);

    // CREATE NOTIFICATION — BEFORE the return!
    Notification::create([
        'user_id' => $request->student_id,
        'user_type' => 'student',
        'type' => 'task_assigned',
        'title' => 'New Task Assigned',
        'message' => "You have been assigned: {$request->task_title}",
        'url' => '/student/tasks',
    ]);

    return response()->json(['success' => true, 'message' => 'Task created successfully.']);
}
    

    // Supervisor: update task
    public function update(Request $request, $id)
    {
        $task = Task::where('id', $id)
            ->where('supervisor_id', session('supervisor')->id)
            ->firstOrFail();

        $request->validate([
            'task_title'  => 'required|string|max:255',
            'description' => 'nullable|string',
            'guidelines'  => 'nullable|string',
            'deadline'    => 'nullable|date',
            'total_steps' => 'required|integer|min:1|max:20',
            'status'      => 'required|in:pending,ongoing,completed',
        ]);

        $task->update($request->only([
            'task_title', 'description', 'guidelines',
            'deadline', 'total_steps', 'status',
        ]));

        return response()->json(['success' => true, 'message' => 'Task updated.']);
    }

    // Supervisor: delete task
    public function destroy($id)
    {
        $task = Task::where('id', $id)
            ->where('supervisor_id', session('supervisor')->id)
            ->firstOrFail();

        $task->delete();

        return response()->json(['success' => true, 'message' => 'Task deleted.']);
    }

    // Supervisor: approve or reject a submission
public function reviewSubmission(Request $request, $submissionId)
{
    $request->validate([
        'status' => 'required|in:approved,rejected',
        'notes'  => 'nullable|string',
    ]);

    $submission = TaskSubmission::with(['task', 'student'])->findOrFail($submissionId);
    
    $submission->update([
        'status' => $request->status,
        'notes'  => $request->notes,
    ]);

    // ── NOTIFY STUDENT ─────────────────────────────
    $statusLabel = $request->status === 'approved' ? 'approved' : 'rejected';
    $actionLabel = $request->status === 'approved' ? 'approved' : 'rejected';

    Notification::create([
        'user_id'   => $submission->student_id,
        'user_type' => 'student',
        'type'      => 'submission_' . $request->status,   // "submission_approved" or "submission_rejected"
        'title'     => 'Submission ' . ucfirst($statusLabel),
        'message'   => "Your submission for Step {$submission->step_number} of \"{$submission->task->task_title}\" has been {$actionLabel}.",
        'url'       => '/student/tasks',
    ]);

    // Update task status based on approvals
    $submission->task->updateStatus();

    return response()->json(['success' => true, 'message' => 'Submission ' . $request->status . '.']);
}

    public function notifications()
{
    $supervisor   = session('supervisor');
    $supervisorId = $supervisor->id;

    $pending = \App\Models\TaskSubmission::with(['task', 'student.user'])
        ->whereHas('task', fn($q) => $q->where('supervisor_id', $supervisorId))
        ->where('status', 'pending')
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(fn($s) => [
            'id'           => $s->id,
            'student_name' => $s->student->user->name ?? 'Unknown',
            'task_title'   => $s->task->task_title ?? 'Unknown Task',
            'step_number'  => $s->step_number,
            'proof_url'    => $s->proof_url,
            'created_at'   => $s->created_at->diffForHumans(),
        ]);

    return response()->json($pending);
}
}