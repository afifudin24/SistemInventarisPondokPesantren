<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    /** @use HasFactory<\Database\Factories\NotifikasiFactory> */
    use HasFactory;

    protected $table = 'notifikasi';
    protected $fillable = [
        'jenis', 'user_id', 'user_role', 'pesan', 'is_read', 'tanggal', 'link'
    ];

    public function user() {
        return $this->belongsTo( User::class, 'user_id', 'id' );
    }
}
