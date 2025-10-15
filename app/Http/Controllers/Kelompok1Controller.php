<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Kelompok1Controller extends Controller
{
    private $baseUrl = 'https://rental-baju.netlify.app/api/public/products';

    public function index()
    {
        $response = Http::get($this->baseUrl);
        $data = $response->json()['products'] ?? [];
        return view('kelompok1.index', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            $response = Http::post($this->baseUrl, [
                'name' => $request->name,
                'category' => $request->category,
                'currentPrice' => (int) $request->price,
                'description' => $request->description,
                'imageUrl' => $request->imageUrl,
            ]);

            if ($response->successful()) {
                return back()->with('success', 'Produk berhasil ditambahkan!');
            } else {
                return back()->with('error', 'Gagal menambah produk!');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $url = $this->baseUrl . '/' . $id;

        try {
            $response = Http::put($url, [
                'name' => $request->name,
                'description' => $request->description,
                'currentPrice' => (int) $request->price,
                'imageUrl' => $request->imageUrl,
            ]);

            if ($response->successful()) {
                return back()->with('success', 'Produk berhasil diperbarui!');
            } else {
                return back()->with('error', 'Gagal memperbarui produk!');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $url = $this->baseUrl . '/' . $id;
        try {
            $response = Http::delete($url);
            return $response->successful()
                ? back()->with('success', 'Produk berhasil dihapus!')
                : back()->with('error', 'Gagal menghapus produk!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
