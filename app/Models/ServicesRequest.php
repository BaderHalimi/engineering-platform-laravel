<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicesRequest extends Model
{
    protected $fillable = [
        'service_id',
        'user_id',
        'assigned_to',

        'title',
        'reference',
        'reason',
        'details',

        'admin_notes',

        'status',

        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',

        'documents',
        'meta',
    ];

    protected $casts = [
        'documents' => 'array',
        'meta' => 'array',
    ];

    public function service()
    {
        return $this->belongsTo(ServicesType::class, 'service_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }


}
