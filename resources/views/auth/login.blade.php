<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Shortener Sinjaikab</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-sinjai.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8 font-sans antialiased text-slate-800">
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-3 focus:outline-hidden">
            <img src="{{ asset('images/logo-sinjai.png') }}" alt="Logo Kabupaten Sinjai" class="h-12 w-auto object-contain">
        </a>
        <h2 class="mt-4 text-2xl font-bold tracking-tight text-slate-900">
            Masuk Layanan Tautan Sinjaikab
        </h2>
        <p class="mt-1 text-xs text-slate-500">
            Terhubung Gateway ENIKDA untuk ASN dan Akun Administrator Diskominfo
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md px-4 sm:px-0">
        <div class="border border-slate-200 bg-white p-6 shadow-xs rounded-xl sm:p-8">
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="identifier" class="block text-xs font-semibold text-slate-700">NIP atau Email Kedinasan</label>
                    <div class="mt-1">
                        <input id="identifier" name="identifier" type="text" autocomplete="username" required value="{{ old('identifier') }}" placeholder="198507102010011005 atau admin@sinjaikab.go.id" class="block h-11 w-full rounded-lg border {{ $errors->has('identifier') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : 'border-slate-300 focus:border-blue-600 focus:ring-blue-600' }} px-3 text-sm text-slate-900 shadow-xs focus:outline-hidden focus:ring-1">
                    </div>
                    @error('identifier')
                        <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-700">Kata Sandi</label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" autocomplete="current-password" required class="block h-11 w-full rounded-lg border {{ $errors->has('password') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500' : 'border-slate-300 focus:border-blue-600 focus:ring-blue-600' }} px-3 text-sm text-slate-900 shadow-xs focus:outline-hidden focus:ring-1">
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-xs text-slate-600 select-none">Ingat perangkat ini</span>
                    </label>
                </div>

                <div>
                    <button type="submit" data-loading-text="Memproses Login..." class="flex h-11 w-full items-center justify-center rounded-lg bg-blue-600 px-4 text-sm font-semibold text-white shadow-xs transition hover:bg-blue-700 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                        Login
                    </button>
                </div>
            </form>

            <div class="mt-6 border-t border-slate-100 pt-4 text-center">
                <p class="text-xs text-slate-500">
                    Pegawai ASN dapat masuk langsung menggunakan NIP dan kata sandi akun ENIKDA
                </p>
            </div>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('home') }}" class="text-xs font-medium text-slate-500 hover:text-slate-800">
                Kembali ke Beranda
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
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
