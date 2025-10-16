<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Kelompok9Controller extends Controller
{
    private $baseUrl = 'https://projekkelompok9-production.up.railway.app/api/';

    // 📄 Tampilkan semua data
    public function index()
    {
        try {
            $ml  = Http::withoutVerifying()->get($this->baseUrl . 'get_data.php')->json();
            $aov = Http::withoutVerifying()->get($this->baseUrl . 'get_dataAOV.php')->json();
            $wr  = Http::withoutVerifying()->get($this->baseUrl . 'get_dataWR.php')->json();
        } catch (\Exception $e) {
            $ml = $aov = $wr = ['error' => $e->getMessage()];
        }

        return view('kelompok9.index', compact('ml', 'aov', 'wr'));
    }

    // ➕ Tambah akun baru
    public function store(Request $request)
    {
        $endpoint = match($request->game) {
            'ML'  => 'insert_data.php',
            'AOV' => 'insert_dataAOV.php',
            'WR'  => 'insert_dataWR.php',
            default => null
        };

        if (!$endpoint) {
            return back()->with('error', 'Game tidak valid!');
        }

        $payload = [
            'penjual' => $request->penjual,
            'skin' => $request->skin,
            'rank' => $request->rank,
            'hero' => $request->hero,
            'price' => $request->price,
            'deskripsi' => $request->deskripsi,
            'preview_image' => $request->preview_image,
        ];

        $response = Http::withoutVerifying()->post($this->baseUrl . $endpoint, $payload);

        return $response->successful()
            ? back()->with('success', 'Akun berhasil ditambahkan!')
            : back()->with('error', 'Gagal menambah data: ' . $response->body());
    }


    // ❌ Hapus akun
    public function destroy($id, $game)
    {
        $endpoint = match($game) {
            'ML'  => 'delete_ML.php',
            'AOV' => 'delete_AOV.php',
            'WR'  => 'delete_WR.php',
            default => null
        };

        if (!$endpoint) {
            return back()->with('error', 'Game tidak valid!');
        }

        // 🔹 Gunakan POST karena skrip PHP biasanya tidak menerima DELETE
        $response = Http::withoutVerifying()->post($this->baseUrl . $endpoint, ['id' => $id]);

        return $response->successful()
            ? back()->with('success', 'Akun berhasil dihapus!')
            : back()->with('error', 'Gagal hapus data: ' . $response->body());
    }
}
