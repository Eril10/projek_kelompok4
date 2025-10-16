<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Kelompok9Controller extends Controller
{
    private $base = 'https://projekkelompok9-production.up.railway.app/api/';

    // 🔹 Tampilkan semua kategori data
    public function index()
    {
        try {
            $ml = Http::get($this->base . 'get_data.php')->json();
            $aov = Http::get($this->base . 'get_dataAOV.php')->json();
            $wr  = Http::get($this->base . 'get_dataWR.php')->json();
        } catch (\Exception $e) {
            $ml = $aov = $wr = ['error' => $e->getMessage()];
        }

        return view('kelompok9.index', compact('ml', 'aov', 'wr'));
    }

    // 🔹 Tambah akun baru
    public function store(Request $request)
    {
        try {
            $endpoint = match($request->game) {
                'ML'  => 'insert_data.php',
                'AOV' => 'insert_dataAOV.php',
                'WR'  => 'insert_dataWR.php',
                default => null
            };

            if (!$endpoint) {
                return back()->with('error', 'Game tidak valid!');
            }

            $data = [
                'penjual' => $request->penjual,
                'skin' => $request->skin,
                'rank' => $request->rank,
                'hero' => $request->hero,
                'price' => $request->price,
                'deskripsi' => $request->deskripsi,
                'preview_image' => $request->preview_image,
            ];

            $response = Http::asJson()->post($this->base . $endpoint, $data);

            return $response->successful()
                ? back()->with('success', 'Akun berhasil ditambahkan!')
                : back()->with('error', 'Gagal menambah data. Status: '.$response->status());

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }

    // 🔹 Hapus akun
public function destroy($id, $game)
{
    try {
        $endpoint = match($game) {
            'ML'  => 'delete_ML.php',
            'AOV' => 'delete_AOV.php',
            'WR'  => 'delete_WR.php',
            default => null
        };
        if (!$endpoint) return back()->with('error', 'Game tidak valid!');

        // umumnya skrip PHP expect POST form, bukan DELETE
        $response = Http::asForm()->post($this->base . $endpoint, [
            'id' => $id,
            // kalau skrip kamu pakai method override, boleh tambahkan:
            // '_method' => 'DELETE',
        ]);

        return $response->successful()
            ? back()->with('success', 'Akun berhasil dihapus!')
            : back()->with('error', 'Gagal menghapus data. Status: '.$response->status().' | '.$response->body());

    } catch (\Exception $e) {
        return back()->with('error', 'Terjadi kesalahan: '.$e->getMessage());
    }
}
}
