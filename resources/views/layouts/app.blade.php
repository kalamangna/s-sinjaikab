<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Link Shortener') - Pemkab Sinjai</title>
    <meta name="description" content="Layanan link singkat dan kode QR resmi Pemerintah Kabupaten Sinjai.">
    <meta name="author" content="Diskominfo-SP Sinjai">

    <meta property="og:type" content="website">
    <meta property="og:locale" content="id_ID">
    <meta property="og:site_name" content="Link Shortener - Pemkab Sinjai">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Link Shortener') - Pemkab Sinjai">
    <meta property="og:description" content="Layanan link singkat dan kode QR resmi Pemerintah Kabupaten Sinjai.">
    <meta property="og:image" content="{{ asset('images/meta.png') }}">
    <meta property="og:image:secure_url" content="{{ asset('images/meta.png') }}">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1640">
    <meta property="og:image:height" content="924">
    <meta property="og:image:alt" content="Link Shortener - Pemkab Sinjai">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="@yield('title', 'Link Shortener') - Pemkab Sinjai">
    <meta name="twitter:description" content="Layanan link singkat dan kode QR resmi Pemerintah Kabupaten Sinjai.">
    <meta name="twitter:image" content="{{ asset('images/meta.png') }}">
    <meta name="twitter:image:alt" content="Link Shortener - Pemkab Sinjai">

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-full flex-col font-sans text-slate-800 antialiased selection:bg-blue-600 selection:text-white">
    <header class="sticky top-0 z-40 border-b border-slate-200 bg-white shadow-xs">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-6">
                <a href="{{ route('urls.index') }}" class="flex items-center gap-2.5 sm:gap-3 rounded-lg focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 shrink-0">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Kabupaten Sinjai" class="h-8 sm:h-9 w-auto object-contain shrink-0">
                    <div class="flex flex-col text-left leading-tight shrink-0">
                        <span class="text-sm font-bold tracking-tight text-slate-900">Link Shortener</span>
                        <span class="text-xs font-medium text-slate-500">Pemkab Sinjai</span>
                    </div>
                </a>

                @if(auth()->check() && auth()->user()->isAdmin())
                    <nav class="hidden md:flex items-center gap-1.5" aria-label="Navigasi Utama">
                        <a href="{{ route('urls.index') }}" class="inline-flex h-9 items-center gap-1.5 rounded-lg px-3.5 text-xs font-semibold transition {{ request()->routeIs('urls.*') ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-600/20' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <svg class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                            </svg>
                            Kelola Link
                        </a>
                        <a href="{{ route('admin.logs.index') }}" class="inline-flex h-9 items-center gap-1.5 rounded-lg px-3.5 text-xs font-semibold transition {{ request()->routeIs('admin.logs.*') ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-600/20' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <svg class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            Log Aktivitas
                        </a>
                    </nav>
                @endif
            </div>

            <div class="flex items-center gap-3">
                <div class="hidden text-right sm:block max-w-xs md:max-w-sm truncate">
                    <p class="text-xs font-semibold text-slate-800 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-500 truncate">{{ auth()->user()->isAdmin() ? 'Administrator' : (auth()->user()->department ?? 'Pemerintah Kabupaten Sinjai') }}</p>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="inline shrink-0">
                    @csrf
                    <button type="submit" class="inline-flex h-10 items-center justify-center gap-1.5 rounded-lg border border-slate-300 bg-white px-3 text-xs font-semibold text-slate-700 transition hover:bg-slate-50 hover:text-rose-600 focus:outline-hidden focus:ring-2 focus:ring-rose-500 focus:ring-offset-2">
                        <svg class="h-3.5 w-3.5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>

        @if(auth()->check() && auth()->user()->isAdmin())
            <div class="border-t border-slate-200 bg-slate-50/80 px-4 py-2 md:hidden">
                <nav class="grid grid-cols-2 gap-2" aria-label="Navigasi Ponsel">
                    <a href="{{ route('urls.index') }}" class="inline-flex h-10 items-center justify-center gap-1.5 rounded-lg px-3 text-xs font-semibold transition {{ request()->routeIs('urls.*') ? 'bg-white text-blue-700 shadow-xs ring-1 ring-blue-600/20' : 'text-slate-600 hover:bg-white hover:text-slate-900' }}">
                        <svg class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                        </svg>
                        Kelola Link
                    </a>
                    <a href="{{ route('admin.logs.index') }}" class="inline-flex h-10 items-center justify-center gap-1.5 rounded-lg px-3 text-xs font-semibold transition {{ request()->routeIs('admin.logs.*') ? 'bg-white text-blue-700 shadow-xs ring-1 ring-blue-600/20' : 'text-slate-600 hover:bg-white hover:text-slate-900' }}">
                        <svg class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        Log Aktivitas
                    </a>
                </nav>
            </div>
        @endif
    </header>

    <!-- Notifikasi Mengambang (Floating Toast) -->
    <div id="toast-container" class="fixed {{ auth()->check() && auth()->user()->isAdmin() ? 'top-28 md:top-20' : 'top-20' }} right-4 left-4 sm:left-auto sm:right-6 z-50 flex flex-col gap-2 sm:max-w-sm sm:w-full pointer-events-none">
        @if(session('success'))
            <div id="toast-success" class="pointer-events-auto flex items-start justify-between rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-900 shadow-lg transition-opacity duration-300" role="status">
                <div class="flex items-start gap-3">
                    <svg class="h-5 w-5 text-emerald-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <div>
                        <p class="text-xs font-bold text-emerald-900">Berhasil</p>
                        <p class="text-xs text-emerald-800 mt-0.5">{{ session('success') }}</p>
                    </div>
                </div>
                <button type="button" onclick="dismissToast('toast-success')" aria-label="Tutup pemberitahuan" class="text-emerald-700 hover:text-emerald-900 text-lg leading-none p-1 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 rounded">
                    &times;
                </button>
            </div>
        @endif

        @if(session('error'))
            <div id="toast-session-error" class="pointer-events-auto flex items-start justify-between rounded-xl border border-rose-200 bg-rose-50 p-4 text-rose-900 shadow-lg transition-opacity duration-300" role="alert">
                <div class="flex items-start gap-3">
                    <svg class="h-5 w-5 text-rose-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div>
                        <p class="text-xs font-bold text-rose-900">Kendala</p>
                        <p class="text-xs text-rose-800 mt-0.5">{{ session('error') }}</p>
                    </div>
                </div>
                <button type="button" onclick="dismissToast('toast-session-error')" aria-label="Tutup pemberitahuan kendala" class="text-rose-700 hover:text-rose-900 text-lg leading-none p-1 focus:outline-hidden focus:ring-2 focus:ring-rose-500 rounded">
                    &times;
                </button>
            </div>
        @endif
    </div>

    <main class="flex-1 pb-12 pt-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>

    <footer class="mt-auto border-t border-slate-200 bg-white py-6">
        <div class="mx-auto max-w-7xl px-4 text-center text-xs text-slate-500 sm:px-6 lg:px-8">
            <p>&copy; {{ date('Y') }} Diskominfo-SP Sinjai</p>
        </div>
    </footer>

    <script>
        function dismissToast(id) {
            const toast = document.getElementById(id);
            if (toast) {
                toast.classList.add('opacity-0');
                setTimeout(() => toast.remove(), 300);
            }
        }

        // Salin Link Satu Ketukan Global
        function copyShortLink(text, buttonElement) {
            navigator.clipboard.writeText(text).then(() => {
                const originalHtml = buttonElement.innerHTML;
                buttonElement.innerHTML = `
                    <svg class="h-3.5 w-3.5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Link Tersalin</span>
                `;
                buttonElement.classList.remove('text-slate-700', 'bg-white');
                buttonElement.classList.add('text-emerald-700', 'bg-emerald-50', 'border-emerald-300');

                setTimeout(() => {
                    buttonElement.innerHTML = originalHtml;
                    buttonElement.classList.remove('text-emerald-700', 'bg-emerald-50', 'border-emerald-300');
                    buttonElement.classList.add('text-slate-700', 'bg-white');
                }, 2000);
            });
        }

        // Auto-dismiss toast setelah 5 detik
        setTimeout(() => {
            ['toast-success', 'toast-error'].forEach(id => {
                const toast = document.getElementById(id);
                if (toast) {
                    toast.classList.add('opacity-0');
                    setTimeout(() => toast.remove(), 300);
                }
            });
        }, 5000);

        // Pencegahan Klik Ganda & Penutupan Modal dengan ESC
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function (e) {
                    if (this.dataset.submitting === 'true') {
                        e.preventDefault();
                        return;
                    }
                    const submitBtn = this.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        this.dataset.submitting = 'true';
                        submitBtn.disabled = true;
                        submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
                        const loadingLabel = submitBtn.dataset.loadingText || 'Menyimpan...';
                        submitBtn.dataset.originalHtml = submitBtn.innerHTML;
                        submitBtn.textContent = loadingLabel;
                    }
                });
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    document.querySelectorAll('#modal-create-url, #modal-edit-url, #modal-qr-preview').forEach(modal => {
                        modal.classList.add('hidden');
                    });
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
