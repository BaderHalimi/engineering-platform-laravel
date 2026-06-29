<?php
// app/Models/Setup.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setup extends Model
{
    protected $table = 'setups';

    protected $fillable = ['key', 'value'];


    public static function get(string $key, $default = null)
    {
        return Cache::rememberForever("setup_{$key}", function () use ($key, $default) {
            $row = static::where('key', $key)->first();
            return $row ? $row->value : $default;
        });
    }

    public static function set(string $key, $value): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        Cache::forget("setup_{$key}");
    }

  
    public static function forget(string $key): void
    {
        Cache::forget("setup_{$key}");
    }
}
