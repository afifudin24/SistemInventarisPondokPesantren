<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class BarangController extends Controller {
    public function index() {
        //tampilkan data user dengan paginate 10 data per halaman
        $barangs = Barang::paginate( 10 );
        return view( 'admin.databarang.index', compact( 'barangs' ) );

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
}