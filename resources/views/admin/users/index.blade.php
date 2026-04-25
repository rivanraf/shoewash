<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Manajemen User & Staff</h1>
                <p class="text-gray-600 mt-1">Kelola hak akses admin dan pantau seluruh pengguna sistem.</p>
            </div>

            {{-- Form Input Admin Baru (Card Style) --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mb-8">
                <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                    <h2 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Daftarkan Admin Toko Baru</h2>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            {{-- Nama --}}
                            <div>
                                <x-input-label for="name" :value="__('Nama Lengkap')" class="text-xs mb-1" />
                                <x-text-input id="name" name="name" type="text" class="w-full text-sm" placeholder="Contoh: Budi Staf" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-1" />
                            </div>

                            {{-- Email --}}
                            <div>
                                <x-input-label for="email" :value="__('Email')" class="text-xs mb-1" />
                                <x-text-input id="email" name="email" type="email" class="w-full text-sm" placeholder="staf@email.com" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-1" />
                            </div>

                            {{-- Password --}}
                            <div>
                                <x-input-label for="password" :value="__('Password')" class="text-xs mb-1" />
                                <x-text-input id="password" name="password" type="password" class="w-full text-sm" placeholder="••••••••" required />
                                <x-input-error :messages="$errors->get('password')" class="mt-1" />
                            </div>

                            {{-- Konfirmasi Password --}}
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-xs mb-1" />
                                <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="w-full text-sm" placeholder="••••••••" required />
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <x-button type="submit" class="px-6 py-2.5 text-xs font-bold uppercase tracking-widest bg-blue-600 hover:bg-blue-700">
                                + Tambah Admin Sekarang
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Daftar User (Table Card) --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Nama / Email</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Role</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Bergabung</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($users as $user)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $user->name }}</div>
                                    <div class="text-xs text-blue-600 font-mono">{{ $user->email }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($user->role === 'admin')
                                        <span class="px-2 py-1 text-[10px] font-bold bg-red-100 text-red-700 rounded-md uppercase">Admin</span>
                                    @else
                                        <span class="px-2 py-1 text-[10px] font-bold bg-blue-100 text-blue-700 rounded-md uppercase">Customer</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-500">
                                    {{ $user->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-2">
                                        <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            @if($user->role === 'admin')
                                                <x-button type="submit" variant="secondary" class="text-[10px] px-3 py-1.5 border-red-200 text-red-600 hover:bg-red-50">
                                                    Suspend
                                                </x-button>
                                            @else
                                                <x-button type="submit" variant="primary" class="text-[10px] px-3 py-1.5">
                                                    Promote
                                                </x-button>
                                            @endif
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>