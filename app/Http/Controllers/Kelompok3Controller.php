<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Kelompok3Controller extends Controller
{
    // 🔹 Tampilkan semua data rekomendasi
    public function index()
    {
        try {
            $response = Http::timeout(10)
                ->withoutVerifying()
                ->withToken('Tokengadgethouse')
                ->get('http://www.cvjayatehnik.com/api/recomendations.php?action=read');

            if ($response->successful()) {
                $rekomendasi = $response->json();
            } else {
                $rekomendasi = ['error' => 'Gagal memuat data. Status: '.$response->status()];
            }
        } catch (\Exception $e) {
            $rekomendasi = ['error' => 'Tidak dapat menghubungi API: '.$e->getMessage()];
        }

        return view('kelompok3.index', compact('rekomendasi'));
    }

    // 🔹 Tambah data baru
    public function store(Request $request)
    {
        try {
            $response = Http::withoutVerifying()
                ->withToken('Tokengadgethouse')
                ->post('http://www.cvjayatehnik.com/api/recomendations.php?action=create', [
                    'product_id' => $request->product_id,
                    'product_title' => $request->product_title,
                    'product_price' => $request->product_price,
                    'product_img1' => $request->product_img1,
                ]);

            if ($response->successful()) {
                return redirect()->route('kelompok3.index')->with('success', 'Data berhasil ditambahkan!');
            } else {
                return back()->with('error', 'Gagal menambah data. Status: '.$response->status());
            }

        } catch (\Exception $e) {
            return back()->with('error', 'Kesalahan: '.$e->getMessage());
        }
    }

    // 🔹 Update data
    public function update(Request $request, $id)
    {
        try {
            $response = Http::withoutVerifying()
                ->withToken('Tokengadgethouse')
                ->put('http://cvjayatehnik.com/api/recomendations.php?action=update', [
                    'product_id' => $id,
                    'product_title' => $request->product_title,
                    'product_price' => $request->product_price,
                    'product_img1' => $request->product_img1,
                ]);

            if ($response->successful()) {
                return redirect()->route('kelompok3.index')->with('success', 'Data berhasil diperbarui!');
            } else {
                return back()->with('error', 'Gagal memperbarui data. Status: '.$response->status());
            }

        } catch (\Exception $e) {
            return back()->with('error', 'Kesalahan: '.$e->getMessage());
        }
    }

    // 🔹 Hapus data
    public function destroy($id)
    {
        try {
            $response = Http::withoutVerifying()
                ->withToken('Tokengadgethouse')
                ->delete("http://cvjayatehnik.com/api/recomendations.php?action=delete&id=$id");

            if ($response->successful()) {
                return redirect()->route('kelompok3.index')->with('success', 'Data berhasil dihapus!');
            } else {
                return back()->with('error', 'Gagal menghapus data. Status: '.$response->status());
            }

        } catch (\Exception $e) {
            return back()->with('error', 'Kesalahan: '.$e->getMessage());
        }
    }
}
