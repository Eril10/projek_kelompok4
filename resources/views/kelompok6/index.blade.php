<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Kelompok 6 CRUD (API Reservasi)') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 bg-white rounded-lg shadow">

                {{-- Pesan sukses/error --}}
                @if(session('success'))
                    <div class="p-4 mb-4 text-green-800 bg-green-200 rounded">{{ session('success') }}</div>
                @elseif(session('error'))
                    <div class="p-4 mb-4 text-red-800 bg-red-200 rounded">{{ session('error') }}</div>
                @endif

                {{-- Tambah Reservasi --}}
                <h3 class="mb-3 text-lg font-semibold">Tambah Reservasi Baru</h3>
                <form action="{{ route('kelompok6.store') }}" method="POST" class="mb-6 space-y-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div><label>Nama</label><input type="text" name="nama" class="w-full px-3 py-2 border rounded" required></div>
                        <div><label>Email</label><input type="email" name="email" class="w-full px-3 py-2 border rounded" required></div>
                        <div><label>Telepon</label><input type="text" name="telepon" class="w-full px-3 py-2 border rounded" required></div>
                        <div><label>Jam</label><input type="time" name="jam" class="w-full px-3 py-2 border rounded" required></div>
                        <div><label>Tanggal</label><input type="date" name="tanggal" class="w-full px-3 py-2 border rounded" required></div>
                        <div><label>Jumlah Orang</label><input type="number" name="jumlah_orang" class="w-full px-3 py-2 border rounded" required></div>
                    </div>
                    <div>
                        <label>Catatan</label>
                        <textarea name="catatan" rows="3" class="w-full px-3 py-2 border rounded"></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                            + Simpan Reservasi
                        </button>
                    </div>
                </form>

                {{-- Daftar Reservasi --}}
                <h3 class="mb-3 text-lg font-semibold">Daftar Reservasi</h3>
                @if(isset($reservasi['error']))
                    <div class="p-4 text-red-800 bg-red-200 rounded">{{ $reservasi['error'] }}</div>
                @else
                    <table class="min-w-full border border-gray-300">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 border">ID</th>
                                <th class="px-4 py-2 border">Nama</th>
                                <th class="px-4 py-2 border">Email</th>
                                <th class="px-4 py-2 border">Tanggal</th>
                                <th class="px-4 py-2 border">Jam</th>
                                <th class="px-4 py-2 border">Jumlah Orang</th>
                                <th class="px-4 py-2 border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservasi ?? [] as $item)
                                <tr>
                                    <td class="px-4 py-2 border">{{ $item['id'] ?? '-' }}</td>
                                    <td class="px-4 py-2 border">{{ $item['nama'] ?? '-' }}</td>
                                    <td class="px-4 py-2 border">{{ $item['email'] ?? '-' }}</td>
                                    <td class="px-4 py-2 border">{{ $item['tanggal'] ?? '-' }}</td>
                                    <td class="px-4 py-2 border">{{ $item['jam'] ?? '-' }}</td>
                                    <td class="px-4 py-2 border">{{ $item['jumlah_orang'] ?? '-' }}</td>
                                    <td class="px-4 py-2 text-center border">
                                        <button onclick="editData({{ $item['id'] }}, '{{ $item['nama'] }}', '{{ $item['email'] }}', '{{ $item['telepon'] }}', '{{ $item['jam'] }}', '{{ $item['tanggal'] }}', '{{ $item['jumlah_orang'] }}', '{{ $item['catatan'] }}')"
                                            class="px-3 py-1 text-white bg-yellow-500 rounded hover:bg-yellow-600">Edit</button>
                                        <form action="{{ route('kelompok6.destroy', $item['id']) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin hapus reservasi ini?')">
                                            @csrf @method('DELETE')
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

    {{-- Modal Edit --}}
    <div id="editModal" class="fixed inset-0 items-center justify-center hidden bg-black bg-opacity-50">
        <div class="w-1/2 p-6 bg-white rounded-lg">
            <h3 class="mb-4 text-lg font-semibold">Edit Reservasi</h3>
            <form id="editForm" method="POST">
                @csrf @method('PATCH')
                <input type="hidden" id="edit_id" name="id">
                <div class="grid grid-cols-2 gap-4 mb-3">
                    <input id="edit_nama" name="nama" class="px-3 py-2 border rounded" placeholder="Nama">
                    <input id="edit_email" name="email" class="px-3 py-2 border rounded" placeholder="Email">
                    <input id="edit_telepon" name="telepon" class="px-3 py-2 border rounded" placeholder="Telepon">
                    <input id="edit_jam" name="jam" class="px-3 py-2 border rounded" type="time">
                    <input id="edit_tanggal" name="tanggal" class="px-3 py-2 border rounded" type="date">
                    <input id="edit_jumlah" name="jumlah_orang" class="px-3 py-2 border rounded" type="number">
                </div>
                <textarea id="edit_catatan" name="catatan" rows="3" class="w-full px-3 py-2 border rounded"></textarea>
                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 text-white bg-gray-500 rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editData(id, nama, email, telepon, jam, tanggal, jumlah, catatan) {
            document.getElementById('editModal').classList.remove('hidden');
            edit_id.value = id;
            edit_nama.value = nama;
            edit_email.value = email;
            edit_telepon.value = telepon;
            edit_jam.value = jam;
            edit_tanggal.value = tanggal;
            edit_jumlah.value = jumlah;
            edit_catatan.value = catatan;
            document.getElementById('editForm').action = `/kelompok6/${id}`;
        }
        function closeModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
