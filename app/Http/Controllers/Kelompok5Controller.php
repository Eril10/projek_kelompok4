<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Kelompok5Controller extends Controller
{
    // Menampilkan semua data kopi dari API
    public function index()
    {
        try {
            $response = Http::timeout(20)
                ->withoutVerifying()
                ->get('https://projek5-production.up.railway.app/api/kopi');

            if ($response->successful()) {
                $kopi = $response->json();
            } else {
                $kopi = ['error' => 'Gagal memuat data dari server API. Status: ' . $response->status()];
            }
        } catch (\Exception $e) {
            $kopi = ['error' => 'Tidak bisa menghubungi server API: ' . $e->getMessage()];
        }

        return view('kelompok5.index', compact('kopi'));
    }
    public function update(Request $request, $id)
    {
        try {
            $response = Http::withoutVerifying()->put("https://projek5-production.up.railway.app/api/kopi/$id", [
                'name' => $request->name,
                'description' => $request->description,
                'category' => $request->category,
                'price' => $request->price,
                'image' => $request->image,
            ]);

            if ($response->successful()) {
                return redirect()->route('kelompok5.index')->with('success', 'Data kopi berhasil diperbarui!');
            } else {
                return back()->with('error', 'Gagal memperbarui data. Status: '.$response->status());
            }

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }
    // Tambah data kopi (POST)
    public function store(Request $request)
    {
        try {
            $response = Http::withoutVerifying()->post('https://projek5-production.up.railway.app/api/kopi', [
                'name' => $request->name,
                'description' => $request->description,
                'category' => $request->category,
                'price' => $request->price,
                'image' => $request->image,
            ]);

            return redirect()->route('kelompok5.index')->with('success', 'Data kopi berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    // Hapus data kopi (DELETE)
    public function destroy($id)
    {
        try {
            $response = Http::withoutVerifying()->delete("https://projek5-production.up.railway.app/api/kopi/$id");

            return redirect()->route('kelompok5.index')->with('success', 'Data kopi berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
