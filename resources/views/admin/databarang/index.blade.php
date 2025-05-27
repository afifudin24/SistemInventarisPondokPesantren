@extends('layouts.dashboard')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title">
                    <span class="page-title-icon bg-gradient-primary text-white me-2">
                        <i class="mdi mdi-home"></i>
                    </span> Data Barang
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
            {{-- <div class="row"> --}}
            <div class="mb-3">
                <button id="btnShowForm" class="btn btn-primary">
                    Tambah Barang
                </button>
            </div>
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">

                        {{-- Form Tambah Barang --}}
                        <div id="formTambahBarang" class="card mb-4"
                            style="display: {{ $errors->any() ? 'block' : 'none' }};">
                            <div class="card-body position-relative">
                                <button type="button" class="btn-close position-absolute top-0 end-0 m-3"
                                    aria-label="Close" id="btnCloseForm"></button>
                                <h5 class="card-title">Tambah Barang</h5>
                                <form action="{{ route('databarang.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="kode_barang" class="form-label">Kode Barang:</label>
                                        <input type="text" name="kode_barang"
                                            class="form-control @error('kode_barang') is-invalid @enderror" id="kode_barang"
                                            value="{{ old('kode_barang') }}">
                                        @error('kode_barang')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="nama_barang" class="form-label">Nama Barang:</label>
                                        <input type="text" name="nama_barang"
                                            class="form-control @error('nama_barang') is-invalid @enderror" id="nama_barang"
                                            value="{{ old('nama_barang') }}">
                                        @error('nama_barang')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="jumlah" class="form-label">Jumlah:</label>
                                        <input type="number" name="jumlah"
                                            class="form-control @error('jumlah') is-invalid @enderror" id="jumlah"
                                            value="{{ old('jumlah') }}">
                                        @error('jumlah')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="keterangan" class="form-label">Keterangan:</label>
                                        <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan">{{ old('keterangan') }}</textarea>
                                        @error('keterangan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </form>
                            </div>
                        </div>

                        {{-- Form Edit Barang --}}
                        <div id="formEditBarang" class="card mt-3" style="display: none;">
                            <div class="card-body position-relative">
                                <button type="button" class="btn-close position-absolute top-0 end-0 m-3"
                                    aria-label="Close" id="btnCloseEditForm"></button>
                                <h5 class="card-title">Edit Barang</h5>
                                <form id="editBarangForm" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="edit-kode_barang" class="form-label">Kode Barang:</label>
                                        <input type="text" name="kode_barang" class="form-control" id="edit-kode_barang">
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit-nama_barang" class="form-label">Nama Barang:</label>
                                        <input type="text" name="nama_barang" class="form-control" id="edit-nama_barang">
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit-jumlah" class="form-label">Jumlah:</label>
                                        <input type="number" name="jumlah" class="form-control" id="edit-jumlah">
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit-keterangan" class="form-label">Keterangan:</label>
                                        <textarea name="keterangan" class="form-control" id="edit-keterangan"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </form>
                            </div>
                        </div>

                        {{-- Table Data --}}
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($barangs as $barang)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $barang->kode_barang }}</td>
                                            <td>{{ $barang->nama_barang }}</td>
                                            <td>{{ $barang->jumlah }}</td>
                                            <td>{{ $barang->keterangan ?: '-' }}</td>
                                            <td>
                                                <button class="btn btn-warning btnEditBarang"
                                                    data-barang='@json($barang)'>Edit</button>
                                                <button class="btn btn-danger btnHapusBarang"
                                                    data-barang='@json($barang)' data-bs-toggle="modal"
                                                    data-bs-target="#modalHapusBarang">Hapus</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">Data Kosong</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end mx-2 my-2">
                            {!! $barangs->links('pagination::bootstrap-5') !!}
                        </div>
                    </div>
                </div>

                {{-- Modal Hapus Barang --}}
                <div class="modal fade" id="modalHapusBarang" tabindex="-1" aria-labelledby="modalHapusBarangLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="formHapusBarang" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="modal-header">
                                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Yakin ingin menghapus barang <strong id="hapusBarangName"></strong>?</p>
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
            </div>

            @push('scripts')
                <script>
                    $(document).ready(function() {
                        const btnShowForm = $('#btnShowForm');
                        const btnCloseForm = $('#btnCloseForm');
                        const formTambahBarang = $('#formTambahBarang');

                        btnShowForm.on('click', () => {
                            $('#formTambahBarang').slideDown();
                        });

                        $('#btnCloseForm').on('click', () => {
                            $('#formTambahBarang').slideUp();
                        });

                        // btnCloseForm.on('click', () => formTambahBarang.hide());

                        const formEditBarang = $('#formEditBarang');
                        const formEdit = $('#editBarangForm');

                        $('.btnEditBarang').on('click', function() {
                            const barang = $(this).data('barang');
                            $('#edit-kode_barang').val(barang.kode_barang);
                            $('#edit-nama_barang').val(barang.nama_barang);
                            $('#edit-jumlah').val(barang.jumlah);
                            $('#edit-keterangan').val(barang.keterangan);
                            formEdit.attr('action', `/databarang/${barang.barang_id}`);
                            // formEditBarang.show();
                            $('#formEditBarang').slideDown();
                        });

                        // $('#btnCloseEditForm').on('click', () => formEditBarang.hide());
                        $('#btnCloseEditForm').on('click', function() {
                            $('#formEditBarang').slideUp();
                        });
                        $('.btnHapusBarang').on('click', function() {
                            const barang = $(this).data('barang');
                            $('#hapusBarangName').text(barang.nama_barang);
                            $('#formHapusBarang').attr('action', `/databarang/${barang.barang_id}`);
                        });
                    });
                </script>
            @endpush
        </div>
    @endsection
