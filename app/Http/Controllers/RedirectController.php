<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class RedirectController extends Controller
{
    /**
     * Display landing page.
     */
    public function home(): View
    {
        return view('welcome');
    }

    /**
     * Redirect short URL to destination.
     */
    public function redirect(string $code): Response
    {
        $code = trim($code);

        $shortUrl = ShortUrl::where('short_code', $code)
            ->where('is_active', true)
            ->first();

        if (! $shortUrl) {
            $shortUrl = ShortUrl::whereRaw('LOWER(short_code) = ?', [strtolower($code)])
                ->where('is_active', true)
                ->first();
        }

        if (! $shortUrl) {
            return response()->view('errors.404', [
                'message' => 'Link tidak ditemukan.',
            ], 404);
        }

        // Fast atomic counter increment
        $shortUrl->increment('clicks_count');

        return redirect()->away($shortUrl->original_url, 302);
    }
}
