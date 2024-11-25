<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $fillable = [
        'id_pasien',
        'id_user',
        'id_obat',
        'id_stok',
        'tanggal',
        'jumlah_obat',
        'harga_total',
        'status_transaksi',
    ];

    // Relasi ke model Pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'id_pasien');
    }

    // Relasi ke model User/Login
    public function user()
    {
        return $this->belongsTo(Login::class, 'id_user', 'id_user');
    }

    // Relasi ke model Obat
    public function obat()
    {
        return $this->belongsTo(Obat::class, 'id_obat', 'id');
    }

    // Relasi ke model Stok
    public function stok()
    {
        return $this->belongsTo(Stok::class, 'id_stok', 'id');
    }
}
