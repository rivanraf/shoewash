<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden">
                {{-- Header --}}
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <div>
                        <h2 class="text-xl font-black text-gray-900 uppercase tracking-tight">Detail Pesanan</h2>
                        <p class="text-xs text-blue-600 font-bold font-mono">{{ $booking->order_number }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-black uppercase {{ $booking->payment_status === 'success' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                        {{ $booking->payment_status }}
                    </span>
                </div>

                <div class="p-8 space-y-8">
                    {{-- Foto Sepatu --}}
                    @if($booking->shoe_image)
                    <div>
                        <p class="text-[10px] uppercase text-gray-400 font-black tracking-widest mb-3">Foto Kondisi Awal</p>
                        <img src="{{ asset('storage/bookings/' . $booking->shoe_image) }}" class="w-full rounded-2xl border-2 border-gray-100 shadow-inner object-cover max-h-72">
                    </div>
                    @endif

                    {{-- Info Customer & Layanan --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-4">
                            <div>
                                <p class="text-[10px] uppercase text-gray-400 font-black tracking-widest">Nama Pelanggan</p>
                                <p class="text-lg font-bold text-gray-900">{{ $booking->customer_name }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase text-gray-400 font-black tracking-widest">WhatsApp / Telepon</p>
                                <p class="text-lg font-bold text-blue-700">{{ $booking->customer_phone }}</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <p class="text-[10px] uppercase text-gray-400 font-black tracking-widest">Merek Sepatu</p>
                                <p class="text-lg font-bold text-gray-900 capitalize">{{ $booking->shoe_brand }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase text-gray-400 font-black tracking-widest">Jenis Layanan</p>
                                <p class="text-lg font-bold text-gray-900">{{ $booking->service->name }}</p>
                            </div>
                            {{-- TAMBAHAN: Menampilkan Tanggal Booking Customer --}}
                            <div>
                                <p class="text-[10px] uppercase text-gray-400 font-black tracking-widest">Tanggal Booking</p>
                                <p class="text-lg font-bold text-gray-900">{{ $booking->created_at->format('d M Y, H:i') }} WIB</p>
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-100">

                    {{-- Info Pembayaran --}}
                    <div class="flex justify-between items-center bg-gray-50 p-6 rounded-2xl border border-gray-100">
                        <div>
                            <p class="text-[10px] uppercase text-gray-400 font-black tracking-widest">Metode Pembayaran</p>
                            <p class="text-sm font-bold text-gray-900 uppercase">{{ $booking->payment_method }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] uppercase text-gray-400 font-black tracking-widest">Total Bayar</p>
                            <p class="text-2xl font-black text-gray-900">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    {{-- Tombol Kembali --}}
                    <div class="pt-4 flex gap-3">
                        <a href="{{ route('admin.dashboard') }}" class="flex-1 bg-gray-900 text-white text-center font-bold py-3 rounded-xl hover:bg-black transition">
                            Kembali ke Dashboard
                        </a>
                        <button onclick="window.print()" class="px-6 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>