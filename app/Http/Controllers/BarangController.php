<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangController extends Controller {
    public function index() {
        //tampilkan data user dengan paginate 10 data per halaman
        $barangs = Barang::with( 'catatanKondisi' )->paginate( 10 );
        if ( auth()->user()->role == 'pengurus' ) {
            return view( 'pengurus.databarang.index', compact( 'barangs' ) );
        } else if ( auth()->user()->role == 'admin' ) {
            return view( 'admin.databarang.index', compact( 'barangs' ) );

        } else if ( auth()->user()->role == 'peminjam' ) {
            return view( 'peminjam.databarang.index', compact( 'barangs' ) );
        }

    }

    public function store( Request $request ) {
        // Validasi input dengan pesan dalam Bahasa Indonesia
        $request->validate( [
            'nama_barang' => 'required',
            'kode_barang' => 'required',
            'jumlah' => 'required|numeric',
        ], [
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'kode_barang.required' => 'Kode barang wajib diisi.',
            'jumlah.required' => 'Jumlah barang wajib diisi.',
            'jumlah.numeric' => 'Jumlah barang harus berupa angka.',
        ] );

        $barang = new Barang;
        $barang->nama_barang = $request->nama_barang;
        $barang->kode_barang = $request->kode_barang;
        $barang->jumlah = $request->jumlah;
        $barang->keterangan = $request->keterangan;
        // boleh kosong, tidak perlu validasi
        $barang->save();

        return redirect()->route( 'databarang.index' )
        ->with( 'success', 'Data barang berhasil ditambahkan.' );
    }

    public function update( Request $request, Barang $barang ) {
        // Validasi input dengan pesan dalam Bahasa Indonesia
        $request->validate( [
            'nama_barang' => 'required',
            'kode_barang' => 'required',
            'jumlah' => 'required|numeric',
        ], [
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'kode_barang.required' => 'Kode barang wajib diisi.',
            'jumlah.required' => 'Jumlah barang wajib diisi.',
            'jumlah.numeric' => 'Jumlah barang harus berupa angka.',
        ] );

        $barang->nama_barang = $request->nama_barang;
        $barang->kode_barang = $request->kode_barang;
        $barang->jumlah = $request->jumlah;
        $barang->keterangan = $request->keterangan;
        // boleh kosong, tidak perlu validasi
        $barang->save();
        return redirect()->route( 'databarang.index' )
        ->with( 'success', 'Data barang berhasil diperbarui.' );

    }

    public function destroy( Barang $barang ) {
        $barang->delete();

        return redirect()->route( 'databarang.index' )
        ->with( 'success', 'Data barang berhasil dihapus.' );
    }

    public function cetakPDf() {
        $barangs = Barang::with( 'catatanKondisi' )->get();

        $pdf = Pdf::loadView( 'pengurus.databarang.cetak', compact( 'barangs' ) );
        return $pdf->download( 'data-barang.pdf' );
    }
}