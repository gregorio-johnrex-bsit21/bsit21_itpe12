<?php

// app/Models/Company.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\CompanyOjtRequirement;

class Company extends Model
{
    protected $table = 'company_tbl';

    protected $fillable = [
        'company_id',
        'name',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($company) {
            do {
                $code = strtoupper(str()->random(8));
            } while (self::where('company_id', $code)->exists());
            
            $company->company_id = $code;
        });
    }

    public function ojtRequirement(): HasOne
{
    return $this->hasOne(CompanyOjtRequirement::class);
}

public function supervisors()
{
    return $this->hasMany(Supervisor::class, 'company_id', 'company_id');
}
}