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
    public function index() {
        $user = Auth::user();
        if ( $user->role == 'admin' ) {
            $usercount = User::count();
            $barangcount = Barang::count();
            $transaksicount = Transaksi::count();
            return view( 'admin.dashboard.index', compact( 'usercount', 'barangcount', 'transaksicount' ) );
        } else if ( $user->role == 'pengurus' ) {
            $barangcount = Barang::count();
            $verifikasiPeminjamanCount = Peminjaman::where( 'status', 'Menunggu Verifikasi' )->count();
            $konfirmasiPengembalianCount = Pengembalian::where( 'status', 'Menunggu Konfirmasi' )->count();
            return view( 'pengurus.dashboard.index', compact( 'barangcount', 'verifikasiPeminjamanCount', 'konfirmasiPengembalianCount' ) );
        } else {
            $barangcount = Barang::count();
            $pinjamcount = Peminjaman::where( 'user_id', Auth::user()->id )->count();
          $kembalikancount = Pengembalian::whereHas('peminjaman', function ($query) {
        $query->where('user_id', Auth::id());
    })
    ->where('status', 'Dikonfirmasi')
    ->count();
            return view( 'peminjam.dashboard.index', compact( 'barangcount', 'pinjamcount', 'kembalikancount' ) );
        }
        // kasih kondisi role
    }
}