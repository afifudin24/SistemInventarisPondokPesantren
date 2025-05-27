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
      Schema::create('peminjaman', function (Blueprint $table) {
    $table->bigIncrements('peminjaman_id');
    $table->unsignedBigInteger('transaksi_id');
    $table->foreign('transaksi_id')->references('transaksi_id')->on('transaksi')->onDelete('cascade');

    $table->integer('jumlah_pinjam');
    $table->dateTime('tanggal_pinjam');
    $table->dateTime('tanggal_kembali')->nullable();
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
