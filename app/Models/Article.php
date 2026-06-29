<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'thumbnail',
        'attachments',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_image',
        'canonical_url',
        'status',
        'published_at',
        'user_id',
        'category_id',
        'views',
        'reading_time',
        'is_featured',
        'is_trending',
        'tags',
    ];

    protected $casts = [
        'attachments'     => 'array',
        'tags'            => 'array',
        'published_at'    => 'datetime',
        'is_featured'     => 'boolean',
        'is_trending'     => 'boolean',
        'views'           => 'integer',
        'meta_keywords'   => 'array',
        'reading_time'    => 'integer',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(ArticleCategory::class, 'category_id');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                     ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeTrending($query)
    {
        return $query->where('is_trending', true);
    }

    public function getReadingTimeAttribute($value)
    {
        return $value ?: ceil(str_word_count(strip_tags($this->content)) / 200);
    }

    public function getExcerptAttribute()
    {
        return substr(strip_tags($this->content), 0, 160) . '...';
    }
}
