<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Shortener Sinjaikab') - Layanan Tautan Pendek Resmi</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-sinjai.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-full flex-col font-sans text-slate-800 antialiased selection:bg-blue-600 selection:text-white">
    <header class="sticky top-0 z-40 border-b border-slate-200 bg-white shadow-xs">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                    <img src="{{ asset('images/logo-sinjai.png') }}" alt="Logo Kabupaten Sinjai" class="h-9 w-auto object-contain">
                    <div class="flex flex-col">
                        <span class="text-sm font-bold tracking-tight text-slate-900 sm:text-base">s.sinjaikab.go.id</span>
                        <span class="text-xs text-slate-500">Layanan Tautan Pemkab Sinjai</span>
                    </div>
                </a>

                <nav class="hidden md:ml-8 md:flex md:items-center md:gap-1">
                    <a href="{{ route('dashboard') }}" class="rounded-md px-3 py-2 text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('urls.index') }}" class="rounded-md px-3 py-2 text-sm font-medium transition {{ request()->routeIs('urls.*') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        Kelola Tautan
                    </a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('users.index') }}" class="rounded-md px-3 py-2 text-sm font-medium transition {{ request()->routeIs('users.*') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            Kelola Akun OPD
                        </a>
                    @endif
                </nav>
            </div>

            <div class="flex items-center gap-3">
                <div class="hidden text-right sm:block">
                    <p class="text-xs font-semibold text-slate-800">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-500">{{ auth()->user()->department ?? 'Administrator' }}</p>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex h-10 items-center justify-center rounded-lg border border-slate-300 bg-white px-3.5 text-xs font-semibold text-slate-700 transition hover:bg-slate-50 hover:text-red-600 focus:outline-hidden focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <nav class="flex border-t border-slate-100 px-4 py-2 md:hidden overflow-x-auto gap-2 bg-slate-50">
            <a href="{{ route('dashboard') }}" class="inline-flex h-10 items-center whitespace-nowrap rounded-md px-3 text-xs font-medium {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'bg-white text-slate-700 border border-slate-200' }}">
                Dashboard
            </a>
            <a href="{{ route('urls.index') }}" class="inline-flex h-10 items-center whitespace-nowrap rounded-md px-3 text-xs font-medium {{ request()->routeIs('urls.*') ? 'bg-blue-600 text-white' : 'bg-white text-slate-700 border border-slate-200' }}">
                Kelola Tautan
            </a>
            @if(auth()->user()->isAdmin())
                <a href="{{ route('users.index') }}" class="inline-flex h-10 items-center whitespace-nowrap rounded-md px-3 text-xs font-medium {{ request()->routeIs('users.*') ? 'bg-blue-600 text-white' : 'bg-white text-slate-700 border border-slate-200' }}">
                    Kelola Akun OPD
                </a>
            @endif
        </nav>
    </header>

    <main class="flex-1 pb-12 pt-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 flex items-center justify-between rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800 shadow-xs" role="alert">
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-rose-800 shadow-xs" role="alert">
                    <p class="text-sm font-semibold">Terdapat kendala pada isian Anda:</p>
                    <ul class="mt-1 list-inside list-disc text-xs space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer class="mt-auto border-t border-slate-200 bg-white py-6">
        <div class="mx-auto max-w-7xl px-4 text-center text-xs text-slate-500 sm:px-6 lg:px-8">
            <p>Pemerintah Kabupaten Sinjai • Dinas Komunikasi Informatika dan Persandian</p>
            <p class="mt-1 text-slate-400">Domain Resmi s.sinjaikab.go.id</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
