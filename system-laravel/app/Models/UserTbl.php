<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserTbl extends Model
{
    protected $table = 'users_tbl';

    protected $fillable = [
        'supervisor_id',
        'student_id',
        'company_id',
        'name',
        'password',
        'role',
        'status',
    ];

    protected $hidden = ['password'];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }
}