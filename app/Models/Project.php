<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'attachments',
        'is_active',
        'sort_order',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'og_title',
        'og_description',
        'og_image',
        'category_id',
        'created_by',
        //'updated_by',
    ];

    protected $casts = [
        'attachments' => 'array',
        'is_active' => 'boolean',
        'meta_keywords' => 'array',

    ];

    function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'category_id');
    }

    function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
