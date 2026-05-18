<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';

    protected $fillable = [
        'student_id',
        'supervisor_id',
        'task_title',
        'description',
        'guidelines',
        'deadline',
        'total_steps',
        'status',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class);
    }

    public function submissions()
    {
        return $this->hasMany(TaskSubmission::class);
    }

    public function approvedSubmissions()
    {
        return $this->hasMany(TaskSubmission::class)->where('status', 'approved');
    }

    public function getProgressAttribute(): int
    {
        if ($this->total_steps <= 0) return 0;
        $approved = $this->approvedSubmissions()->count();
        return min(100, (int) round(($approved / $this->total_steps) * 100));
    }

    public function updateStatus(): void
    {
        $approved = $this->approvedSubmissions()->count();
        if ($approved >= $this->total_steps) {
            $this->update(['status' => 'completed']);
        } elseif ($approved > 0) {
            $this->update(['status' => 'ongoing']);
        }
    }
}