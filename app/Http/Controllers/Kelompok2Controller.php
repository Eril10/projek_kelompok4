<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Kelompok2Controller extends Controller
{
    // 🔹 Tampilkan semua data booking
    public function index()
    {
        try {
            $response = Http::timeout(10)
                ->withoutVerifying()
                ->get('https://tripnesia-vm51.vercel.app/api/bookings?action=list');

            if ($response->successful()) {
                $bookings = $response->json();
            } else {
                $bookings = ['error' => 'Gagal memuat data. Status: ' . $response->status()];
            }
        } catch (\Exception $e) {
            $bookings = ['error' => 'Tidak bisa menghubungi API: ' . $e->getMessage()];
        }

        return view('kelompok2.index', compact('bookings'));
    }

    // 🔹 Tambah data booking
    public function store(Request $request)
    {
        try {
            $response = Http::withoutVerifying()->post('https://tripnesia-vm51.vercel.app/api/bookings?action=create', [
                'name' => $request->name,
                'type' => $request->type,
                'destination' => $request->destination,
                'date' => $request->date,
            ]);

            if ($response->successful()) {
                return redirect()->route('kelompok2.index')->with('success', 'Data berhasil ditambahkan!');
            } else {
                return back()->with('error', 'Gagal menambah data. Status: '.$response->status());
            }

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }

    // 🔹 Update data booking
    public function update(Request $request, $id)
    {
        try {
            $response = Http::withoutVerifying()->put("https://v0-tripnesia-mvp-web-app.vercel.app/api/bookings?action=update&id=$id", [
                'id' => $id,
                'name' => $request->name,
                'type' => $request->type,
                'destination' => $request->destination,
                'date' => $request->date,
            ]);

            if ($response->successful()) {
                return redirect()->route('kelompok2.index')->with('success', 'Data berhasil diperbarui!');
            } else {
                return back()->with('error', 'Gagal memperbarui data. Status: '.$response->status());
            }

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }

    // 🔹 Hapus data booking
    public function destroy($id)
    {
        try {
            $response = Http::withoutVerifying()->delete("https://tripnesia-vm51.vercel.app/api/bookings?action=delete&id=$id");

            if ($response->successful()) {
                return redirect()->route('kelompok2.index')->with('success', 'Data berhasil dihapus!');
            } else {
                return back()->with('error', 'Gagal menghapus data. Status: '.$response->status());
            }

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }
}
