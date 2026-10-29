<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Pemkab Sinjai</title>
    <meta name="description" content="Layanan link singkat dan kode QR resmi Pemerintah Kabupaten Sinjai.">
    <meta name="author" content="Diskominfo-SP Sinjai">

    <meta property="og:type" content="website">
    <meta property="og:locale" content="id_ID">
    <meta property="og:site_name" content="Link Shortener - Pemkab Sinjai">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="404 - Pemkab Sinjai">
    <meta property="og:description" content="Layanan link singkat dan kode QR resmi Pemerintah Kabupaten Sinjai.">
    <meta property="og:image" content="{{ asset('images/meta.png') }}">
    <meta property="og:image:secure_url" content="{{ asset('images/meta.png') }}">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1640">
    <meta property="og:image:height" content="924">
    <meta property="og:image:alt" content="Link Shortener - Pemkab Sinjai">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="404 - Pemkab Sinjai">
    <meta name="twitter:description" content="Layanan link singkat dan kode QR resmi Pemerintah Kabupaten Sinjai.">
    <meta name="twitter:image" content="{{ asset('images/meta.png') }}">
    <meta name="twitter:image:alt" content="Link Shortener - Pemkab Sinjai">

    <link rel="icon" type="image/png" href="{{ asset('images/logo-sinjai.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-full flex-col justify-center py-12 px-4 sm:px-6 md:px-8 font-sans antialiased text-slate-800 text-center">
    <div class="sm:mx-auto sm:w-full sm:max-w-md md:max-w-lg">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5 sm:gap-3 rounded-lg p-1 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
            <img src="{{ asset('images/logo-sinjai.png') }}" alt="Logo Kabupaten Sinjai" class="h-8 sm:h-9 w-auto object-contain">
            <div class="flex flex-col text-left leading-tight">
                <span class="text-sm font-bold tracking-tight text-slate-900">Link Shortener</span>
                <span class="text-xs font-medium text-slate-500">Pemkab Sinjai</span>
            </div>
        </a>

        <div class="mt-6 rounded-xl border border-slate-200 bg-white p-5 sm:p-8 md:p-10 shadow-xs">
            <span class="inline-flex rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">Galat 404</span>
            <h1 class="mt-4 text-xl font-bold tracking-tight text-slate-900 sm:text-2xl">
                Link Tidak Ditemukan
            </h1>
            <p class="mt-2 text-xs text-slate-600 leading-relaxed">
                {{ $message ?? 'Link tidak terdaftar atau sudah dinonaktifkan.' }}
            </p>

            <div class="mt-6 flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="{{ route('home') }}" class="inline-flex h-11 w-full sm:w-auto items-center justify-center rounded-lg bg-blue-600 px-4 text-xs font-semibold text-white shadow-xs transition hover:bg-blue-700 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                    Buka Beranda
                </a>
                <a href="https://sinjaikab.go.id" rel="noopener noreferrer" target="_blank" class="inline-flex h-11 w-full sm:w-auto items-center justify-center rounded-lg border border-slate-300 bg-white px-4 text-xs font-semibold text-slate-700 transition hover:bg-slate-50 focus:outline-hidden focus:ring-2 focus:ring-slate-400 focus:ring-offset-2">
                    Kunjungi Portal Sinjai
                </a>
            </div>
        </div>

        <p class="mt-6 text-xs text-slate-400">
            &copy; {{ date('Y') }} Diskominfo-SP Sinjai
        </p>
    </div>
</body>
</html>
