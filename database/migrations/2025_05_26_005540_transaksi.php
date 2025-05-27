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
      Schema::create('transaksi', function (Blueprint $table) {
    $table->id('transaksi_id');
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    $table->dateTime('tanggal');
    $table->enum('jenis', ['peminjaman', 'pengembalian']);
    $table->enum('status', ['pending', 'disetujui', 'ditolak', 'selesai']);
    $table->text('catatan')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
