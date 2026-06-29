<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'image',
        'is_active',
        'sort_order'
    ];
    public function articles()
        {
            return $this->hasMany(Article::class, 'category_id');
        }

}
