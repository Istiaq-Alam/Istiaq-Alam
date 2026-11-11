<?php

namespace App\Support;

class ImageUrl
{
    /**
     * Return data URIs and external URLs unchanged; resolve bundled asset paths via asset().
     */
    public static function resolve(?string $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (str_starts_with($value, 'data:image') || str_starts_with($value, 'http')) {
            return $value;
        }

        return asset($value);
    }
}
