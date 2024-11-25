<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use Illuminate\Http\Request;

class PasienController extends Controller
{
  public function index()
  {
    return view('content.pasien.index', [
      'Pasien' => Pasien::get(),
    ]);
  }

  public function edit($id)
  {
      $pasien = Pasien::findOrFail($id); // Mencari pasien berdasarkan ID
      return view('edit_view', compact('pasien')); // Melempar data pasien ke view edit
  }

  // Fungsi untuk memperbarui data pasien
  public function store(Request $request)
{
    $request->validate([
        'nama' => 'required',
        'alamat' => 'required',
        'telepon' => 'required',
        'email' => 'required|email',
        'gender' => 'required',
        'status' => 'required|in:Active,Inactive',
    ]);

    Pasien::create($request->all());

    return redirect()->route('pasien.index')->with('success', 'Pasien berhasil ditambahkan.');
}

public function update(Request $request, $id)
{
    $request->validate([
        'nama' => 'required',
        'alamat' => 'required',
        'telepon' => 'required',
        'email' => 'required|email',
        'gender' => 'required',
        'status' => 'required|in:Active,Inactive',
    ]);

    $pasien = Pasien::findOrFail($id);
    $pasien->update($request->all());

    return redirect()->route('pasien.index')->with('success', 'Pasien berhasil diperbarui.');
}

    public function destroy($id_pasien)
    {
        $pasien = Pasien::findOrFail($id_pasien); // Menemukan pasien berdasarkan ID
        $pasien->delete(); // Menghapus pasien

        return redirect()->route('pasien.index')->with('success', 'Pasien berhasil dihapus.');
    }
}
