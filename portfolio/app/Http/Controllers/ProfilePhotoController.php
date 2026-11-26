<?php

namespace App\Http\Controllers;

use App\Support\SiteDetails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class ProfilePhotoController extends Controller
{
    private const FALLBACK = 'assets/images/istiaq.jpg';

    /**
     * Same-origin copy of the profile image. Uploads live on Vercel Blob, and the
     * browser can only paint a cross-origin photo onto the social card canvas if
     * it can be read back, so the card draws this copy instead.
     */
    public function show(): Response
    {
        $headers = ['Cache-Control' => 'public, max-age=86400'];

        $stored = SiteDetails::storedPhoto();

        if ($stored === null) {
            return response()->file(public_path(self::FALLBACK), $headers);
        }

        if (! str_starts_with($stored, 'http')) {
            $path = public_path($stored);

            return response()->file(
                is_file($path) ? $path : public_path(self::FALLBACK),
                $headers
            );
        }

        $remote = Http::timeout(15)->get($stored);

        if (! $remote->successful() || $remote->body() === '') {
            return response()->file(public_path(self::FALLBACK), $headers);
        }

        return response($remote->body(), 200, $headers + [
            'Content-Type' => $remote->header('Content-Type') ?: 'image/jpeg',
        ]);
    }

    /**
     * Replace the profile image shown in the sidebar and on the social card.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'photo' => ['required', 'file', 'mimetypes:image/jpeg,image/png,image/webp', 'max:8192'],
        ]);

        $url = SiteDetails::storePhoto($request->file('photo'));

        return response()->json([
            'url' => $url,
            'proxy' => '/profile-photo?v='.SiteDetails::photoVersion(),
        ]);
    }
}
