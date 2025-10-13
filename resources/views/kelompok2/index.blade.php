<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Kelompok 2 CRUD (API Tripnesia)') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 bg-white rounded-lg shadow-md">

                {{-- ✅ Pesan sukses/error --}}
                @if(session('success'))
                    <div class="p-4 mb-4 text-green-800 bg-green-200 rounded">{{ session('success') }}</div>
                @elseif(session('error'))
                    <div class="p-4 mb-4 text-red-800 bg-red-200 rounded">{{ session('error') }}</div>
                @endif

                {{-- ➕ Form Tambah Data --}}
                <h3 class="mb-3 text-lg font-semibold">Tambah Data Booking</h3>
                <form action="{{ route('kelompok2.store') }}" method="POST" class="mb-6 space-y-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama</label>
                            <input type="text" name="name" class="w-full px-3 py-2 border rounded focus:ring focus:ring-blue-300" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tipe</label>
                            <input type="text" name="type" class="w-full px-3 py-2 border rounded" placeholder="flight / hotel" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tujuan</label>
                            <input type="text" name="destination" class="w-full px-3 py-2 border rounded" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                            <input type="date" name="date" class="w-full px-3 py-2 border rounded" required>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-2 bg-blue-600 rounded hover:bg-blue-700">
                            + Simpan Booking
                        </button>
                    </div>
                </form>

                {{-- 📋 Tabel Data --}}
                <h3 class="mb-3 text-lg font-semibold">Daftar Booking</h3>
                @if(isset($bookings['error']))
                    <div class="p-4 text-red-800 bg-red-200 rounded">{{ $bookings['error'] }}</div>
                @else
                    <table class="min-w-full border border-gray-300">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 border">ID</th>
                                <th class="px-4 py-2 border">Nama</th>
                                <th class="px-4 py-2 border">Tipe</th>
                                <th class="px-4 py-2 border">Tujuan</th>
                                <th class="px-4 py-2 border">Tanggal</th>
                                <th class="px-4 py-2 border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings['data'] ?? [] as $item)
                                <tr>
                                    <td class="px-4 py-2 border">{{ $item['id'] ?? '-' }}</td>
                                    <td class="px-4 py-2 border">{{ $item['name'] ?? '-' }}</td>
                                    <td class="px-4 py-2 border">{{ $item['type'] ?? '-' }}</td>
                                    <td class="px-4 py-2 border">{{ $item['destination'] ?? '-' }}</td>
                                    <td class="px-4 py-2 border">{{ $item['date'] ?? '-' }}</td>
                                    <td class="px-4 py-2 text-center border">
                                        <button onclick="editData({{ $item['id'] }}, '{{ $item['name'] }}', '{{ $item['type'] }}', '{{ $item['destination'] }}', '{{ $item['date'] }}')"
                                            class="px-3 py-1 text-white bg-yellow-500 rounded hover:bg-yellow-600">Edit</button>

                                        <form action="{{ route('kelompok2.destroy', $item['id']) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin hapus data ini?')">
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
            <h3 class="mb-4 text-lg font-semibold">Edit Data Booking</h3>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_id" name="id">

                <div class="grid grid-cols-2 gap-4 mb-3">
                    <input type="text" id="edit_name" name="name" class="px-3 py-2 border rounded" placeholder="Nama">
                    <input type="text" id="edit_type" name="type" class="px-3 py-2 border rounded" placeholder="Tipe">
                    <input type="text" id="edit_destination" name="destination" class="px-3 py-2 border rounded" placeholder="Tujuan">
                    <input type="date" id="edit_date" name="date" class="px-3 py-2 border rounded">
                </div>

                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 text-white bg-gray-500 rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editData(id, name, type, destination, date) {
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_type').value = type;
            document.getElementById('edit_destination').value = destination;
            document.getElementById('edit_date').value = date;
            document.getElementById('editForm').action = `/kelompok2/${id}`;
        }

        function closeModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
