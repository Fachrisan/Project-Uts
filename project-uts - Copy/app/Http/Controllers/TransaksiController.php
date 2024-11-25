<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Stok;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class TransaksiController extends Controller
{
  public function index()
  {
      // Mengambil data transaksi beserta relasi pasien, user, obat, dan stok
      $transaksi = Transaksi::with(['pasien', 'user', 'obat', 'stok'])->latest()->get();

      // Mengambil data stok, obat, pasien, dan user
      $stok = Stok::all();
      $obats = Obat::all();
      $pasien = Pasien::all();
      $user = Login::all();

      // Mengirim data ke view
      return view('content.transaksi.index', compact(
          'transaksi',
          'stok',
          'obats',
          'pasien',
          'user'
      ));
  }




  public function create()
  {
      $obats = Obat::with('stok')->get();
      $users = Login::all();
      $stoks = Stok::all();

      // Debug untuk melihat data
      foreach($obats as $obat) {
          Log::info("Obat: {$obat->nama_obat}, Stok: " . ($obat->stok ? $obat->stok->jumlah_stok : 'Tidak ada'));
      }

      return view('stok.create', compact('users', 'obats', 'stoks'));
  }

public function store(Request $request)
{
    // Log data yang diterima dari form
    Log::info('Request data untuk store: ', $request->all());

    try {
        // Validasi input
        $validated = $request->validate([
            'pasien_id' => 'required|exists:pasien,id_pasien',
            'obat_id' => 'required|exists:obats,id',
            'jumlah_obat' => 'required|integer|min:1',
            'status_transaksi' => 'required|in:pending,selesai',
        ]);

        // Mulai transaksi database
        DB::beginTransaction();

        // Ambil stok berdasarkan ID obat
        $stok = Stok::where('obat_id', $request->obat_id)->lockForUpdate()->first();

        if (!$stok) {
            throw new \Exception('Stok obat tidak ditemukan');
        }

        // Cek apakah stok cukup
        if ($stok->jumlah_stok < $request->jumlah_obat) {
            throw new \Exception('Stok obat tidak mencukupi. Stok tersedia: ' . $stok->jumlah_stok);
        }

        // Menghitung total harga
        $harga_total = $stok->harga * $request->jumlah_obat;

        // Simpan transaksi
        $transaksi = Transaksi::create([
            'id_pasien' => $request->pasien_id,
            'id_user' => auth()->id(), // Pastikan user sudah login
            'id_obat' => $request->obat_id,
            'id_stok' => $stok->id,
            'tanggal' => now(),
            'jumlah_obat' => $request->jumlah_obat,
            'harga_total' => $harga_total,
            'status_transaksi' => $request->status_transaksi,
        ]);

        dd($transaksi->all());

        // Update stok
        $stok->jumlah_stok -= $request->jumlah_obat;
        $stok->save();

        // Commit transaksi
        DB::commit();

        Log::info('Transaksi berhasil disimpan: ', $transaksi->toArray());

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Transaksi berhasil disimpan');

    } catch (\Exception $e) {
        DB::rollback();
        Log::error('Error saat menyimpan transaksi: ' . $e->getMessage());

        return back()
            ->withInput()
            ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
    }
}

  //
    public function show(Transaksi $transaksi)
    {
        $transaksi->load(['pasien', 'user', 'obat', 'stok']);
        return view('transaksi.show', compact('transaksi'));
    }

    public function edit(Transaksi $transaksi)
    {
        $stoks = Stok::with('obat')->where('jumlah', '>', 0)
                     ->orWhere('id', $transaksi->stok_id)->get();
        $obats = Obat::all();
        $pasiens = Pasien::all();
        $users = Login::all();

        return view('transaksi.edit', compact('transaksi', 'stok', 'obats', 'pasien', 'user'));
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'id_pasien' => 'required|exists:pasien,id_pasien',
            'id_obat' => 'required|exists:obats,id',
            'jumlah_obat' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'status_transaksi' => 'required|in:pending,selesai',
        ]);

        try {
            DB::beginTransaction();

            // Jika jumlah obat berubah, update stok lama dan baru
            if ($transaksi->jumlah_obat != $request->jumlah_obat ||
                $transaksi->id_obat != $request->id_obat) {

                // Kembalikan stok lama
                $stokLama = Stok::find($transaksi->id);
                $stokLama->jumlah += $transaksi->jumlah_obat;
                $stokLama->save();

                // Ambil dan update stok baru
                $stokBaru = Stok::where('obat_id', $request->obat_id)
                                ->where('jumlah', '>=', $request->jumlah_obat)
                                ->first();

                if (!$stokBaru) {
                    return back()
                        ->withInput()
                        ->withErrors(['jumlah_obat' => 'Stok tidak mencukupi']);
                }

                // Hitung total harga baru
                $harga_total = $stokBaru->harga * $request->jumlah_obat;

                // Update stok baru
                $stokBaru->jumlah -= $request->jumlah_obat;
                $stokBaru->save();

                // Update transaksi
                $transaksi->update([
                    'stok_id' => $stokBaru->id,
                    'obat_id' => $request->obat_id,
                    'jumlah_obat' => $request->jumlah_obat,
                    'harga_total' => $harga_total,
                ]);
            }

            // Update data transaksi lainnya
            $transaksi->update([
                'pasien_id' => $request->pasien_id,
                'tanggal' => $request->tanggal,
                'status_transaksi' => $request->status_transaksi,
            ]);

            DB::commit();

            return redirect()->route('transaksi.index')
                           ->with('success', 'Transaksi berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function destroy(Transaksi $transaksi)
    {
        try {
            DB::beginTransaction();

            // Kembalikan stok
            $stok = Stok::find($transaksi->stok_id);
            $stok->jumlah += $transaksi->jumlah_obat;
            $stok->save();

            // Hapus transaksi
            $transaksi->delete();

            DB::commit();

            return redirect()->route('transaksi.index')
                           ->with('success', 'Transaksi berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}
