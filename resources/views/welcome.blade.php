<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SOAR Security System</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif;
        }
    </style>
</head>

{{-- TEMA DARK DENGAN GRADIENT BACKGROUND --}}

<body class="antialiased bg-gray-900 dark:bg-gray-900 text-gray-100 min-h-screen">

    <header class="absolute top-0 left-0 w-full p-6 z-10">
        <nav class="flex justify-end">
            @auth
                {{-- Jika sudah login, tampilkan tombol ke Dashboard --}}
                <a href="{{ url('/dashboard') }}"
                    class="text-sm font-semibold px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition duration-150 shadow-lg">
                    Dashboard
                </a>
            @else
                {{-- Jika belum login, tampilkan tombol Login --}}
                <a href="{{ route('login') }}"
                    class="text-sm font-semibold px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition duration-150 shadow-lg">
                    Login
                </a>
            @endauth
        </nav>
    </header>

    <main class="relative flex items-center justify-center min-h-screen">

        {{-- EFEK VISUAL TEMA CYBER SECURITY --}}
        <div class="absolute inset-0 opacity-10 pointer-events-none">
            <div
                class="h-full w-full bg-[radial-gradient(#202020_1px,transparent_1px)] [background-size:16px_16px] [mask-image:radial-gradient(ellipse_50%_50%_at_50%_50%,#000_70%,transparent_100%)]">
            </div>
        </div>

        {{-- KOTAK INFORMASI --}}
        <div class="max-w-4xl mx-auto text-center z-10 p-6">

            <span
                class="inline-block px-3 py-1 text-xs font-semibold tracking-wider text-green-400 uppercase bg-green-900 bg-opacity-30 rounded-full border border-green-700 mb-4">
                Security Alert Monitoring
            </span>

            <h1 class="text-6xl font-extrabold tracking-tight mb-4 text-white">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-600">Sistem Keamanan
                    Siber</span> Terintegrasi
            </h1>

            <p class="text-xl text-gray-400 mb-8">
                Memperkuat pertahanan digital Anda dengan otomatisasi deteksi ancaman real-time dari Wazuh, korelasi
                aksi dari Shuffle, dan analisis cerdas menggunakan Gemini AI.
            </p>

            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">

                {{-- TOMBOL UTAMA KE LOGIN/DASHBOARD --}}
                <a href="{{ auth()->check() ? url('/dashboard') : route('login') }}"
                    class="px-8 py-3 text-lg font-bold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition duration-300 shadow-xl transform hover:scale-[1.02]">
                    Akses Sistem Sekarang
                </a>
            </div>
        </div>
    </main>

</body>

</html>
