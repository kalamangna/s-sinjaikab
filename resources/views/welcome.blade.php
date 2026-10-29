<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pemendek Tautan Resmi Kabupaten Sinjai - s.sinjaikab.go.id</title>
    <meta name="description" content="Layanan pemendekan tautan dan pembuatan kode QR untuk dokumen kedinasan Pemerintah Kabupaten Sinjai berbasis domain s.sinjaikab.go.id.">
    <meta name="author" content="Diskominfo-SP Sinjai">

    <meta property="og:type" content="website">
    <meta property="og:locale" content="id_ID">
    <meta property="og:site_name" content="Pemerintah Kabupaten Sinjai">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Pemendek Tautan Resmi Kabupaten Sinjai - s.sinjaikab.go.id">
    <meta property="og:description" content="Layanan pemendekan tautan dan pembuatan kode QR untuk dokumen kedinasan Pemerintah Kabupaten Sinjai berbasis domain s.sinjaikab.go.id.">
    <meta property="og:image" content="{{ asset('images/meta.png') }}">
    <meta property="og:image:secure_url" content="{{ asset('images/meta.png') }}">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1640">
    <meta property="og:image:height" content="924">
    <meta property="og:image:alt" content="Portal Resmi Pemerintah Kabupaten Sinjai">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="Pemendek Tautan Resmi Kabupaten Sinjai - s.sinjaikab.go.id">
    <meta name="twitter:description" content="Layanan pemendekan tautan dan pembuatan kode QR untuk dokumen kedinasan Pemerintah Kabupaten Sinjai berbasis domain s.sinjaikab.go.id.">
    <meta name="twitter:image" content="{{ asset('images/meta.png') }}">
    <meta name="twitter:image:alt" content="Portal Resmi Pemerintah Kabupaten Sinjai">

    <link rel="icon" type="image/png" href="{{ asset('images/logo-sinjai.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col font-sans text-slate-800 antialiased selection:bg-blue-600 selection:text-white">
    <header class="border-b border-slate-200 bg-white shrink-0">
        <div class="mx-auto flex h-14 max-w-5xl items-center justify-between px-4 sm:px-6">
            <a href="{{ route('home') }}" class="flex items-center gap-3 rounded-lg focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                <img src="{{ asset('images/logo-sinjai.png') }}" alt="Logo Kabupaten Sinjai" class="h-8 sm:h-9 w-auto object-contain">
                <div class="flex flex-col text-left">
                    <span class="text-sm font-bold tracking-tight text-slate-900 sm:text-base">s.sinjaikab.go.id</span>
                    <span class="text-[11px] text-slate-500">Pemerintah Kabupaten Sinjai</span>
                </div>
            </a>

            <div>
                @auth
                    <a href="{{ route('urls.index') }}" class="inline-flex h-9 items-center justify-center rounded-lg bg-blue-600 px-3.5 text-xs font-semibold text-white shadow-xs transition hover:bg-blue-700 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                        Kelola Tautan
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex h-9 items-center justify-center rounded-lg bg-blue-600 px-3.5 text-xs font-semibold text-white shadow-xs transition hover:bg-blue-700 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <main class="flex-1 flex flex-col justify-center py-6 sm:py-8 px-4 sm:px-6">
        <div class="mx-auto max-w-3xl w-full text-center space-y-6">
            <!-- Hero Ringkas -->
            <div class="space-y-3">
                <span class="inline-flex items-center rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                    Layanan Resmi Pemerintah Kabupaten Sinjai
                </span>

                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">
                    Pemendek Tautan Resmi Kabupaten Sinjai
                </h1>

                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed max-w-xl mx-auto">
                    Layanan pemendekan tautan dan pembuatan kode QR untuk dokumen kedinasan Pemerintah Kabupaten Sinjai berbasis domain s.sinjaikab.go.id.
                </p>

                <div class="pt-2 flex flex-wrap items-center justify-center gap-3">
                    @auth
                        <a href="{{ route('urls.index') }}" class="inline-flex h-10 items-center justify-center rounded-lg bg-blue-600 px-5 text-xs font-semibold text-white shadow-xs transition hover:bg-blue-700 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                            Kelola Tautan
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex h-10 items-center justify-center rounded-lg bg-blue-600 px-5 text-xs font-semibold text-white shadow-xs transition hover:bg-blue-700 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                            Login Akun ENIKDA
                        </a>
                    @endauth
                    <a href="https://sinjaikab.go.id" rel="noopener noreferrer" target="_blank" class="inline-flex h-10 items-center justify-center rounded-lg border border-slate-300 bg-white px-5 text-xs font-semibold text-slate-700 shadow-xs transition hover:bg-slate-50 focus:outline-hidden focus:ring-2 focus:ring-slate-400 focus:ring-offset-2">
                        Kunjungi Portal Sinjai
                    </a>
                </div>
            </div>

            <!-- 3 Pilar Layanan Padat -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-left">
                <div class="rounded-xl border border-slate-200 bg-white p-3.5 shadow-xs">
                    <h2 class="text-xs font-bold text-slate-900">Domain Terpercaya</h2>
                    <p class="mt-1 text-[11px] text-slate-500 leading-snug">
                        Jaminan keaslian informasi kedinasan dan perlindungan dari penipuan digital.
                    </p>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-3.5 shadow-xs">
                    <h2 class="text-xs font-bold text-slate-900">Kode QR Dokumen</h2>
                    <p class="mt-1 text-[11px] text-slate-500 leading-snug">
                        Otomatis siap unduh untuk surat edaran, pengumuman, dan publikasi cetak.
                    </p>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-3.5 shadow-xs">
                    <h2 class="text-xs font-bold text-slate-900">Statistik Kunjungan</h2>
                    <p class="mt-1 text-[11px] text-slate-500 leading-snug">
                        Pemantauan jumlah klik secara akurat untuk mengukur jangkauan publikasi.
                    </p>
                </div>
            </div>

            <p class="text-[11px] text-slate-400">
                Pengelolaan tautan khusus aparatur Pemerintah Kabupaten Sinjai melalui autentikasi akun kepegawaian ENIKDA.
            </p>
        </div>
    </main>

    <footer class="border-t border-slate-200 bg-white py-3 shrink-0">
        <div class="mx-auto max-w-5xl px-4 text-center text-xs text-slate-500 sm:px-6">
            <p>&copy; {{ date('Y') }} Diskominfo-SP Sinjai</p>
        </div>
    </footer>
</body>
</html>
