<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;

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
     * Encode an uploaded image as a data URI so it persists inside the SQLite longText column.
     */
    public static function encodeUpload(UploadedFile $file): string
    {
        return 'data:'.$file->getMimeType().';base64,'.base64_encode($file->get());
    }
}
