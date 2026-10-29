@extends('layouts.app')

@section('title', 'Kelola Tautan')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-xl font-bold tracking-tight text-slate-900 sm:text-2xl">Kelola Tautan</h1>
            <p class="text-xs text-slate-500 mt-1">Pantau data kunjungan dan kelola tautan pendek Anda</p>
        </div>

        <div>
            <button type="button" onclick="document.getElementById('modal-create-url').classList.remove('hidden')" class="inline-flex h-10 items-center justify-center rounded-lg bg-blue-600 px-4 text-xs font-semibold text-white shadow-xs transition hover:bg-blue-700 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                Tambah Tautan
            </button>
        </div>
    </div>

    <!-- Ringkasan Statistik -->
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

    <!-- Filter dan Pencarian -->
    <form method="GET" action="{{ route('urls.index') }}" class="flex items-center gap-2">
        <div class="relative flex-1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, kode tautan, atau alamat tujuan" class="block h-11 w-full rounded-lg border border-slate-300 bg-white px-3 text-xs text-slate-900 shadow-xs focus:border-blue-600 focus:outline-hidden focus:ring-1 focus:ring-blue-600">
        </div>
        <button type="submit" class="inline-flex h-11 items-center justify-center rounded-lg bg-slate-900 px-5 text-xs font-semibold text-white transition hover:bg-slate-800 focus:outline-hidden focus:ring-2 focus:ring-slate-400 focus:ring-offset-2">
            Filter
        </button>
        @if(request('search'))
            <a href="{{ route('urls.index') }}" class="inline-flex h-11 items-center justify-center rounded-lg border border-slate-300 bg-white px-5 text-xs font-semibold text-slate-700 transition hover:bg-slate-50 focus:outline-hidden focus:ring-2 focus:ring-slate-400 focus:ring-offset-2">
                Reset
            </a>
        @endif
    </form>

    <!-- Daftar Tautan Pola Hybrid Card List -->
    @if($shortUrls->isEmpty())
        <div class="rounded-xl border border-slate-200 bg-white p-12 text-center shadow-xs">
            <p class="text-sm font-semibold text-slate-700">Belum ada tautan dibuat</p>
            <div class="mt-4">
                <button type="button" onclick="document.getElementById('modal-create-url').classList.remove('hidden')" class="inline-flex h-10 items-center justify-center rounded-lg bg-blue-600 px-4 text-xs font-semibold text-white shadow-xs transition hover:bg-blue-700 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                    Tambah Tautan
                </button>
            </div>
        </div>
    @else
        <div class="space-y-3">
            @foreach($shortUrls as $url)
                <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-xs transition hover:border-slate-300 space-y-3">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center gap-2 min-w-0">
                            <h3 class="text-base font-bold text-slate-900 truncate">{{ $url->title ?: $url->display_original_url }}</h3>
                            @if($url->is_active)
                                <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-[11px] font-semibold text-emerald-700">Aktif</span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-rose-50 px-2.5 py-0.5 text-[11px] font-semibold text-rose-700">Nonaktif</span>
                            @endif
                        </div>

                        <!-- Metrik Klik Badge Kapsul -->
                        <span class="inline-flex items-center gap-1.5 self-start sm:self-auto rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700 border border-blue-100">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            {{ number_format($url->clicks_count, 0, ',', '.') }} Klik
                        </span>
                    </div>

                    <!-- Informasi Tautan Pendek dan Alamat Asli -->
                    <div class="space-y-1">
                        <a href="{{ $url->full_url }}" target="_blank" rel="noopener noreferrer" class="block font-mono text-sm font-bold text-blue-600 hover:underline truncate">
                            {{ $url->display_short_url }}
                        </a>
                        <p class="text-xs text-slate-500 truncate" title="{{ $url->original_url }}">
                            Tujuan: <span class="text-slate-700">{{ $url->display_original_url }}</span>
                        </p>
                    </div>

                    <!-- Baris Aksi dan Meta -->
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between pt-3 border-t border-slate-100 text-xs">
                        <p class="text-slate-400">
                            Dibuat {{ $url->created_at->translatedFormat('d F Y') }}
                            @if(auth()->user()->isAdmin() && $url->user)
                                • Oleh: {{ $url->user->department ?? $url->user->name }}
                            @endif
                        </p>

                        <div class="flex flex-wrap items-center gap-2">
                            <button type="button" onclick="copyShortLink('{{ $url->full_url }}', this)" class="inline-flex h-9 items-center justify-center rounded-lg border border-slate-300 bg-white px-3 text-xs font-semibold text-slate-700 shadow-xs transition hover:bg-slate-50 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                                Salin Tautan
                            </button>
                            <button type="button" onclick="openQrModal({{ json_encode($url) }})" class="inline-flex h-9 items-center justify-center rounded-lg border border-slate-300 bg-white px-3 text-xs font-semibold text-slate-700 hover:bg-slate-50 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                                Lihat Kode QR
                            </button>
                            <button type="button" onclick="openEditModal({{ json_encode($url) }})" class="inline-flex h-9 items-center justify-center rounded-lg border border-slate-300 bg-white px-3 text-xs font-semibold text-slate-700 hover:bg-slate-50 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                                Ubah Tautan
                            </button>
                            <form method="POST" action="{{ route('urls.destroy', $url->id) }}" onsubmit="return confirm('Hapus tautan ini? Pengunjung tidak dapat lagi mengakses tautan pendek dan kode QR terkait.');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" data-loading-text="Menghapus Tautan..." class="inline-flex h-9 items-center justify-center rounded-lg border border-rose-200 bg-rose-50 px-3 text-xs font-semibold text-rose-700 hover:bg-rose-100 focus:outline-hidden focus:ring-2 focus:ring-rose-500 focus:ring-offset-2">
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

