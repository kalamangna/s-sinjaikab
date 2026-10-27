<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        $shortUrl = ShortUrl::where('short_code', $code)
            ->where('is_active', true)
            ->first();

        if (!$shortUrl) {
            return response()->view('errors.404', [
                'message' => 'Tautan pendek tidak ditemukan atau telah dinonaktifkan.',
            ], 404);
        }

        // Fast atomic counter increment
        $shortUrl->increment('clicks_count');

        return redirect()->away($shortUrl->original_url, 302);
    }
}
