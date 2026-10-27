<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show application dashboard.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            $totalUrls = ShortUrl::count();
            $totalClicks = (int) ShortUrl::sum('clicks_count');

            $topUrls = ShortUrl::with('user')
                ->orderByDesc('clicks_count')
                ->limit(5)
                ->get();

            $recentUrls = ShortUrl::with('user')
                ->latest()
                ->limit(5)
                ->get();
        } else {
            $totalUrls = $user->shortUrls()->count();
            $totalClicks = (int) $user->shortUrls()->sum('clicks_count');

            $topUrls = $user->shortUrls()
                ->orderByDesc('clicks_count')
                ->limit(5)
                ->get();

            $recentUrls = $user->shortUrls()
                ->latest()
                ->limit(5)
                ->get();
        }

        return view('dashboard.index', compact('totalUrls', 'totalClicks', 'topUrls', 'recentUrls'));
    }
}
