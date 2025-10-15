<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Kelompok8Controller extends Controller
{
    private $baseUrl = 'https://dodgerblue-monkey-417412.hostingersite.com';

    /** 🔹 Tampilkan semua produk */
    public function index()
    {
        try {
            $response = Http::accept('application/json')->get($this->baseUrl . '/menu');
            $data = $response->json()['data'] ?? [];
        } catch (\Exception $e) {
            $data = [];
        }
        return view('kelompok8.index', compact('data'));
    }

    /** 🔹 Form edit produk */
    public function show($id)
    {
        $response = Http::accept('application/json')->get("{$this->baseUrl}/products/{$id}");
        $product = $response->json()['data'] ?? null;
        return view('kelompok8.edit', compact('product'));
    }

    /** 🔹 Tambah produk baru */
    public function store(Request $request)
    {
        try {
            $response = Http::accept('application/json')->post($this->baseUrl . '/products', [
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price,
                'stock' => $request->stock,
                'image' => $request->image,
            ]);

            return $response->successful()
                ? back()->with('success', 'Produk berhasil ditambahkan!')
                : back()->with('error', 'Gagal menambahkan produk.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /** 🔹 Update produk */
    public function update(Request $request, $id)
    {
        try {
            $response = Http::accept('application/json')->put($this->baseUrl . '/products/' . $id, [
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price,
                'stock' => $request->stock,
                'image' => $request->image,
            ]);

            return $response->successful()
                ? back()->with('success', 'Produk berhasil diperbarui!')
                : back()->with('error', 'Gagal memperbarui produk.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /** 🔹 Hapus produk */
    public function destroy($id)
    {
        try {
            $response = Http::accept('application/json')->delete($this->baseUrl . '/products/' . $id);
            return $response->successful()
                ? back()->with('success', 'Produk berhasil dihapus!')
                : back()->with('error', 'Gagal menghapus produk.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}