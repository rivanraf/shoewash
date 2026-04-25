<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Shoewash') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-50">
        {{-- Container utama dibuat flex-center di semua ukuran layar agar presisi --}}
        <div class="min-h-screen flex flex-col justify-center items-center p-4 sm:p-6 bg-gray-50">
            
            {{-- Bagian Atas: Ruang untuk Logo atau Judul Tambahan jika ada --}}
            <div class="mb-2">
                <a href="/">
                    {{-- Logo ditaruh di sini jika ingin muncul di luar kotak putih --}}
                </a>
            </div>

            {{-- Card Container: Responsif Lebar --}}
            <div class="w-full sm:max-w-md bg-white shadow-xl border border-gray-100 overflow-hidden rounded-2xl">
                <div class="px-6 py-8 sm:px-10">
                    {{ $slot }}
                </div>
            </div>

            {{-- Footer Kecil (Opsional untuk TA) --}}
            <div class="mt-8 text-center">
                <p class="text-xs text-gray-400">
                    &copy; {{ date('Y') }} Shoewash Service. All rights reserved.
                </p>
            </div>
        </div>
    </body>
</html>