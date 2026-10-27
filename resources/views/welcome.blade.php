<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Layanan Tautan Pendek Resmi - Pemerintah Kabupaten Sinjai</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-sinjai.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-full flex-col font-sans text-slate-800 antialiased selection:bg-blue-600 selection:text-white">
    <header class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo-sinjai.png') }}" alt="Logo Kabupaten Sinjai" class="h-10 w-auto object-contain">
                <div>
                    <span class="block text-sm font-bold tracking-tight text-slate-900 sm:text-base">s.sinjaikab.go.id</span>
                    <span class="block text-xs text-slate-500">Pemerintah Kabupaten Sinjai</span>
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

    <main class="flex-1">
        <section class="border-b border-slate-200 bg-white py-16 sm:py-24">
            <div class="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
                <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 shadow-xs">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                    </svg>
                </div>

                <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl lg:text-5xl">
                    Layanan Pemendek Tautan Resmi Pemerintah Kabupaten Sinjai
                </h1>

                <p class="mx-auto mt-4 max-w-2xl text-base text-slate-600 sm:text-lg">
                    Platform terpadu untuk memendekkan alamat web dinas, dokumen publik, dan publikasi resmi dengan subdomain terpercaya s.sinjaikab.go.id.
                </p>

                <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                    @auth
                        <a href="{{ route('urls.index') }}" class="inline-flex h-11 items-center justify-center rounded-lg bg-blue-600 px-6 text-sm font-semibold text-white shadow-xs transition hover:bg-blue-700 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                            Kelola Tautan
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex h-11 items-center justify-center rounded-lg bg-blue-600 px-6 text-sm font-semibold text-white shadow-xs transition hover:bg-blue-700 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                            Masuk Akun OPD
                        </a>
                    @endauth
                    <a href="https://sinjaikab.go.id" rel="noopener noreferrer" target="_blank" class="inline-flex h-11 items-center justify-center rounded-lg border border-slate-300 bg-white px-6 text-sm font-semibold text-slate-700 shadow-xs transition hover:bg-slate-50 focus:outline-hidden focus:ring-2 focus:ring-slate-400 focus:ring-offset-2">
                        Kunjungi Portal Sinjai
                    </a>
                </div>
            </div>
        </section>

        <section class="py-12 sm:py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs">
                        <div class="mb-4 inline-flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="text-base font-semibold text-slate-900">Identitas Resmi Terpercaya</h3>
                        <p class="mt-2 text-xs text-slate-600 leading-relaxed">
                            Mencegah kecurigaan penipuan daring dengan memastikan tautan bersumber langsung dari domain resmi Pemerintah Kabupaten Sinjai.
                        </p>
                    </div>

                    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs">
                        <div class="mb-4 inline-flex h-10 w-10 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                            </svg>
                        </div>
                        <h3 class="text-base font-semibold text-slate-900">Generator Kode QR Otomatis</h3>
                        <p class="mt-2 text-xs text-slate-600 leading-relaxed">
                            Setiap tautan yang dibuat siap diunduh dalam format vektor SVG untuk kebutuhan media cetak, surat edaran, spanduk, atau publikasi baliho.
                        </p>
                    </div>

                    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs">
                        <div class="mb-4 inline-flex h-10 w-10 items-center justify-center rounded-lg bg-amber-50 text-amber-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-base font-semibold text-slate-900">Pengalihan Cepat dan Ringan</h3>
                        <p class="mt-2 text-xs text-slate-600 leading-relaxed">
                            Proses pengalihan instan dengan pencatatan klik yang terukur tanpa memperlambat kecepatan akses pengguna ke alamat tujuan.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="border-t border-slate-200 bg-white py-6">
        <div class="mx-auto max-w-7xl px-4 text-center text-xs text-slate-500 sm:px-6 lg:px-8">
            <p>Pemerintah Kabupaten Sinjai • Dinas Komunikasi Informatika dan Persandian</p>
            <p class="mt-1 text-slate-400">Layanan Tautan Resmi s.sinjaikab.go.id</p>
        </div>
    </footer>
</body>
</html>
