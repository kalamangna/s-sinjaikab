@extends('layouts.app')

@section('title', 'Kelola Link')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-xl font-bold tracking-tight text-slate-900 sm:text-2xl">Kelola Link</h1>
            <p class="text-xs text-slate-500 mt-1">Pantau data kunjungan dan kelola link singkat Anda</p>
        </div>

        <div>
            <button type="button" onclick="document.getElementById('modal-create-url').classList.remove('hidden')" class="inline-flex h-11 sm:h-10 w-full sm:w-auto items-center justify-center rounded-lg bg-blue-600 px-4 text-xs font-semibold text-white shadow-xs transition hover:bg-blue-700 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                Tambah Link
            </button>
        </div>
    </div>

    <!-- Ringkasan Statistik -->
    <div class="grid grid-cols-2 gap-3 sm:gap-4">
        <div class="rounded-xl border border-slate-200 bg-white p-3.5 sm:p-5 shadow-xs">
            <p class="text-[11px] sm:text-xs font-semibold text-slate-500">Total Link</p>
            <p class="mt-1 sm:mt-2 text-xl sm:text-2xl font-bold text-slate-900">{{ number_format($totalUrls, 0, ',', '.') }}</p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-3.5 sm:p-5 shadow-xs">
            <p class="text-[11px] sm:text-xs font-semibold text-slate-500">Total Klik</p>
            <p class="mt-1 sm:mt-2 text-xl sm:text-2xl font-bold text-slate-900">{{ number_format($totalClicks, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Filter dan Pencarian -->
    <form method="GET" action="{{ route('urls.index') }}" class="flex flex-col sm:flex-row gap-2">
        <div class="relative flex-1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Surat Edaran Bupati, se-bupati-100, atau drive.google.com" class="block h-11 w-full rounded-lg border border-slate-300 bg-white px-3 text-xs text-slate-900 shadow-xs focus:border-blue-600 focus:outline-hidden focus:ring-1 focus:ring-blue-600">
        </div>
        <div class="flex items-center gap-2">
            <button type="submit" class="inline-flex h-11 flex-1 sm:flex-none items-center justify-center rounded-lg bg-slate-900 px-5 text-xs font-semibold text-white transition hover:bg-slate-800 focus:outline-hidden focus:ring-2 focus:ring-slate-400 focus:ring-offset-2">
                Filter
            </button>
            @if(request('search'))
                <a href="{{ route('urls.index') }}" class="inline-flex h-11 flex-1 sm:flex-none items-center justify-center rounded-lg border border-slate-300 bg-white px-5 text-xs font-semibold text-slate-700 transition hover:bg-slate-50 focus:outline-hidden focus:ring-2 focus:ring-slate-400 focus:ring-offset-2">
                    Reset
                </a>
            @endif
        </div>
    </form>

    <!-- Daftar Link Pola Hybrid Card List -->
    @if($shortUrls->isEmpty())
        <div class="rounded-xl border border-slate-200 bg-white p-8 sm:p-12 text-center shadow-xs">
            <p class="text-sm font-semibold text-slate-700">Belum ada link dibuat</p>
            <div class="mt-4">
                <button type="button" onclick="document.getElementById('modal-create-url').classList.remove('hidden')" class="inline-flex h-11 sm:h-10 w-full sm:w-auto items-center justify-center rounded-lg bg-blue-600 px-4 text-xs font-semibold text-white shadow-xs transition hover:bg-blue-700 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                    Tambah Link
                </button>
            </div>
        </div>
    @else
        <div class="space-y-3">
            @foreach($shortUrls as $url)
                <div class="rounded-xl border border-slate-200 bg-white p-4 sm:p-5 shadow-xs transition hover:border-slate-300 space-y-3">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2">
                                <h3 class="text-sm sm:text-base font-bold text-slate-900 truncate">{{ $url->title ?: $url->display_original_url }}</h3>
                                @if($url->is_active)
                                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-[10px] sm:text-[11px] font-semibold text-emerald-700 shrink-0">Aktif</span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-rose-50 px-2 py-0.5 text-[10px] sm:text-[11px] font-semibold text-rose-700 shrink-0">Nonaktif</span>
                                @endif
                            </div>
                        </div>

                        <!-- Metrik Klik Badge Kapsul -->
                        <span class="inline-flex items-center gap-1 sm:gap-1.5 rounded-full bg-blue-50 px-2.5 py-0.5 sm:py-1 text-[11px] sm:text-xs font-bold text-blue-700 border border-blue-100 shrink-0">
                            <svg class="h-3 w-3 sm:h-3.5 sm:w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            {{ number_format($url->clicks_count, 0, ',', '.') }} Klik
                        </span>
                    </div>

                    <!-- Informasi Link Singkat dan Alamat Asli -->
                    <div class="space-y-1">
                        <a href="{{ $url->full_url }}" target="_blank" rel="noopener noreferrer" class="block font-mono text-xs sm:text-sm font-bold text-blue-600 hover:underline truncate">
                            {{ $url->display_short_url }}
                        </a>
                        <p class="text-[11px] sm:text-xs text-slate-500 truncate" title="{{ $url->original_url }}">
                            Tujuan: <span class="text-slate-700">{{ $url->display_original_url }}</span>
                        </p>
                    </div>

                    <!-- Baris Aksi dan Meta -->
                    <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between pt-3 border-t border-slate-100 text-xs">
                        <p class="text-[11px] sm:text-xs text-slate-400">
                            Dibuat {{ $url->created_at->translatedFormat('d F Y') }}
                            @if($url->user)
                                • Oleh: {{ $url->user->name }}@if(!$url->user->isAdmin() && $url->user->department) - {{ $url->user->department }}@endif
                            @endif
                        </p>

                        <div class="grid grid-cols-2 gap-2 sm:flex sm:flex-wrap sm:items-center">
                            <button type="button" onclick="copyShortLink('{{ $url->full_url }}', this)" class="inline-flex h-10 sm:h-9 w-full sm:w-auto items-center justify-center rounded-lg border border-slate-300 bg-white px-3 text-xs font-semibold text-slate-700 shadow-xs transition hover:bg-slate-50 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                                Salin Link
                            </button>
                            <button type="button" onclick="openQrModal({{ json_encode($url) }})" class="inline-flex h-10 sm:h-9 w-full sm:w-auto items-center justify-center rounded-lg border border-slate-300 bg-white px-3 text-xs font-semibold text-slate-700 hover:bg-slate-50 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                                Lihat Kode QR
                            </button>
                            <button type="button" onclick="openEditModal({{ json_encode($url) }})" class="inline-flex h-10 sm:h-9 w-full sm:w-auto items-center justify-center rounded-lg border border-slate-300 bg-white px-3 text-xs font-semibold text-slate-700 hover:bg-slate-50 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                                Ubah Link
                            </button>
                            <form method="POST" action="{{ route('urls.destroy', $url->id) }}" onsubmit="return confirm('Hapus link ini? Pengunjung tidak dapat lagi mengakses link singkat dan kode QR terkait.');" class="w-full sm:w-auto">
                                @csrf
                                @method('DELETE')
                                <button type="submit" data-loading-text="Menghapus Link..." class="inline-flex h-10 sm:h-9 w-full sm:w-auto items-center justify-center rounded-lg border border-rose-200 bg-rose-50 px-3 text-xs font-semibold text-rose-700 hover:bg-rose-100 focus:outline-hidden focus:ring-2 focus:ring-rose-500 focus:ring-offset-2">
                                    Hapus Link
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

<!-- Modal Tambah Link -->
<div id="modal-create-url" class="fixed inset-0 z-50 {{ $errors->any() ? '' : 'hidden' }} overflow-y-auto bg-slate-900/60 p-4 sm:p-6 flex items-center justify-center">
    <div class="w-full max-w-lg rounded-xl border border-slate-200 bg-white p-6 shadow-xl">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="text-sm font-bold text-slate-900">Tambah Link</h3>
            <button type="button" onclick="document.getElementById('modal-create-url').classList.add('hidden')" aria-label="Tutup dialog" class="text-slate-400 hover:text-slate-600 text-lg leading-none p-1 focus:outline-hidden focus:ring-2 focus:ring-slate-400 rounded">&times;</button>
        </div>

        <form method="POST" action="{{ route('urls.store') }}" class="mt-4 space-y-4">
            @csrf

            <div>
                <label for="create_title" class="block text-xs font-semibold text-slate-700">Judul Link <span class="font-normal text-slate-400">Opsional</span></label>
                <div class="mt-1">
                    <input type="text" id="create_title" name="title" value="{{ old('title') }}" placeholder="Surat Edaran Bupati Nomor 100 Tahun 2026" class="block h-11 w-full rounded-lg border {{ $errors->has('title') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : 'border-slate-300 focus:border-blue-600 focus:ring-blue-600' }} px-3 text-xs text-slate-900 shadow-xs focus:outline-hidden focus:ring-1">
                </div>
                @error('title')
                    <p class="mt-1 text-[11px] font-medium text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="create_original_url" class="block text-xs font-semibold text-slate-700">Alamat Tujuan</label>
                <div class="mt-1">
                    <input type="url" id="create_original_url" name="original_url" required value="{{ old('original_url') }}" placeholder="https://drive.google.com/file/d/1a2b3c4d5e6f7g8h9/view" class="block h-11 w-full rounded-lg border {{ $errors->has('original_url') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : 'border-slate-300 focus:border-blue-600 focus:ring-blue-600' }} px-3 text-xs text-slate-900 shadow-xs focus:outline-hidden focus:ring-1">
                </div>
                <p class="mt-1 text-[11px] text-slate-500">Gunakan alamat web yang valid diawali https</p>
                @error('original_url')
                    <p class="mt-1 text-[11px] font-medium text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="create_short_code" class="block text-xs font-semibold text-slate-700">Kode Link Kustom <span class="font-normal text-slate-400">Opsional</span></label>
                <div class="mt-1 flex rounded-lg shadow-xs">
                    <span class="inline-flex items-center rounded-l-lg border border-r-0 border-slate-300 bg-slate-50 px-3 text-xs text-slate-500 shrink-0">s.sinjaikab.go.id/</span>
                    <input type="text" id="create_short_code" name="short_code" value="{{ old('short_code') }}" placeholder="se-bupati-100-2026" class="block h-11 w-full min-w-0 rounded-r-lg border {{ $errors->has('short_code') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : 'border-slate-300 focus:border-blue-600 focus:ring-blue-600' }} px-3 text-xs text-slate-900 focus:outline-hidden focus:ring-1">
                </div>
                <p class="mt-1 text-[11px] text-slate-500">Kosongkan jika ingin sistem membuat kode acak secara otomatis</p>
                @error('short_code')
                    <p class="mt-1 text-[11px] font-medium text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-2 sm:gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('modal-create-url').classList.add('hidden')" class="inline-flex h-11 w-full sm:w-auto items-center justify-center rounded-lg border border-slate-300 bg-white px-4 text-xs font-semibold text-slate-700 hover:bg-slate-50 focus:outline-hidden focus:ring-2 focus:ring-slate-400">
                    Batal
                </button>
                <button type="submit" data-loading-text="Menyimpan Link..." class="inline-flex h-11 w-full sm:w-auto items-center justify-center rounded-lg bg-blue-600 px-4 text-xs font-semibold text-white hover:bg-blue-700 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                    Simpan Link
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Ubah Link -->
<div id="modal-edit-url" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 p-4 sm:p-6 flex items-center justify-center">
    <div class="w-full max-w-lg rounded-xl border border-slate-200 bg-white p-6 shadow-xl">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="text-sm font-bold text-slate-900">Ubah Link</h3>
            <button type="button" onclick="document.getElementById('modal-edit-url').classList.add('hidden')" aria-label="Tutup dialog" class="text-slate-400 hover:text-slate-600 text-lg leading-none p-1 focus:outline-hidden focus:ring-2 focus:ring-slate-400 rounded">&times;</button>
        </div>

        <form id="form-edit-url" method="POST" action="" class="mt-4 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="edit_title" class="block text-xs font-semibold text-slate-700">Judul Link <span class="font-normal text-slate-400">Opsional</span></label>
                <div class="mt-1">
                    <input type="text" id="edit_title" name="title" placeholder="Surat Edaran Bupati Nomor 100 Tahun 2026" class="block h-11 w-full rounded-lg border border-slate-300 px-3 text-xs text-slate-900 shadow-xs focus:border-blue-600 focus:outline-hidden focus:ring-1 focus:ring-blue-600">
                </div>
            </div>

            <div>
                <label for="edit_original_url" class="block text-xs font-semibold text-slate-700">Alamat Tujuan</label>
                <div class="mt-1">
                    <input type="url" id="edit_original_url" name="original_url" required placeholder="https://drive.google.com/file/d/1a2b3c4d5e6f7g8h9/view" class="block h-11 w-full rounded-lg border border-slate-300 px-3 text-xs text-slate-900 shadow-xs focus:border-blue-600 focus:outline-hidden focus:ring-1 focus:ring-blue-600">
                </div>
            </div>

            <div>
                <label for="edit_short_code" class="block text-xs font-semibold text-slate-700">Kode Link</label>
                <div class="mt-1 flex rounded-lg shadow-xs">
                    <span class="inline-flex items-center rounded-l-lg border border-r-0 border-slate-300 bg-slate-50 px-3 text-xs text-slate-500 shrink-0">s.sinjaikab.go.id/</span>
                    <input type="text" id="edit_short_code" name="short_code" required placeholder="se-bupati-100-2026" class="block h-11 w-full min-w-0 rounded-r-lg border border-slate-300 px-3 text-xs text-slate-900 focus:outline-hidden focus:ring-1 focus:ring-blue-600">
                </div>
            </div>

            <div>
                <label for="edit_is_active" class="block text-xs font-semibold text-slate-700">Status Link</label>
                <div class="mt-1">
                    <select id="edit_is_active" name="is_active" class="block h-11 w-full rounded-lg border border-slate-300 px-3 text-xs text-slate-900 shadow-xs focus:border-blue-600 focus:outline-hidden focus:ring-1 focus:ring-blue-600">
                        <option value="1">Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                </div>
            </div>

            <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-2 sm:gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('modal-edit-url').classList.add('hidden')" class="inline-flex h-11 w-full sm:w-auto items-center justify-center rounded-lg border border-slate-300 bg-white px-4 text-xs font-semibold text-slate-700 hover:bg-slate-50 focus:outline-hidden focus:ring-2 focus:ring-slate-400">
                    Batal
                </button>
                <button type="submit" data-loading-text="Menyimpan Perubahan..." class="inline-flex h-11 w-full sm:w-auto items-center justify-center rounded-lg bg-blue-600 px-4 text-xs font-semibold text-white hover:bg-blue-700 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
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
                <img id="qr-image" src="" alt="Kode QR Link" class="h-56 w-56 object-contain">
            </div>

            <p id="qr-short-url" class="mt-3 font-mono text-xs font-bold text-blue-600 truncate max-w-full"></p>
            <p id="qr-title" class="mt-1 text-xs text-slate-500 truncate max-w-full"></p>
        </div>

        <div class="mt-6 flex flex-col-reverse sm:flex-row items-center sm:justify-end gap-2 sm:gap-3 border-t border-slate-100 pt-3">
            <button type="button" onclick="closeQrModal()" class="inline-flex h-11 w-full sm:w-auto items-center justify-center rounded-lg border border-slate-300 bg-white px-4 text-xs font-semibold text-slate-700 hover:bg-slate-50 focus:outline-hidden focus:ring-2 focus:ring-slate-400">
                Tutup
            </button>
            <a id="qr-download-btn" href="#" class="inline-flex h-11 w-full sm:w-auto items-center justify-center rounded-lg bg-blue-600 px-4 text-xs font-semibold text-white hover:bg-blue-700 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
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
