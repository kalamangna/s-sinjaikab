@extends('layouts.app')

@section('title', 'Kelola Tautan')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-xl font-bold tracking-tight text-slate-900 sm:text-2xl">Kelola Tautan Pendek</h1>
            <p class="text-xs text-slate-500 mt-1">Daftar tautan resmi s.sinjaikab.go.id milik unit kerja Anda</p>
        </div>

        <div>
            <button type="button" onclick="document.getElementById('modal-create-url').classList.remove('hidden')" class="inline-flex h-10 items-center justify-center rounded-lg bg-blue-600 px-4 text-xs font-semibold text-white shadow-xs transition hover:bg-blue-700 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                Kustom Tautan Baru
            </button>
        </div>
    </div>

    <!-- Kotak Pemendek Cepat (Quick Shorten Bar) -->
    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-xs">
        <h2 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3">Pemendek Tautan Cepat</h2>
        <form method="POST" action="{{ route('urls.store') }}" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
            @csrf
            <div class="md:col-span-5">
                <label for="quick_original_url" class="block text-xs font-semibold text-slate-700 mb-1">URL Tujuan Lengkap</label>
                <input type="url" id="quick_original_url" name="original_url" required value="{{ old('original_url') }}" placeholder="https://sinjaikab.go.id/berita-resmi" class="block h-11 w-full rounded-lg border border-slate-300 px-3 text-xs text-slate-900 shadow-xs focus:border-blue-600 focus:outline-hidden focus:ring-1 focus:ring-blue-600">
            </div>
            <div class="md:col-span-4">
                <label for="quick_title" class="block text-xs font-semibold text-slate-700 mb-1">Judul Tautan</label>
                <input type="text" id="quick_title" name="title" required value="{{ old('title') }}" placeholder="Pengumuman Beasiswa 2026" class="block h-11 w-full rounded-lg border border-slate-300 px-3 text-xs text-slate-900 shadow-xs focus:border-blue-600 focus:outline-hidden focus:ring-1 focus:ring-blue-600">
            </div>
            <div class="md:col-span-3">
                <button type="submit" class="inline-flex h-11 w-full items-center justify-center rounded-lg bg-blue-600 px-4 text-xs font-semibold text-white shadow-xs transition hover:bg-blue-700 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                    Singkatkan Tautan
                </button>
            </div>
        </form>
    </div>

    <!-- Filter dan Pencarian -->
    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-xs">
        <form method="GET" action="{{ route('urls.index') }}" class="flex flex-col sm:flex-row items-center gap-3">
            <div class="relative w-full flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, slug, atau URL tujuan" class="block h-11 w-full rounded-lg border border-slate-300 px-3 text-xs text-slate-900 shadow-xs focus:border-blue-600 focus:outline-hidden focus:ring-1 focus:ring-blue-600">
            </div>
            <div class="flex w-full sm:w-auto items-center gap-2">
                <button type="submit" class="inline-flex h-11 flex-1 sm:flex-initial items-center justify-center rounded-lg bg-slate-900 px-5 text-xs font-semibold text-white transition hover:bg-slate-800 focus:outline-hidden">
                    Filter
                </button>
                @if(request('search'))
                    <a href="{{ route('urls.index') }}" class="inline-flex h-11 flex-1 sm:flex-initial items-center justify-center rounded-lg border border-slate-300 bg-white px-5 text-xs font-semibold text-slate-700 transition hover:bg-slate-50 focus:outline-hidden">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Daftar Tautan Pola Hybrid Card List -->
    @if($shortUrls->isEmpty())
        <div class="rounded-xl border border-slate-200 bg-white p-12 text-center shadow-xs">
            <p class="text-sm font-semibold text-slate-700">Belum ada tautan dibuat</p>
            <p class="mt-1 text-xs text-slate-500">Gunakan kotak di atas untuk membuat tautan resmi pertama Anda</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($shortUrls as $url)
                <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-xs transition hover:border-slate-300">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                        <div class="space-y-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <h3 class="text-base font-bold text-slate-900">{{ $url->title }}</h3>
                                @if($url->is_active)
                                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-[11px] font-semibold text-emerald-700">Aktif</span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-rose-50 px-2.5 py-0.5 text-[11px] font-semibold text-rose-700">Nonaktif</span>
                                @endif
                            </div>
                            <p class="text-xs text-slate-500">
                                Dibuat {{ $url->created_at->translatedFormat('d F Y') }}
                                @if(auth()->user()->isAdmin() && $url->user)
                                    • Pengelola: {{ $url->user->department ?? $url->user->name }}
                                @endif
                            </p>
                        </div>

                        <!-- Metrik Klik Badge Kapsul -->
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-3.5 py-1.5 text-xs font-bold text-blue-700 border border-blue-100">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                {{ number_format($url->clicks_count, 0, ',', '.') }} Klik
                            </span>
                        </div>
                    </div>

                    <!-- Panel Tautan Pendek dan Alamat Asli -->
                    <div class="mt-4 flex flex-col gap-3 rounded-lg border border-slate-100 bg-slate-50 p-3.5 sm:flex-row sm:items-center sm:justify-between">
                        <div class="min-w-0 flex-1 space-y-1">
                            <a href="{{ $url->full_url }}" target="_blank" rel="noopener noreferrer" class="block font-mono text-sm font-bold text-blue-600 hover:underline truncate">
                                {{ $url->full_url }}
                            </a>
                            <p class="text-xs text-slate-500 truncate" title="{{ $url->original_url }}">
                                Menuju ke: <span class="text-slate-700">{{ $url->original_url }}</span>
                            </p>
                        </div>

                        <div class="shrink-0">
                            <button type="button" onclick="copyShortLink('{{ $url->full_url }}', this)" class="inline-flex h-10 w-full sm:w-auto items-center justify-center rounded-lg border border-slate-300 bg-white px-4 text-xs font-semibold text-slate-700 shadow-xs transition hover:bg-slate-50 focus:outline-hidden">
                                Salin Tautan
                            </button>
                        </div>
                    </div>

                    <!-- Baris Aksi Pendukung -->
                    <div class="mt-4 flex flex-wrap items-center justify-between gap-2 pt-3 border-t border-slate-100">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('urls.qr', ['url' => $url->id, 'download' => 1]) }}" class="inline-flex h-10 items-center justify-center rounded-lg border border-slate-300 bg-white px-3.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                                Unduh QR Code
                            </a>
                        </div>

                        <div class="flex items-center gap-2">
                            <button type="button" onclick="openEditModal({{ json_encode($url) }})" class="inline-flex h-10 items-center justify-center rounded-lg border border-slate-300 bg-white px-3.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                                Ubah Data
                            </button>

                            <form method="POST" action="{{ route('urls.destroy', $url->id) }}" onsubmit="return confirm('Hapus tautan ini? Pengalihan melalui alamat pendek ini akan terhenti secara permanen.');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex h-10 items-center justify-center rounded-lg border border-rose-200 bg-rose-50 px-3.5 text-xs font-semibold text-rose-700 hover:bg-rose-100">
                                    Hapus Tautan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach

            @if($shortUrls->hasPages())
                <div class="pt-2">
                    {{ $shortUrls->links() }}
                </div>
            @endif
        </div>
    @endif
