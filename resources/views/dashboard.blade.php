<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Monitoring Security Alerts 12345') }}
        </h2>
    </x-slot>

    <div class="py-12">
        {{-- MODIFIKASI DISINI --}}
        {{-- Mengubah max-w-7xl menjadi max-w-6xl atau max-w-5xl --}}
        {{-- Menambah mx-auto dan sm:px-6 lg:px-8 untuk centering dan padding --}}
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @forelse ($alertsByDomain as $domain => $alerts)
                {{-- KARD UTAMA PER DOMAIN --}}
                <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-6">

                    {{-- HEADER DOMAIN --}}
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        {{ $domain }}
                        <span
                            class="ml-4 text-sm font-medium px-3 py-1 bg-red-100 text-red-800 rounded-full dark:bg-red-800 dark:text-red-100">
                            {{ $alerts->count() }} Alert
                        </span>
                    </h3>

                    {{-- TABEL ALERT --}}
                    <div class="overflow-x-auto"> {{-- overflow-x-auto akan membuat scrollbar horizontal jika tabel terlalu lebar --}}
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">
                                        Waktu</th> {{-- Tambah lebar kolom --}}
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">
                                        Judul (Wazuh)</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/12">
                                        Path Diserang</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-6/12">
                                        Rekomendasi (Gemini)</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($alerts as $alert)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50" x-data="{ open: false }">

                                        {{-- KOLOM WAKTU --}}
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{-- Menggunakan Carbon dari Eloquent untuk memformat waktu --}}
                                            {{ $alert->attack_time->diffForHumans() }}
                                            <div class="text-xs">{{ $alert->attack_time->format('d M H:i:s') }}</div>
                                        </td>

                                        {{-- KOLOM JUDUL --}}
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-red-600 dark:text-red-400">
                                            {{ $alert->alert_title }}
                                            <span class="ml-2 text-xs font-semibold text-gray-500">
                                                (Lvl: {{ $alert->severity_level }})
                                            </span>
                                        </td>

                                        {{-- KOLOM PATH --}}
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100 max-w-xs">
                                            <code
                                                class="text-xs bg-gray-100 dark:bg-gray-700 p-1 rounded whitespace-pre-wrap break-words">{{ $alert->attack_path }}</code>
                                        </td>

                                        {{-- KOLOM REKOMENDASI --}}
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                            <div class="flex items-center">
                                                {{-- Ringkasan --}}
                                                <p class="text-xs">
                                                    {{ \Illuminate\Support\Str::limit($alert->gemini_recommendation, 80) }}
                                                </p>

                                                {{-- Tombol Detail/Sembunyikan --}}
                                                <button @click="open = ! open"
                                                    class="ml-2 flex-shrink-0 text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 text-xs font-medium">
                                                    <span x-show="! open">Lihat Detail</span>
                                                    <span x-show="open">Sembunyikan</span>
                                                </button>
                                            </div>

                                            {{-- DETAIL LENGKAP REKOMENDASI --}}
                                            <div x-show="open" x-collapse.duration.500ms
                                                class="mt-2 p-3 bg-indigo-50 dark:bg-indigo-900/50 rounded-lg border-l-4 border-indigo-500">
                                                <p class="font-semibold text-sm mb-1 text-gray-800 dark:text-gray-200">
                                                    Rekomendasi Lengkap Gemini:</p>
                                                <pre class="text-xs whitespace-pre-wrap text-gray-700 dark:text-gray-300">{{ $alert->gemini_recommendation }}</pre>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @empty
                {{-- JIKA TIDAK ADA ALERT --}}
                <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-6">
                    <p class="text-lg text-gray-500">🥳 Tidak ada alert keamanan yang terdeteksi sejauh ini.</p>
                    <p class="text-sm text-gray-400 mt-2">Pastikan alur Shuffle SOAR Anda sudah mengirim data ke API
                        Laravel.</p>
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>
