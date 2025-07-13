<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use App\Models\Notifikasi;
use Auth;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('partials.header', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                if($user->role == 'admin') {
                    $notifikasi = Notifikasi::where('user_role', 'admin')
                    ->where('is_read', false)
                    ->orderBy('tanggal', 'desc')
                    ->limit(10)
                    ->get();

                    $view->with('notifikasi', $notifikasi);
                }else if($user->role == 'pengurus') {
                    $notifikasi = Notifikasi::where('user_role', 'pengurus')
                    ->where('is_read', false)
                    ->orderBy('tanggal', 'desc')
                    ->limit(10)
                    ->get();

            }else if($user->role == 'peminjam') {
                $notifikasi = Notifikasi::where('user_role', 'peminjam')
                ->where('user_id', $user->id)
                ->where('is_read', false)
                ->orderBy('tanggal', 'desc')
                ->limit(10)
                ->get();
            }
            $view->with('notifikasi', $notifikasi);
        }
        });
    }
}
