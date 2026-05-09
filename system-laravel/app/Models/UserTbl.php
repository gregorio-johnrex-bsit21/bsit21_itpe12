<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTbl extends Model
{
    protected $table = 'users_tbl';
    protected $fillable = ['name', 'password', 'role', 'status'];
    protected $hidden = ['password'];

    public function admin()
    {
        return $this->hasOne(Admin::class, 'user_id');
    }

    public function supervisor()
    {
        return $this->hasOne(Supervisor::class, 'user_id');
    }

    public function student()
    {
        return $this->hasOne(Student::class, 'user_id');
    }

    public function profile()
    {
        return match($this->role) {
            'admin'      => $this->admin,
            'supervisor' => $this->supervisor,
            'student'    => $this->student,
            default      => null,
        };
    }
}