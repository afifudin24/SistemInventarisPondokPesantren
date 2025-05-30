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

    public function index( Request $request ) {
        // kasih query misal filter berdasarkan start_date dan end_date

        $query = Pengembalian::with( [ 'peminjaman.barang', 'peminjaman.user' ] )
        ->whereIn( 'status', [ 'Menunggu Konfirmasi', 'Tidak Sesuai' ] );

        // Jika terdapat query startdate dan enddate
        if ( $request->filled( 'start_date' ) && $request->filled( 'end_date' ) ) {
            $query->whereBetween( 'tanggal_kembali', [ $request->start_date, $request->end_date ] );
        }

        $pengembalians = $query->paginate( 10 );

        return view( 'pengurus.konfirmasipengembalianbarang.index', compact( 'pengembalians' ) );
    }

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

    public function update( Request $request, $id ) {
        $pengembalian =  Pengembalian::with( [ 'peminjaman.barang', 'peminjaman.user' ] )->findOrFail( $id );
        $barang = Barang::where( 'barang_id', $pengembalian->peminjaman->barang_id )->first();
        $peminjaman = Peminjaman::where( 'peminjaman_id', $pengembalian->peminjaman_id )->first();
        $pengembalian->jumlah_kembali = $request->jumlah_kembali;
        $pengembalian->status = $request->status;
        if ( $pengembalian->jumlah_kembali < $pengembalian->peminjaman->jumlah_pinjam ) {
            $pengembalian->status = 'Tidak Sesuai';
        } else {
            $barang->jumlah += $pengembalian->jumlah_kembali;
            $barang->save();
            $peminjaman->status = 'Selesai';
        }
        $pengembalian->kondisi = $request->kondisi;
        $pengembalian->save();

        return redirect()->route( 'konfirmasipengembalianbarang.index' )->with( 'success', 'Pengembalian berhasil diperbarui.' );
    }
}