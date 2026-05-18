<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    protected $table = 'student_profiles';

    protected $fillable = [
    'student_id', 'course', 'section', 'year_level',
    'school_name', 'school_address', 'home_address',
    'contact_number', 'emergency_contact',
    'is_complete', 'has_seen_tutorial',
    ];

    protected $casts = [
    'is_complete' => 'boolean',
    'has_seen_tutorial' => 'boolean',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    /**
     * All required fields must be filled for profile to be complete.
     */
    public function checkIsComplete(): bool
    {
        return !empty($this->course)
            && !empty($this->section)
            && !empty($this->year_level)
            && !empty($this->school_name)
            && !empty($this->school_address)
            && !empty($this->home_address)
            && !empty($this->contact_number)
            && !empty($this->emergency_contact);
    }
    public function profile()
{
    return $this->hasOne(StudentProfile::class, 'student_id');
}
}