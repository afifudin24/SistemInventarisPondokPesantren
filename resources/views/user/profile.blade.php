@extends('layouts.dashboard')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title">
                    <span class="page-title-icon bg-gradient-primary text-white me-2">
                        <i class="mdi mdi-account"></i>
                    </span> Profil
                </h3>
            </div>
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        {{-- kasih jika sukss tampil alert --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between align-items-center"
                                role="alert">
                                <div>{{ session('success') }}</div>
                                <button type="button" class="btn-close ms-3" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-12">
                                <form action="/updateprofil" method="POST">
                                    @csrf   
                                    @method('PUT')
                                    <div class="d-flex flex-column flex-md-row gap-3">

                                        <div class="form-group w-100">
                                            <label for="exampleInputName1">Nama</label>
                                            <input type="text" name="name" class="form-control" id="exampleInputName1"
                                                value="{{ $user->name }}">
                                                 <div>

                                            @error('name')
                                            <div class="alert alert-danger">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        </div>
                                        {{-- kalau error validasi --}}
                                       

                                        <div class="form-group w-100">
                                            <label for="exampleInputEmail3">Email</label>
                                            <input type="email" name="email" class="form-control" id="exampleInputEmail3"
                                                value="{{ $user->email }}">
                                                <div>
                                                      @error('email')
                                            <div class="alert alert-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                                </div>
                                        </div>
                                        {{-- kalau error validasi --}}
                                      
                                    </div>

                            </div>
                            <div class="flex">
                                <button type="submit" class="btn btn-success">Update Profil</button>
                                <button type="button" class="btn btn-primary btnshowgantipassword">Ganti Password</button>
                            </div>
                            </form>
                        </div>
                        <form action="/gantipassword" id="formgantipassword" method="POST" class="mt-5" style="display: {{ $errors->any() ? 'block' : 'none' }};">
                             @csrf   
                                    @method('PUT')
                            <div class="form-group">
                                <label for="exampleInputPassword4">Password Lama</label>
                                <input type="password" class="form-control" name="current_password" id="exampleInputPassword4"
                                    placeholder="Password Lama">
                                    <div>
                                        @error('current_password')
                                            <div class="alert alert-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword4">Password Baru</label>
                                <input type="password" class="form-control" name="new_password" id="exampleInputPassword4"
                                    placeholder="Password Baru">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword4">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" name="new_confirm_password" id="exampleInputPassword4"
                                    placeholder="Konfirmasi Password">
                            </div>
                            <button type="submit" class="btn btn-primary me-2">Update Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $(".btnshowgantipassword").click(function() {
                    console.log('anjay')
                    $('#formgantipassword').slideToggle(); // toggle tampil/sembunyi dengan efek slide
                })
            })
        </script>
    @endpush
@endsection