<!-- Modal Tambah Tautan -->
<div id="modal-create-url" class="fixed inset-0 z-50 {{ $errors->any() ? '' : 'hidden' }} overflow-y-auto bg-slate-900/60 p-4 sm:p-6 flex items-center justify-center">
    <div class="w-full max-w-lg rounded-xl border border-slate-200 bg-white p-6 shadow-xl">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="text-sm font-bold text-slate-900">Tambah Tautan</h3>
            <button type="button" onclick="document.getElementById('modal-create-url').classList.add('hidden')" aria-label="Tutup dialog" class="text-slate-400 hover:text-slate-600 text-lg leading-none p-1 focus:outline-hidden focus:ring-2 focus:ring-slate-400 rounded">&times;</button>
        </div>

        <form method="POST" action="{{ route('urls.store') }}" class="mt-4 space-y-4">
            @csrf

            <div>
                <label for="create_title" class="block text-xs font-semibold text-slate-700">Judul Tautan <span class="font-normal text-slate-400">Opsional</span></label>
                <div class="mt-1">
                    <input type="text" id="create_title" name="title" value="{{ old('title') }}" placeholder="Pengumuman Seleksi Beasiswa Sinjai 2026" class="block h-11 w-full rounded-lg border {{ $errors->has('title') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : 'border-slate-300 focus:border-blue-600 focus:ring-blue-600' }} px-3 text-xs text-slate-900 shadow-xs focus:outline-hidden focus:ring-1">
                </div>
                @error('title')
                    <p class="mt-1 text-[11px] font-medium text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="create_original_url" class="block text-xs font-semibold text-slate-700">Alamat Tujuan</label>
                <div class="mt-1">
                    <input type="url" id="create_original_url" name="original_url" required value="{{ old('original_url') }}" placeholder="https://sinjaikab.go.id/berita/pengumuman-seleksi" class="block h-11 w-full rounded-lg border {{ $errors->has('original_url') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : 'border-slate-300 focus:border-blue-600 focus:ring-blue-600' }} px-3 text-xs text-slate-900 shadow-xs focus:outline-hidden focus:ring-1">
                </div>
                <p class="mt-1 text-[11px] text-slate-500">Gunakan alamat web yang valid diawali https</p>
                @error('original_url')
                    <p class="mt-1 text-[11px] font-medium text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="create_short_code" class="block text-xs font-semibold text-slate-700">Kode Tautan Kustom <span class="font-normal text-slate-400">Opsional</span></label>
                <div class="mt-1 flex rounded-lg shadow-xs">
                    <span class="inline-flex items-center rounded-l-lg border border-r-0 border-slate-300 bg-slate-50 px-3 text-xs text-slate-500">s.sinjaikab.go.id/</span>
                    <input type="text" id="create_short_code" name="short_code" value="{{ old('short_code') }}" placeholder="beasiswa-2026" class="block h-11 w-full rounded-r-lg border {{ $errors->has('short_code') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : 'border-slate-300 focus:border-blue-600 focus:ring-blue-600' }} px-3 text-xs text-slate-900 focus:outline-hidden focus:ring-1">
                </div>
                <p class="mt-1 text-[11px] text-slate-500">Kosongkan jika ingin sistem membuat kode acak secara otomatis</p>
                @error('short_code')
                    <p class="mt-1 text-[11px] font-medium text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('modal-create-url').classList.add('hidden')" class="inline-flex h-11 items-center justify-center rounded-lg border border-slate-300 bg-white px-4 text-xs font-semibold text-slate-700 hover:bg-slate-50 focus:outline-hidden focus:ring-2 focus:ring-slate-400">
                    Batal
                </button>
                <button type="submit" data-loading-text="Menyimpan Tautan..." class="inline-flex h-11 items-center justify-center rounded-lg bg-blue-600 px-4 text-xs font-semibold text-white hover:bg-blue-700 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
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
            <h3 class="text-sm font-bold text-slate-900">Ubah Tautan</h3>
            <button type="button" onclick="document.getElementById('modal-edit-url').classList.add('hidden')" aria-label="Tutup dialog" class="text-slate-400 hover:text-slate-600 text-lg leading-none p-1 focus:outline-hidden focus:ring-2 focus:ring-slate-400 rounded">&times;</button>
        </div>

        <form id="form-edit-url" method="POST" action="" class="mt-4 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="edit_title" class="block text-xs font-semibold text-slate-700">Judul Tautan <span class="font-normal text-slate-400">Opsional</span></label>
                <div class="mt-1">
                    <input type="text" id="edit_title" name="title" class="block h-11 w-full rounded-lg border border-slate-300 px-3 text-xs text-slate-900 shadow-xs focus:border-blue-600 focus:outline-hidden focus:ring-1 focus:ring-blue-600">
                </div>
            </div>

            <div>
                <label for="edit_original_url" class="block text-xs font-semibold text-slate-700">Alamat Tujuan</label>
                <div class="mt-1">
                    <input type="url" id="edit_original_url" name="original_url" required class="block h-11 w-full rounded-lg border border-slate-300 px-3 text-xs text-slate-900 shadow-xs focus:border-blue-600 focus:outline-hidden focus:ring-1 focus:ring-blue-600">
                </div>
            </div>

            <div>
                <label for="edit_short_code" class="block text-xs font-semibold text-slate-700">Kode Tautan</label>
                <div class="mt-1 flex rounded-lg shadow-xs">
                    <span class="inline-flex items-center rounded-l-lg border border-r-0 border-slate-300 bg-slate-50 px-3 text-xs text-slate-500">s.sinjaikab.go.id/</span>
                    <input type="text" id="edit_short_code" name="short_code" required class="block h-11 w-full rounded-r-lg border border-slate-300 px-3 text-xs text-slate-900 focus:outline-hidden focus:ring-1 focus:ring-blue-600">
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
                <button type="button" onclick="document.getElementById('modal-edit-url').classList.add('hidden')" class="inline-flex h-11 items-center justify-center rounded-lg border border-slate-300 bg-white px-4 text-xs font-semibold text-slate-700 hover:bg-slate-50 focus:outline-hidden focus:ring-2 focus:ring-slate-400">
                    Batal
                </button>
                <button type="submit" data-loading-text="Menyimpan Perubahan..." class="inline-flex h-11 items-center justify-center rounded-lg bg-blue-600 px-4 text-xs font-semibold text-white hover:bg-blue-700 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Pratinjau Kode QR -->
