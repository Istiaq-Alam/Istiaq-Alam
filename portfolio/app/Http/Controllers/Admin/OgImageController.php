<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\SiteDetails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OgImageController extends Controller
{
    /**
     * Save the Open Graph card rendered by the admin browser from the site details.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'image' => ['required', 'file', 'mimetypes:image/jpeg,image/png', 'max:8192'],
        ]);

        $url = SiteDetails::storeOgImage($request->file('image'));

        return response()->json(['url' => $url]);
    }
}
