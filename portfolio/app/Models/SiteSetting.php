<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    public static function valueFor(string $key): mixed
    {
        $row = static::where('key', $key)->first();

        return $row ? json_decode((string) $row->value, true) : null;
    }

    public static function store(string $key, array $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => json_encode($value, JSON_UNESCAPED_UNICODE)]);
    }
}
