<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
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
     * Upload an image to Vercel Blob when a token is configured, otherwise to public/assets/uploads.
     * Vercel's filesystem is read-only, so Blob is required for uploads to persist in production.
     */
    public static function storeUpload(UploadedFile $file): string
    {
        $name = Str::random(20).'.'.$file->extension();

        $token = env('BLOB_READ_WRITE_TOKEN');

        if (! $token) {
            $file->move(public_path('assets/uploads'), $name);

            return 'assets/uploads/'.$name;
        }

        $response = Http::withToken($token)
            ->withHeaders(['x-api-version' => '7', 'x-content-type' => $file->getMimeType(), 'x-add-random-suffix' => '0'])
            ->withBody(file_get_contents($file->getRealPath()), $file->getMimeType())
            ->put('https://blob.vercel-storage.com/uploads/'.$name);

        $response->throw();

        return $response->json('url');
    }
}
