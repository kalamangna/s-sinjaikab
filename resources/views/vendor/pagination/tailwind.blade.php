@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navigasi Halaman" class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-2">
        {{-- Tampilan Ponsel --}}
        <div class="flex w-full items-center justify-between gap-2 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="inline-flex h-10 flex-1 items-center justify-center rounded-lg border border-slate-200 bg-slate-50 px-3 text-xs font-medium text-slate-400 cursor-not-allowed">
                    Sebelumnya
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex h-10 flex-1 items-center justify-center rounded-lg border border-slate-300 bg-white px-3 text-xs font-semibold text-slate-700 transition hover:bg-slate-50 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                    Sebelumnya
                </a>
            @endif

            <span class="px-2 text-xs font-medium text-slate-600 shrink-0">
                Hal {{ $paginator->currentPage() }} dari {{ $paginator->lastPage() }}
            </span>

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex h-10 flex-1 items-center justify-center rounded-lg border border-slate-300 bg-white px-3 text-xs font-semibold text-slate-700 transition hover:bg-slate-50 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                    Berikutnya
                </a>
            @else
                <span class="inline-flex h-10 flex-1 items-center justify-center rounded-lg border border-slate-200 bg-slate-50 px-3 text-xs font-medium text-slate-400 cursor-not-allowed">
                    Berikutnya
                </span>
            @endif
        </div>

        {{-- Ringkasan Data Desktop --}}
        <div class="hidden sm:block">
            <p class="text-xs text-slate-500">
                Menampilkan
                <span class="font-semibold text-slate-800">{{ $paginator->firstItem() }}</span>
                sampai
                <span class="font-semibold text-slate-800">{{ $paginator->lastItem() }}</span>
                dari
                <span class="font-semibold text-slate-800">{{ $paginator->total() }}</span>
                data
            </p>
        </div>

        {{-- Tombol Navigasi Desktop --}}
        <div class="hidden sm:flex items-center gap-1">
            {{-- Tombol Sebelumnya --}}
            @if ($paginator->onFirstPage())
                <span aria-disabled="true" aria-label="Halaman Sebelumnya" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 bg-slate-50 text-slate-300 cursor-not-allowed">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Halaman Sebelumnya" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-300 bg-white text-slate-700 transition hover:bg-slate-50 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
            @endif

            {{-- Angka Halaman --}}
            @foreach ($elements as $element)
                {{-- Pemisah Tiga Titik --}}
                @if (is_string($element))
                    <span aria-disabled="true" class="inline-flex h-9 w-9 items-center justify-center text-xs text-slate-400">
                        {{ $element }}
                    </span>
                @endif

                {{-- Tautan Halaman --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page" class="inline-flex h-9 min-w-9 items-center justify-center rounded-lg bg-blue-600 px-3 text-xs font-semibold text-white shadow-xs">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" aria-label="Menuju Halaman {{ $page }}" class="inline-flex h-9 min-w-9 items-center justify-center rounded-lg border border-slate-300 bg-white px-3 text-xs font-medium text-slate-700 transition hover:bg-slate-50 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Tombol Berikutnya --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Halaman Berikutnya" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-300 bg-white text-slate-700 transition hover:bg-slate-50 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            @else
                <span aria-disabled="true" aria-label="Halaman Berikutnya" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 bg-slate-50 text-slate-300 cursor-not-allowed">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </span>
            @endif
        </div>
    </nav>
@endif
