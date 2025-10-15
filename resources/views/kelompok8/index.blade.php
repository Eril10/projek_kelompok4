<x-app-layout>
<x-slot name="header">
    <h2 class="text-xl font-semibold text-gray-800">Kelompok 8 – Cafeku CRUD API ☕</h2>
</x-slot>

<div class="py-6">
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow">
        {{-- Pesan sukses/error --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4">{{ session('error') }}</div>
        @endif

        {{-- Form Tambah --}}
        <h3 class="font-semibold mb-3 text-lg">Tambah Produk Baru</h3>
        <form method="POST" action="{{ route('kelompok8.store') }}" class="grid grid-cols-2 gap-4 mb-6">
            @csrf
            <input type="text" name="title" placeholder="Nama Produk" class="border p-2 rounded" required>
            <input type="number" name="price" placeholder="Harga" class="border p-2 rounded" required>
            <input type="number" name="stock" placeholder="Stok" class="border p-2 rounded">
            <input type="text" name="image" placeholder="Nama File Gambar (contoh: espresso.jpg)" class="border p-2 rounded">
            <textarea name="description" rows="2" placeholder="Deskripsi" class="border p-2 col-span-2 rounded"></textarea>
            <button class="bg-blue-600 hover:bg-blue-700 text-white py-2 rounded col-span-2">Tambah Produk</button>
        </form>

        {{-- Daftar Produk --}}
        <h3 class="font-semibold mb-3 text-lg">Daftar Menu</h3>
        <table class="w-full border border-gray-300 text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-3 py-2">ID</th>
                    <th class="border px-3 py-2">Nama</th>
                    <th class="border px-3 py-2">Deskripsi</th>
                    <th class="border px-3 py-2">Harga</th>
                    <th class="border px-3 py-2">Stok</th>
                    <th class="border px-3 py-2">Gambar</th>
                    <th class="border px-3 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                    <tr>
                        <td class="border px-3 py-2">{{ $item['id'] }}</td>
                        <td class="border px-3 py-2">{{ $item['title'] }}</td>
                        <td class="border px-3 py-2">{{ $item['description'] }}</td>
                        <td class="border px-3 py-2">{{ $item['price'] }}</td>
                        <td class="border px-3 py-2">{{ $item['stock'] }}</td>
                        <td class="border px-3 py-2">
                            <img src="https://dodgerblue-monkey-417412.hostingersite.com/storage/products/{{ $item['image'] }}"
                                 class="w-16 h-16 object-cover rounded">
                        </td>
                        <td class="border px-3 py-2 text-center">
                            <button onclick="openEditModal({{ json_encode($item) }})"
                                    class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">Edit</button>
                            <form action="{{ route('kelompok8.delete', $item['id']) }}" method="POST"
                                  class="inline-block" onsubmit="return confirm('Yakin hapus produk ini?')">
                                @csrf @method('DELETE')
                                <button class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL EDIT --}}
<div id="editModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden justify-center items-center">
    <div class="bg-white p-6 rounded-lg w-1/2 shadow">
        <h3 class="text-lg font-semibold mb-4">Edit Produk</h3>
        <form id="editForm" method="POST">
            @csrf @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <input id="editTitle" name="title" class="border p-2 rounded" required>
                <input id="editPrice" name="price" type="number" class="border p-2 rounded" required>
                <input id="editStock" name="stock" type="number" class="border p-2 rounded">
                <input id="editImage" name="image" class="border p-2 rounded">
            </div>
            <textarea id="editDesc" name="description" rows="3"
                      class="border p-2 w-full rounded mt-3"></textarea>
            <div class="flex justify-end mt-4">
                <button type="button" onclick="closeEditModal()"
                        class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Batal</button>
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(item) {
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editTitle').value = item.title ?? '';
    document.getElementById('editPrice').value = item.price ?? '';
    document.getElementById('editStock').value = item.stock ?? '';
    document.getElementById('editImage').value = item.image ?? '';
    document.getElementById('editDesc').value = item.description ?? '';
    document.getElementById('editForm').action = /kelompok8/update/${item.id};
}
function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}
</script>
</x-app-layout>