</div>

<!-- Modal Kustom Tautan Baru -->
<div id="modal-create-url" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 p-4 sm:p-6 flex items-center justify-center">
    <div class="w-full max-w-lg rounded-xl border border-slate-200 bg-white p-6 shadow-xl">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="text-sm font-bold text-slate-900">Buat Tautan Pendek dengan Kustom Slug</h3>
            <button type="button" onclick="document.getElementById('modal-create-url').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg leading-none">&times;</button>
        </div>

        <form method="POST" action="{{ route('urls.store') }}" class="mt-4 space-y-4">
            @csrf

            <div>
                <label for="create_title" class="block text-xs font-semibold text-slate-700">Judul Tautan</label>
                <div class="mt-1">
                    <input type="text" id="create_title" name="title" required value="{{ old('title') }}" placeholder="Pengumuman Seleksi Beasiswa Sinjai 2026" class="block h-11 w-full rounded-lg border border-slate-300 px-3 text-xs text-slate-900 shadow-xs focus:border-blue-600 focus:outline-hidden focus:ring-1 focus:ring-blue-600">
                </div>
            </div>

            <div>
                <label for="create_original_url" class="block text-xs font-semibold text-slate-700">URL Tujuan Lengkap</label>
                <div class="mt-1">
                    <input type="url" id="create_original_url" name="original_url" required value="{{ old('original_url') }}" placeholder="https://sinjaikab.go.id/berita/pengumuman-seleksi" class="block h-11 w-full rounded-lg border border-slate-300 px-3 text-xs text-slate-900 shadow-xs focus:border-blue-600 focus:outline-hidden focus:ring-1 focus:ring-blue-600">
                </div>
                <p class="mt-1 text-[11px] text-slate-500">Wajib diawali https:// dan dilarang mengarahkan ke berkas unduhan program berbahaya</p>
            </div>

            <div>
                <label for="create_short_code" class="block text-xs font-semibold text-slate-700">Kustom Slug Tautan</label>
                <div class="mt-1 flex rounded-lg shadow-xs">
                    <span class="inline-flex items-center rounded-l-lg border border-r-0 border-slate-300 bg-slate-50 px-3 text-xs text-slate-500">s.sinjaikab.go.id/</span>
                    <input type="text" id="create_short_code" name="short_code" value="{{ old('short_code') }}" placeholder="beasiswa-2026" class="block h-11 w-full rounded-r-lg border border-slate-300 px-3 text-xs text-slate-900 focus:border-blue-600 focus:outline-hidden focus:ring-1 focus:ring-blue-600">
                </div>
                <p class="mt-1 text-[11px] text-slate-500">Kosongkan kolom ini jika ingin sistem menghasilkan kode acak secara otomatis</p>
            </div>

            <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('modal-create-url').classList.add('hidden')" class="inline-flex h-11 items-center justify-center rounded-lg border border-slate-300 bg-white px-4 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                    Batal
                </button>
                <button type="submit" class="inline-flex h-11 items-center justify-center rounded-lg bg-blue-600 px-4 text-xs font-semibold text-white hover:bg-blue-700">
                    Simpan Tautan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Ubah Tautan -->
