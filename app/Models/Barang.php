<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';
    protected $primaryKey = 'barang_id';
    public $timestamps = false;

    protected $fillable = [
        'nama_barang',
        'kode_barang',
        'jumlah',
        'keterangan',
    ];

    public function catatanKondisi()
    {
        return $this->hasMany(CatatanKondisiBarang::class, 'barang_id', 'barang_id');
    }

    public function pengembalian()
    {
        return $this->hasMany(Pengembalian::class, 'barang_id', 'barang_id');
    }
}
