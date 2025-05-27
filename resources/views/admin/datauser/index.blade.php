@extends('layouts.dashboard')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title">
                    <span class="page-title-icon bg-gradient-primary text-white me-2">
                        <i class="mdi mdi-home"></i>
                    </span> Data User
                </h3>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Terjadi kesalahan:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row">
                <!-- Mulai Table  -->

                <div class="mb-3">
                    <button id="btnShowForm" class="btn btn-primary">
                        Tambah User
                    </button>
                </div>
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        {{-- form tambah user --}}
                        {{-- akhir form tambah user --}}
                        <div class="card">
                            {{-- alert --}}

                            {{-- form tambah user --}}
                            <div id="formTambahUser" class="card mt-3"
                                style="display: {{ $errors->any() ? 'block' : 'none' }};">
                                <div class="card-body position-relative">
                                    <!-- Tombol Close -->
                                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3"
                                        aria-label="Close" id="btnCloseForm"></button>
                                    <h5 class="card-title">Tambah User</h5>
                                    <form action="{{ route('datauser.store') }}" method="POST">
                                        @csrf
                                        <!-- Nama -->
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nama:</label>
                                            <input type="text" name="name"
                                                class="form-control @error('name') is-invalid @enderror" id="name"
                                                value="{{ old('name') }}">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!-- Email -->
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email:</label>
                                            <input type="email" name="email"
                                                class="form-control @error('email') is-invalid @enderror" id="email"
                                                value="{{ old('email') }}">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!-- Password -->
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password:</label>
                                            <input type="password" name="password"
                                                class="form-control @error('password') is-invalid @enderror" id="password">
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!-- Role -->
                                        <div class="mb-3">
                                            <label for="role" class="form-label">Role:</label>
                                            <select name="role" class="form-select @error('role') is-invalid @enderror"
                                                id="role">
                                                <option value="">-- Pilih Role --</option>
                                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin
                                                </option>
                                                <option value="pengurus" {{ old('role') == 'pengurus' ? 'selected' : '' }}>
                                                    Pengurus</option>
                                                <option value="peminjam" {{ old('role') == 'peminjam' ? 'selected' : '' }}>
                                                    Peminjam</option>
                                            </select>
                                            @error('role')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </form>
                                </div>
                            </div>
                            {{-- akhir form tambah user --}}
                            {{-- form edit user --}}
                            <div id="formEditUser" class="card mt-3" style="display: none;">
                                <div class="card-body position-relative">
                                    <!-- Tombol Close -->
                                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3"
                                        aria-label="Close" id="btnCloseEditForm"></button>
                                    <h5 class="card-title">Edit User</h5>
                                    <form id="editUserForm" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <!-- Nama -->
                                        <div class="mb-3">
                                            <label for="edit-name" class="form-label">Nama:</label>
                                            <input type="text" name="name" class="form-control" id="edit-name">
                                        </div>
                                        <!-- Email -->
                                        <div class="mb-3">
                                            <label for="edit-email" class="form-label">Email:</label>
                                            <input type="email" name="email" class="form-control" id="edit-email">
                                        </div>
                                        <!-- Role -->
                                        <div class="mb-3">
                                            <label for="edit-role" class="form-label">Role:</label>
                                            <select name="role" class="form-select" id="edit-role">
                                                <option value="">-- Pilih Role --</option>
                                                <option value="admin">Admin</option>
                                                <option value="pengurus">Pengurus</option>
                                                <option value="peminjam">Peminjam</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </form>
                                </div>
                            </div>
                            {{-- akhir form edit user --}}
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($users) && count($users) > 0)
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td> <!-- Ini index dimulai dari 1 -->
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td class="text-capitalize">{{ $user->role }}</td>
                                                    <td>
                                                        <button id="buttonDetail" data-user="{{ $user->toJson() }}"
                                                            data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                            class="btn btn-info">Detail</button>
                                                        <button class="btn btn-warning btnEditUser"
                                                            data-user="{{ $user->toJson() }}">
                                                            Edit
                                                        </button>
                                                        <button class="btn btn-danger btnHapusUser"
                                                            data-user='@json($user)'
                                                            data-bs-toggle="modal" data-bs-target="#modalHapusUser">
                                                            Hapus
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4">Data Kosong</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end mx-2 my-2">
                                {!! $users->links('pagination::bootstrap-5') !!}
                            </div>
                        </div>
                    </div>
                    {{-- modal detail --}}
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Header -->
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Detail User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <!-- Body -->
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Nama:</label>
                                        <input type="text" class="form-control" id="recipient-name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Email:</label>
                                        <input type="text" class="form-control" id="recipient-email">
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Role:</label>
                                        <input type="text" class="form-control" id="recipient-role">
                                    </div>
                                </div>
                                <!-- Footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- akhir modal detail --}}
                    {{-- modal tambah user --}}
                    {{-- modal hapus user --}}
                    <!-- Modal Hapus User -->
                    <div class="modal fade" id="modalHapusUser" tabindex="-1" aria-labelledby="modalHapusUserLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form id="formHapusUser" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalHapusUserLabel">Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Tutup"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Apakah Anda yakin ingin menghapus user <strong id="hapusUserName"></strong>?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- akhir modal --}}
                </div>
                <!-- Selesai Table -->
            </div>
        </div>
        @push('scripts')
            <script>
                $(document).ready(function() {
                    // form user 
                    const btnShowForm = document.getElementById('btnShowForm');
                    const btnCloseForm = document.getElementById('btnCloseForm');
                    const formSection = document.getElementById('formTambahUser');
                    btnShowForm.addEventListener('click', function() {
                        formSection.style.display = 'block';
                    });
                    btnCloseForm.addEventListener('click', function() {
                        formSection.style.display = 'none';
                    });
                    $('#buttonDetail').click(function() {
                        var user = $(this).data('user');
                        console.log(user);
                        $('#recipient-name').val(user.name);
                        $('#recipient-email').val(user.email);
                        $('#recipient-role').val(user.role);
                    });
                    // edit form
                    const $formEditUser = $('#formEditUser');
                    const $editForm = $('#editUserForm');
                    const $nameInput = $('#edit-name');
                    const $emailInput = $('#edit-email');
                    const $roleSelect = $('#edit-role');
                    const $btnCloseEditForm = $('#btnCloseEditForm');
                    // Saat tombol edit diklik
                    $('.btnEditUser').on('click', function() {
                        const user = $(this).data('user');
                        // Set nilai ke input
                        $nameInput.val(user.name);
                        $emailInput.val(user.email);
                        $roleSelect.val(user.role);
                        // Set form action
                        $editForm.attr('action', `/datauser/${user.id}`);
                        // Tampilkan form edit
                        $formEditUser.show();
                    });
                    // Saat tombol close diklik
                    $btnCloseEditForm.on('click', function() {
                        $formEditUser.hide();
                    });

                    // hapus button
                    $('.btnHapusUser').on('click', function() {
                        const user = $(this).data('user');

                        // Tampilkan nama di dalam modal
                        $('#hapusUserName').text(user.name);

                        // Set form action ke /datauser/{id}
                        $('#formHapusUser').attr('action', `/datauser/${user.id}`);
                    });
                });
            </script>
        @endpush
    @endsection
