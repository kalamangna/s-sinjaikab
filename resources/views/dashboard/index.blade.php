@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-xl font-bold tracking-tight text-slate-900 sm:text-2xl">Dashboard Layanan Tautan</h1>
            <p class="text-xs text-slate-500 mt-1">Ringkasan aktivitas pemendekan tautan resmi Pemerintah Kabupaten Sinjai</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('urls.index') }}" class="inline-flex h-10 items-center justify-center rounded-lg bg-blue-600 px-4 text-xs font-semibold text-white shadow-xs transition hover:bg-blue-700 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                Kelola Tautan
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-xs">
            <p class="text-xs font-medium text-slate-500">Total Tautan Aktif</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ number_format($totalUrls, 0, ',', '.') }}</p>
            <p class="mt-1 text-xs text-slate-400">Tautan pendek aktif saat ini</p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-xs">
            <p class="text-xs font-medium text-slate-500">Total Klik Pengunjung</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ number_format($totalClicks, 0, ',', '.') }}</p>
            <p class="mt-1 text-xs text-slate-400">Akumulasi pengalihan tautan berhasil</p>
        </div>

        @if(auth()->user()->isAdmin() && $totalOpd !== null)
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-xs">
                <p class="text-xs font-medium text-slate-500">Organisasi Perangkat Daerah</p>
                <p class="mt-2 text-2xl font-bold text-slate-900">{{ number_format($totalOpd, 0, ',', '.') }}</p>
                <p class="mt-1 text-xs text-slate-400">OPD terdaftar dalam sistem</p>
            </div>
        @endif
    </div>

    <div class="rounded-xl border border-slate-200 bg-white shadow-xs overflow-hidden">
        <div class="border-b border-slate-200 px-5 py-4 flex items-center justify-between">
            <h2 class="text-sm font-bold text-slate-900">Tautan Paling Sering Dikunjungi</h2>
            <a href="{{ route('urls.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800">
                Lihat Semua
            </a>
        </div>

        @if($topUrls->isEmpty())
            <div class="px-5 py-12 text-center">
                <p class="text-xs text-slate-500">Belum ada data kunjungan tautan.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="border-b border-slate-200 bg-slate-50 font-semibold text-slate-600">
                        <tr>
                            <th scope="col" class="px-5 py-3">Judul Tautan</th>
                            <th scope="col" class="px-5 py-3">Tautan Pendek</th>
                            @if(auth()->user()->isAdmin())
                                <th scope="col" class="px-5 py-3">OPD Pengelola</th>
                            @endif
                            <th scope="col" class="px-5 py-3 text-right">Total Klik</th>
                            <th scope="col" class="px-5 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($topUrls as $url)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-5 py-3.5">
                                    <p class="font-semibold text-slate-900">{{ $url->title }}</p>
                                    <p class="text-slate-400 truncate max-w-xs mt-0.5" title="{{ $url->original_url }}">{{ $url->original_url }}</p>
                                </td>
                                <td class="px-5 py-3.5 font-mono text-blue-600">
                                    <a href="{{ $url->full_url }}" target="_blank" rel="noopener noreferrer" class="hover:underline">
                                        {{ $url->full_url }}
                                    </a>
                                </td>
                                @if(auth()->user()->isAdmin())
                                    <td class="px-5 py-3.5 text-slate-600">
                                        {{ $url->user->department ?? $url->user->name ?? 'Admin' }}
                                    </td>
                                @endif
                                <td class="px-5 py-3.5 text-right font-semibold text-slate-900">
                                    {{ number_format($url->clicks_count, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                    <a href="{{ route('urls.qr', ['url' => $url->id, 'download' => 1]) }}" class="inline-flex h-8 items-center justify-center rounded-md border border-slate-300 bg-white px-2.5 text-xs font-medium text-slate-700 hover:bg-slate-50 focus:outline-hidden">
                                        Unduh QR Code
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
