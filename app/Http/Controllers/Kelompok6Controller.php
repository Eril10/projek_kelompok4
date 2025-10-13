<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Kelompok6Controller extends Controller
{
    private $url = 'https://rsjauhzcwslcsoktbplq.supabase.co/rest/v1/reservasi';
    private $headers = [
        'apikey' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InJzamF1aHpjd3NsY3Nva3RicGxxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTkzMjI3NzUsImV4cCI6MjA3NDg5ODc3NX0.EPNgXjJxtKRyPiWVXGm79aWBEV4rQiNolsR7n5sa_p8',
        'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InJzamF1aHpjd3NsY3Nva3RicGxxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTkzMjI3NzUsImV4cCI6MjA3NDg5ODc3NX0.EPNgXjJxtKRyPiWVXGm79aWBEV4rQiNolsR7n5sa_p8',
        'Prefer' => 'return=representation'
    ];

    // 🔹 READ
    public function index()
    {
        try {
            $response = Http::withHeaders($this->headers)->get($this->url);
            $reservasi = $response->successful() ? $response->json() : ['error' => 'Gagal memuat data. Status: ' . $response->status()];
        } catch (\Exception $e) {
            $reservasi = ['error' => 'Tidak dapat menghubungi API: ' . $e->getMessage()];
        }
        return view('kelompok6.index', compact('reservasi'));
    }

    // 🔹 CREATE
    public function store(Request $request)
    {
        try {
            $data = [
                'nama' => $request->nama,
                'email' => $request->email,
                'telepon' => $request->telepon,
                'jam' => $request->jam,
                'tanggal' => $request->tanggal,
                'jumlah_orang' => $request->jumlah_orang,
                'catatan' => $request->catatan,
            ];

            $response = Http::withHeaders($this->headers)->post($this->url, $data);

            return $response->successful()
                ? redirect()->route('kelompok6.index')->with('success', 'Reservasi berhasil ditambahkan!')
                : back()->with('error', 'Gagal menambah data. Status: '.$response->status());
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }

    // 🔹 UPDATE
    public function update(Request $request, $id)
    {
        try {
            $data = [
                'nama' => $request->nama,
                'email' => $request->email,
                'telepon' => $request->telepon,
                'jam' => $request->jam,
                'tanggal' => $request->tanggal,
                'jumlah_orang' => $request->jumlah_orang,
                'catatan' => $request->catatan,
            ];

            $response = Http::withHeaders($this->headers)
                ->patch($this->url . '?id=eq.' . $id, $data);

            return $response->successful()
                ? redirect()->route('kelompok6.index')->with('success', 'Data reservasi berhasil diperbarui!')
                : back()->with('error', 'Gagal memperbarui data. Status: '.$response->status());
        } catch (\Exception $e) {
            return back()->with('error', 'Kesalahan: '.$e->getMessage());
        }
    }

    // 🔹 DELETE
    public function destroy($id)
    {
        try {
            $response = Http::withHeaders($this->headers)
                ->delete($this->url . '?id=eq.' . $id);

            return $response->successful()
                ? redirect()->route('kelompok6.index')->with('success', 'Data berhasil dihapus!')
                : back()->with('error', 'Gagal menghapus data. Status: '.$response->status());
        } catch (\Exception $e) {
            return back()->with('error', 'Kesalahan: '.$e->getMessage());
        }
    }
}
