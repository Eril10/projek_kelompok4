<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Kelompok 7 - SobatPromo CRUD API
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white rounded-lg shadow">

                {{-- Alert pesan --}}
                @if(session('success'))
                    <div class="p-3 mb-3 text-green-800 bg-green-100 rounded">{{ session('success') }}</div>
                @elseif(session('error'))
                    <div class="p-3 mb-3 text-red-800 bg-red-100 rounded">{{ session('error') }}</div>
                @endif

                {{-- Form Tambah --}}
                <h3 class="mb-3 text-lg font-semibold">Tambah Promo Baru</h3>
                <form action="{{ route('kelompok7.store') }}" method="POST" class="mb-6">
                    @csrf
                    <div class="grid grid-cols-3 gap-4">
                        <input type="text" name="title" placeholder="Judul Promo" class="p-2 border rounded" required>
                        <input type="text" name="description" placeholder="Deskripsi Promo" class="p-2 border rounded" required>
                        <input type="date" name="valid_until" class="p-2 border rounded" required>
                    </div>
                    <button class="px-4 py-2 mt-3 text-white bg-blue-600 rounded hover:bg-blue-700">Tambah Promo</button>
                </form>

                {{-- Tabel daftar promo --}}
                <h3 class="mb-3 text-lg font-semibold">Daftar Promo</h3>
                <table class="w-full text-sm border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-3 py-2 border">ID</th>
                            <th class="px-3 py-2 border">Judul</th>
                            <th class="px-3 py-2 border">Deskripsi</th>
                            <th class="px-3 py-2 border">Berlaku Sampai</th>
                            <th class="px-3 py-2 text-center border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $promo)
                            <tr>
                                <td class="px-3 py-2 border">{{ $promo['id'] ?? '-' }}</td>
                                <td class="px-3 py-2 border">{{ $promo['title'] ?? '-' }}</td>
                                <td class="px-3 py-2 border">{{ $promo['description'] ?? '-' }}</td>
                                <td class="px-3 py-2 border">{{ $promo['valid_until'] ?? '-' }}</td>
                                <td class="px-3 py-2 text-center border">
                                    <button
                                        onclick="openEditModal({{ json_encode($promo) }})"
                                        class="px-2 py-1 text-white bg-yellow-500 rounded hover:bg-yellow-600">
                                        Edit
                                    </button>

                                    <form action="{{ route('kelompok7.destroy', $promo['id']) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus promo ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-2 py-1 text-white bg-red-600 rounded hover:bg-red-700">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="py-2 text-center text-gray-500">Tidak ada data promo.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- MODAL EDIT --}}
    <div id="editModal" class="fixed inset-0 flex items-center justify-center hidden bg-gray-900 bg-opacity-50">
        <div class="w-1/2 p-6 bg-white rounded-lg shadow-lg">
            <h3 class="mb-4 text-lg font-semibold">Edit Promo</h3>

            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-2 gap-4">
                    <input type="text" name="title" id="editTitle" class="p-2 border rounded" placeholder="Judul Promo" required>
                    <input type="text" name="valid_until" id="editValid" class="p-2 border rounded" placeholder="YYYY-MM-DD" required>
                </div>
                <div class="mt-4">
                    <textarea name="description" id="editDesc" rows="3" class="w-full p-2 border rounded" placeholder="Deskripsi Promo"></textarea>
                </div>

                <div class="flex justify-end mt-4">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 mr-2 text-white bg-gray-500 rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 rounded hover:bg-blue-700">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Script Modal --}}
    <script>
        function openEditModal(promo) {
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editTitle').value = promo.title ?? '';
            document.getElementById('editDesc').value = promo.description ?? '';
            document.getElementById('editValid').value = promo.valid_until ?? '';
            document.getElementById('editForm').action = `/kelompok7/${promo.id}`;
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
