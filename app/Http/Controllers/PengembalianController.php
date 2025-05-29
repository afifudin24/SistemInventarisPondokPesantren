<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\Barang;
// use auth
use Illuminate\Support\Facades\Auth;
// use carbon
use Carbon\Carbon;

class PengembalianController extends Controller {
    public function store( Request $request ) {
        // Validasi input
        $request->validate( [
            'peminjaman_id' => 'required|exists:peminjaman,peminjaman_id',
            'bukti' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'peminjaman_id.required' => 'Peminjaman ID diperlukan.',
            'peminjaman_id.exists' => 'Peminjaman ID tidak valid.',
            'bukti.required' => 'Bukti pengembalian wajib diunggah.',
            'bukti.image' => 'Bukti pengembalian harus berupa gambar.',
            'bukti.mimes' => 'Format gambar yang diizinkan: jpeg, png, jpg, gif.',
            'bukti.max' => 'Ukuran gambar maksimal 2MB.',
        ] );

        // Simpan data pengembalian
        $user = Auth::user();

        $peminjaman = Peminjaman::where( 'peminjaman_id', $request->peminjaman_id )->first();
        if ( $user->id !== $peminjaman->user_id ) {
            return redirect()->back()->withErrors( [ 'peminjaman_id' => 'Peminjaman ID tidak valid.' ] );
        }

        $peminjaman->tanggal_kembali = Carbon::today();
        $peminjaman->save();

        // Upload file ke storage/app/public/bukti
        $path = $request->file( 'bukti' )->store( 'bukti', 'public' );

        // Simpan ke database
        $pengembalian = new Pengembalian;
        $pengembalian->tanggal_kembali = Carbon::today();
        $pengembalian->peminjaman_id = $request->peminjaman_id;
        $pengembalian->bukti = $path;
        // Simpan path
        $pengembalian->save();

        return redirect()->route( 'riwayatpeminjamanbarang.index' )->with( 'success', 'Pengembalian berhasil disimpan, silahkan menunggu konfirmasi.' );

    }
}