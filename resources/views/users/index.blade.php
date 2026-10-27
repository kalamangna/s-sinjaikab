@extends('layouts.app')

@section('title', 'Kelola Akun OPD')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-xl font-bold tracking-tight text-slate-900 sm:text-2xl">Kelola Akun OPD</h1>
            <p class="text-xs text-slate-500 mt-1">Daftar operator Organisasi Perangkat Daerah yang memiliki akses pemendekan tautan</p>
        </div>

        <div>
            <button type="button" onclick="document.getElementById('modal-create-user').classList.remove('hidden')" class="inline-flex h-10 items-center justify-center rounded-lg bg-blue-600 px-4 text-xs font-semibold text-white shadow-xs transition hover:bg-blue-700 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                Tambah Akun OPD
            </button>
        </div>
    </div>

    <!-- Filter dan Pencarian -->
    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-xs">
        <form method="GET" action="{{ route('users.index') }}" class="flex flex-col sm:flex-row items-center gap-3">
            <div class="relative w-full flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama operator, OPD, atau email kedinasan" class="block h-10 w-full rounded-lg border border-slate-300 px-3 text-xs text-slate-900 shadow-xs focus:border-blue-600 focus:outline-hidden focus:ring-1 focus:ring-blue-600">
            </div>
            <div class="flex w-full sm:w-auto items-center gap-2">
                <button type="submit" class="inline-flex h-10 flex-1 sm:flex-initial items-center justify-center rounded-lg bg-slate-900 px-4 text-xs font-semibold text-white transition hover:bg-slate-800 focus:outline-hidden">
                    Filter
                </button>
                @if(request('search'))
                    <a href="{{ route('users.index') }}" class="inline-flex h-10 flex-1 sm:flex-initial items-center justify-center rounded-lg border border-slate-300 bg-white px-4 text-xs font-semibold text-slate-700 transition hover:bg-slate-50 focus:outline-hidden">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabel Pengguna OPD -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-xs overflow-hidden">
        @if($users->isEmpty())
            <div class="py-16 text-center px-4">
                <p class="text-sm font-semibold text-slate-700">Belum ada akun OPD terdaftar</p>
                <p class="mt-1 text-xs text-slate-500">Tambahkan akun dinas untuk memberikan akses pengelolaan tautan resmi</p>
                <button type="button" onclick="document.getElementById('modal-create-user').classList.remove('hidden')" class="mt-4 inline-flex h-10 items-center justify-center rounded-lg bg-blue-600 px-4 text-xs font-semibold text-white transition hover:bg-blue-700 focus:outline-hidden">
                    Tambah Akun OPD
                </button>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="border-b border-slate-200 bg-slate-50 font-semibold text-slate-600">
                        <tr>
                            <th scope="col" class="px-5 py-3">Organisasi Perangkat Daerah</th>
                            <th scope="col" class="px-5 py-3">Nama Operator</th>
                            <th scope="col" class="px-5 py-3">Email Kedinasan</th>
                            <th scope="col" class="px-5 py-3 text-center">Total Tautan</th>
                            <th scope="col" class="px-5 py-3 text-center">Status</th>
                            <th scope="col" class="px-5 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($users as $user)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-5 py-3.5 font-semibold text-slate-900">
                                    {{ $user->department }}
                                </td>
                                <td class="px-5 py-3.5 text-slate-700">
                                    {{ $user->name }}
                                </td>
                                <td class="px-5 py-3.5 font-mono text-slate-600">
                                    {{ $user->email }}
                                </td>
                                <td class="px-5 py-3.5 text-center font-semibold text-slate-900">
                                    {{ number_format($user->short_urls_count, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    @if($user->is_active)
                                        <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-1 text-[11px] font-medium text-emerald-700">Aktif</span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-rose-50 px-2 py-1 text-[11px] font-medium text-rose-700">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <button type="button" onclick="openEditUserModal({{ json_encode($user) }})" class="inline-flex h-8 items-center rounded-md border border-slate-300 bg-white px-2.5 text-xs font-medium text-slate-700 hover:bg-slate-50">
                                            Ubah Data
                                        </button>

                                        <form method="POST" action="{{ route('users.destroy', $user->id) }}" onsubmit="return confirm('Hapus akun OPD ini? Seluruh riwayat tautan dinas ini akan tetap tersimpan namun tidak lagi memiliki pengelola aktif.');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex h-8 items-center rounded-md border border-rose-200 bg-rose-50 px-2.5 text-xs font-medium text-rose-700 hover:bg-rose-100">
                                                Hapus Akun
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div class="border-t border-slate-200 bg-white px-5 py-3">
                    {{ $users->links() }}
                </div>
            @endif
        @endif
    </div>
</div>

<!-- Modal Tambah Akun OPD -->
<div id="modal-create-user" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 p-4 sm:p-6 flex items-center justify-center">
    <div class="w-full max-w-lg rounded-xl border border-slate-200 bg-white p-6 shadow-xl">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="text-sm font-bold text-slate-900">Tambah Akun OPD Baru</h3>
            <button type="button" onclick="document.getElementById('modal-create-user').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg leading-none">&times;</button>
        </div>

        <form method="POST" action="{{ route('users.store') }}" class="mt-4 space-y-4">
            @csrf

            <div>
                <label for="create_department" class="block text-xs font-semibold text-slate-700">Nama Organisasi Perangkat Daerah</label>
                <div class="mt-1">
                    <input type="text" id="create_department" name="department" required value="{{ old('department') }}" placeholder="Badan Perencanaan Pembangunan Daerah" class="block h-10 w-full rounded-lg border border-slate-300 px-3 text-xs text-slate-900 shadow-xs focus:border-blue-600 focus:outline-hidden focus:ring-1 focus:ring-blue-600">
                </div>
            </div>

            <div>
                <label for="create_name" class="block text-xs font-semibold text-slate-700">Nama Lengkap Operator</label>
                <div class="mt-1">
                    <input type="text" id="create_name" name="name" required value="{{ old('name') }}" placeholder="Operator Bappeda Sinjai" class="block h-10 w-full rounded-lg border border-slate-300 px-3 text-xs text-slate-900 shadow-xs focus:border-blue-600 focus:outline-hidden focus:ring-1 focus:ring-blue-600">
                </div>
            </div>

            <div>
                <label for="create_email" class="block text-xs font-semibold text-slate-700">Email Kedinasan</label>
                <div class="mt-1">
                    <input type="email" id="create_email" name="email" required value="{{ old('email') }}" placeholder="bappeda@sinjaikab.go.id" class="block h-10 w-full rounded-lg border border-slate-300 px-3 text-xs text-slate-900 shadow-xs focus:border-blue-600 focus:outline-hidden focus:ring-1 focus:ring-blue-600">
                </div>
            </div>

            <div>
                <label for="create_password" class="block text-xs font-semibold text-slate-700">Kata Sandi Awal</label>
                <div class="mt-1">
                    <input type="password" id="create_password" name="password" required minlength="8" class="block h-10 w-full rounded-lg border border-slate-300 px-3 text-xs text-slate-900 shadow-xs focus:border-blue-600 focus:outline-hidden focus:ring-1 focus:ring-blue-600">
                </div>
                <p class="mt-1 text-[11px] text-slate-500">Minimal 8 karakter kombinasi huruf dan angka</p>
            </div>

            <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('modal-create-user').classList.add('hidden')" class="inline-flex h-10 items-center justify-center rounded-lg border border-slate-300 bg-white px-4 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                    Batal
                </button>
                <button type="submit" class="inline-flex h-10 items-center justify-center rounded-lg bg-blue-600 px-4 text-xs font-semibold text-white hover:bg-blue-700">
                    Simpan Akun
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Ubah Akun OPD -->
<div id="modal-edit-user" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 p-4 sm:p-6 flex items-center justify-center">
    <div class="w-full max-w-lg rounded-xl border border-slate-200 bg-white p-6 shadow-xl">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="text-sm font-bold text-slate-900">Ubah Data Akun OPD</h3>
            <button type="button" onclick="document.getElementById('modal-edit-user').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg leading-none">&times;</button>
        </div>

        <form id="form-edit-user" method="POST" action="" class="mt-4 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="edit_user_department" class="block text-xs font-semibold text-slate-700">Nama Organisasi Perangkat Daerah</label>
                <div class="mt-1">
                    <input type="text" id="edit_user_department" name="department" required class="block h-10 w-full rounded-lg border border-slate-300 px-3 text-xs text-slate-900 shadow-xs focus:border-blue-600 focus:outline-hidden focus:ring-1 focus:ring-blue-600">
                </div>
            </div>

            <div>
                <label for="edit_user_name" class="block text-xs font-semibold text-slate-700">Nama Lengkap Operator</label>
                <div class="mt-1">
                    <input type="text" id="edit_user_name" name="name" required class="block h-10 w-full rounded-lg border border-slate-300 px-3 text-xs text-slate-900 shadow-xs focus:border-blue-600 focus:outline-hidden focus:ring-1 focus:ring-blue-600">
                </div>
            </div>

            <div>
                <label for="edit_user_email" class="block text-xs font-semibold text-slate-700">Email Kedinasan</label>
                <div class="mt-1">
                    <input type="email" id="edit_user_email" name="email" required class="block h-10 w-full rounded-lg border border-slate-300 px-3 text-xs text-slate-900 shadow-xs focus:border-blue-600 focus:outline-hidden focus:ring-1 focus:ring-blue-600">
                </div>
            </div>

            <div>
                <label for="edit_user_password" class="block text-xs font-semibold text-slate-700">Kata Sandi Baru</label>
                <div class="mt-1">
                    <input type="password" id="edit_user_password" name="password" minlength="8" placeholder="Kosongkan jika tidak ingin mengubah kata sandi" class="block h-10 w-full rounded-lg border border-slate-300 px-3 text-xs text-slate-900 shadow-xs focus:border-blue-600 focus:outline-hidden focus:ring-1 focus:ring-blue-600">
                </div>
            </div>

            <div>
                <label for="edit_user_is_active" class="block text-xs font-semibold text-slate-700">Status Akses Akun</label>
                <div class="mt-1">
                    <select id="edit_user_is_active" name="is_active" class="block h-10 w-full rounded-lg border border-slate-300 px-3 text-xs text-slate-900 shadow-xs focus:border-blue-600 focus:outline-hidden focus:ring-1 focus:ring-blue-600">
                        <option value="1">Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('modal-edit-user').classList.add('hidden')" class="inline-flex h-10 items-center justify-center rounded-lg border border-slate-300 bg-white px-4 text-xs font-semibold text-slate-700 hover:bg-slate-50">
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
    function openEditUserModal(user) {
        const form = document.getElementById('form-edit-user');
        form.action = `/users/${user.id}`;
        document.getElementById('edit_user_department').value = user.department;
        document.getElementById('edit_user_name').value = user.name;
        document.getElementById('edit_user_email').value = user.email;
        document.getElementById('edit_user_is_active').value = user.is_active ? '1' : '0';
        document.getElementById('edit_user_password').value = '';
        document.getElementById('modal-edit-user').classList.remove('hidden');
    }
</script>
@endpush
