<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Kelompok 5 CRUD (API Kopi)') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">

                {{-- ✅ Pesan sukses/error --}}
                @if(session('success'))
                    <div class="p-4 mb-4 text-green-800 bg-green-200 rounded">
                        {{ session('success') }}
                    </div>
                @elseif(session('error'))
                    <div class="p-4 mb-4 text-red-800 bg-red-200 rounded">
                        {{ session('error') }}
                    </div>
                @endif

{{-- ➕ Form Tambah Menu --}}
<h3 class="mb-3 text-lg font-semibold">Tambah Menu Baru</h3>

<form action="{{ route('kelompok5.store') }}" method="POST" class="mb-6 space-y-4">
    @csrf

    <div class="grid grid-cols-2 gap-4">
        {{-- Nama Kopi --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Nama Kopi</label>
            <input type="text" name="name" class="w-full px-3 py-2 border rounded focus:ring focus:ring-blue-300" required>
        </div>

        {{-- Kategori --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Kategori</label>
            <input type="text" name="category" value="kopi" class="w-full px-3 py-2 border rounded focus:ring focus:ring-blue-300">
        </div>

        {{-- Harga --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Harga</label>
            <input type="number" name="price" class="w-full px-3 py-2 border rounded focus:ring focus:ring-blue-300" required>
        </div>

        {{-- Gambar --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Gambar (URL)</label>
            <input type="text" name="image" class="w-full px-3 py-2 border rounded focus:ring focus:ring-blue-300" placeholder="contoh: gambar.jpg">
        </div>
    </div>

    {{-- Deskripsi --}}
    <div>
        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
        <textarea name="description" rows="3" class="w-full px-3 py-2 border rounded focus:ring focus:ring-blue-300" required></textarea>
    </div>

    {{-- 🔘 Tombol Simpan Menu --}}
    <div class="flex justify-end pt-2">
        <button type="submit"
            class="px-6 py-2 transition bg-blue-600 rounded text- hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
            + Simpan Menu
        </button>
    </div>
</form>


                {{-- 📋 Tabel Data Kopi --}}
                <h3 class="mb-3 text-lg font-semibold">Daftar Kopi</h3>
                @if(isset($kopi['error']))
                    <div class="p-4 text-red-800 bg-red-200 rounded">{{ $kopi['error'] }}</div>
                @else
                    <table class="min-w-full border border-gray-300">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 border">ID</th>
                                <th class="px-4 py-2 border">Nama</th>
                                <th class="px-4 py-2 border">Deskripsi</th>
                                <th class="px-4 py-2 border">Kategori</th>
                                <th class="px-4 py-2 border">Harga</th>
                                <th class="px-4 py-2 border">Gambar</th>
                                <th class="px-4 py-2 border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kopi['data'] ?? [] as $item)
                                <tr>
                                    <td class="px-4 py-2 border">{{ $item['id'] }}</td>
                                    <td class="px-4 py-2 border">{{ $item['name'] }}</td>
                                    <td class="px-4 py-2 border">{{ $item['description'] }}</td>
                                    <td class="px-4 py-2 border">{{ $item['category'] }}</td>
                                    <td class="px-4 py-2 border">{{ $item['price'] }}</td>
                                    <td class="px-4 py-2 border">
                                        <img src="{{ $item['image'] }}" alt="gambar" class="object-cover w-16 h-16">
                                    </td>
                                    <td class="px-4 py-2 text-center border">
                                        {{-- Tombol Edit --}}
                                        <button
                                            onclick="editData({{ $item['id'] }}, '{{ $item['name'] }}', '{{ $item['description'] }}', '{{ $item['category'] }}', '{{ $item['price'] }}', '{{ $item['image'] }}')"
                                            class="px-3 py-1 text-white bg-yellow-500 rounded hover:bg-yellow-600">
                                            Edit
                                        </button>

                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('kelompok5.destroy', $item['id']) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin hapus menu ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="px-3 py-1 text-white bg-red-600 rounded hover:bg-red-700">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    {{-- 🧱 Modal Edit --}}
    <div id="editModal" class="fixed inset-0 items-center justify-center hidden bg-black bg-opacity-50">
        <div class="w-1/2 p-6 bg-white rounded-lg">
            <h3 class="mb-4 text-lg font-semibold">Edit Data Kopi</h3>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_id" name="id">

                <div class="grid grid-cols-2 gap-4 mb-3">
                    <input type="text" id="edit_name" name="name" class="px-3 py-2 border rounded" placeholder="Nama Kopi">
                    <input type="text" id="edit_category" name="category" class="px-3 py-2 border rounded" placeholder="Kategori">
                    <input type="number" id="edit_price" name="price" class="px-3 py-2 border rounded" placeholder="Harga">
                    <input type="text" id="edit_image" name="image" class="px-3 py-2 border rounded" placeholder="URL Gambar">
                </div>

                <textarea id="edit_description" name="description" rows="3" class="w-full px-3 py-2 border rounded" placeholder="Deskripsi"></textarea>

                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 text-white bg-gray-500 rounded">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 rounded">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Fungsi buka modal edit
        function editData(id, name, description, category, price, image) {
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_description').value = description;
            document.getElementById('edit_category').value = category;
            document.getElementById('edit_price').value = price;
            document.getElementById('edit_image').value = image;
            document.getElementById('editForm').action = `/kelompok5/${id}`;
        }

        // Fungsi tutup modal
        function closeModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
