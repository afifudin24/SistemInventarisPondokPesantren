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
       Schema::create('pengembalian', function (Blueprint $table) {
    $table->id('pengembalian_id');
     $table->unsignedBigInteger('transaksi_id');
     $table->foreign('transaksi_id')->references('transaksi_id')->on('transaksi')->onDelete('cascade');
    $table->integer('jumlah_kembali');
    $table->dateTime('tanggal_kembali');
    $table->string('kondisi', 50)->nullable();
    $table->string('bukti', 255)->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalian');
    }
};
