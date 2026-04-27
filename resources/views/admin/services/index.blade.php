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
                            <th class="px-6 py-4 text-[10px] uppercase font-black text-gray-400 tracking-widest text-center">Status</th>
                            <th class="px-6 py-4 text-[10px] uppercase font-black text-gray-400 tracking-widest text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($services as $s)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4 font-bold text-gray-900">{{ $s->name }}</td>
                            <td class="px-6 py-4 text-blue-600 font-mono font-bold">Rp {{ number_format($s->price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $s->description }}</td>
                            <td class="px-6 py-4 text-center">
                                @if($s->is_active)
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Aktif</span>
                                @else
                                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right flex justify-end gap-2">
                                {{-- Tombol Edit --}}
                                <button type="button" onclick="openEditModal({{ $s->id }}, '{{ addslashes($s->name) }}', {{ $s->price }}, '{{ addslashes($s->description) }}', {{ $s->is_active ? 'true' : 'false' }})" class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>

                                {{-- Tombol Toggle Status --}}
                                <form action="{{ route('admin.services.destroy', $s->id) }}" method="POST" onsubmit="return confirm('{{ $s->is_active ? 'Nonaktifkan' : 'Aktifkan' }} layanan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 {{ $s->is_active ? 'text-red-500 hover:bg-red-50' : 'text-green-500 hover:bg-green-50' }} rounded-lg transition" title="{{ $s->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        @if($s->is_active)
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        @endif
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

    {{-- Modal Edit --}}
    <div id="edit-modal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
        <div class="bg-white p-6 rounded-2xl w-full max-w-md shadow-xl">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-900">Edit Layanan</h3>
                <button type="button" onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="edit-form" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Layanan</label>
                        <input type="text" name="name" id="edit-name" class="w-full rounded-xl border-gray-200 text-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                        <input type="number" name="price" id="edit-price" class="w-full rounded-xl border-gray-200 text-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <input type="text" name="description" id="edit-description" class="w-full rounded-xl border-gray-200 text-sm">
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="is_active" id="edit-is_active" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <label for="edit-is_active" class="text-sm text-gray-700">Layanan Aktif</label>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition">Batal</button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, name, price, description, isActive) {
            document.getElementById('edit-modal').classList.remove('hidden');
            document.getElementById('edit-modal').classList.add('flex');
            
            document.getElementById('edit-form').action = `/admin/services/${id}`;
            
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-price').value = price;
            document.getElementById('edit-description').value = description;
            document.getElementById('edit-is_active').checked = isActive;
        }

        function closeEditModal() {
            document.getElementById('edit-modal').classList.add('hidden');
            document.getElementById('edit-modal').classList.remove('flex');
        }
    </script>
</x-app-layout>