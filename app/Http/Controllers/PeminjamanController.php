<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Barang;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PeminjamanController extends Controller {
    //

    public function index( Request $request ) {
        $query = Peminjaman::with( 'barang', 'user' )
        ->where( 'user_id', Auth::user()->id );

        // Jika terdapat query startdate dan enddate
        if ( $request->filled( 'start_date' ) && $request->filled( 'end_date' ) ) {
            $query->whereBetween( 'tanggal_pinjam', [ $request->start_date, $request->end_date ] );
        }

        $peminjamans = $query->paginate( 10 );
        $barangs = Barang::all();

        return view( 'peminjam.peminjaman.index', compact( 'peminjamans', 'barangs' ) );
    }

    public function riwayatPeminjaman() {
        $peminjamans = Peminjaman::with( 'pengembalian' )->with( 'user' )->where( 'user_id', Auth::user()->id )->where( 'status',  'Diverifikasi' )->paginate( 10 );

        return view( 'peminjam.riwayatpeminjamanbarang.index', compact( 'peminjamans' ) );
    }

    public function store( Request $request ) {
        // Validasi input
        $request->validate( [
            'barang_id' => 'required|exists:barang,barang_id',
            'jumlah' => 'required|integer|min:1',
            'keperluan' => 'required',
        ], [
            'barang_id.required' => 'Barang harus dipilih.',
            'barang_id.exists' => 'Barang yang dipilih tidak valid.',
            'keperluan.required' => 'Kolom keperluan wajib diisi.',
            'jumlah.required' => 'Jumlah peminjaman harus diisi.',
            'jumlah.integer' => 'Jumlah peminjaman harus berupa angka.',
            'jumlah.min' => 'Jumlah peminjaman minimal 1.',
        ] );

        // Simpan data peminjaman
        $user = Auth::user();

        $barang = Barang::where( 'barang_id', $request->barang_id )->first();

        if ( $barang->jumlah < $request->jumlah_pinjam ) {
            return redirect()->back()->withErrors( [ 'jumlah' => 'Jumlah barang tidak mencukupi.' ] );
        }
        $peminjaman = new Peminjaman;
        $peminjaman->user_id = $user->id;
        $peminjaman->barang_id = $request->barang_id;
        $peminjaman->jumlah_pinjam = $request->jumlah;
        $peminjaman->keperluan = $request->keperluan;
        $peminjaman->tanggal_pinjam = Carbon::today();
        $peminjaman->save();

        return redirect()->route( 'peminjaman.index' )
        ->with( 'success', 'Data peminjaman berhasil ditambahkan.' );
    }

    public function verifikasipeminjamanlist( Request $request ) {
        $query = Peminjaman::with( 'barang', 'user' )
        ->orderByRaw( "CASE WHEN status = 'Menunggu Verifikasi' THEN 0 ELSE 1 END" );

        if ( $request->filled( 'start_date' ) && $request->filled( 'end_date' ) ) {
            $query->whereBetween( 'tanggal_pinjam', [ $request->start_date, $request->end_date ] );
        }

        $peminjamans = $query->paginate( 10 );

        return view( 'pengurus.verifikasipeminjaman.index', compact( 'peminjamans' ) );
    }

    public function updateStatus( Request $request, $id ) {
        if ( Auth::user()->role !== 'pengurus' ) {
            abort( 403, 'Anda tidak memiliki akses.' );
        }

        $request->validate( [
            'status' => 'required|in:Diverifikasi,Ditolak',
        ] );
        $peminjaman = Peminjaman::where( 'peminjaman_id', $id )->first();
        $barang = Barang::where( 'barang_id', $peminjaman->barang_id )->first();
        if ( $request->status === 'Diverifikasi' ) {
            $barang->jumlah = $barang->jumlah -= $peminjaman->jumlah_pinjam;
            $barang->save();
        }

        $peminjaman = Peminjaman::findOrFail( $id );
        $peminjaman->status = $request->status;
        $peminjaman->save();

        return back()->with( 'success', 'Status peminjaman diperbarui.' );
    }

    public function batalkan( $id ) {
        $peminjaman = Peminjaman::findOrFail( $id );
        $user = Auth::user();
        if (
            !(
                $user->role === 'pengurus' ||
                ( $user->role === 'peminjam' && $user->id === $peminjaman->user_id )
            )
        ) {
            abort( 403, 'Anda tidak memiliki akses.' );
        }
        $barang = Barang::where( 'barang_id', $peminjaman->barang_id )->first();

        $barang->jumlah = $barang->jumlah += $peminjaman->jumlah_pinjam;
        $barang->save();
        $peminjaman->status = 'Dibatalkan';
        $peminjaman->save();

        return back()->with( 'success', 'Peminjaman berhasil dibatalkan.' );
    }

    public function destroy( $id ) {
        $peminjaman = Peminjaman::findOrFail( $id );
        $user = Auth::user();
        if (
            !(
                $user->role === 'pengurus' ||
                ( $user->role === 'peminjam' && $user->id === $peminjaman->user_id )
            )
        ) {
            abort( 403, 'Anda tidak memiliki akses.' );
        }
        $peminjaman->delete();

        return back()->with( 'success', 'Peminjaman berhasil dihapus.' );

    }

    public function cetakVerifikasi( $id ) {
        $peminjaman = Peminjaman::with( 'barang', 'user' )->findOrFail( $id );
        if ( $peminjaman->user_id !== Auth::user()->id ) {
            abort( 403, 'Anda tidak memiliki akses.' );
        }
        $pdf = Pdf::loadView( 'peminjam.peminjaman.cetakbukti', compact( 'peminjaman' ) );
        return $pdf->download( 'bukti-verifikasi.pdf' );
    }

}