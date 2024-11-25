<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $fillable = ['nama_obat', 'jenis_obat'];

    public function stok()
    {
        return $this->hasOne(Stok::class, 'obat_id', 'id');
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'id_obat');
    }
}
