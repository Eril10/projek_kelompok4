<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ __('Kelompok 9 CRUD (JustBuy API)') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 bg-white rounded-lg shadow">

                {{-- ✅ Notifikasi --}}
                @if(session('success'))
                    <div class="p-4 mb-4 text-green-800 bg-green-200 rounded">{{ session('success') }}</div>
                @elseif(session('error'))
                    <div class="p-4 mb-4 text-red-800 bg-red-200 rounded">{{ session('error') }}</div>
                @endif

                {{-- ➕ Tambah Akun --}}
                <h3 class="mb-3 text-lg font-semibold">Tambah Akun Game</h3>
                <form action="{{ route('kelompok9.store') }}" method="POST" class="grid grid-cols-2 gap-4 mb-6">
                    @csrf
                    <div>
                        <label>Penjual</label>
                        <input type="text" name="penjual" class="w-full px-3 py-2 border rounded" required>
                    </div>
                    <div>
                        <label>Game</label>
                        <select name="game" class="w-full px-3 py-2 border rounded">
                            <option value="ML">Mobile Legends</option>
                            <option value="AOV">AOV</option>
                            <option value="WR">Wild Rift</option>
                        </select>
                    </div>
                    <div><label>Skin</label><input type="number" name="skin" class="w-full px-3 py-2 border rounded" required></div>
                    <div><label>Hero</label><input type="number" name="hero" class="w-full px-3 py-2 border rounded" required></div>
                    <div><label>Rank</label><input type="text" name="rank" class="w-full px-3 py-2 border rounded"></div>
                    <div><label>Harga</label><input type="number" name="price" class="w-full px-3 py-2 border rounded"></div>
                    <div class="col-span-2">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" rows="2" class="w-full px-3 py-2 border rounded"></textarea>
                    </div>
                    <div class="col-span-2">
                        <label>Gambar (URL)</label>
                        <input type="text" name="preview_image" class="w-full px-3 py-2 border rounded">
                    </div>
                    <div class="flex justify-end col-span-2">
                        <button type="submit" class="px-6 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Simpan</button>
                    </div>
                </form>

                {{-- 📋 Daftar Akun ML --}}
                <h3 class="mt-6 mb-3 text-lg font-semibold">Daftar Akun Mobile Legends</h3>
                <table class="min-w-full mb-8 border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">Penjual</th>
                            <th class="px-4 py-2 border">Skin</th>
                            <th class="px-4 py-2 border">Hero</th>
                            <th class="px-4 py-2 border">Rank</th>
                            <th class="px-4 py-2 border">Harga</th>
                            <th class="px-4 py-2 border">Gambar</th>
                            <th class="px-4 py-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ml ?? [] as $item)
                            <tr>
                                <td class="px-4 py-2 border">{{ $item['penjual'] ?? '-' }}</td>
                                <td class="px-4 py-2 border">{{ $item['skin'] ?? '-' }}</td>
                                <td class="px-4 py-2 border">{{ $item['hero'] ?? '-' }}</td>
                                <td class="px-4 py-2 border">{{ $item['rank'] ?? '-' }}</td>
                                <td class="px-4 py-2 border">{{ $item['price'] ?? '-' }}</td>
                                <td class="px-4 py-2 border">
                                    <img src="{{ $item['preview_image'] ?? '' }}" class="object-cover w-16 h-16 rounded">
                                </td>
                                <td class="px-4 py-2 text-center border">
                                    <form action="{{ route('kelompok9.destroy', ['id' => $item['id'] ?? 0]) }}"
                                          method="POST"
                                          onsubmit="return confirm('Hapus akun ML ini?')"
                                          class="inline-block">
                                        @csrf @method('DELETE')
                                        <button class="px-3 py-1 text-white bg-red-600 rounded hover:bg-red-700">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- 📋 Daftar Akun AOV --}}
                <h3 class="mt-6 mb-3 text-lg font-semibold">Daftar Akun AOV</h3>
                <table class="min-w-full mb-8 border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">Penjual</th>
                            <th class="px-4 py-2 border">Skin</th>
                            <th class="px-4 py-2 border">Hero</th>
                            <th class="px-4 py-2 border">Rank</th>
                            <th class="px-4 py-2 border">Harga</th>
                            <th class="px-4 py-2 border">Gambar</th>
                            <th class="px-4 py-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($aov ?? [] as $item)
                            <tr>
                                <td class="px-4 py-2 border">{{ $item['penjual'] ?? '-' }}</td>
                                <td class="px-4 py-2 border">{{ $item['skin'] ?? '-' }}</td>
                                <td class="px-4 py-2 border">{{ $item['hero'] ?? '-' }}</td>
                                <td class="px-4 py-2 border">{{ $item['rank'] ?? '-' }}</td>
                                <td class="px-4 py-2 border">{{ $item['price'] ?? '-' }}</td>
                                <td class="px-4 py-2 border">
                                    <img src="{{ $item['preview_image'] ?? '' }}" class="object-cover w-16 h-16 rounded">
                                </td>
                                <td class="px-4 py-2 text-center border">
                                    <button class="px-3 py-1 text-white bg-gray-400 rounded cursor-not-allowed"
                                            title="Hapus hanya tersedia untuk akun ML" disabled>
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- 📋 Daftar Akun WR --}}
                <h3 class="mt-6 mb-3 text-lg font-semibold">Daftar Akun Wild Rift</h3>
                <table class="min-w-full border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">Penjual</th>
                            <th class="px-4 py-2 border">Skin</th>
                            <th class="px-4 py-2 border">Hero</th>
                            <th class="px-4 py-2 border">Rank</th>
                            <th class="px-4 py-2 border">Harga</th>
                            <th class="px-4 py-2 border">Gambar</th>
                            <th class="px-4 py-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($wr ?? [] as $item)
                            <tr>
                                <td class="px-4 py-2 border">{{ $item['penjual'] ?? '-' }}</td>
                                <td class="px-4 py-2 border">{{ $item['skin'] ?? '-' }}</td>
                                <td class="px-4 py-2 border">{{ $item['hero'] ?? '-' }}</td>
                                <td class="px-4 py-2 border">{{ $item['rank'] ?? '-' }}</td>
                                <td class="px-4 py-2 border">{{ $item['price'] ?? '-' }}</td>
                                <td class="px-4 py-2 border">
                                    <img src="{{ $item['preview_image'] ?? '' }}" class="object-cover w-16 h-16 rounded">
                                </td>
                                <td class="px-4 py-2 text-center border">
                                    <button class="px-3 py-1 text-white bg-gray-400 rounded cursor-not-allowed"
                                            title="Hapus hanya tersedia untuk akun ML" disabled>
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>
