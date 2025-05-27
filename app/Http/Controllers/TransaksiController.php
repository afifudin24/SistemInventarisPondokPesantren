<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Barang;
use Carbon\Carbon;

class TransaksiController extends Controller {
    public function index( Request $request ) {
        $query = Transaksi::query();

        // Filter berdasarkan tanggal jika ada input
        if ( $request->filled( 'start_date' ) && $request->filled( 'end_date' ) ) {
            $query->whereBetween( 'created_at', [ $request->start_date, $request->end_date ] );
        }
        $barangs = Barang::all();
        // Paginate hasil ( 10 per halaman )
        $transaksis = $query->latest()->paginate( 10 )->withQueryString();

        return view( 'admin.datatransaksi.index', compact( 'transaksis', 'barangs' ) );
    }

    public function store( Request $request ) {
        // Validasi data
        $request->validate( [
            'barang_id' => 'required|exists:barang,barang_id',
            'jenis' => 'required|string|max:255',
            'catatan' => 'nullable|string',
            'jumlah' => 'required|numeric',
        ] );

        // Simpan data transaksi
        $transaksi = new Transaksi();

        // Atau bisa diisi manual jika dari input
        $transaksi->barang_id = $request->barang_id;
        $transaksi->jenis = $request->jenis;
        $transaksi->catatan = $request->catatan;
        $transaksi->jumlah = $request->jumlah;
        $transaksi->tanggal = Carbon::today();
        // tanggal hari ini
        $transaksi->save();

        return redirect()->back()->with( 'success', 'Transaksi berhasil ditambahkan.' );
    }

    public function update( Request $request, $id ) {
        // dd( $transaksi );
        // Validasi data
        $transaksi = Transaksi::findOrFail( $id );
        $request->validate( [
            'jenis' => 'required|string|max:255',
            'catatan' => 'nullable|string',
            'jumlah' => 'required|numeric',
        ] );

        // Update data transaksi
        $transaksi->jenis = $request->jenis;
        $transaksi->catatan = $request->catatan;

        $transaksi->jumlah = $request->jumlah;
        $transaksi->save();

        return redirect()->back()->with( 'success', 'Transaksi berhasil diperbarui.' );
    }

    public function destroy( $id ) {
        $transaksi = Transaksi::findOrFail( $id );
        $transaksi->delete();

        return redirect()->back()->with( 'success', 'Transaksi berhasil dihapus.' );
    }
}
