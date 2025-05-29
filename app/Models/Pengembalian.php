<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengembalian extends Model {
    use HasFactory;

    protected $table = 'pengembalian';
    protected $primaryKey = 'pengembalian_id';
    public $timestamps = false;

    protected $fillable = [
        'transaksi_id',
        'barang_id',
        'jumlah_kembali',
        'tanggal_kembali',
        'kondisi',
        'bukti',
    ];

    public function transaksi() {
        return $this->belongsTo( Transaksi::class, 'transaksi_id', 'transaksi_id' );
    }

    public function barang() {
        return $this->belongsTo( Barang::class, 'barang_id', 'barang_id' );
    }

    // buat relasi dengan peminjaman

    public function peminjaman() {
        return $this->belongsTo( Peminjaman::class, 'peminjaman_id', 'peminjaman_id' );
    }
}