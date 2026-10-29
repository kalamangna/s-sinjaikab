<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\ShortUrl;
use App\Services\QrCodeService;
use App\Services\UrlShortenerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use InvalidArgumentException;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ShortUrlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $query = ShortUrl::with('user');

        if (! $user->isAdmin()) {
            $query->where('user_id', $user->id);
        }

        $totalUrls = (clone $query)->count();
        $totalClicks = (int) (clone $query)->sum('clicks_count');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('short_code', 'like', "%{$search}%")
                    ->orWhere('original_url', 'like', "%{$search}%");
            });
        }

        $shortUrls = $query->latest()->paginate(15)->withQueryString();

        return view('urls.index', compact('shortUrls', 'totalUrls', 'totalClicks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, UrlShortenerService $service): RedirectResponse
    {
        if ($request->filled('short_code')) {
            $request->merge([
                'short_code' => trim((string) $request->input('short_code')),
            ]);
        }

        $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'original_url' => ['required', 'string', 'url', 'max:2048'],
            'short_code' => ['nullable', 'string', 'min:3', 'max:64', 'alpha_dash:ascii', 'unique:short_urls,short_code'],
        ], [
            'original_url.required' => 'URL tujuan wajib diisi.',
            'original_url.url' => 'Format URL tidak valid.',
            'short_code.min' => 'Minimal 3 karakter.',
            'short_code.max' => 'Maksimal 64 karakter.',
            'short_code.alpha_dash' => 'Hanya huruf, angka, strip, dan garis bawah.',
            'short_code.unique' => 'Kode sudah digunakan.',
        ]);

        try {
            $service->validateDestinationUrl($request->input('original_url'), $request->getHost());
        } catch (InvalidArgumentException $e) {
            return back()->withErrors(['original_url' => $e->getMessage()])->withInput();
        }

        $shortCode = $request->input('short_code');

        if ($shortCode) {
            $shortCode = trim((string) $shortCode);

            if ($service->isSlugReserved($shortCode)) {
                return back()->withErrors(['short_code' => 'Kode tidak tersedia.'])->withInput();
            }

            if (ShortUrl::whereRaw('LOWER(short_code) = ?', [strtolower($shortCode)])->exists()) {
                return back()->withErrors(['short_code' => 'Kode sudah digunakan.'])->withInput();
            }
        } else {
            $shortCode = $service->generateUniqueCode();
        }

        $shortUrl = $request->user()->shortUrls()->create([
            'title' => $request->input('title'),
            'original_url' => $request->input('original_url'),
            'short_code' => $shortCode,
            'is_active' => true,
        ]);

        ActivityLog::record('create_url', "Membuat link {$shortUrl->short_code} menuju {$shortUrl->original_url}");

        return redirect()->route('urls.index')->with('success', 'Link berhasil dibuat.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShortUrl $url, UrlShortenerService $service): RedirectResponse
    {
        $user = $request->user();

        if (! $user->isAdmin() && $url->user_id !== $user->id) {
            abort(403, 'Akses tidak diizinkan.');
        }

        if ($request->filled('short_code')) {
            $request->merge([
                'short_code' => trim((string) $request->input('short_code')),
            ]);
        }

        $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'original_url' => ['required', 'string', 'url', 'max:2048'],
            'short_code' => ['required', 'string', 'min:3', 'max:64', 'alpha_dash:ascii', Rule::unique('short_urls', 'short_code')->ignore($url->id)],
            'is_active' => ['required', 'boolean'],
        ], [
            'original_url.required' => 'URL tujuan wajib diisi.',
            'original_url.url' => 'Format URL tidak valid.',
            'short_code.required' => 'Kode link wajib diisi.',
            'short_code.min' => 'Minimal 3 karakter.',
            'short_code.max' => 'Maksimal 64 karakter.',
            'short_code.alpha_dash' => 'Hanya huruf, angka, strip, dan garis bawah.',
            'short_code.unique' => 'Kode sudah digunakan.',
        ]);

        try {
            $service->validateDestinationUrl($request->input('original_url'), $request->getHost());
        } catch (InvalidArgumentException $e) {
            return back()->withErrors(['original_url' => $e->getMessage()])->withInput();
        }

        $shortCode = trim((string) $request->input('short_code'));

        if ($shortCode !== $url->short_code) {
            if ($service->isSlugReserved($shortCode)) {
                return back()->withErrors(['short_code' => 'Kode tidak tersedia.'])->withInput();
            }

            if (ShortUrl::whereRaw('LOWER(short_code) = ?', [strtolower($shortCode)])->where('id', '!=', $url->id)->exists()) {
                return back()->withErrors(['short_code' => 'Kode sudah digunakan.'])->withInput();
            }
        }

        $url->update([
            'title' => $request->input('title'),
            'original_url' => $request->input('original_url'),
            'short_code' => $shortCode,
            'is_active' => $request->boolean('is_active'),
        ]);

        ActivityLog::record('update_url', "Memperbarui link {$url->short_code} menuju {$url->original_url}");

        return redirect()->route('urls.index')->with('success', 'Perubahan berhasil disimpan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, ShortUrl $url): RedirectResponse
    {
        $user = $request->user();

        if (! $user->isAdmin() && $url->user_id !== $user->id) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $code = $url->short_code;
        $url->delete();

        ActivityLog::record('delete_url', "Menghapus link {$code}");

        return redirect()->route('urls.index')->with('success', 'Link berhasil dihapus.');
    }

    /**
     * Generate or download QR Code for the short url.
     */
    public function qrCode(ShortUrl $url, Request $request, QrCodeService $qrService): Response
    {
        $targetUrl = $url->full_url;
        $format = strtolower($request->query('format', 'svg'));
        $download = $request->boolean('download');

        if ($format === 'png') {
            $png = $qrService->generatePng($targetUrl, 1000);
            $filename = "qr-sinjaikab-{$url->short_code}.png";
            $headers = [
                'Content-Type' => 'image/png',
            ];

            if ($download) {
                $headers['Content-Disposition'] = "attachment; filename=\"{$filename}\"";
            }

            return response($png, 200, $headers);
        }

        $svg = $qrService->generateSvg($targetUrl, 400);
        $filename = "qr-sinjaikab-{$url->short_code}.svg";
        $headers = [
            'Content-Type' => 'image/svg+xml',
        ];

        if ($download) {
            $headers['Content-Disposition'] = "attachment; filename=\"{$filename}\"";
        }

        return response($svg, 200, $headers);
    }
}
