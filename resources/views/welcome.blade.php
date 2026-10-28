<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pemendek Tautan Sinjai - s.sinjaikab.go.id</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-sinjai.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-full flex-col font-sans text-slate-800 antialiased selection:bg-blue-600 selection:text-white">
    <header class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex h-16 max-w-5xl items-center justify-between px-4 sm:px-6">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo-sinjai.png') }}" alt="Logo Kabupaten Sinjai" class="h-9 w-auto object-contain">
                <div>
                    <span class="block text-sm font-bold tracking-tight text-slate-900 sm:text-base">s.sinjaikab.go.id</span>
                    <span class="block text-xs text-slate-500">Pemkab Sinjai</span>
                </div>
            </div>

            <div>
                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex h-10 items-center justify-center rounded-lg bg-blue-600 px-4 text-xs font-semibold text-white shadow-xs transition hover:bg-blue-700 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                        Buka Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex h-10 items-center justify-center rounded-lg bg-blue-600 px-4 text-xs font-semibold text-white shadow-xs transition hover:bg-blue-700 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <main class="flex-1 flex items-center justify-center py-16 px-4 sm:px-6">
        <div class="max-w-2xl text-center">
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">
                Pemendek Tautan Resmi Sinjai
            </h1>

            <p class="mt-4 text-sm sm:text-base text-slate-600 leading-relaxed">
                Layanan resmi Pemerintah Kabupaten Sinjai untuk memendekkan tautan dan membuat kode QR dokumen kedinasan berbasis domain s.sinjaikab.go.id.
            </p>

            <div class="mt-8 flex items-center justify-center gap-3">
                @auth
                    <a href="{{ route('urls.index') }}" class="inline-flex h-11 items-center justify-center rounded-lg bg-blue-600 px-6 text-xs font-semibold text-white shadow-xs transition hover:bg-blue-700 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                        Kelola Tautan
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex h-11 items-center justify-center rounded-lg bg-blue-600 px-6 text-xs font-semibold text-white shadow-xs transition hover:bg-blue-700 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                        Login
                    </a>
                @endauth
                <a href="https://sinjaikab.go.id" rel="noopener noreferrer" target="_blank" class="inline-flex h-11 items-center justify-center rounded-lg border border-slate-300 bg-white px-6 text-xs font-semibold text-slate-700 shadow-xs transition hover:bg-slate-50 focus:outline-hidden focus:ring-2 focus:ring-slate-400 focus:ring-offset-2">
                    Kunjungi Portal Sinjai
                </a>
            </div>
        </div>
    </main>

    <footer class="border-t border-slate-200 bg-white py-6">
        <div class="mx-auto max-w-5xl px-4 text-center text-xs text-slate-500 sm:px-6">
            <p>Diskominfo Sinjai • Layanan Tautan Resmi s.sinjaikab.go.id</p>
        </div>
    </footer>
</body>
</html>
