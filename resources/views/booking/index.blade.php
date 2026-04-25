<x-app-layout>
    <div class="py-6 sm:py-12 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Bagian Alert Error & Success --}}
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-lg shadow-sm">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-lg shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-8 flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Halaman Booking</h1>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-button variant="secondary" type="submit">Keluar</x-button>
                </form>
            </div>

            {{-- 1. LOGIKA QUOTA --}}
            @php 
                $quota = \App\Http\Controllers\BookingController::getQuotaStatus(); 
                $isFull = $quota['is_full'];
            @endphp

            @if($isFull)
                <div class="mb-8 p-6 bg-red-50 border-2 border-red-200 rounded-3xl text-center shadow-sm">
                    <h3 class="text-xl font-black text-red-900 uppercase">Kuota Minggu Ini Penuh!</h3>
                    <p class="text-sm text-red-700">Kami membatasi layanan maksimal {{ $quota['max'] }} sepatu per minggu.</p>
                </div>
            @endif

            {{-- 2. FORM UTAMA --}}
            <form action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data" 
                  x-data="{ 
                    selectedService: '{{ old('service') }}', 
                    imagePreview: null,
                    handleFile(e) {
                        const file = e.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = (e) => { this.imagePreview = e.target.result; };
                            reader.readAsDataURL(file);
                        }
                    }
                  }">
                @csrf
                
                <div class="bg-white shadow-sm rounded-2xl border border-gray-200 p-8 mb-10 transition-all">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                        {{-- Input Data Kiri --}}
                        <div class="space-y-6">
                            <div>
                                <x-input-label for="phone" value="Nomor WhatsApp" />
                                <x-text-input id="phone" name="phone" type="text" class="block w-full mt-1" :value="old('phone')" placeholder="Contoh: 081234567xxx" required />
                            </div>
                            <div>
                                <x-input-label for="shoe_type" value="Merek & Model Sepatu" />
                                <x-text-input id="shoe_type" name="shoe_type" type="text" class="block w-full mt-1" :value="old('shoe_type')" placeholder="Contoh: Nike Air Jordan 1" required />
                            </div>
                            <div>
                                <x-input-label for="pickup_method" value="Metode Pembayaran" />
                                <select name="pickup_method" class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm text-gray-700 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="cod">COD (Bayar di Toko)</option>
                                    <option value="midtrans">Midtrans (Pembayaran Digital)</option>
                                </select>
                            </div>
                        </div>

                        {{-- Dropzone Area Kanan --}}
                        <div class="flex flex-col">
                            <x-input-label value="Foto Kondisi Sepatu (Awal)" class="mb-2" />
                            
                            <div class="flex items-center justify-center w-full">
                                <label for="dropzone-file" 
                                       class="flex flex-col items-center justify-center w-full h-64 bg-gray-50 border-2 border-dashed border-gray-300 rounded-2xl cursor-pointer hover:bg-gray-100 transition-colors relative overflow-hidden group">
                                    
                                    {{-- Placeholder jika gambar belum dipilih --}}
                                    <div x-show="!imagePreview" class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-10 h-10 mb-4 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold text-blue-600">Klik untuk upload</span> atau seret gambar</p>
                                        <p class="text-xs text-gray-400">PNG, JPG atau JPEG (Maks. 2MB)</p>
                                    </div>

                                    {{-- Preview jika gambar sudah dipilih --}}
                                    <div x-show="imagePreview" class="absolute inset-0 w-full h-full">
                                        <img :src="imagePreview" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <p class="text-white text-xs font-bold uppercase tracking-widest">Ganti Gambar</p>
                                        </div>
                                    </div>

                                    <input id="dropzone-file" name="shoe_image" type="file" class="hidden" @change="handleFile" accept="image/*" />
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 3. LOOPING SERVICES --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                    @foreach($services as $s)
                        <div @click="selectedService = '{{ $s->id }}'" 
                             :class="selectedService == '{{ $s->id }}' ? 'border-blue-600 ring-2 ring-blue-600 bg-blue-50/30' : 'border-gray-200 hover:border-blue-300'"
                             class="bg-white p-6 rounded-2xl border cursor-pointer transition-all shadow-sm">
                            <h2 class="font-bold text-gray-900">{{ $s->name }}</h2>
                            <p class="text-xs text-gray-500 mt-2 leading-relaxed">{{ $s->description }}</p>
                            <p class="mt-4 font-black text-lg text-blue-700">Rp {{ number_format($s->price, 0, ',', '.') }}</p>
                        </div>
                    @endforeach
                </div>

                <input type="hidden" name="service" :value="selectedService" required>

                {{-- 4. FOOTER & TOMBOL SUBMIT --}}
                <div class="bg-white p-6 rounded-2xl border border-gray-200 flex flex-col sm:flex-row justify-between items-center shadow-sm gap-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <p class="text-xs text-gray-500 italic">Layanan profesional & terjamin kebersihannya.</p>
                    </div>
                    
                    @if($isFull)
                        <x-button type="button" disabled class="bg-gray-400 cursor-not-allowed opacity-50 px-10 py-4">
                            Maaf, Kuota Penuh
                        </x-button>
                    @else
                        <x-button type="submit" variant="primary" 
                                  ::disabled="!selectedService"
                                  :class="!selectedService ? 'opacity-50 cursor-not-allowed' : 'hover:scale-105 transition-transform'"
                                  class="px-10 py-4 shadow-lg text-sm font-black uppercase tracking-widest">
                            Konfirmasi Booking
                        </x-button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</x-app-layout>