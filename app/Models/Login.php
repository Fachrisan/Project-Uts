<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Login extends Authenticatable
{
    use HasFactory;

    protected $table = 'login'; // Nama tabel yang digunakan (bukan 'logins')
    protected $primaryKey = 'id_user'; // Primary key yang benar
    public $timestamps = false; // Matikan jika tabel tidak memiliki kolom timestamps

    protected $fillable = [
        'nama',
        'email',
        'password',
        'level',
    ];
}
