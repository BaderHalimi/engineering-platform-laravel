<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicesType extends Model
{
    protected $fillable = [
        'category_id',
        'slug',
        'name',
        'short_description',
        'description',
        'thumbnail',
        'icon',
        'estimated_time',
        'price',
        'price_type',
        'documented',
        'visit_required',
        'status',
        'sort_order',
        'advantages',
        'requirements',
        'steps',
        'faqs',
        'gallery',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'created_by',
    ];
    protected $casts = [
        'price' => 'decimal:2',
        'documented' => 'boolean',
        'visit_required' => 'boolean',
        'advantages' => 'array',
        'requirements' => 'array',
        'steps' => 'array',
        'faqs' => 'array',
        'gallery' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'category_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
