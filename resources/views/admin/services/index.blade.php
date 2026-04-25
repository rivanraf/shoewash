<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Manajemen Layanan</h1>
                    <p class="text-gray-600">Atur jenis cuci, harga, dan deskripsi layanan Shoewash.</p>
                </div>
                {{-- Tombol Tambah (Bisa pakai Modal atau Collapse) --}}
                <button onclick="document.getElementById('form-tambah').classList.toggle('hidden')" class="bg-blue-600 text-white px-6 py-2 rounded-xl font-bold hover:bg-blue-700 transition">
                    + Tambah Layanan
                </button>
            </div>

            {{-- Form Tambah (Hidden by Default) --}}
            <div id="form-tambah" class="hidden mb-8 bg-white p-6 rounded-2xl border border-blue-100 shadow-sm">
                <form action="{{ route('admin.services.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <input type="text" name="name" placeholder="Nama Layanan (ex: Deep Clean)" class="rounded-xl border-gray-200 text-sm" required>
                        <input type="number" name="price" placeholder="Harga (ex: 50000)" class="rounded-xl border-gray-200 text-sm" required>
                        <input type="text" name="description" placeholder="Deskripsi Singkat" class="rounded-xl border-gray-200 text-sm">
                    </div>
                    <button type="submit" class="mt-4 bg-green-600 text-white px-6 py-2 rounded-xl font-bold text-sm">Simpan Layanan</button>
                </form>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-200 mb-8 shadow-sm">
                <h3 class="font-bold text-gray-800 mb-4">Pengaturan Kuota Mingguan</h3>
                <form action="{{ route('admin.settings.updateQuota') }}" method="POST" class="flex items-center gap-4">
                    @csrf
                    <div class="flex-grow">
                        <input type="number" name="weekly_quota" 
                            value="{{ \DB::table('settings')->where('key', 'weekly_quota')->value('value') ?? 6 }}" 
                            class="w-full rounded-xl border-gray-200">
                    </div>
                    <x-button type="submit" variant="primary">Update Kuota</x-button>
                </form>
            </div>

            {{-- Table Layanan --}}
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-[10px] uppercase font-black text-gray-400 tracking-widest">Nama Layanan</th>
                            <th class="px-6 py-4 text-[10px] uppercase font-black text-gray-400 tracking-widest">Harga</th>
                            <th class="px-6 py-4 text-[10px] uppercase font-black text-gray-400 tracking-widest">Deskripsi</th>
                            <th class="px-6 py-4 text-[10px] uppercase font-black text-gray-400 tracking-widest text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($services as $s)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4 font-bold text-gray-900">{{ $s->name }}</td>
                            <td class="px-6 py-4 text-blue-600 font-mono font-bold">Rp {{ number_format($s->price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $s->description }}</td>
                            <td class="px-6 py-4 text-right flex justify-end gap-2">
                                {{-- Tombol Delete --}}
                                <form action="{{ route('admin.services.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Hapus layanan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>