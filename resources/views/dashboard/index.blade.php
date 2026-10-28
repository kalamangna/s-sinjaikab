@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-xl font-bold tracking-tight text-slate-900 sm:text-2xl">Dashboard</h1>
            <p class="text-xs text-slate-500 mt-1">Pantau statistik klik dan kelola tautan pendek Anda</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('urls.index') }}" class="inline-flex h-10 items-center justify-center rounded-lg bg-blue-600 px-4 text-xs font-semibold text-white shadow-xs transition hover:bg-blue-700 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                Kelola Tautan
            </a>
        </div>
    </div>

    <!-- Kotak Pemendek Cepat (Quick Shorten Bar) -->
    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-xs">
        <h2 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3">Singkatkan Tautan Baru</h2>
        <form method="POST" action="{{ route('urls.store') }}" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
            @csrf
            <div class="md:col-span-5">
                <label for="dash_original_url" class="block text-xs font-semibold text-slate-700 mb-1">Alamat Tujuan</label>
                <input type="url" id="dash_original_url" name="original_url" required value="{{ old('original_url') }}" placeholder="https://sinjaikab.go.id/berita-resmi" class="block h-11 w-full rounded-lg border {{ $errors->has('original_url') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : 'border-slate-300 focus:border-blue-600 focus:ring-blue-600' }} px-3 text-xs text-slate-900 shadow-xs focus:outline-hidden focus:ring-1">
                @error('original_url')
                    <p class="mt-1 text-[11px] font-medium text-rose-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="md:col-span-4">
                <label for="dash_title" class="block text-xs font-semibold text-slate-700 mb-1">Judul Tautan</label>
                <input type="text" id="dash_title" name="title" required value="{{ old('title') }}" placeholder="Pengumuman Beasiswa 2026" class="block h-11 w-full rounded-lg border {{ $errors->has('title') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : 'border-slate-300 focus:border-blue-600 focus:ring-blue-600' }} px-3 text-xs text-slate-900 shadow-xs focus:outline-hidden focus:ring-1">
                @error('title')
                    <p class="mt-1 text-[11px] font-medium text-rose-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="md:col-span-3">
                <button type="submit" data-loading-text="Menyimpan..." class="inline-flex h-11 w-full items-center justify-center rounded-lg bg-blue-600 px-4 text-xs font-semibold text-white shadow-xs transition hover:bg-blue-700 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                    Singkatkan Tautan
                </button>
            </div>
        </form>
    </div>

    <!-- Statistik Ringkasan -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-xs">
            <p class="text-xs font-semibold text-slate-500">Total Tautan</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ number_format($totalUrls, 0, ',', '.') }}</p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-xs">
            <p class="text-xs font-semibold text-slate-500">Total Klik</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ number_format($totalClicks, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Tautan Terpopuler Pola Hybrid Card List -->
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-sm font-bold text-slate-900">Tautan Terpopuler</h2>
            <a href="{{ route('urls.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800">
                Lihat Semua
            </a>
        </div>

        @if($topUrls->isEmpty())
            <div class="rounded-xl border border-slate-200 bg-white p-12 text-center shadow-xs">
                <p class="text-sm font-semibold text-slate-700">Belum ada kunjungan tautan</p>
                <p class="mt-1 text-xs text-slate-500">Statistik klik akan tampil begitu tautan mulai diakses</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach($topUrls as $url)
                    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-xs transition hover:border-slate-300">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div class="min-w-0 flex-1 space-y-1">
                                <div class="flex items-center gap-2">
                                    <h3 class="text-sm font-bold text-slate-900 truncate">{{ $url->title }}</h3>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-bold text-blue-700">
                                        {{ number_format($url->clicks_count, 0, ',', '.') }} Klik
                                    </span>
                                </div>
                                <a href="{{ $url->full_url }}" target="_blank" rel="noopener noreferrer" class="font-mono text-xs font-bold text-blue-600 hover:underline">
                                    {{ $url->full_url }}
                                </a>
                                <p class="text-xs text-slate-400 truncate" title="{{ $url->original_url }}">
                                    Tujuan: {{ $url->original_url }}
                                </p>
                            </div>

                            <div class="flex items-center gap-2 shrink-0">
                                <button type="button" onclick="copyShortLink('{{ $url->full_url }}', this)" class="inline-flex h-10 items-center justify-center rounded-lg border border-slate-300 bg-white px-3.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                                    Salin Tautan
                                </button>
                                <a href="{{ route('urls.qr', ['url' => $url->id, 'download' => 1]) }}" class="inline-flex h-10 items-center justify-center rounded-lg border border-slate-300 bg-white px-3.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                                    Unduh Kode QR
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
