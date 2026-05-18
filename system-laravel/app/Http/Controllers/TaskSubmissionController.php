<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TaskSubmissionController extends Controller
{
    // Student: view their tasks
    public function index()
    {
        $student   = session('student');
        $studentId = $student->id;

        $tasks = Task::with(['submissions' => function ($q) use ($studentId) {
                $q->where('student_id', $studentId)->orderBy('step_number');
            }])
            ->where('student_id', $studentId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($task) use ($studentId) {
                $approved     = $task->submissions->where('status', 'approved')->count();
                $progress     = $task->total_steps > 0
                    ? min(100, (int) round(($approved / $task->total_steps) * 100))
                    : 0;
                $nextStep     = $approved + 1;
                $pendingSub   = $task->submissions
                    ->where('status', 'pending')
                    ->first();
                $canSubmit    = !$pendingSub && $approved < $task->total_steps;

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
                    'next_step'    => $nextStep,
                    'can_submit'   => $canSubmit,
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

        return view('students.tasks', compact('tasks'));
    }

    // Student: upload proof for a step
    public function submit(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'proof'   => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $student   = session('student');
        $studentId = $student->id;
        $task      = Task::where('id', $request->task_id)
            ->where('student_id', $studentId)
            ->firstOrFail();

        // Check no pending submission exists
        $hasPending = TaskSubmission::where('task_id', $task->id)
            ->where('student_id', $studentId)
            ->where('status', 'pending')
            ->exists();

        if ($hasPending) {
            return response()->json([
                'success' => false,
                'message' => 'You already have a pending submission. Wait for supervisor review.',
            ]);
        }

        $approved = TaskSubmission::where('task_id', $task->id)
            ->where('student_id', $studentId)
            ->where('status', 'approved')
            ->count();

        if ($approved >= $task->total_steps) {
            return response()->json([
                'success' => false,
                'message' => 'All steps are already completed.',
            ]);
        }

        $path = $request->file('proof')->store('task_proofs', 'public');
        $url  = Storage::url($path);

        TaskSubmission::create([
            'task_id'     => $task->id,
            'student_id'  => $studentId,
            'proof_url'   => $url,
            'step_number' => $approved + 1,
            'status'      => 'pending',
        ]);

        // Update task to ongoing if it was pending
        if ($task->status === 'pending') {
            $task->update(['status' => 'ongoing']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Proof submitted! Waiting for supervisor approval.',
        ]);
    }
}