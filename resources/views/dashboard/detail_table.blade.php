<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('SOAR Security Alerts') }}
        </h2>
    </x-slot>

    {{-- KONTENER UTAMA (ALERTS) --}}
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-8" x-data="{
            showModal: false,
            modalTitle: '',
            modalContent: '',
        
            // Fungsi untuk membuka modal dan mengisi konten
            openModal(title, content) {
                this.modalTitle = title;
                this.modalContent = content;
                this.showModal = true;
            }
        }">

            @forelse ($alertsByDomain as $domain => $alerts)
                {{-- KARD UTAMA PER DOMAIN --}}
                <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-6">

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
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">
                                        Waktu</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">
                                        Judul</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/12">
                                        Path Diserang</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-6/12">
                                        Rekomendasi AI</th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">
                                        AKSI</th>
                                </tr>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($alerts as $alert)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">

                                        {{-- KOLOM WAKTU --}}
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
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

                                        {{-- KOLOM REKOMENDASI (TOMBOL MODAL BARU) --}}
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                            <div class="flex flex-col">
                                                {{-- Ringkasan --}}
                                                <p class="text-xs mb-2">
                                                    {{ \Illuminate\Support\Str::limit($alert->gemini_recommendation, 80) }}
                                                </p>

                                                {{-- Tombol Pemicu Modal --}}
                                                <button
                                                    @click="openModal('Rekomendasi Mitigasi: {{ $alert->alert_title }}', '{{ str_replace(["\n", "\r", "'"], ['<br>', '', "\\'"], $alert->gemini_recommendation) }}')"
                                                    class="self-start text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 text-xs font-medium underline">
                                                    Lihat Detail
                                                </button>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium"
                                            class="delete-form">
                                            <form action="{{ route('alerts.destroy', $alert->id) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus alert ini? Aksi ini tidak dapat dibatalkan.');">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-600 transition duration-150">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.86 12.04A2 2 0 0116.14 21H7.86A2 2 0 016 19.04L5 7m5 4v6m4-6v6m1-10H8" />
                                                    </svg>
                                                </button>

                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @empty
                {{-- ... Pesan Kosong ... --}}
                <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-6">
                    <p class="text-lg text-gray-500">🥳 Tidak ada alert keamanan yang terdeteksi sejauh ini.</p>
                </div>
            @endforelse

            {{-- ==========================================================
                 MODAL (POP-UP) REKOMENDASI GEMINI
                 ========================================================== --}}
            <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title"
                role="dialog" aria-modal="true" style="display: none;">

                {{-- Backdrop --}}
                <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                    class="fixed inset-0 bg-gray-500 dark:bg-gray-900 bg-opacity-75 dark:bg-opacity-90 transition-opacity"
                    @click="showModal = false">
                </div>

                {{-- Kontainer Modal --}}
                <div x-show="showModal" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="flex items-center justify-center min-h-screen p-4">

                    <div
                        class="relative bg-white dark:bg-gray-800 rounded-lg shadow-xl transform transition-all sm:w-full sm:max-w-3xl">

                        {{-- Header Modal --}}
                        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100" id="modal-title"
                                x-text="modalTitle">
                            </h3>
                        </div>

                        {{-- Body Modal --}}
                        <div class="p-6">
                            <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                <pre class="whitespace-pre-wrap font-mono break-words overflow-wrap-anywhere" x-html="modalContent"></pre>
                            </div>
                        </div>

                        {{-- Footer Modal --}}
                        <div
                            class="px-4 py-3 bg-gray-50 dark:bg-gray-900 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-lg">
                            <button type="button" @click="showModal = false"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
