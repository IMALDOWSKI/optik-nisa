<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $fillable = ['key', 'value'];

    // Ambil nilai pengaturan
    public static function get($key, $default = null)
    {
        $data = self::where('key', $key)->first();
        return $data ? $data->value : $default;
    }

    // Set / update nilai pengaturan
    public static function set($key, $value)
    {
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
}