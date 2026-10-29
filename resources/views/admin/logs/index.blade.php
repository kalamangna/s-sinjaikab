@extends('layouts.app')

@section('title', 'Log Aktivitas')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-xl font-bold tracking-tight text-slate-900 sm:text-2xl">Log Aktivitas</h1>
            <p class="text-xs text-slate-500 mt-1">Rekaman kronologis aktivitas operasional pengguna pada sistem</p>
        </div>

        <div class="text-xs text-slate-500 font-medium">
            Masa simpan log: 30 hari terakhir
        </div>
    </div>

    @if($logs->isEmpty())
        <div class="rounded-xl border border-slate-200 bg-white p-8 sm:p-12 text-center shadow-xs">
            <p class="text-sm font-semibold text-slate-700">Belum ada log aktivitas tercatat</p>
        </div>
    @else
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-xs">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="border-b border-slate-200 bg-slate-50 text-[11px] font-semibold text-slate-700 uppercase tracking-wider">
                        <tr>
                            <th scope="col" class="py-3.5 px-4 whitespace-nowrap">Waktu</th>
                            <th scope="col" class="py-3.5 px-4 whitespace-nowrap">Pengguna</th>
                            <th scope="col" class="py-3.5 px-4 whitespace-nowrap">Aksi</th>
                            <th scope="col" class="py-3.5 px-4">Keterangan</th>
                            <th scope="col" class="py-3.5 px-4 whitespace-nowrap">Alamat IP</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach($logs as $log)
                            <tr class="hover:bg-slate-50/75 transition">
                                <td class="py-3.5 px-4 whitespace-nowrap font-medium text-slate-900">
                                    {{ $log->created_at ? $log->created_at->translatedFormat('d M Y, H:i:s') : '-' }}
                                </td>
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    @if($log->user)
                                        <p class="font-semibold text-slate-900">{{ $log->user->name }}</p>
                                        <p class="text-[11px] text-slate-500">{{ $log->user->isAdmin() ? 'Administrator' : ($log->user->department ?? 'OPD') }}</p>
                                    @else
                                        <span class="text-slate-400">Pengguna Terhapus</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    <span class="inline-flex items-center rounded-md px-2 py-1 text-[11px] font-semibold {{ $log->action_badge_class }}">
                                        {{ $log->action_label }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-slate-700 break-words max-w-md">
                                    {{ $log->description }}
                                </td>
                                <td class="py-3.5 px-4 whitespace-nowrap font-mono text-[11px] text-slate-500">
                                    {{ $log->ip_address ?: '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($logs->hasPages())
                <div class="border-t border-slate-200 p-4">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>
    @endif
</div>
@endsection
