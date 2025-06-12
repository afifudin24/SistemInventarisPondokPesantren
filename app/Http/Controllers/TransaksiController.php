<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Barang;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class TransaksiController extends Controller {
    public function index( Request $request ) {
        $query = Transaksi::query();
        if ( $request->filled( 'jenis' ) ) {
            $query->where( 'jenis', $request->jenis );
        }

        // Filter berdasarkan tanggal jika ada input
        if ( $request->filled( 'start_date' ) && $request->filled( 'end_date' ) ) {
            $query->whereBetween( 'tanggal', [ $request->start_date, $request->end_date ] );
        }
        $barangs = Barang::all();
        // Paginate hasil ( 10 per halaman )
        $transaksis = $query->orderBy( 'tanggal', 'desc' )->paginate( 10 );

        return view( 'admin.datatransaksi.index', compact( 'transaksis', 'barangs' ) );
    }

    public function cetakPDF( Request $request ) {
        $query = Transaksi::query();

        // Filter jika ada
        if ( $request->filled( 'jenis' ) ) {
            $query->where( 'jenis', $request->jenis );
        }

        if ( $request->filled( 'start_date' ) && $request->filled( 'end_date' ) ) {
            $query->whereBetween( 'tanggal', [ $request->start_date, $request->end_date ] );
        }

        $transaksis = $query->get();

        $pdf = Pdf::loadView( 'admin.datatransaksi.rekap-pdf', compact( 'transaksis' ) );
        return $pdf->download( 'rekap-transaksi.pdf' );
    }

    public function store( Request $request ) {
        // Validasi data
        $request->validate( [
            'barang_id' => 'required|exists:barang,barang_id',
            'jenis' => 'required|string|max:255',
            'catatan' => 'nullable|string',
            'jumlah' => 'required|numeric',
        ] );

        $barang = Barang::findOrFail( $request->barang_id );

        // Pengecekan jika jenis keluar
        if ( $request->jenis == 'keluar' ) {
            if ( $barang->jumlah < $request->jumlah ) {
                return redirect()->back()->withErrors( [ 'jumlah' => 'Jumlah barang tidak mencukupi untuk dikeluarkan.' ] );
            }
        }

        // Simpan data transaksi
        $transaksi = new Transaksi();
        $transaksi->barang_id = $request->barang_id;
        $transaksi->jenis = $request->jenis;
        $transaksi->catatan = $request->catatan;
        $transaksi->jumlah = $request->jumlah;
        $transaksi->tanggal = Carbon::today();
        $transaksi->save();

        // Update jumlah barang
        if ( $request->jenis == 'masuk' ) {
            $barang->jumlah = ( int )$barang->jumlah + ( int )$request->jumlah;
        } else {
            $barang->jumlah = ( int )$barang->jumlah - ( int )$request->jumlah;
        }

        $barang->save();

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
