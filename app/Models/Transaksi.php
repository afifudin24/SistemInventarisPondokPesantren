<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Barang;

class Transaksi extends Model {
    use HasFactory;
    protected $table = 'transaksi';
    protected $primaryKey = 'transaksi_id';
    public $timestamps = false;
    protected $fillable = [
        'tanggal',
        'barang_id',
        'jenis',
        'status',
        'catatan',
        'created_at',
        'updated_at',
    ];

    // buat relasi dengan barang

    public function barang() {
        return $this->belongsTo( Barang::class, 'barang_id', 'barang_id' );
    }
}
