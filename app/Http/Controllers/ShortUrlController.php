<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
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
        $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'original_url' => ['required', 'string', 'url', 'max:2048'],
            'short_code' => ['nullable', 'string', 'min:3', 'max:64', 'alpha_dash:ascii', 'unique:short_urls,short_code'],
        ], [
            'original_url.required' => 'Alamat tujuan wajib diisi.',
            'original_url.url' => 'Alamat tujuan tidak valid. Pastikan diawali http atau https.',
            'short_code.min' => 'Kode tautan minimal 3 karakter.',
            'short_code.max' => 'Kode tautan maksimal 64 karakter.',
            'short_code.alpha_dash' => 'Kode tautan hanya boleh memuat huruf, angka, tanda strip, dan garis bawah.',
            'short_code.unique' => 'Kode tautan sudah digunakan. Silakan gunakan kombinasi lain.',
        ]);

        try {
            $service->validateDestinationUrl($request->input('original_url'), $request->getHost());
        } catch (InvalidArgumentException $e) {
            return back()->withErrors(['original_url' => $e->getMessage()])->withInput();
        }

        $shortCode = $request->input('short_code');

        if ($shortCode) {
            $shortCode = Str::slug($shortCode);
            if ($service->isSlugReserved($shortCode)) {
                return back()->withErrors(['short_code' => 'Kode tautan tersebut dicadangkan untuk kebutuhan sistem.'])->withInput();
            }
        } else {
            $shortCode = $service->generateUniqueCode();
        }

        $request->user()->shortUrls()->create([
            'title' => $request->input('title'),
            'original_url' => $request->input('original_url'),
            'short_code' => $shortCode,
            'is_active' => true,
        ]);

        return redirect()->route('urls.index')->with('success', 'Tautan pendek berhasil dibuat.');
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

        $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'original_url' => ['required', 'string', 'url', 'max:2048'],
            'short_code' => ['required', 'string', 'min:3', 'max:64', 'alpha_dash:ascii', Rule::unique('short_urls', 'short_code')->ignore($url->id)],
            'is_active' => ['required', 'boolean'],
        ], [
            'original_url.required' => 'Alamat tujuan wajib diisi.',
            'original_url.url' => 'Alamat tujuan tidak valid. Pastikan diawali http atau https.',
            'short_code.required' => 'Kode tautan wajib diisi.',
            'short_code.min' => 'Kode tautan minimal 3 karakter.',
            'short_code.max' => 'Kode tautan maksimal 64 karakter.',
            'short_code.alpha_dash' => 'Kode tautan hanya boleh memuat huruf, angka, tanda strip, dan garis bawah.',
            'short_code.unique' => 'Kode tautan sudah digunakan. Silakan gunakan kombinasi lain.',
        ]);

        try {
            $service->validateDestinationUrl($request->input('original_url'), $request->getHost());
        } catch (InvalidArgumentException $e) {
            return back()->withErrors(['original_url' => $e->getMessage()])->withInput();
        }

        $shortCode = Str::slug($request->input('short_code'));

        if ($shortCode !== $url->short_code && $service->isSlugReserved($shortCode)) {
            return back()->withErrors(['short_code' => 'Kode tautan tersebut dicadangkan untuk kebutuhan sistem.'])->withInput();
        }

        $url->update([
            'title' => $request->input('title'),
            'original_url' => $request->input('original_url'),
            'short_code' => $shortCode,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('urls.index')->with('success', 'Perubahan tautan berhasil disimpan.');
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

        $url->delete();

        return redirect()->route('urls.index')->with('success', 'Tautan pendek berhasil dihapus.');
    }

    /**
     * Generate or download QR Code for the short url.
     */
    public function qrCode(ShortUrl $url, Request $request): Response
    {
        $targetUrl = $url->full_url;
        $svg = QrCode::size(300)->errorCorrection('H')->generate($targetUrl);

        $download = $request->boolean('download');
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
