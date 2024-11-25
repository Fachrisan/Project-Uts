<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;

    // Tentukan nama tabel secara eksplisit jika tidak menggunakan pluralisasi default
    protected $table = 'stok';  // Nama tabel di database Anda

    protected $fillable = ['obat_id', 'stok', 'harga'];

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'obat_id', 'id');
    }
    // Relasi dengan transaksi
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'id_stok');
    }
}
