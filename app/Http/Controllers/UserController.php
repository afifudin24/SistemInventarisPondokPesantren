<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
            //tampilkan data user dengan paginate 10 data per halaman
        $users = User::paginate(10);
        return view('admin.datauser.index', compact('users'));    
    }

   public function store(Request $request)
{
    $request->validate([
    'name'     => 'required|string|max:255',
    'email'    => 'required|email|unique:users,email',
    'password' => 'required|min:6',
    'role'     => 'required|in:admin,pengurus,peminjam',
], [
    'name.required'     => 'Nama wajib diisi.',
    'name.string'       => 'Nama harus berupa teks.',
    'name.max'          => 'Nama tidak boleh lebih dari :max karakter.',

    'email.required'    => 'Email wajib diisi.',
    'email.email'       => 'Format email tidak valid.',
    'email.unique'      => 'Email sudah terdaftar.',

    'password.required' => 'Password wajib diisi.',
    'password.min'      => 'Password minimal :min karakter.',

    'role.required'     => 'Role wajib dipilih.',
    'role.in'           => 'Role harus salah satu dari: admin, pengurus, atau peminjam.',
]);


    $user = new User;
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = bcrypt($request->password);
    $user->role = $request->role;
    $user->save();

    return redirect()->route('datauser.index')
                 ->with('success', 'Data user berhasil ditambahkan.');

}

public function update(Request $request, User $user)
{
    $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email,' . $user->id,
        'role'     => 'required|in:admin,pengurus,peminjam',
    ], [
        'name.required'     => 'Nama wajib diisi.',
        'name.string'       => 'Nama harus berupa teks.',
        'name.max'          => 'Nama tidak boleh lebih dari :max karakter.',

        'email.required'    => 'Email wajib diisi.',
        'email.email'       => 'Format email tidak valid.',
        'email.unique'      => 'Email sudah terdaftar.',

        'role.required'     => 'Role wajib dipilih.',
        'role.in'           => 'Role harus salah satu dari: admin, pengurus, atau peminjam.',
    ]);

    $user->name = $request->name;
    $user->email = $request->email;
    $user->role = $request->role;
    $user->save();

    return redirect()->route('datauser.index')
                 ->with('success', 'Data user berhasil diperbarui.');
}

public function destroy(User $user)
{
    $user->delete();

    return redirect()->route('datauser.index')
                 ->with('success', 'Data user berhasil dihapus.');

}
}
