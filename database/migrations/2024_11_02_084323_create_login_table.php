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
    Schema::create('login', function (Blueprint $table) {
      $table->bigIncrements('id_user');
      $table->string('nama');
      $table->string('email')->unique();
      $table->string('password');
      $table->enum('level', ['admin', 'kasir'])->default('kasir');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('login');
  }
};
