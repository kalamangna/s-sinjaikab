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
                Tambah Tautan
            </button>
        </div>
    </div>

    <!-- Filter dan Pencarian -->
    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-xs">
        <form method="GET" action="{{ route('urls.index') }}" class="flex flex-col sm:flex-row items-center gap-3">
            <div class="relative w-full flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, slug, atau URL tujuan" class="block h-10 w-full rounded-lg border border-slate-300 px-3 text-xs text-slate-900 shadow-xs focus:border-blue-600 focus:outline-hidden focus:ring-1 focus:ring-blue-600">
            </div>
            <div class="flex w-full sm:w-auto items-center gap-2">
                <button type="submit" class="inline-flex h-10 flex-1 sm:flex-initial items-center justify-center rounded-lg bg-slate-900 px-4 text-xs font-semibold text-white transition hover:bg-slate-800 focus:outline-hidden">
                    Filter
                </button>
                @if(request('search'))
                    <a href="{{ route('urls.index') }}" class="inline-flex h-10 flex-1 sm:flex-initial items-center justify-center rounded-lg border border-slate-300 bg-white px-4 text-xs font-semibold text-slate-700 transition hover:bg-slate-50 focus:outline-hidden">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabel Tautan -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-xs overflow-hidden">
        @if($shortUrls->isEmpty())
            <div class="py-16 text-center px-4">
                <p class="text-sm font-semibold text-slate-700">Belum ada tautan dibuat</p>
                <p class="mt-1 text-xs text-slate-500">Mulai buat tautan pendek resmi pertama untuk instansi Anda</p>
                <button type="button" onclick="document.getElementById('modal-create-url').classList.remove('hidden')" class="mt-4 inline-flex h-10 items-center justify-center rounded-lg bg-blue-600 px-4 text-xs font-semibold text-white transition hover:bg-blue-700 focus:outline-hidden">
                    Tambah Tautan
                </button>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="border-b border-slate-200 bg-slate-50 font-semibold text-slate-600">
                        <tr>
                            <th scope="col" class="px-5 py-3">Informasi Tautan</th>
                            <th scope="col" class="px-5 py-3">Tautan Pendek</th>
                            @if(auth()->user()->isAdmin())
                                <th scope="col" class="px-5 py-3">OPD</th>
                            @endif
                            <th scope="col" class="px-5 py-3 text-center">Total Klik</th>
                            <th scope="col" class="px-5 py-3 text-center">Status</th>
                            <th scope="col" class="px-5 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($shortUrls as $url)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-5 py-3.5 max-w-sm">
                                    <p class="font-semibold text-slate-900">{{ $url->title }}</p>
                                    <a href="{{ $url->original_url }}" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-slate-600 truncate block mt-0.5" title="{{ $url->original_url }}">
                                        {{ $url->original_url }}
                                    </a>
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-2">
                                        <span class="font-mono font-medium text-blue-600">{{ $url->full_url }}</span>
                                        <button type="button" onclick="navigator.clipboard.writeText('{{ $url->full_url }}'); alert('Tautan berhasil disalin ke papan klip');" class="inline-flex h-7 items-center rounded border border-slate-200 bg-slate-50 px-2 text-[11px] font-medium text-slate-600 hover:bg-slate-100" title="Salin ke papan klip">
                                            Salin Tautan
                                        </button>
                                    </div>
                                </td>
                                @if(auth()->user()->isAdmin())
                                    <td class="px-5 py-3.5 text-slate-600">
                                        {{ $url->user->department ?? $url->user->name ?? 'Admin' }}
                                    </td>
                                @endif
                                <td class="px-5 py-3.5 text-center font-semibold text-slate-900">
                                    {{ number_format($url->clicks_count, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    @if($url->is_active)
                                        <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-1 text-[11px] font-medium text-emerald-700">Aktif</span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-rose-50 px-2 py-1 text-[11px] font-medium text-rose-700">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('urls.qr', ['url' => $url->id, 'download' => 1]) }}" class="inline-flex h-8 items-center rounded-md border border-slate-300 bg-white px-2.5 text-xs font-medium text-slate-700 hover:bg-slate-50">
                                            Unduh QR Code
                                        </a>

                                        <button type="button" onclick="openEditModal({{ json_encode($url) }})" class="inline-flex h-8 items-center rounded-md border border-slate-300 bg-white px-2.5 text-xs font-medium text-slate-700 hover:bg-slate-50">
                                            Ubah Data
                                        </button>

                                        <form method="POST" action="{{ route('urls.destroy', $url->id) }}" onsubmit="return confirm('Hapus tautan ini? Akses pengguna melalui alamat pendek ini akan terhenti secara permanen.');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex h-8 items-center rounded-md border border-rose-200 bg-rose-50 px-2.5 text-xs font-medium text-rose-700 hover:bg-rose-100">
                                                Hapus Tautan
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($shortUrls->hasPages())
                <div class="border-t border-slate-200 bg-white px-5 py-3">
                    {{ $shortUrls->links() }}
                </div>
            @endif
        @endif
    </div>
</div>

<!-- Modal Tambah Tautan -->
<div id="modal-create-url" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 p-4 sm:p-6 flex items-center justify-center">
    <div class="w-full max-w-lg rounded-xl border border-slate-200 bg-white p-6 shadow-xl">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="text-sm font-bold text-slate-900">Buat Tautan Pendek Baru</h3>
            <button type="button" onclick="document.getElementById('modal-create-url').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg leading-none">&times;</button>
        </div>

        <form method="POST" action="{{ route('urls.store') }}" class="mt-4 space-y-4">
            @csrf

            <div>
                <label for="create_title" class="block text-xs font-semibold text-slate-700">Judul Tautan</label>
                <div class="mt-1">
                    <input type="text" id="create_title" name="title" required value="{{ old('title') }}" placeholder="Pengumuman Seleksi Beasiswa Sinjai 2026" class="block h-10 w-full rounded-lg border border-slate-300 px-3 text-xs text-slate-900 shadow-xs focus:border-blue-600 focus:outline-hidden focus:ring-1 focus:ring-blue-600">
                </div>
            </div>

            <div>
                <label for="create_original_url" class="block text-xs font-semibold text-slate-700">URL Tujuan Lengkap</label>
                <div class="mt-1">
                    <input type="url" id="create_original_url" name="original_url" required value="{{ old('original_url') }}" placeholder="https://sinjaikab.go.id/berita/pengumuman-seleksi" class="block h-10 w-full rounded-lg border border-slate-300 px-3 text-xs text-slate-900 shadow-xs focus:border-blue-600 focus:outline-hidden focus:ring-1 focus:ring-blue-600">
                </div>
                <p class="mt-1 text-[11px] text-slate-500">Wajib diawali https:// dan dilarang mengarahkan ke berkas unduhan program berbahaya</p>
            </div>

            <div>
                <label for="create_short_code" class="block text-xs font-semibold text-slate-700">Kustom Slug Tautan</label>
                <div class="mt-1 flex rounded-lg shadow-xs">
                    <span class="inline-flex items-center rounded-l-lg border border-r-0 border-slate-300 bg-slate-50 px-3 text-xs text-slate-500">s.sinjaikab.go.id/</span>
                    <input type="text" id="create_short_code" name="short_code" value="{{ old('short_code') }}" placeholder="beasiswa-2026" class="block h-10 w-full rounded-r-lg border border-slate-300 px-3 text-xs text-slate-900 focus:border-blue-600 focus:outline-hidden focus:ring-1 focus:ring-blue-600">
                </div>
                <p class="mt-1 text-[11px] text-slate-500">Kosongkan kolom ini jika ingin sistem menghasilkan kode acak secara otomatis</p>
            </div>

            <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('modal-create-url').classList.add('hidden')" class="inline-flex h-10 items-center justify-center rounded-lg border border-slate-300 bg-white px-4 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                    Batal
                </button>
                <button type="submit" class="inline-flex h-10 items-center justify-center rounded-lg bg-blue-600 px-4 text-xs font-semibold text-white hover:bg-blue-700">
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
            <h3 class="text-sm font-bold text-slate-900">Ubah Tautan Pendek</h3>
            <button type="button" onclick="document.getElementById('modal-edit-url').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg leading-none">&times;</button>
        </div>

        <form id="form-edit-url" method="POST" action="" class="mt-4 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="edit_title" class="block text-xs font-semibold text-slate-700">Judul Tautan</label>
                <div class="mt-1">
                    <input type="text" id="edit_title" name="title" required class="block h-10 w-full rounded-lg border border-slate-300 px-3 text-xs text-slate-900 shadow-xs focus:border-blue-600 focus:outline-hidden focus:ring-1 focus:ring-blue-600">
                </div>
            </div>

            <div>
                <label for="edit_original_url" class="block text-xs font-semibold text-slate-700">URL Tujuan Lengkap</label>
                <div class="mt-1">
                    <input type="url" id="edit_original_url" name="original_url" required class="block h-10 w-full rounded-lg border border-slate-300 px-3 text-xs text-slate-900 shadow-xs focus:border-blue-600 focus:outline-hidden focus:ring-1 focus:ring-blue-600">
                </div>
            </div>

            <div>
                <label for="edit_is_active" class="block text-xs font-semibold text-slate-700">Status Tautan</label>
                <div class="mt-1">
                    <select id="edit_is_active" name="is_active" class="block h-10 w-full rounded-lg border border-slate-300 px-3 text-xs text-slate-900 shadow-xs focus:border-blue-600 focus:outline-hidden focus:ring-1 focus:ring-blue-600">
                        <option value="1">Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('modal-edit-url').classList.add('hidden')" class="inline-flex h-10 items-center justify-center rounded-lg border border-slate-300 bg-white px-4 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                    Batal
                </button>
                <button type="submit" class="inline-flex h-10 items-center justify-center rounded-lg bg-blue-600 px-4 text-xs font-semibold text-white hover:bg-blue-700">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
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
