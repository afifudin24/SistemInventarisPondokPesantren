<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Barang;

class CatatanKondisiBarang extends Model {
    protected $table = 'catatan_kondisi_barang';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'id',
        'catatan',
        'barang_id',
    ];

    public function barang() {
        return $this->belongsTo( Barang::class, 'barang_id', 'barang_id' );
    }
}
