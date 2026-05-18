<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';
    protected $fillable = ['user_id', 'student_id', 'company_id'];

    public function user()
    {
        return $this->belongsTo(UserTbl::class, 'user_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    
    public function getNameAttribute()
{
    return $this->user->name ?? null;
}

public function getStatusAttribute()
{
    return $this->user->status ?? null;
}

public function getAvatarAttribute()
{
    return $this->user->avatar ?? null;
} 

public function supervisor()
{
    return $this->hasOneThrough(
        \App\Models\Supervisor::class,
        \App\Models\Company::class,
        'company_id',
        'company_id',
        'company_id',
        'company_id'
    );
}

}