<div id="modal-edit-url" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 p-4 sm:p-6 flex items-center justify-center">
    <div class="w-full max-w-lg rounded-xl border border-slate-200 bg-white p-6 shadow-xl">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="text-sm font-bold text-slate-900">Ubah Data Tautan Pendek</h3>
            <button type="button" onclick="document.getElementById('modal-edit-url').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg leading-none">&times;</button>
        </div>

        <form id="form-edit-url" method="POST" action="" class="mt-4 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="edit_title" class="block text-xs font-semibold text-slate-700">Judul Tautan</label>
                <div class="mt-1">
                    <input type="text" id="edit_title" name="title" required class="block h-11 w-full rounded-lg border border-slate-300 px-3 text-xs text-slate-900 shadow-xs focus:border-blue-600 focus:outline-hidden focus:ring-1 focus:ring-blue-600">
                </div>
            </div>

            <div>
                <label for="edit_original_url" class="block text-xs font-semibold text-slate-700">URL Tujuan Lengkap</label>
                <div class="mt-1">
                    <input type="url" id="edit_original_url" name="original_url" required class="block h-11 w-full rounded-lg border border-slate-300 px-3 text-xs text-slate-900 shadow-xs focus:border-blue-600 focus:outline-hidden focus:ring-1 focus:ring-blue-600">
                </div>
            </div>

            <div>
                <label for="edit_is_active" class="block text-xs font-semibold text-slate-700">Status Tautan</label>
                <div class="mt-1">
                    <select id="edit_is_active" name="is_active" class="block h-11 w-full rounded-lg border border-slate-300 px-3 text-xs text-slate-900 shadow-xs focus:border-blue-600 focus:outline-hidden focus:ring-1 focus:ring-blue-600">
                        <option value="1">Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('modal-edit-url').classList.add('hidden')" class="inline-flex h-11 items-center justify-center rounded-lg border border-slate-300 bg-white px-4 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                    Batal
                </button>
                <button type="submit" class="inline-flex h-11 items-center justify-center rounded-lg bg-blue-600 px-4 text-xs font-semibold text-white hover:bg-blue-700">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function copyShortLink(text, buttonElement) {
        navigator.clipboard.writeText(text).then(() => {
            const originalText = buttonElement.textContent;
            buttonElement.textContent = 'Tersalin!';
            buttonElement.classList.remove('text-slate-700', 'bg-white');
            buttonElement.classList.add('text-emerald-700', 'bg-emerald-50', 'border-emerald-300');

            setTimeout(() => {
                buttonElement.textContent = originalText;
                buttonElement.classList.remove('text-emerald-700', 'bg-emerald-50', 'border-emerald-300');
                buttonElement.classList.add('text-slate-700', 'bg-white');
            }, 2000);
        });
    }

    function openEditModal(url) {
        const form = document.getElementById('form-edit-url');
        form.action = `/urls/${url.id}`;
        document.getElementById('edit_title').value = url.title;
        document.getElementById('edit_original_url').value = url.original_url;
        document.getElementById('edit_is_active').value = url.is_active ? '1' : '0';
        document.getElementById('modal-edit-url').classList.remove('hidden');
    }
</script>
@endpush
