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
class DashboardController extends Controller
{
    public function index(){
        $user = Auth::user();
        if($user->role == "admin"){
            $usercount = User::count();
            $barangcount = Barang::count();
            $transaksicount = Transaksi::count();
            return view('admin.dashboard.index', compact('usercount', 'barangcount', 'transaksicount'));
        }else if($user->role == 'pengurus'){
            return view('pengurus.dashboard.index');
        }else{
            return view('peminjam.dashboard.index');
        }
        // kasih kondisi role

    }
}
