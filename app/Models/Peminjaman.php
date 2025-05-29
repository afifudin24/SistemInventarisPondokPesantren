<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\User;

class Peminjaman extends Model {
    use HasFactory;

    protected $table = 'peminjaman';
    protected $primaryKey = 'peminjaman_id';
    public $timestamps = false;

    protected $fillable = [
        'transaksi_id',
        'jumlah_pinjam',
        'tanggal_pinjam',
        'tanggal_kembali',
    ];

    public function transaksi() {
        return $this->belongsTo( Transaksi::class, 'transaksi_id', 'transaksi_id' );
    }

    // relasi dengan user

    // Peminjaman.php

    public function user() {
        return $this->belongsTo( User::class, 'user_id', 'id' );
    }

    // buat relasi dengan pengembalian

    public function pengembalian() {
        return $this->hasOne( Pengembalian::class, 'peminjaman_id', 'peminjaman_id' );
    }

    // buat relasi dengan barang

    public function barang() {
        return $this->belongsTo( Barang::class, 'barang_id', 'barang_id' );
    }

}