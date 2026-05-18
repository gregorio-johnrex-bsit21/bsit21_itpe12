<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyOjtRequirement extends Model
{
    protected $fillable = [
        'company_id',
        'am_start_time',
        'am_end_time',
        'pm_start_time',
        'pm_end_time',
        'required_hours',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function getDailyHoursAttribute(): float
    {
        $am = 0;
        $pm = 0;
        if ($this->am_start_time && $this->am_end_time) {
            $am = \Carbon\Carbon::parse($this->am_start_time)->diffInHours(\Carbon\Carbon::parse($this->am_end_time));
        }
        if ($this->pm_start_time && $this->pm_end_time) {
            $pm = \Carbon\Carbon::parse($this->pm_start_time)->diffInHours(\Carbon\Carbon::parse($this->pm_end_time));
        }
        return $am + $pm;
    }

    public function getAmHoursAttribute(): float
    {
        if (!$this->am_start_time || !$this->am_end_time) return 0;
        return \Carbon\Carbon::parse($this->am_start_time)->diffInHours(\Carbon\Carbon::parse($this->am_end_time));
    }

    public function getPmHoursAttribute(): float
    {
        if (!$this->pm_start_time || !$this->pm_end_time) return 0;
        return \Carbon\Carbon::parse($this->pm_start_time)->diffInHours(\Carbon\Carbon::parse($this->pm_end_time));
    }
}