<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('pasien', function (Blueprint $table) {
      $table->bigIncrements('id_pasien');
      $table->string('nama');
      $table->string('alamat')->nullable();
      $table->string('telepon')->nullable();
      $table->string('email')->nullable();
      $table->enum('gender', ['Laki-Laki', 'Perempuan'])->default('Laki-Laki');
      $table->enum('status', ['active', 'inactive'])->default('active');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('pasien');
  }
};
