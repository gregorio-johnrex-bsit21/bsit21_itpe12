<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admins';
    protected $fillable = ['user_id', 'admin_code'];

    public function user()
    {
        return $this->belongsTo(UserTbl::class, 'user_id');
    }
}