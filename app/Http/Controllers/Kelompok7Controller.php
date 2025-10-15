<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Kelompok7Controller extends Controller
{
    private $baseUrl = 'https://sobatpromo-api-production.up.railway.app/api.php';

    // 📄 Lihat semua data promo
    public function index()
    {
        try {
            $response = Http::withoutVerifying()->get($this->baseUrl, ['action' => 'list']);
            $data = $response->json()['data'] ?? $response->json();
        } catch (\Exception $e) {
            $data = [];
        }

        return view('kelompok7.index', compact('data'));
    }

    // ➕ Tambah promo
    public function store(Request $request)
    {
        $payload = [
            'title' => $request->title,
            'description' => $request->description,
            'valid_until' => $request->valid_until,
        ];

        $response = Http::withoutVerifying()->post($this->baseUrl . '?action=create', $payload);

        return $response->successful()
            ? back()->with('success', 'Promo berhasil ditambahkan!')
            : back()->with('error', 'Gagal menambah promo: ' . $response->body());
    }

    // ✏️ Edit promo
    public function update(Request $request, $id)
    {
        $payload = [
            'title' => $request->title,
            'description' => $request->description,
            'valid_until' => $request->valid_until,
        ];

        $response = Http::withoutVerifying()
            ->put($this->baseUrl . "?action=update&id={$id}", $payload);

        return $response->successful()
            ? back()->with('success', 'Promo berhasil diperbarui!')
            : back()->with('error', 'Gagal update promo: ' . $response->body());
    }

    // ❌ Hapus promo
    public function destroy($id)
    {
        $response = Http::withoutVerifying()
            ->delete($this->baseUrl . "?action=delete&id={$id}");

        return $response->successful()
            ? back()->with('success', 'Promo berhasil dihapus!')
            : back()->with('error', 'Gagal hapus promo: ' . $response->body());
    }
}
