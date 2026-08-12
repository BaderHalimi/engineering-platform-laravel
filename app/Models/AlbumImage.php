<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class AlbumImage extends Model
{
    protected $table = 'album_images';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image_path',
        'thumbnail_path',
        'alt_text',
        'visibility',
        'featured',
        'sort_order',
        'views',
        'likes',
        'downloads',
        'shares',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'canonical_url',
        'indexable',
        'og_title',
        'og_description',
        'og_image',
        'meta',
        'user_id'
    ];

    protected $casts = [
        'featured'   => 'boolean',
        'indexable'  => 'boolean',
        'meta'        => 'array',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
