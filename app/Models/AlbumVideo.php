<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlbumVideo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',

        'title',
        'slug',

        'description',
        'content',

        'video_url',
        'embed_url',
        'provider',

        'duration',

        'thumbnail',

        'views',
        'likes',
        'dislikes',
        'shares',
        'comments_count',

        'is_published',
        'is_featured',
        'allow_comments',

        'published_at',

        'canonical_url',

        'seo_title',
        'seo_description',
        'seo_keywords',

        'og_title',
        'og_description',
        'og_image',

        'seo_json',

        'language',
        'visibility',

        'meta',
    ];

    protected $casts = [
        'duration' => 'integer',

        'views' => 'integer',
        'likes' => 'integer',
        'dislikes' => 'integer',
        'shares' => 'integer',
        'comments_count' => 'integer',

        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'allow_comments' => 'boolean',

        'published_at' => 'datetime',

        'seo_json' => 'array',
        'meta' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
