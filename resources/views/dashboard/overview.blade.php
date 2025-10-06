<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Monitoring Security App') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- GRID UNTUK METRIK UTAMA --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                {{-- KARTU 1: TOTAL ALERTS --}}
                <div class="bg-indigo-600 dark:bg-indigo-800 p-6 rounded-lg shadow-xl text-white">
                    <p class="text-sm font-medium opacity-80">Total Alerts Hari Ini</p>
                    <p class="text-4xl font-extrabold mt-1">{{ $totalAlertsToday }}</p>
                </div>
                {{-- KARTU 2: SEVERITY TERTINGGI --}}
                <div class="bg-red-600 dark:bg-red-800 p-6 rounded-lg shadow-xl text-white">
                    <p class="text-sm font-medium opacity-80">Level Kritis Tertinggi</p>
                    <p class="text-4xl font-extrabold mt-1">Lvl {{ $maxSeverity ?? 0 }}</p>
                </div>
                {{-- KARTU 3: DOMAIN TERDAMPAK --}}
                <div class="bg-gray-100 dark:bg-gray-700 p-6 rounded-lg shadow-xl text-gray-900 dark:text-gray-100">
                    <p class="text-sm font-medium">Domain Terdampak</p>
                    <p class="text-4xl font-extrabold mt-1">{{ $topDomains->count() }}</p>
                </div>
                {{-- KARTU 4: LINK KE DETAIL --}}
                <div
                    class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl flex items-center justify-center border border-indigo-200 dark:border-indigo-700">
                    <a href="{{ route('alerts.detail') }}"
                        class="text-indigo-600 dark:text-indigo-400 font-bold hover:underline">
                        Lihat Detail Tabel Serangan →
                    </a>
                </div>
            </div>

            {{-- TOP DOMAIN DAN TOP THREATS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">

                {{-- TOP 5 DOMAIN --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl">
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Top 5 Domain Terdampak</h4>
                    <ol class="space-y-2">
                        @forelse ($topDomains as $domain)
                            <li
                                class="flex justify-between text-sm text-gray-700 dark:text-gray-300 border-b border-gray-100 dark:border-gray-700 pb-1">
                                <span>{{ $domain->domain }}</span>
                                <span class="font-bold text-indigo-600">{{ $domain->count }} Alerts</span>
                            </li>
                        @empty
                            <p class="text-gray-500">Tidak ada data serangan hari ini.</p>
                        @endforelse
                    </ol>
                </div>

                {{-- TOP 5 JENIS SERANGAN --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl">
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Top 5 Jenis Ancaman</h4>
                    <ol class="space-y-2">
                        @forelse ($topAttacks as $attack)
                            <li
                                class="flex justify-between text-sm text-gray-700 dark:text-gray-300 border-b border-gray-100 dark:border-gray-700 pb-1">
                                <span>{{ $attack->alert_title }}</span>
                                <span class="font-bold text-red-600">{{ $attack->count }} Alerts</span>
                            </li>
                        @empty
                            <p class="text-gray-500">Tidak ada data ancaman yang signifikan.</p>
                        @endforelse
                    </ol>
                </div>
            </div>

            {{-- ... (Tempat untuk Grafik Waktu jika Anda ingin menambahkannya) ... --}}

        </div>
    </div>
</x-app-layout>
