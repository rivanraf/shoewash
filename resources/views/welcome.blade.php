<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="overflow-x-hidden">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Shoe Wash - Batas Kota</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            html {
        scroll-behavior: smooth;
    }
    
    body {
        overflow-x: hidden;
        width: 100%;
        position: relative;
    }

    /* 1. Kontainer Utama (Wrapper) */
    .marquee-wrapper {
        display: flex;
        overflow: hidden;
        user-select: none;
        width: 100%;
    }

    /* 2. Logika Animasi */
    @keyframes marquee-horizontal {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }

    /* 3. Class untuk Teks (Navbar) */
    .animate-marquee-nav {
        display: flex;
        flex-shrink: 0;
        min-width: 100%;
        white-space: nowrap; /* KUNCI: Mencegah teks menumpuk ke bawah */
        animation: marquee-horizontal 30s linear infinite;
    }

    /* 4. Class untuk Testimoni */
    .animate-marquee-testi {
        display: flex;
        flex-shrink: 0;
        gap: 3rem; /* Jarak antar item testi */
        white-space: nowrap;
        animation: marquee-horizontal 40s linear infinite;
    }

    .animate-marquee-nav:hover,
    .animate-marquee-testi:hover {
        animation-play-state: paused;
    }
</style>
    </head>
    <body class="antialiased bg-white">
        
        <x-navbar />

        <main class="pt-16 md:pt-24">
            <section id="home" class="relative bg-gray-900 lg:grid lg:h-screen lg:place-content-center overflow-hidden">
    {{-- Container Gambar Latar Belakang --}}
    <div class="absolute inset-0 z-0">
        <img 
            src="https://images.unsplash.com/photo-1626379530580-6a58c5cf1d5e?q=80&w=687&auto=format&fit=crop" 
            class="w-full h-full object-cover opacity-50 grayscale-[30%]" 
            alt="Shoewash Background"
        >
        {{-- Overlay Hitam Solid & Gradient --}}
        <div class="absolute inset-0 bg-black/40"></div> {{-- Gelapkan gambar agar teks putih menonjol --}}
        <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-transparent to-gray-900"></div>
    </div>

    {{-- Konten Utama --}}
    <div class="relative z-10 mx-auto w-full max-w-7xl px-4 py-16 sm:px-6 sm:py-24 lg:px-8 lg:py-32">
        <div class="mx-auto max-w-prose text-center">
            <h1 class="text-4xl font-black text-white sm:text-6xl tracking-tighter">
                Solusi Cuci Sepatu
                <span class="text-blue-500"> Terbaik </span>
                di Batas Kota
            </h1>

            <p class="mt-6 text-base text-gray-300 font-medium sm:text-lg/relaxed">
                Kembalikan kebersihan sepatu Anda dengan layanan profesional kami. 
                Booking sekarang dan rasakan perbedaannya.
            </p>
        </div>
    </div>
