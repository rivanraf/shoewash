<nav class="fixed w-full z-20 top-0 start-0 border-b border-gray-200">
    {{-- Marquee Section --}}
    <div class="relative flex overflow-x-hidden bg-blue-700 text-white py-2 border-b border-blue-800">
        <div class="animate-marquee-nav whitespace-nowrap flex flex-shrink-0">
            @foreach(range(1, 10) as $i)
                <span class="text-xs md:text-sm font-bold uppercase mx-4">Gapapa malas nyuci, biar kami yang beraksi.</span>
            @endforeach
        </div>
    </div>

    {{-- Main Navbar Section --}}
    <div class="bg-white">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4 relative">
            
            <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse md:absolute md:left-1/2 md:-translate-x-1/2">
                <span class="self-center text-xl md:text-2xl font-black whitespace-nowrap text-gray-900 uppercase tracking-tighter">Shoewash</span>
            </a>

            <div class="flex md:order-2 space-x-3 rtl:space-x-reverse">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-lg text-sm px-4 py-2 text-center transition-all">Profile</a>
                    @else
                        <a href="{{ route('login') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-lg text-sm px-4 py-2 text-center transition-all">Order Now</a>
                    @endauth
                @endif

                <x-button variant="hamburger" data-collapse-toggle="navbar-cta" aria-controls="navbar-cta" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                    </svg>
                </x-button>
            </div>

            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-cta">
                <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white">
                    <li>
                        <a href="#home" class="nav-link block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 transition-colors">Home</a>
                    </li>
                    <li>
                        <a href="#about" class="nav-link block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 transition-colors">About</a>
                    </li>
                    <li>
                        <a href="#services" class="nav-link block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 transition-colors">Services</a>
                    </li>
                    <li>
                        <a href="#testimonials" class="nav-link block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 transition-colors">Testimonials</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

{{-- Tambahkan Style ini di Head atau file CSS Anda --}}
<style>
    /* Efek Semi Bold dan Biru saat link diklik/aktif */
    .nav-link:focus, 
    .nav-link:active {
        color: #1d4ed8 !important; /* blue-700 */
        font-weight: 600 !important; /* semibold */
    }

    /* Smooth transition */
    .nav-link {
        transition: all 0.3s ease;
    }
</style>