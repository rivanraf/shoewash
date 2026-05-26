<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Laporan Keuangan</h1>
                    <p class="text-gray-600">Analisis pendapatan dan performa layanan Shoewash.</p>
                </div>
                <button onclick="window.print()" class="bg-white border border-gray-300 px-4 py-2 rounded-xl text-sm font-bold flex items-center gap-2 hover:bg-gray-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak Laporan
                </button>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                {{-- Card Pendapatan Bulanan dengan Dropdown Filter --}}
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                            Pendapatan {{ $months[$selectedMonth] }}
                        </p>
                        
                        {{-- Form Filter Dropdown Bulan --}}
                        <form action="{{ url('/admin/report') }}" method="GET" id="monthFilterForm" class="m-0 p-0">
                            <select 
                                name="month" 
                                onchange="document.getElementById('monthFilterForm').submit()"
                                class="text-xs font-bold text-gray-600 bg-gray-50 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 py-1 px-2 cursor-pointer outline-none"
                            >
                                @foreach($months as $number => $name)
                                    <option value="{{ $number }}" {{ $selectedMonth == $number ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                    <h2 class="text-2xl font-black text-blue-700 mt-2">Rp {{ number_format($report['monthly_revenue'], 0, ',', '.') }}</h2>
                </div>

                {{-- Card Pendapatan Tahun Ini --}}
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Pendapatan Tahun Ini</p>
                    <h2 class="text-2xl font-black text-gray-900 mt-2">Rp {{ number_format($report['yearly_revenue'], 0, ',', '.') }}</h2>
                </div>

                {{-- Card Total Seluruh Pendapatan --}}
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Seluruh Pendapatan</p>
                    <h2 class="text-2xl font-black text-green-600 mt-2">Rp {{ number_format($report['total_revenue'], 0, ',', '.') }}</h2>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Detail Layanan Terpopuler --}}
                <div class="lg:col-span-1">
                    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                        <h3 class="font-bold text-gray-900 mb-6">Performa Layanan</h3>
                        <div class="space-y-6">
                            @foreach($report['top_services'] as $top)
                            <div>
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="font-bold text-gray-700">{{ $top->service->name }}</span>
                                    <span class="text-gray-500">{{ $top->total }} Order</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($top->total / max($report['top_services']->pluck('total')->toArray() ?: [1])) * 100 }}%"></div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Tabel Transaksi Terakhir --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-gray-100">
                            <h3 class="font-bold text-gray-900">Riwayat Transaksi Sukses</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-gray-50 text-[10px] font-bold text-gray-400 uppercase">
                                    <tr>
                                        <th class="px-6 py-4">Order</th>
                                        <th class="px-6 py-4">Layanan</th>
                                        <th class="px-6 py-4 text-right">Nominal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($transactions as $t)
                                    <tr class="text-sm">
                                        <td class="px-6 py-4">
                                            <span class="font-bold text-gray-900">#{{ $t->order_number }}</span>
                                            <p class="text-xs text-gray-500">{{ $t->updated_at->format('d M Y') }}</p>
                                        </td>
                                        <td class="px-6 py-4 text-gray-600">{{ $t->service->name }}</td>
                                        <td class="px-6 py-4 text-right font-bold text-gray-900">
                                            Rp {{ number_format($t->total_price, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>