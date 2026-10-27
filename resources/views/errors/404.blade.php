<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tautan Tidak Ditemukan - s.sinjaikab.go.id</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-sinjai.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8 font-sans antialiased text-slate-800 text-center">
    <div class="sm:mx-auto sm:w-full sm:max-w-md px-4">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-3 focus:outline-hidden">
            <img src="{{ asset('images/logo-sinjai.png') }}" alt="Logo Kabupaten Sinjai" class="h-14 w-auto object-contain mx-auto">
        </a>

        <div class="mt-6 rounded-2xl border border-slate-200 bg-white p-8 shadow-xs">
            <span class="inline-flex rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">Galat 404</span>
            <h1 class="mt-4 text-xl font-bold tracking-tight text-slate-900 sm:text-2xl">
                Tautan Pendek Tidak Ditemukan
            </h1>
            <p class="mt-2 text-xs text-slate-600 leading-relaxed">
                {{ $message ?? 'Alamat tautan pendek yang Anda tuju tidak terdaftar atau telah dinonaktifkan oleh unit kerja pengelola.' }}
            </p>

            <div class="mt-6 flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="{{ route('home') }}" class="inline-flex h-10 w-full sm:w-auto items-center justify-center rounded-lg bg-blue-600 px-4 text-xs font-semibold text-white shadow-xs transition hover:bg-blue-700 focus:outline-hidden">
                    Kembali ke Beranda
                </a>
                <a href="https://sinjaikab.go.id" rel="noopener noreferrer" target="_blank" class="inline-flex h-10 w-full sm:w-auto items-center justify-center rounded-lg border border-slate-300 bg-white px-4 text-xs font-semibold text-slate-700 transition hover:bg-slate-50 focus:outline-hidden">
                    Kunjungi Portal Sinjai
                </a>
            </div>
        </div>

        <p class="mt-6 text-xs text-slate-400">
            Layanan Resmi s.sinjaikab.go.id • Pemerintah Kabupaten Sinjai
        </p>
    </div>
</body>
</html>