</section>

            <section id="about" class="bg-white pt-24">
                <div class="mx-auto w-full max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
                    <div class="mx-auto max-w-prose text-center">
                        <h1 class="text-4xl font-bold text-gray-900 sm:text-6xl tracking-tight">
                            Kenapa harus cuci <strong class="text-blue-700"> Sepatu </strong> di Kita?
                        </h1>
                        <p class="mt-6 text-base text-pretty text-gray-700 sm:text-lg/relaxed">
                            Karena di kami melayani keseluruhan customer dengan hati tanpa memilah milih harga sesuai mood layanan pada saat mengeksekusi untuk memberikan hasil terbaik bagi pelanggan kami. 
                        </p>
                    </div>

                    <div class="mt-16 grid grid-cols-1 gap-8 md:grid-cols-3">
                        <div class="rounded-2xl border border-gray-100 p-8 shadow-sm transition hover:shadow-md">
                            <div class="inline-flex rounded-lg bg-blue-50 p-3 text-blue-700">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                </svg>
                            </div>
                            <h3 class="mt-4 text-lg font-bold text-gray-900">Premium Materials</h3>
                            <p class="mt-2 text-sm text-gray-600 leading-relaxed">Cairan pembersih khusus (*deep cleaner*) yang aman untuk berbagai bahan.</p>
                        </div>

                        <div class="rounded-2xl border border-gray-100 p-8 shadow-sm transition hover:shadow-md">
                            <div class="inline-flex rounded-lg bg-blue-50 p-3 text-blue-700">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
                                </svg>
                            </div>
                            <h3 class="mt-4 text-lg font-bold text-gray-900">Fast & Reliable</h3>
                            <p class="mt-2 text-sm text-gray-600 leading-relaxed">Sistem manajemen memastikan sepatu Anda selesai tepat waktu.</p>
                        </div>

                        <div class="rounded-2xl border border-gray-100 p-8 shadow-sm transition hover:shadow-md">
                            <div class="inline-flex rounded-lg bg-blue-50 p-3 text-blue-700">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.745 3.745 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                                </svg>
                            </div>
                            <h3 class="mt-4 text-lg font-bold text-gray-900">Satisfaction Guarantee</h3>
                            <p class="mt-2 text-sm text-gray-600 leading-relaxed">Cuci ulang gratis jika Anda tidak puas dengan hasilnya.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section id="services" class="bg-white pt-24">
    <div class="mx-auto w-full max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-prose text-center mb-16">
            <h1 class="text-4xl font-bold text-gray-900 sm:text-6xl tracking-tight capitalize">
                Our <span class="text-blue-700">Services</span>
            </h1>
            <p class="mt-6 text-base text-pretty text-gray-700 sm:text-lg/relaxed">Pilih perawatan yang tepat untuk sepatu kesayangan Anda.</p>
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 items-start">
            
            <div class="group relative flex flex-col rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:shadow-xl hover:border-blue-500">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Medium Clean</h3>
                    <p class="mt-2 text-xs font-semibold text-blue-600 uppercase tracking-widest">Midsole & Upper</p>
                    <div class="mt-4 border-t border-gray-100 pt-4">
                        <p class="text-xs text-gray-500 italic">Estimasi: 2 Hari</p>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="{{ route('booking.index') }}">
                        <x-button variant="primary" class="w-full justify-center py-2.5 bg-gray-900 hover:bg-blue-700 text-xs">
                            Order Now
                        </x-button>
                    </a>
                </div>
            </div>

            <div class="group relative flex flex-col rounded-2xl border-2 border-blue-600 bg-white p-6 shadow-md transition hover:shadow-xl">
                <div class="absolute -top-3 left-1/2 -translate-x-1/2 rounded-full bg-blue-600 px-4 py-1 text-[9px] font-black uppercase text-white tracking-widest">
                    Recommended
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Deep Clean</h3>
                    <p class="mt-2 text-xs font-semibold text-blue-600 uppercase tracking-widest">All Parts & Materials</p>
                    <div class="mt-4 border-t border-gray-100 pt-4">
                        <p class="text-xs text-gray-500 italic">Estimasi: 3 Hari</p>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="{{ route('booking.index') }}">
                        <x-button variant="primary" class="w-full justify-center py-2.5 text-xs">
                            Order Now
                        </x-button>
                    </a>
                </div>
            </div>

            <div class="group relative flex flex-col rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:shadow-xl hover:border-blue-500">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Hard Clean</h3>
                    <p class="mt-2 text-xs font-semibold text-blue-600 uppercase tracking-widest">Extra Dirty Shoes</p>
                    <div class="mt-4 border-t border-gray-100 pt-4">
                        <p class="text-xs text-gray-500 italic">Estimasi: 3 Hari</p>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="{{ route('booking.index') }}">
                        <x-button variant="primary" class="w-full justify-center py-2.5 bg-gray-900 hover:bg-blue-700 text-xs">
                            Order Now
                        </x-button>
                    </a>
                </div>
            </div>

            <div class="group relative flex flex-col rounded-2xl border border-gray-900 bg-gray-900 p-6 shadow-sm transition hover:shadow-xl">
                <div>
                    <h3 class="text-xl font-bold text-white leading-tight">Express Clean</h3>
                    <p class="mt-2 text-xs font-semibold text-blue-400 uppercase tracking-widest">Priority Service</p>
                    <div class="mt-4 border-t border-gray-700 pt-4">
                        <p class="text-xs text-gray-400 italic">Estimasi: 1 Hari</p>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="{{ route('booking.index') }}">
                        <x-button variant="secondary" class="w-full justify-center py-2.5 bg-white text-gray-900 hover:bg-blue-400 border-none text-xs">
                            Order Now
                        </x-button>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

            <section id="testimonials" class="bg-white overflow-hidden pt-24">
                <div class="mx-auto w-full max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
                    <div class="mx-auto max-w-prose text-center mb-16">
                        <h1 class="text-4xl font-bold text-gray-900 sm:text-6xl tracking-tight capitalize">
                            Our <span class="text-blue-700">Testimonials</span>
                        </h1>
                        <p class="mt-6 text-base text-pretty text-gray-700 sm:text-lg/relaxed">Apa kata mereka tentang layanan kami?</p>
                    </div>

                    <div class="relative flex overflow-x-hidden group">
                        <div class="absolute inset-y-0 left-0 w-24 md:w-48 bg-gradient-to-r from-white to-transparent z-10 pointer-events-none"></div>
                        <div class="absolute inset-y-0 right-0 w-24 md:w-48 bg-gradient-to-l from-white to-transparent z-10 pointer-events-none"></div>

                        <div class="animate-marquee-testi flex gap-12 items-center whitespace-nowrap">
                            @php
                                $testis = [
                                    ['img' => 'https://images.unsplash.com/photo-1633332755192-727a05c4013d', 'name' => 'Budi Santoso', 'text' => 'Sepatu jadi seperti baru lagi!'],
                                    ['img' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330', 'name' => 'Siti Aminah', 'text' => 'Pelayanan cepat & admin ramah.'],
                                    ['img' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d', 'name' => 'Rian Adi', 'text' => 'Deep clean-nya juara banget.'],
                                    ['img' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80', 'name' => 'Dewi Lestari', 'text' => 'Repaint-nya rapi, warna akurat.'],
                                    ['img' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e', 'name' => 'Eko Prasetyo', 'text' => 'Suka banget sama wanginya.'],
                                    ['img' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb', 'name' => 'Linda Sari', 'text' => 'Harga terjangkau hasil memukau.'],
                                ];
                            @endphp

                            @foreach(array_merge($testis, $testis) as $t)
                            <div class="flex flex-col items-center text-center min-w-[200px]">
                                <img src="{{ $t['img'] }}?auto=format&fit=crop&q=80&w=150" alt="Customer" class="size-24 rounded-full object-cover border-2 border-gray-50">
                                <div class="mt-4">
                                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-tighter">{{ $t['name'] }}</h3>
                                    <p class="mt-0.5 text-[10px] font-medium text-blue-700 italic">"{{ $t['text'] }}"</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="bg-blue-700 mt-6 text-white">
    {{-- Padding vertikal dipangkas dari py-16 menjadi py-10 --}}
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
            {{-- Bagian Kontak --}}
            <div>
                <p>
                    <span class="text-[10px] tracking-wide text-blue-200 uppercase font-bold"> Contact us </span>
                    <a href="https://wa.me/6288865659999" class="block text-xl font-black text-white hover:text-blue-200 sm:text-2xl tracking-tighter mt-1 transition-colors">
                        0888-6565-9999
                    </a>
                </p>

                {{-- Jarak margin dikurangi dari mt-8 menjadi mt-4 --}}
                <ul class="mt-4 space-y-1 text-sm text-blue-100">
                    <li><span class="font-bold text-white">Open Hours:</span></li>
                    <li>Mon - Fri: 09am - 08pm</li>
                    <li>Weekend: 10am - 05pm</li>
                </ul>

                <ul class="mt-4 flex gap-5">
                    <li>
                        <a href="#" class="text-white transition hover:text-blue-200">
                            <span class="sr-only">Instagram</span>
                            <svg class="size-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Link Navigasi --}}
            <div class="grid grid-cols-2 gap-8 lg:col-span-2">
                <div>
                    <p class="font-black text-white uppercase tracking-widest text-[10px]">Services</p>
                    <ul class="mt-4 space-y-2 text-sm font-medium">
                        <li><a href="#" class="text-blue-100 transition hover:text-white"> Medium Clean </a></li>
                        <li><a href="#" class="text-blue-100 transition hover:text-white"> Deep Clean </a></li>
                        <li><a href="#" class="text-blue-100 transition hover:text-white"> Hard Clean </a></li>
                        <li><a href="#" class="text-blue-100 transition hover:text-white"> Express Service </a></li>
                    </ul>
                </div>

                <div>
                    <p class="font-black text-white uppercase tracking-widest text-[10px]">Company</p>
                    <ul class="mt-4 space-y-2 text-sm font-medium">
                        <li><a href="#" class="text-blue-100 transition hover:text-white"> About Us </a></li>
                        <li><a href="#" class="text-blue-100 transition hover:text-white"> Location </a></li>
                        <li><a href="#" class="text-blue-100 transition hover:text-white"> Privacy Policy </a></li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Bottom Footer --}}
        {{-- Jarak padding dikurangi dari pt-12 menjadi pt-8 --}}
        <div class="mt-8 border-t border-blue-600 pt-8">
            <div class="sm:flex sm:items-center sm:justify-between">
                <p class="text-xl font-black text-white tracking-tighter">Shoewash</p>
                <p class="mt-4 text-[10px] text-blue-200 sm:mt-0 font-medium">
                    &copy; 2026 Shoewash Batas Kota. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</footer>
    </body>
</html>