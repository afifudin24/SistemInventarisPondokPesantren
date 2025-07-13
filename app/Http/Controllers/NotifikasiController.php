<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Http\Requests\StoreNotifikasiRequest;
use App\Http\Requests\UpdateNotifikasiRequest;

class NotifikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNotifikasiRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Notifikasi $notifikasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notifikasi $notifikasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNotifikasiRequest $request, Notifikasi $notifikasi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notifikasi $notifikasi)
    {
        //
    }
    public function buka($id)
{
    $notif = Notifikasi::findOrFail($id);
    $user = auth()->user();

    if($notif->user_role !== $user->role) {
        abort(403);
    }

    // Cek apakah user boleh akses notif ini (opsional, untuk keamanan)
    // if (auth()->id() !== $notif->user_id) {
    //     abort(403);
    // }

    // Tandai sebagai sudah dibaca
    $notif->update(['is_read' => true]);

    // Redirect ke link yang dituju
    return redirect($notif->link ?? '/');
}

}
