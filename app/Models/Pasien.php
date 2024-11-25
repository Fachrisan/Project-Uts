<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
  use HasFactory;

    protected $fillable = [
        'nama',
        'alamat',
        'telepon',
        'email',
        'gender',
        'status',
    ];
  protected $table = 'pasien';
      // Jika Anda menggunakan kolom yang berbeda untuk kunci primer
      protected $primaryKey = 'id_pasien';

      // Jika kolom kunci primer tidak auto-increment
      public $incrementing = false;

      // Jika kunci primer Anda bukan integer
      protected $keyType = 'string'; // Ganti dengan 'int' jika menggunakan integer

      public function transaksis()
      {
          return $this->hasMany(Transaksi::class, 'id_pasien');
      }
}
