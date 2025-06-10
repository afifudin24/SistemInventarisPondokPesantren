<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
// gunakan use auth
use Illuminate\Support\Facades\Auth;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\User;
class DashboardController extends Controller {
    public function index(Request $request) {
        $user = Auth::user();
        if ( $user->role == 'admin' ) {
            $usercount = User::count();
            $barangcount = Barang::count();
            $transaksicount = Transaksi::count();
        $users = User::where('is_active', 0)->paginate(10);

            // dd($user);
            return view( 'admin.dashboard.index', compact( 'usercount', 'barangcount', 'transaksicount', 'users' ) );
        } else if ( $user->role == 'pengurus' ) {
            $barangcount = Barang::count();
            $verifikasiPeminjamanCount = Peminjaman::where( 'status', 'Menunggu Verifikasi' )->count();
            $konfirmasiPengembalianCount = Pengembalian::where( 'status', 'Menunggu Konfirmasi' )->count();

             $query = Peminjaman::with( 'barang', 'user' )->where( 'status', 'Menunggu Verifikasi' )
        ->orderByRaw( "CASE WHEN status = 'Menunggu Verifikasi' THEN 0 ELSE 1 END" );

        if ( $request->filled( 'start_date' ) && $request->filled( 'end_date' ) ) {
            $query->whereBetween( 'tanggal_pinjam', [ $request->start_date, $request->end_date ] );
        }

        $peminjamans = $query->paginate( 10 );


           $querykonfirmasipengembalian = Pengembalian::with( [ 'peminjaman.barang', 'peminjaman.user' ] )->where('status', 'Menunggu Konfirmasi');

        // Jika terdapat query startdate dan enddate
        if ( $request->filled( 'start_date' ) && $request->filled( 'end_date' ) ) {
            $querykonfirmasipengembalian->whereBetween( 'tanggal_kembali', [ $request->start_date, $request->end_date ] );
        }

        $pengembalians = $querykonfirmasipengembalian->paginate( 10 );

            return view( 'pengurus.dashboard.index', compact( 'barangcount', 'verifikasiPeminjamanCount', 'konfirmasiPengembalianCount', 'peminjamans', 'pengembalians' ) );
        } else {
            $barangcount = Barang::count();
            $pinjamcount = Peminjaman::where( 'user_id', Auth::user()->id )->count();
          $kembalikancount = Pengembalian::whereHas('peminjaman', function ($query) {
             $query->where('user_id', Auth::id());
             })
                 ->where('status', 'Dikonfirmasi')
                ->count();
                $peminjamanBelumKembali = Peminjaman::with('user')
    ->where('user_id', Auth::user()->id)
    ->doesntHave('pengembalian')
    ->paginate(10);
                    return view( 'peminjam.dashboard.index', compact( 'barangcount', 'pinjamcount', 'kembalikancount', 'peminjamanBelumKembali' ) );
             }
           
        // kasih kondisi role
    }
}