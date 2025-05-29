<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CatatanKondisiBarang;
use App\Models\Barang;

class CatatanKondisiBarangController extends Controller {
    public function index() {
        $barangs = Barang::with( 'catatanKondisi' )->paginate( 10 );
        return view( 'pengurus.catatankondisibarang.index', compact( 'barangs' ) );
    }

    public function store( Request $request ) {

        // Validasi input
        $request->validate( [
            'catatan' => 'required|string|max:1000',
            'barang_id' => 'required|exists:barang,barang_id',
        ], [
            'catatan.required' => 'Kolom catatan wajib diisi.',
            'catatan.string' => 'Catatan harus berupa teks.',
            'catatan.max' => 'Catatan tidak boleh lebih dari 1000 karakter.',
            'barang_id.required' => 'Pilih barang terlebih dahulu.',
            'barang_id.exists' => 'Barang yang dipilih tidak valid.',
        ] );

        // Simpan data jika validasi lolos
        $catatanKondisiBarang = new CatatanKondisiBarang;
        $catatanKondisiBarang->catatan = $request->catatan;
        $catatanKondisiBarang->barang_id = $request->barang_id;
        $catatanKondisiBarang->save();

        return redirect()->route( 'catatankondisibarang.index' )
        ->with( 'success', 'Catatan kondisi barang berhasil ditambahkan.' );

    }

    public function destroy( $id ) {
        $catatanKondisiBarang = CatatanKondisiBarang::findOrFail( $id );
        $catatanKondisiBarang->delete();

        return redirect()->route( 'catatankondisibarang.index' )
        ->with( 'success', 'Catatan kondisi barang berhasil dihapus.' );
    }
}
