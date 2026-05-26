<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header Section --}}
            <div class="mb-8">
                <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Manajemen Pesanan</h1>
                        <p class="text-gray-600 mt-1">Pantau dan kelola seluruh antrean layanan Shoewash.</p>
                    </div>
                    
                    {{-- Statistik Ringkas --}}
                    <div class="flex flex-wrap gap-3">
                        <div class="bg-yellow-50 border border-yellow-100 px-4 py-2 rounded-xl">
                            <p class="text-[10px] uppercase font-bold text-yellow-600 tracking-widest">Pending</p>
                            <span class="text-lg font-black text-yellow-700">{{ $stats['pending'] }}</span>
                        </div>

                        <div class="bg-green-50 border border-green-100 px-4 py-2 rounded-xl">
                            <p class="text-[10px] uppercase font-bold text-green-600 tracking-widest">Success</p>
                            <span class="text-lg font-black text-green-700">{{ $stats['success'] }}</span>
                        </div>

                        <div class="bg-red-50 border border-red-100 px-4 py-2 rounded-xl">
                            <p class="text-[10px] uppercase font-bold text-red-600 tracking-widest">Expired</p>
                            <span class="text-lg font-black text-red-700">{{ $stats['expired'] }}</span>
                        </div>

                        <div class="bg-blue-600 px-5 py-2 rounded-xl flex flex-col justify-center text-white">
                            <p class="text-[10px] uppercase font-bold text-blue-100 tracking-widest">Total</p>
                            <span class="text-lg font-black leading-none">{{ $stats['total'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAMBAHAN: FORM BAR PENCARIAN (SEARCH BAR) --}}
            <div class="mb-6 bg-white p-4 rounded-2xl border border-gray-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
                <form action="{{ url('/admin/dashboard') }}" method="GET" class="w-full flex gap-3 m-0 p-0">
                    <div class="relative flex-grow">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="Cari berdasarkan nomor order, nama pelanggan, nomor telepon, atau merek sepatu..." 
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                        >
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold px-6 py-2.5 rounded-xl transition shadow-sm whitespace-nowrap">
                        Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ url('/admin/dashboard') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-bold px-4 py-2.5 rounded-xl transition flex items-center justify-center whitespace-nowrap">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            {{-- Order Cards Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($allBookings as $b)
                    @php
                        $isExpired = $b->payment_status === 'pending' && $b->expired_at->isPast();
                        $isSuccess = $b->payment_status === 'success';
                    @endphp

                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden flex flex-col transition hover:shadow-md">
                        {{-- Card Header --}}
                        <div class="p-4 border-b border-gray-100 flex justify-between items-start bg-gray-50/50">
                            <div>
                                <span class="font-mono text-sm font-bold text-blue-700 tracking-wider block">
                                    #{{ $b->order_number }}
                                </span>
                                {{-- INFORMASI TANGGAL ORDER CUSTOMER --}}
                                <div class="flex items-center gap-1 mt-1 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-[11px] font-medium">
                                        {{ $b->created_at->format('d M Y, H:i') }} WIB
                                    </span>
                                </div>
                            </div>
                            
                            @if($isExpired)
                                <span class="px-2.5 py-1 text-[10px] font-bold uppercase bg-red-100 text-red-700 rounded-lg">Expired</span>
                            @elseif($b->payment_status === 'pending')
                                <span class="px-2.5 py-1 text-[10px] font-bold uppercase bg-yellow-100 text-yellow-700 rounded-lg border border-yellow-200">Pending</span>
                            @else
                                <span class="px-2.5 py-1 text-[10px] font-bold uppercase bg-green-100 text-green-700 rounded-lg">Paid</span>
                            @endif
                        </div>

                        {{-- Card Body --}}
                        <div class="p-5 flex-grow space-y-4">
                            {{-- User Info --}}
                            <div class="flex justify-between items-start">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 font-bold">
                                        {{ substr($b->customer_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-bold text-gray-900">{{ $b->customer_name }}</h3>
                                        <p class="text-xs text-blue-600 font-medium">{{ $b->customer_phone }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] uppercase text-gray-400 font-bold tracking-widest mb-1">Metode Bayar</p>
                                    <span class="text-[11px] font-black px-2 py-0.5 rounded-md border {{ $b->payment_method === 'midtrans' ? 'bg-blue-50 border-blue-200 text-blue-700' : 'bg-gray-50 border-gray-200 text-gray-700' }} uppercase">
                                        {{ $b->payment_method }}
                                    </span>
                                </div>
                            </div>

                            <hr class="border-gray-100">

                            {{-- Informasi Detail Teks (Merek & Layanan Ditampilkan Tanpa Gambar) --}}
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-[10px] uppercase text-gray-400 font-bold tracking-widest mb-1">Merek Sepatu</p>
                                    <p class="text-sm font-bold text-gray-800 capitalize">{{ $b->shoe_brand }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] uppercase text-gray-400 font-bold tracking-widest mb-1">Layanan</p>
                                    <p class="text-sm font-bold text-blue-800">{{ $b->service->name }}</p>
                                </div>
                            </div>

                            {{-- TRACKING UPDATE SECTION --}}
                            <div class="bg-blue-50/50 p-3 rounded-xl border border-blue-100">
                                <form action="{{ route('admin.booking.updateStatus', $b->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <p class="text-[10px] uppercase text-blue-500 font-black tracking-widest mb-2">Update Progress Tracking</p>
                                    <div class="flex gap-2">
                                        <select name="status" class="block w-full text-[11px] border-blue-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-white py-1.5 font-bold text-gray-700">
                                            <option value="pending" {{ $b->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="processing" {{ $b->status == 'processing' ? 'selected' : '' }}>Processing (Diterima)</option>
                                            <option value="washing" {{ $b->status == 'washing' ? 'selected' : '' }}>Washing (Dicuci)</option>
                                            <option value="ready" {{ $b->status == 'ready' ? 'selected' : '' }}>Ready (Siap Ambil)</option>
                                            <option value="success" {{ $b->status == 'success' ? 'selected' : '' }}>Success (Selesai)</option>
                                        </select>
                                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 rounded-lg transition-colors shadow-sm active:scale-95">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- Card Action Footer --}}
                        <div class="px-5 py-4 bg-gray-50 border-t border-gray-100 flex gap-2">
                            <div class="w-full">
                                @if($isExpired)
                                    <x-button type="button" disabled variant="secondary" class="w-full justify-center text-[11px] py-2.5 font-bold uppercase tracking-wider opacity-50 cursor-not-allowed bg-gray-200 border-gray-300 text-gray-500">
                                        Pesanan Expired
                                    </x-button>
                                @elseif($isSuccess)
                                    <x-button type="button" disabled variant="secondary" class="w-full justify-center text-[11px] py-2.5 font-bold uppercase tracking-wider opacity-75 cursor-default bg-green-50 border-green-200 text-green-700">
                                        Lunas / Terbayar
                                    </x-button>
                                @elseif($b->payment_method === 'midtrans')
                                    <x-button type="button" disabled variant="secondary" class="w-full justify-center text-[11px] py-2.5 font-bold uppercase tracking-wider opacity-60 bg-blue-50 border-blue-100 text-blue-400 cursor-not-allowed">
                                        Menunggu Midtrans...
                                    </x-button>
                                @else
                                    <form action="{{ route('admin.booking.update', $b->id) }}" method="POST" class="w-full">
                                        @csrf
                                        @method('PATCH')
                                        <x-button type="submit" variant="primary" class="w-full justify-center text-[11px] py-2.5 font-bold uppercase tracking-wider transition-all active:scale-95">
                                            Konfirmasi Bayar (COD)
                                        </x-button>
                                    </form>
                                @endif
                            </div>
                            
                            @if($isExpired)
                                <form action="{{ route('admin.booking.destroy', $b->id) }}" method="POST" onsubmit="return confirm('Hapus pesanan expired ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <x-button type="submit" class="py-2.5 px-3 bg-red-400 text-white border-red-100 hover:bg-red-600 hover:text-white transition-colors shadow-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </x-button>
                                </form>
                            @else
                                {{-- Tombol Ikon Mata untuk Melihat Detail Struk --}}
                                <a href="{{ route('booking.receipt', $b->order_number) }}" target="_blank" title="Lihat Bukti Transaksi">
                                    <x-button variant="secondary" class="py-2.5 px-3 border-gray-200 hover:bg-gray-100 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </x-button>
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 flex flex-col items-center justify-center text-center bg-white rounded-3xl border-2 border-dashed border-gray-200">
                        <div class="bg-gray-100 p-4 rounded-full mb-4 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Antrean Kosong</h3>
                        <p class="text-gray-500 mt-2">Saat ini belum ada pesanan baru yang cocok dengan kata kunci pencarian Anda.</p>
                    </div>
                @endforelse
            </div>
            
            {{-- MODIFIKASI: Mengikat string pencarian pada tautan pagination --}}
            <div class="mt-8">
                {{ $allBookings->appends(['search' => request('search')])->links() }}
            </div>
        </div>
    </div>
</x-app-layout>