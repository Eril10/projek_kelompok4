<x-app-layout>
<x-slot name="header">
    <h2 class="text-xl font-semibold text-gray-800">Kelompok 1 - Rental Baju CRUD</h2>
</x-slot>

<div class="py-6">
    <div class="max-w-6xl p-6 mx-auto bg-white rounded-lg shadow">
        @if(session('success'))
            <div class="p-3 mb-4 text-green-800 bg-green-100 rounded">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="p-3 mb-4 text-red-800 bg-red-100 rounded">{{ session('error') }}</div>
        @endif

        <h3 class="mb-3 font-semibold">Tambah Produk Baru</h3>
        <form method="POST" action="{{ route('kelompok1.store') }}" class="grid grid-cols-2 gap-4 mb-6">
            @csrf
            <input type="text" name="name" placeholder="Nama Produk" class="p-2 border rounded" required>
            <input type="text" name="category" placeholder="Kategori" class="p-2 border rounded" required>
            <input type="number" name="price" placeholder="Harga" class="p-2 border rounded" required>
            <input type="text" name="imageUrl" placeholder="URL Gambar" class="p-2 border rounded">
            <textarea name="description" rows="2" placeholder="Deskripsi" class="col-span-2 p-2 border rounded"></textarea>
            <button class="col-span-2 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Tambah</button>
        </form>

        <h3 class="mb-3 font-semibold">Daftar Produk</h3>
        <table class="w-full text-sm border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-3 py-2 border">Nama</th>
                    <th class="px-3 py-2 border">Kategori</th>
                    <th class="px-3 py-2 border">Harga</th>
                    <th class="px-3 py-2 border">Deskripsi</th>
                    <th class="px-3 py-2 border">Gambar</th>
                    <th class="px-3 py-2 text-center border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                    <tr>
                        <td class="px-3 py-2 border">{{ $item['name'] }}</td>
                        <td class="px-3 py-2 border">{{ $item['category']['name'] ?? '-' }}</td>
                        <td class="px-3 py-2 border">{{ $item['currentPrice'] }}</td>
                        <td class="px-3 py-2 border">{{ $item['description'] ?? '-' }}</td>
                        <td class="px-3 py-2 border">
                            <img src="{{ $item['imageUrl'] ?? '#' }}" class="object-cover w-16 h-16 rounded">
                        </td>
                        <td class="px-3 py-2 text-center border">
                            <button onclick="openEditModal({{ json_encode($item) }})" class="px-2 py-1 text-white bg-yellow-500 rounded hover:bg-yellow-600">Edit</button>
                            <form action="{{ route('kelompok1.destroy', $item['id']) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus?')">
                                @csrf @method('DELETE')
                                <button class="px-2 py-1 text-white bg-red-600 rounded hover:bg-red-700">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL EDIT --}}
<div id="editModal" class="fixed inset-0 items-center justify-center hidden bg-gray-900 bg-opacity-50">
    <div class="w-1/2 p-6 bg-white rounded-lg shadow">
        <h3 class="mb-4 text-lg font-semibold">Edit Produk</h3>
        <form id="editForm" method="POST">
            @csrf @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <input id="editName" name="name" class="p-2 border rounded" required>
                <input id="editCategory" name="category" class="p-2 border rounded" required>
                <input id="editPrice" name="price" type="number" class="p-2 border rounded" required>
                <input id="editImage" name="imageUrl" class="p-2 border rounded">
            </div>
            <textarea id="editDesc" name="description" rows="3" class="w-full p-2 mt-3 border rounded"></textarea>
            <div class="flex justify-end mt-4">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 mr-2 text-white bg-gray-500 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(item) {
        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editName').value = item.name ?? '';
        document.getElementById('editCategory').value = item.category?.name ?? '';
        document.getElementById('editPrice').value = item.currentPrice ?? '';
        document.getElementById('editImage').value = item.imageUrl ?? '';
        document.getElementById('editDesc').value = item.description ?? '';
        document.getElementById('editForm').action = `/kelompok1/${item.id}`;
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
</script>
</x-app-layout>
