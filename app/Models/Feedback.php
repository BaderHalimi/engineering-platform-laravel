<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = [
        'email',
        'title',
        'content',
        'attachments',
        'meta',
        'read_at',
        'read_by',
    ];

    protected $casts = [
        'attachments' => 'array',
        'meta' => 'array',
        'read_at' => 'datetime',
    ];

    public function reader()
    {
        return $this->belongsTo(User::class, 'read_by');
    }
}
