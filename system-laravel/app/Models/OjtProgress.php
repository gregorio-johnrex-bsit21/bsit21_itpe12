<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OjtProgress extends Model
{
    protected $table = 'ojt_progress';

    protected $fillable = [
        'student_id',
        'required_hours',
        'accumulated_hours',
        'remaining_hours',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}