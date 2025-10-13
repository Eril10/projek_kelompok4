<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Kelompok 3 CRUD (API Gadget House)') }}
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

                {{-- ➕ Form Tambah Produk --}}
                <h3 class="mb-3 text-lg font-semibold">Tambah Produk Baru</h3>
                <form action="{{ route('kelompok3.store') }}" method="POST" class="mb-6 space-y-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">ID Produk</label>
                            <input type="text" name="product_id" class="w-full px-3 py-2 border rounded focus:ring focus:ring-blue-300" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Produk</label>
                            <input type="text" name="product_title" class="w-full px-3 py-2 border rounded focus:ring focus:ring-blue-300" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Harga</label>
                            <input type="number" name="product_price" class="w-full px-3 py-2 border rounded focus:ring focus:ring-blue-300" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Gambar (URL)</label>
                            <input type="text" name="product_img1" class="w-full px-3 py-2 border rounded focus:ring focus:ring-blue-300" placeholder="contoh: produk.webp">
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-2 bg-blue-600 rounded hover:bg-blue-700">
                            + Simpan Produk
                        </button>
                    </div>
                </form>

                {{-- 📋 Tabel Produk --}}
                <h3 class="mb-3 text-lg font-semibold">Daftar Rekomendasi</h3>
                @if(isset($rekomendasi['error']))
                    <div class="p-4 text-red-800 bg-red-200 rounded">{{ $rekomendasi['error'] }}</div>
                @else
                    <table class="min-w-full border border-gray-300">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 border">ID</th>
                                <th class="px-4 py-2 border">Nama Produk</th>
                                <th class="px-4 py-2 border">Harga</th>
                                <th class="px-4 py-2 border">Gambar</th>
                                <th class="px-4 py-2 border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rekomendasi['data'] ?? [] as $item)
                                <tr>
                                    <td class="px-4 py-2 border">{{ $item['product_id'] }}</td>
                                    <td class="px-4 py-2 border">{{ $item['product_title'] }}</td>
                                    <td class="px-4 py-2 border">{{ $item['product_price'] }}</td>
                                    <td class="px-4 py-2 border">
                                        <img src="{{ $item['product_img1'] }}" alt="gambar" class="object-cover w-16 h-16">
                                    </td>
                                    <td class="px-4 py-2 text-center border">
                                        <button
                                            onclick="editData({{ $item['product_id'] }}, '{{ $item['product_title'] }}', '{{ $item['product_price'] }}', '{{ $item['product_img1'] }}')"
                                            class="px-3 py-1 text-white bg-yellow-500 rounded hover:bg-yellow-600">Edit</button>

                                        <form action="{{ route('kelompok3.destroy', $item['product_id']) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin hapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="px-3 py-1 text-white bg-red-600 rounded hover:bg-red-700">Hapus</button>
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
            <h3 class="mb-4 text-lg font-semibold">Edit Produk</h3>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_id" name="product_id">
                <div class="grid grid-cols-2 gap-4 mb-3">
                    <input type="text" id="edit_title" name="product_title" class="px-3 py-2 border rounded" placeholder="Nama Produk">
                    <input type="number" id="edit_price" name="product_price" class="px-3 py-2 border rounded" placeholder="Harga">
                    <input type="text" id="edit_img" name="product_img1" class="px-3 py-2 border rounded" placeholder="URL Gambar">
                </div>
                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 text-white bg-gray-500 rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editData(id, title, price, img) {
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_title').value = title;
            document.getElementById('edit_price').value = price;
            document.getElementById('edit_img').value = img;
            document.getElementById('editForm').action = `/kelompok3/${id}`;
        }

        function closeModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
