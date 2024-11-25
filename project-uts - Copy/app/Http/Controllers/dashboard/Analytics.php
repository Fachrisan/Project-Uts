<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Stok;
use App\Models\Obat;
use App\Models\Transaksi;
use App\Models\Pasien;
use Illuminate\Http\Request;

class Analytics extends Controller
{

  public function index()
  {
      $jumlahPasien = Pasien::count();
        // Ambil data transaksi terakhir (atau stok terakhir, sesuai kebutuhan)
        $lastTransaction = Transaksi::latest()->first(); // Mengambil transaksi terakhir

        // Jika Anda ingin menampilkan harga_total dari transaksi terakhir
        $hargaTotal = $lastTransaction ? $lastTransaction->harga_total : 0;
      $stok = Stok::all();  // Mengambil semua data stok
      $obats = Obat::all();  // Mengambil semua data obat
      return view('content.dashboard.dashboards-analytics', compact('stok', 'obats','hargaTotal','jumlahPasien'));  // Mengirim data stok dan obat ke view
  }
}
