<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('SOAR Security Alerts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- 
                        ==========================================
                        AREA UTAMA TAMPILAN ALERT (LANGKAH BERIKUTNYA)
                        ========================================== 
                    --}}

                    <h3 class="text-2xl font-bold mb-6">Alert Keamanan Berdasarkan Domain</h3>

                    {{-- DI SINI AKAN MUNCUL PERULANGAN PER DOMAIN DAN TABEL --}}

                    {{-- Placeholder --}}
                    <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                        <p class="text-sm">Data alert dari Shuffle SOAR akan dimuat di sini.</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
