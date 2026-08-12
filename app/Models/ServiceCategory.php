<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'image',
        'is_active',
        'sort_order',
    ];

    public function servicesTypes()
    {
        return $this->hasMany(ServicesType::class, 'category_id');
    }

    


}
