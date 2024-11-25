<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    // Menampilkan daftar obat
    public function index()
{
    $obats = Obat::all();  // Ambil semua data obat dari database
    return view('content.obat.index', compact('obats'));
}

    // Menampilkan form untuk menambah obat
    public function create()
    {
        return view('obat.create');
    }

    // Menyimpan data obat baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required',
            'jenis_obat' => 'required|in:Tablet,Kapsul,Sirup,Salep,Lainnya'
        ]);

        Obat::create($request->all());

        return redirect()->route('obat.index')->with('success', 'Obat berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $obat = Obat::findOrFail($id);
        return view('obat.edit', compact('obat'));
    }

    // Mengupdate data obat
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'jenis_obat' => 'required|in:Tablet,Kapsul,Sirup,Salep,Lainnya',
        ]);

        $obat = Obat::findOrFail($id);
        $obat->update([
            'nama_obat' => $request->nama_obat,
            'jenis_obat' => $request->jenis_obat,
        ]);

        return redirect()->route('obat.index')->with('success', 'Obat berhasil diperbarui!');
    }

    // Menghapus data obat
    public function destroy($id)
    {
        $obat = Obat::findOrFail($id);
        $obat->delete();

        return redirect()->route('obat.index')->with('success', 'Obat berhasil dihapus!');
    }
}
