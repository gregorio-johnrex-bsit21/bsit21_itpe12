<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    protected $table = 'supervisors';
    protected $fillable = ['user_id', 'supervisor_id', 'company_id'];

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
}