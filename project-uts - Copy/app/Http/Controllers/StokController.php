<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use App\Models\Obat;
use Illuminate\Http\Request;

class StokController extends Controller
{
    // Menampilkan semua data stok
    public function index()
    {
        $stok = Stok::all();  // Mengambil semua data stok
        $obats = Obat::all();  // Mengambil semua data obat
        return view('content.stok.index', compact('stok', 'obats'));  // Mengirim data stok dan obat ke view
    }

    // Menampilkan form untuk menambah stok
    public function create()
    {
        $obats = Obat::all();  // Mengambil semua obat untuk pilihan
        return view('stok.create', compact('obats'));  // Mengirim data obat ke view
    }

    // Menyimpan data stok
    public function store(Request $request)
    {
        $request->validate([
            'obat_id' => 'required|exists:obats,id',  // Validasi obat yang dipilih
            'stok' => 'required|integer',
            'harga' => 'required|numeric',
        ]);

        // Menyimpan data stok ke database
        Stok::create([
            'obat_id' => $request->obat_id,
            'stok' => $request->stok,
            'harga' => $request->harga,
        ]);

        return redirect()->route('stok.index')->with('success', 'Stok berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit stok
    public function edit($id)
    {
        $stok = Stok::findOrFail($id);  // Mencari stok berdasarkan ID
        $obats = Obat::all();  // Mengambil semua obat untuk pilihan
        return view('stok.edit', compact('stok', 'obats'));  // Mengirim data stok dan obat ke view
    }

    // Mengupdate data stok
    public function update(Request $request, $id)
    {
        $request->validate([
            'obat_id' => 'required|exists:obats,id',  // Validasi obat yang dipilih
            'stok' => 'required|integer',
            'harga' => 'required|numeric',
        ]);

        // Mencari stok dan mengupdate datanya
        $stok = Stok::findOrFail($id);
        $stok->update([
            'obat_id' => $request->obat_id,
            'stok' => $request->stok,
            'harga' => $request->harga,
        ]);

        return redirect()->route('stok.index')->with('success', 'Stok berhasil diperbarui.');
    }

    // Menghapus data stok
    public function destroy($id)
    {
        $stok = Stok::findOrFail($id);  // Mencari stok berdasarkan ID
        $stok->delete();  // Menghapus data stok

        return redirect()->route('stok.index')->with('success', 'Stok berhasil dihapus.');
    }
}
