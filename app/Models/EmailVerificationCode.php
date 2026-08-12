<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailVerificationCode extends Model
{
    protected $fillable = [
        'user_id',
        'otp',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
