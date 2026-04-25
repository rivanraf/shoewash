<x-guest-layout>
    <div class="max-w-md mx-auto">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-black text-gray-900 tracking-tighter uppercase">Shoewash Receipt</h2>
            <p class="text-xs text-gray-500 uppercase tracking-widest mt-1">Bukti Booking Layanan</p>
            
            <div class="mt-4 px-4 py-2 bg-blue-50 border border-blue-100 rounded-lg">
                <p class="text-[10px] md:text-xs text-blue-700 font-bold leading-tight">
                    <span class="inline-block mr-1">⚠️</span>
                    Screenshot/Unduh bukti untuk konfirmasi ke admin shoewash batas kota
                </p>
            </div>
        </div>

        <div class="border-2 border-dashed border-gray-200 rounded-2xl p-6 bg-gray-50/50">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Order Number</p>
                    <p class="text-lg font-mono font-bold text-blue-700">{{ $booking->order_number }}</p>
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Tanggal</p>
                    <p class="text-sm font-bold text-gray-800">{{ $booking->created_at->format('d/m/Y') }}</p>
                </div>
            </div>

            <div class="space-y-4">
                <div class="flex justify-between border-b border-gray-200 pb-2">
                    <span class="text-sm text-gray-600 font-medium">Customer</span>
                    <span class="text-sm font-bold text-gray-900">{{ $booking->customer_name }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-200 pb-2">
                    <span class="text-sm text-gray-600 font-medium">Sepatu</span>
                    <span class="text-sm font-bold text-gray-900 capitalize">{{ $booking->shoe_brand }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-200 pb-2">
                    <span class="text-sm text-gray-600 font-medium">Layanan</span>
                    <span class="text-sm font-bold text-gray-900">{{ $booking->service->name }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-200 pb-2">
                    <span class="text-sm text-gray-600 font-medium">Metode</span>
                    <span class="text-sm font-bold text-blue-600 uppercase">{{ $booking->payment_method }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-200 pb-2">
                    <span class="text-sm text-gray-600 font-medium">Status Pembayaran</span>
                    <span class="text-sm font-bold {{ $booking->payment_status == 'success' ? 'text-green-600' : 'text-orange-500' }} uppercase">
                        {{ $booking->payment_status }}
                    </span>
                </div>
            </div>

            <div class="mt-8 pt-4 border-t-2 border-gray-200 flex justify-between items-center">
                <span class="text-base font-bold text-gray-900 uppercase">Total Bayar</span>
                <span class="text-2xl font-black text-gray-900">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="mt-8 space-y-3">
            <button onclick="window.print()" class="w-full bg-gray-900 text-white font-bold py-3 rounded-xl hover:bg-black transition flex justify-center items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Cetak / Simpan PDF
            </button>
            <a href="{{ route('booking.history') }}" class="block text-center text-sm font-bold text-gray-500 hover:text-blue-700">
                Kembali ke Riwayat
            </a>
        </div>
    </div>

    <style>
        @media print {
            .mt-8, a {
                display: none !important;
            }
            .bg-gray-50\/50 {
                background-color: white !important;
            }
            body {
                background-color: white !important;
            }
        }
    </style>
</x-guest-layout>