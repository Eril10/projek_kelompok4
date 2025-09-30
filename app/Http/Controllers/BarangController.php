<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::all();
        return view('barang.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('barang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:makanan,minuman',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle upload gambar
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('menus', 'public');
            $validated['image'] = $path;
        }

        // Simpan data ke database
        Menu::create($validated);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('barang.edit', compact('menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:makanan,minuman',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle upload gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($menu->image) {
                Storage::disk('public')->delete($menu->image);
            }
            $path = $request->file('image')->store('menus', 'public');
            $validated['image'] = $path;
        }

        // Update data di database
        $menu->update($validated);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        // Hapus gambar jika ada
        if ($menu->image) {
            Storage::disk('public')->delete($menu->image);
        }

        // Hapus data dari database
        $menu->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus');
    }
    public function showMakanan()
{
    $menus = Menu::where('category', 'makanan')->get();
    return view('makanan', compact('menus'));
}

public function showMinuman()
{
    $menus = Menu::where('category', 'minuman')->get();
    return view('minuman', compact('menus'));
}
public function apiMakanan()
{
    $makanan = menu::where('category', 'makanan')->get();
    return response()->json([
        'status' => 'success',
        'data' => $makanan
    ]);
}

public function apiMinuman()
{
    $minuman = menu::where('category', 'minuman')->get();
    return response()->json([
        'status' => 'success',
        'data' => $minuman
    ]);
}
public function storeMakanan(Request $request)
{
    $request->validate([
    'name' => 'required|string|max:255',
    'description' => 'nullable|string',
    'price' => 'required|numeric',
]);

    $barang = Menu::create([
        'name' => $request->name,
        'description' => $request->description,
        'category' => 'makanan',
        'price' => $request->price,

    ]);

    return response()->json([
        'status' => 'success',
        'data' => $barang
    ], 201);
}

public function storeMinuman(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric',

    ]);

    $barang = Menu::create([
        'name' => $request->name,
        'description' => $request->description,
        'category' => 'minuman',
        'price' => $request->price,

    ]);

    return response()->json([
        'status' => 'success',
        'data' => $barang
    ], 201);
}
public function apiUpdateMakanan(Request $request, $id)
{
    $barang = Menu::findOrFail($id);

    $request->validate([
        'name' => 'sometimes|required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'sometimes|required|numeric',

    ]);

    // Update data biasa
    $barang->name = $request->name ?? $barang->name;
    $barang->description = $request->description ?? $barang->description;
    $barang->price = $request->price ?? $barang->price;
    $barang->category = 'makanan';

    $barang->save();
    return response()->json([
        'status' => 'success',
        'data' => $barang
    ], 200);
}
public function apiDeleteMakanan($id)
{
    $barang = Menu::findOrFail($id);

    $barang->delete();
    return response()->json([
        'status' => 'success',
        'message' => 'Barang berhasil dihapus'
    ], 200);
}
public function apiUpdateMinuman(Request $request, $id)
{
    $barang = Menu::findOrFail($id);

    $request->validate([
        'name' => 'sometimes|required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'sometimes|required|numeric',

    ]);

    // Update data biasa
    $barang->name = $request->name ?? $barang->name;
    $barang->description = $request->description ?? $barang->description;
    $barang->price = $request->price ?? $barang->price;
    $barang->category = 'minuman';

    $barang->save();
    return response()->json([
        'status' => 'success',
        'data' => $barang
    ], 200);
}
public function apiDeleteMinuman($id)
{
    $barang = Menu::findOrFail($id);

    $barang->delete();
    return response()->json([
        'status' => 'success',
        'message' => 'Barang berhasil dihapus'
    ], 200);
}
}
