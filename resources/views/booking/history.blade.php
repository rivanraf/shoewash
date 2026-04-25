<x-app-layout>
    <div class="py-6 sm:py-12 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header Section --}}
            <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 leading-tight">Riwayat Booking</h1>
                    <p class="text-sm sm:text-base text-gray-600">Pantau status perawatan sepatu Anda secara real-time.</p>
                </div>
                <a href="{{ route('booking.index') }}" class="w-full sm:w-auto">
                    <x-button variant="primary" class="w-full justify-center px-6 py-3 text-sm sm:text-base">
                        {{ __('+ Booking Baru') }}
                    </x-button>
                </a>
            </div>

            {{-- Grid Cards --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 sm:gap-6">
                @forelse($bookings as $booking)
                    @php
                        $isExpired = $booking->payment_status === 'pending' && $booking->expired_at->isPast();
                        $isPaid = $booking->payment_status === 'success';
                    @endphp

                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden flex flex-col transition hover:shadow-md">
                        {{-- Card Header --}}
                        <div class="p-4 sm:p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                            <span class="font-mono text-xs sm:text-sm font-bold text-blue-700 tracking-wider">
                                #{{ $booking->order_number }}
                            </span>
                            
                            @if($isExpired)
                                <span class="px-2.5 py-1 text-[10px] sm:text-xs font-bold uppercase bg-red-100 text-red-700 rounded-lg">Expired</span>
                            @elseif($booking->payment_status === 'pending')
                                <span class="px-2.5 py-1 text-[10px] sm:text-xs font-bold uppercase bg-yellow-100 text-yellow-700 rounded-lg border border-yellow-200">Pending</span>
                            @elseif($isPaid)
                                <span class="px-2.5 py-1 text-[10px] sm:text-xs font-bold uppercase bg-green-100 text-green-700 rounded-lg">Paid</span>
                            @else
                                <span class="px-2.5 py-1 text-[10px] sm:text-xs font-bold uppercase bg-gray-100 text-gray-700 rounded-lg">{{ $booking->payment_status }}</span>
                            @endif
                        </div>

                        {{-- Card Body --}}
                        <div class="p-5 flex-grow">
                            <div class="mb-4">
                                <p class="text-[10px] uppercase text-gray-500 font-bold tracking-widest mb-1">Merek & Jenis</p>
                                <h3 class="text-base sm:text-lg font-bold text-gray-900 capitalize">{{ $booking->shoe_brand }}</h3>
                            </div>

                            <div class="grid grid-cols-2 gap-4 border-b border-gray-50 pb-4 mb-4">
                                <div>
                                    <p class="text-[10px] uppercase text-gray-500 font-bold tracking-widest mb-1">Layanan</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $booking->service->name ?? 'Layanan Dihapus' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] uppercase text-gray-500 font-bold tracking-widest mb-1">Metode Bayar</p>
                                    <p class="text-sm font-bold {{ $booking->payment_method === 'midtrans' ? 'text-blue-600' : 'text-gray-700' }} uppercase">
                                        {{ $booking->payment_method }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-[10px] uppercase text-gray-500 font-bold tracking-widest">Total Harga</p>
                                    <p class="text-lg font-black text-gray-900">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="px-5 pb-4 flex flex-col gap-2">
                            @if($booking->payment_method == 'midtrans' && $booking->payment_status == 'pending' && !$isExpired)
                                <button 
                                    onclick="window.snap.pay('{{ $booking->snap_token }}', {
                                        onSuccess: function(result){ window.location.reload(); },
                                        onPending: function(result){ window.location.reload(); },
                                        onError: function(result){ alert('Pembayaran gagal!'); }
                                    })"
                                    class="w-full justify-center px-4 py-2 text-xs font-black bg-green-600 hover:bg-green-700 text-white rounded-lg transition shadow-sm uppercase tracking-wider active:scale-95"
                                >
                                    {{ __('Bayar Sekarang via Midtrans') }}
                                </button>
                            @endif

                           @if($isPaid || ($booking->payment_method == 'cod' && !$isExpired))
    <a href="{{ route('booking.track', $booking->order_number) }}" class="w-full block">
        <x-button class="w-full flex items-center justify-center gap-2 px-4 py-2 text-xs font-bold bg-blue-600 hover:bg-blue-700 text-white transition shadow-sm rounded-lg">
            {{-- Icon Map/Location --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            
            {{-- Teks --}}
            <span>{{ __('Lacak Progress Sepatu') }}</span>
        </x-button>
    </a>
@endif

                            <a href="{{ route('booking.receipt', $booking->order_number) }}" class="w-full">
                                <x-button variant="secondary" class="w-full justify-center px-4 py-2 text-xs font-bold border-gray-200 bg-white text-gray-700 hover:bg-gray-50 transition shadow-none">
                                    {{ __('Lihat Struk Konfirmasi') }}
                                </x-button>
                            </a>

                            {{-- Tombol Hapus Riwayat Expired --}}
                            @if($isExpired)
                                <form action="{{ route('booking.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Hapus riwayat booking ini?')" class="w-full">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full justify-center px-4 py-2 text-xs font-bold text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition border border-red-100 active:scale-95">
                                        {{ __('Hapus Riwayat Expired') }}
                                    </button>
                                </form>
                            @endif
                        </div>

                        {{-- Footer Info --}}
                        <div class="px-5 py-4 bg-gray-50 border-t border-gray-100 mt-auto flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-[11px] sm:text-xs text-gray-500 italic">
                                @if($isPaid)
                                    Pengerjaan dimulai: <span class="font-semibold text-gray-700">{{ $booking->updated_at->format('d M, H:i') }}</span>
                                @else
                                    Batas Bayar: <span class="font-semibold {{ $isExpired ? 'text-red-500' : 'text-gray-700' }}">{{ $booking->expired_at->format('d M, H:i') }} WIB</span>
                                @endif
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 flex flex-col items-center justify-center text-center bg-white rounded-3xl border-2 border-dashed border-gray-200">
                        <h3 class="text-lg font-bold text-gray-800">Belum Ada Riwayat</h3>
                        <p class="text-sm text-gray-500 mt-1">Anda belum melakukan pemesanan layanan apa pun.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Script Utama Midtrans --}}
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
</x-app-layout>