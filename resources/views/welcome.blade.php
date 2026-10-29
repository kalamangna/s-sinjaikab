<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Link Shortener - Pemkab Sinjai</title>
    <meta name="description" content="Layanan link singkat dan kode QR resmi Pemerintah Kabupaten Sinjai.">
    <meta name="author" content="Diskominfo-SP Sinjai">

    <meta property="og:type" content="website">
    <meta property="og:locale" content="id_ID">
    <meta property="og:site_name" content="Link Shortener - Pemkab Sinjai">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Link Shortener - Pemkab Sinjai">
    <meta property="og:description" content="Layanan link singkat dan kode QR resmi Pemerintah Kabupaten Sinjai.">
    <meta property="og:image" content="{{ asset('images/meta.png') }}">
    <meta property="og:image:secure_url" content="{{ asset('images/meta.png') }}">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1640">
    <meta property="og:image:height" content="924">
    <meta property="og:image:alt" content="Link Shortener - Pemkab Sinjai">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="Link Shortener - Pemkab Sinjai">
    <meta name="twitter:description" content="Layanan link singkat dan kode QR resmi Pemerintah Kabupaten Sinjai.">
    <meta name="twitter:image" content="{{ asset('images/meta.png') }}">
    <meta name="twitter:image:alt" content="Link Shortener - Pemkab Sinjai">

    <link rel="icon" type="image/png" href="{{ asset('images/logo-sinjai.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col font-sans text-slate-800 antialiased selection:bg-blue-600 selection:text-white">
    <header class="border-b border-slate-200 bg-white shrink-0">
        <div class="mx-auto flex h-14 max-w-5xl items-center justify-between px-4 sm:px-6">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 sm:gap-3 rounded-lg focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                <img src="{{ asset('images/logo-sinjai.png') }}" alt="Logo Kabupaten Sinjai" class="h-8 sm:h-9 w-auto object-contain">
                <div class="flex flex-col text-left leading-tight">
                    <span class="text-sm font-bold tracking-tight text-slate-900">Link Shortener</span>
                    <span class="text-xs font-medium text-slate-500">Pemkab Sinjai</span>
                </div>
            </a>

            <div>
                @auth
                    <a href="{{ route('urls.index') }}" class="inline-flex h-9 items-center justify-center rounded-lg bg-blue-600 px-3.5 text-xs font-semibold text-white shadow-xs transition hover:bg-blue-700 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                        Kelola Link
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex h-9 items-center justify-center rounded-lg bg-blue-600 px-3.5 text-xs font-semibold text-white shadow-xs transition hover:bg-blue-700 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <main class="flex-1 flex flex-col justify-center py-8 sm:py-14 md:py-20 px-4 sm:px-6 md:px-8">
        <div class="mx-auto max-w-xl md:max-w-2xl w-full">
            <div class="rounded-xl border border-slate-200 bg-white p-5 sm:p-8 md:p-10 shadow-xs text-center space-y-5 sm:space-y-6">
                <h1 class="text-xl sm:text-2xl md:text-3xl font-extrabold tracking-tight text-slate-900 leading-tight">
                    Link Shortener - Pemkab Sinjai
                </h1>

                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Layanan link singkat dan kode QR resmi Pemerintah Kabupaten Sinjai.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-3 pt-1">
                    @auth
                        <a href="{{ route('urls.index') }}" class="inline-flex h-11 w-full sm:w-auto items-center justify-center rounded-lg bg-blue-600 px-5 text-xs sm:text-sm font-semibold text-white shadow-xs transition hover:bg-blue-700 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                            Kelola Link
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex h-11 w-full sm:w-auto items-center justify-center rounded-lg bg-blue-600 px-5 text-xs sm:text-sm font-semibold text-white shadow-xs transition hover:bg-blue-700 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                            Login Akun ENIKDA
                        </a>
                    @endauth
                    <a href="https://sinjaikab.go.id" rel="noopener noreferrer" target="_blank" class="inline-flex h-11 w-full sm:w-auto items-center justify-center rounded-lg border border-slate-300 bg-white px-5 text-xs sm:text-sm font-semibold text-slate-700 shadow-xs transition hover:bg-slate-50 focus:outline-hidden focus:ring-2 focus:ring-slate-400 focus:ring-offset-2">
                        Kunjungi Portal Sinjai
                    </a>
                </div>

                <div class="border-t border-slate-100 pt-4">
                    <p class="text-xs text-slate-400">
                        Khusus aparatur Pemerintah Kabupaten Sinjai via ENIKDA.
                    </p>
                </div>
            </div>
        </div>
    </main>

    <footer class="border-t border-slate-200 bg-white py-3 shrink-0">
        <div class="mx-auto max-w-5xl px-4 text-center text-xs text-slate-500 sm:px-6">
            <p>&copy; {{ date('Y') }} Diskominfo-SP Sinjai</p>
        </div>
    </footer>
</body>
</html>