<div id="modal-qr-preview" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 p-4 sm:p-6 flex items-center justify-center">
    <div class="w-full max-w-sm rounded-xl border border-slate-200 bg-white p-6 shadow-xl text-center">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="text-sm font-bold text-slate-900">Pratinjau Kode QR</h3>
            <button type="button" onclick="closeQrModal()" aria-label="Tutup dialog" class="text-slate-400 hover:text-slate-600 text-lg leading-none p-1 focus:outline-hidden focus:ring-2 focus:ring-slate-400 rounded">&times;</button>
        </div>

        <div class="mt-4 flex flex-col items-center">
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-xs">
                <img id="qr-image" src="" alt="Kode QR Tautan" class="h-56 w-56 object-contain">
            </div>

            <p id="qr-short-url" class="mt-3 font-mono text-xs font-bold text-blue-600 truncate max-w-full"></p>
            <p id="qr-title" class="mt-1 text-xs text-slate-500 truncate max-w-full"></p>
        </div>

        <div class="mt-6 flex items-center justify-end gap-3 border-t border-slate-100 pt-3">
            <button type="button" onclick="closeQrModal()" class="inline-flex h-11 items-center justify-center rounded-lg border border-slate-300 bg-white px-4 text-xs font-semibold text-slate-700 hover:bg-slate-50 focus:outline-hidden focus:ring-2 focus:ring-slate-400">
                Tutup
            </button>
            <a id="qr-download-btn" href="#" class="inline-flex h-11 items-center justify-center rounded-lg bg-blue-600 px-4 text-xs font-semibold text-white hover:bg-blue-700 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                Unduh Kode QR
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openQrModal(url) {
        document.getElementById('qr-image').src = `/urls/${url.id}/qr`;
        document.getElementById('qr-short-url').textContent = url.display_short_url || url.full_url.replace(/^https?:\/\//, '');
        document.getElementById('qr-title').textContent = url.title || url.display_original_url || url.original_url.replace(/^https?:\/\//, '');
        document.getElementById('qr-download-btn').href = `/urls/${url.id}/qr?download=1`;
        document.getElementById('modal-qr-preview').classList.remove('hidden');
    }

    function closeQrModal() {
        document.getElementById('modal-qr-preview').classList.add('hidden');
    }

    function openEditModal(url) {
        const form = document.getElementById('form-edit-url');
        form.action = `/urls/${url.id}`;
        document.getElementById('edit_title').value = url.title || '';
        document.getElementById('edit_original_url').value = url.original_url;
        document.getElementById('edit_short_code').value = url.short_code;
        document.getElementById('edit_is_active').value = url.is_active ? '1' : '0';
        document.getElementById('modal-edit-url').classList.remove('hidden');
    }
</script>
@endpush
