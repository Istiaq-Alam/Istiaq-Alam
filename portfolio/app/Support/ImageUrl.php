<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

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

    /**
     * Save an uploaded image under public/assets/uploads and return its relative path.
     * Storing files (not base64 in SQLite) keeps the rendered page small enough for Vercel.
     */
    public static function storeUpload(UploadedFile $file): string
    {
        $name = Str::random(20).'.'.$file->extension();

        $file->move(public_path('assets/uploads'), $name);

        return 'assets/uploads/'.$name;
    }
}
