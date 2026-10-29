<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Pemkab Sinjai</title>
    <meta name="description" content="Layanan link singkat dan kode QR resmi Pemerintah Kabupaten Sinjai.">
    <meta name="author" content="Diskominfo-SP Sinjai">

    <meta property="og:type" content="website">
    <meta property="og:locale" content="id_ID">
    <meta property="og:site_name" content="Link Shortener - Pemkab Sinjai">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Login - Pemkab Sinjai">
    <meta property="og:description" content="Layanan link singkat dan kode QR resmi Pemerintah Kabupaten Sinjai.">
    <meta property="og:image" content="{{ asset('images/meta.png') }}">
    <meta property="og:image:secure_url" content="{{ asset('images/meta.png') }}">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1640">
    <meta property="og:image:height" content="924">
    <meta property="og:image:alt" content="Link Shortener - Pemkab Sinjai">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="Login - Pemkab Sinjai">
    <meta name="twitter:description" content="Layanan link singkat dan kode QR resmi Pemerintah Kabupaten Sinjai.">
    <meta name="twitter:image" content="{{ asset('images/meta.png') }}">
    <meta name="twitter:image:alt" content="Link Shortener - Pemkab Sinjai">

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-full flex-col justify-center py-12 px-4 sm:px-6 md:px-8 font-sans antialiased text-slate-800">
    <div class="sm:mx-auto sm:w-full sm:max-w-md md:max-w-sm">
        <div class="text-center">
            <a href="{{ route('home') }}" class="inline-flex rounded-lg focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Kabupaten Sinjai" class="h-11 w-auto object-contain">
            </a>
            <h1 class="mt-4 text-xl sm:text-2xl font-bold tracking-tight text-slate-900">
                Login Akun ENIKDA
            </h1>
        </div>

        <div class="mt-6 rounded-xl border border-slate-200 bg-white p-5 sm:p-7 md:p-8 shadow-xs">
            @if(session('error') || $errors->any())
                <div class="mb-4 flex items-start gap-2.5 rounded-lg border border-rose-200 bg-rose-50 p-3 text-xs text-rose-800" role="alert">
                    <svg class="h-4 w-4 text-rose-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div class="font-medium space-y-0.5">
                        @if(session('error'))
                            <p>{{ session('error') }}</p>
                        @endif
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="identifier" class="block text-xs font-semibold text-slate-700 mb-1">NIP</label>
                    <input id="identifier" name="identifier" type="text" autocomplete="username" required autofocus value="{{ old('identifier') }}" placeholder="18 digit NIP" class="block h-11 w-full rounded-lg border {{ $errors->has('identifier') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : 'border-slate-300 focus:border-blue-600 focus:ring-blue-600' }} px-3 text-base sm:text-xs text-slate-900 shadow-xs focus:outline-hidden focus:ring-1">
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-700 mb-1">Password</label>
                    <div class="relative">
                        <input id="password" name="password" type="password" autocomplete="current-password" required placeholder="••••••••" class="block h-11 w-full rounded-lg border {{ $errors->has('password') || $errors->has('identifier') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : 'border-slate-300 focus:border-blue-600 focus:ring-blue-600' }} pl-3 pr-11 text-base sm:text-xs text-slate-900 shadow-xs focus:outline-hidden focus:ring-1">
                        <button type="button" id="togglePassword" aria-label="Tampilkan password" class="absolute inset-y-0 right-0 flex h-11 w-11 items-center justify-center text-slate-400 hover:text-slate-600 focus:outline-hidden focus:text-blue-600">
                            <svg id="eyeIcon" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="eyeSlashIcon" class="h-4 w-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="pt-1">
                    <button type="submit" data-loading-text="Memverifikasi..." class="flex h-11 w-full items-center justify-center gap-1.5 rounded-lg bg-blue-600 px-4 text-xs font-semibold text-white shadow-xs transition hover:bg-blue-700 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                        <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Login
                    </button>
                </div>
            </form>
        </div>

        <div class="mt-5 text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-500 hover:text-slate-800 transition">
                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleBtn = document.getElementById('togglePassword');
            if (toggleBtn) {
                toggleBtn.addEventListener('click', function () {
                    const input = document.getElementById('password');
                    const eyeIcon = document.getElementById('eyeIcon');
                    const eyeSlashIcon = document.getElementById('eyeSlashIcon');
                    if (!input) return;

                    const isPassword = input.type === 'password';
                    input.type = isPassword ? 'text' : 'password';
                    this.setAttribute('aria-label', isPassword ? 'Sembunyikan password' : 'Tampilkan password');
                    eyeIcon?.classList.toggle('hidden', isPassword);
                    eyeSlashIcon?.classList.toggle('hidden', !isPassword);
                });
            }

            const form = document.querySelector('form');
            if (form) {
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
                        const loadingLabel = submitBtn.dataset.loadingText || 'Memproses...';
                        submitBtn.textContent = loadingLabel;
                    }
                });
            }
        });
    </script>
</body>
</html>
