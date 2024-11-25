<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pabrik', function (Blueprint $table) {
          $table->bigIncrements('id_pabrik');
          $table->string('nama_pabrik', 100);
          $table->text('alamat');
          $table->string('telepon', 15);
          $table->string('email', 50)->unique();
          $table->string('nama_produk', 100);
          $table->enum('jenis_produk', ['Tablet', 'Kapsul', 'Sirup', 'Salep', 'Lainnya']);
          $table->date('tanggal_produksi');
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pabrik');
    }
};
