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
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id();
            $table->string('jenis');          // user_baru, peminjaman, dll
            $table->unsignedBigInteger('user_id');  // penerima
            $table->string('user_role');      // admin, pengurus, peminjam
            $table->text('pesan');            // isi notifikasi
            $table->boolean('is_read')->default(false);
            $table->timestamp('tanggal')->useCurrent();
            $table->string('link')->nullable();     // 🔗 Tambahkan ini
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
