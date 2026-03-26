<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'conversation',
        'sender',
        'message',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    /**
     * Format timestamp as a human-readable time string.
     */
    public function getTimeAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }
}
