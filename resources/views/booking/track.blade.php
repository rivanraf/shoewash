<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8">
                    <h2 class="text-2xl font-black text-gray-900 mb-2">Tracking Sepatu</h2>
                    <p class="text-gray-500 text-sm mb-4">Order ID: <span class="font-mono font-bold text-blue-600">#{{ $booking->order_number }}</span></p>

                    {{-- Status Indicator Message (Tambahan Baru) --}}
                    <div class="status-indicator mb-8 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                        <p class="text-[10px] uppercase text-gray-400 font-black tracking-widest mb-1">Status Saat Ini</p>
                        @if($booking->status == 'processing')
                            <p class="text-blue-600 font-bold">Pesanan Anda sedang diproses oleh tim kami.</p>
                        @elseif($booking->status == 'washing')
                            <p class="text-indigo-600 font-bold">Sepatu Anda sedang dalam tahap pencucian.</p>
                        @elseif($booking->status == 'ready')
                            <p class="text-green-600 font-bold">Sepatu selesai! Silahkan ambil atau tunggu kurir kami.</p>
                        @elseif($booking->status == 'success')
                            <p class="text-green-700 font-bold">Transaksi Selesai. Terima kasih telah menggunakan layanan kami!</p>
                        @else
                            <p class="text-gray-500 font-bold">Menunggu konfirmasi admin.</p>
                        @endif
                    </div>

                    {{-- Progress Stepper --}}
                    <div class="space-y-8 relative">
                        {{-- Garis Tengah --}}
                        <div class="absolute left-[11px] top-2 bottom-2 w-0.5 bg-gray-200"></div>

                        @php
                            // Sinkronisasi key dengan status yang ada di database/admin
                            $steps = [
                                'pending'    => ['label' => 'Pesanan Diterima', 'desc' => 'Menunggu konfirmasi admin'],
                                'processing' => ['label' => 'Dikonfirmasi', 'desc' => 'Pesanan Anda telah divalidasi dan masuk antrean'],
                                'washing'    => ['label' => 'Sedang Dicuci', 'desc' => 'Sepatu Anda dalam proses pembersihan'],
                                'ready'      => ['label' => 'Siap Diambil', 'desc' => 'Sepatu sudah bersih dan bisa diambil'],
                                'success'    => ['label' => 'Selesai', 'desc' => 'Transaksi telah selesai'],
                            ];
                            $currentStatus = $booking->status;
                            $reached = true;
                        @endphp

                        @foreach($steps as $key => $step)
                            <div class="relative flex items-start group">
                                {{-- Dot Status --}}
                                <div class="z-10 flex items-center justify-center w-6 h-6 rounded-full {{ $reached ? 'bg-blue-600 shadow-md shadow-blue-200' : 'bg-gray-200' }}">
                                    @if($reached)
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>
                                    @endif
                                </div>
                                
                                <div class="ml-6">
                                    <h3 class="text-sm font-bold {{ $reached ? 'text-gray-900' : 'text-gray-400' }}">{{ $step['label'] }}</h3>
                                    <p class="text-xs {{ $reached ? 'text-gray-600' : 'text-gray-300' }}">{{ $step['desc'] }}</p>
                                </div>
                            </div>
                            {{-- Jika loop mencapai status saat ini, hentikan pewarnaan biru (reached) untuk step selanjutnya --}}
                            @if($key == $currentStatus) @php $reached = false; @endphp @endif
                        @endforeach
                    </div>

                    <div class="mt-10 pt-6 border-t border-gray-100 flex justify-center">
                        <x-button variant="secondary" onclick="window.location.reload()" class="text-xs">
                            Refresh Status
                        </x-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>