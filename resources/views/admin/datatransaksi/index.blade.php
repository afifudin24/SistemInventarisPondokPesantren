@extends('layouts.dashboard')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title">
                    <span class="page-title-icon bg-gradient-primary text-white me-2">
                        <i class="mdi mdi-transfer"></i>
                    </span> Data Transaksi
                </h3>
            </div>

            {{-- Tampilkan alert --}}
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- Tampilkan error --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Tombol tambah --}}
            <div class="mb-3">
                <button id="btnShowForm" class="btn btn-primary">Tambah Transaksi</button>
            </div>

            {{-- Form Tambah Transaksi --}}
            <div id="formTambahTransaksi" class="card mb-4" style="display: none;">
                <div class="card-body position-relative">
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3" id="btnCloseForm"></button>
                    <h5 class="card-title">Tambah Transaksi</h5>
                    <form action="{{ route('transaksibarang.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="jenis" class="form-label">Barang</label>
                            {{-- pake select option perulangan dari barangs --}}
                            <select class="form-select" name="barang_id" id="barang_id">
                                <option value="">Pilih Barang</option>
                                @foreach ($barangs as $barang)
                                    <option value="{{ $barang->barang_id }}">{{ $barang->nama_barang }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                        <div class="mb-3">
                            <label for="jenis" class="form-label">Jenis</label>
                            <select class="form-select" name="jenis" id="jenis">
                                <option value="">Pilih Jenis</option>
                                <option class="text-capitalize" value="masuk"
                                    {{ old('jenis') == 'masuk' ? 'selected' : '' }}>Masuk</option>
                                <option class="text-capitalize" value="keluar"
                                    {{ old('jenis') == 'keluar' ? 'selected' : '' }}>Keluar</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" name="jumlah" id="jumlah">
                        </div>

                        <div class="mb-3">
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea name="catatan" class="form-control">{{ old('catatan') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </form>
                </div>
            </div>

            {{-- form edit transaksi --}}
            {{-- Form Edit Transaksi --}}
            <div id="formEditTransaksi" class="card mb-4" style="display: none;">
                <div class="card-body position-relative">
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3"
                        id="btnCloseEditForm"></button>
                    <h5 class="card-title">Edit Transaksi</h5>
                    <form id="editTransaksiForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="transaksi_id" id="edit_id">
                        <div class="mb-3">
                            <label for="jenis" class="form-label">Barang</label>
                            {{-- pake select option perulangan dari barangs --}}
                            <select class="form-select" name="barang_id" id="edit_barang_id">
                                <option value="">Barang</option>
                                @foreach ($barangs as $barang)
                                    <option class="text-capitalize" value="{{ $barang->barang_id }}">
                                        {{ $barang->nama_barang }}
                                    </option>
                                @endforeach
                            </select>

                        </div>

                        <div class="mb-3">
                            <label for="edit_tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" id="edit_tanggal">
                        </div>
                        <div class="mb-3">
                            <label for="edit_jenis" class="form-label">Jenis</label>
                            <select class="form-select" name="jenis" id="edit_jenis">
                                <option value="">Pilih Jenis</option>
                                <option class="text-capitalize" value="masuk"
                                    {{ old('jenis') == 'masuk' ? 'selected' : '' }}>
                                    Masuk</option>
                                <option class="text-capitalize" value="keluar"
                                    {{ old('jenis') == 'keluar' ? 'selected' : '' }}>Keluar</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_jumlah" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" name="jumlah" id="edit_jumlah">
                        </div>
                        <div class="mb-3">
                            <label for="edit_catatan" class="form-label">Catatan</label>
                            <textarea name="catatan" class="form-control" id="edit_catatan"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                    </form>
                </div>
            </div>

            {{-- modal hapus transaksi --}}
            <div class="modal fade" id="modalHapusTransaksi" tabindex="-1" aria-labelledby="modalHapusTransaksiLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="formHapusTransaksi" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalHapusUserLabel">Konfirmasi Hapus</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                <p>Apakah Anda yakin ingin menghapus transaksi?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- akhir modal hapus transaksi --}}

            {{-- Tabel Data Transaksi --}}
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Daftar Transaksi</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>

                                    <th>Tanggal</th>
                                    <th>Jenis</th>
                                    <th>Jumlah</th>

                                    <th>Catatan</th>
                                    <th>Aksi</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transaksis as $transaksi)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>

                                        <td>{{ $transaksi->tanggal }}</td>
                                        <td>{{ $transaksi->jenis }}</td>
                                        <td>{{ $transaksi->jumlah }}</td>

                                        <td>{{ $transaksi->catatan ?? '-' }}</td>
                                        <td>
                                            <button class="btn btn-warning btnEditTransaksi"
                                                data-transaksi='@json($transaksi)'>Edit</button>
                                            <button class="btn btn-danger btnHapusTransaksi"
                                                data-transaksi='@json($transaksi)' data-bs-toggle="modal"
                                                data-bs-target="#modalHapusTransaksi">
                                                Hapus
                                            </button>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Belum ada transaksi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        {!! $transaksis->links('pagination::bootstrap-5') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#btnShowForm').on('click', function() {
                    $('#formTambahTransaksi').slideDown();
                });
                $('#btnCloseForm').on('click', function() {
                    $('#formTambahTransaksi').slideUp();
                });

                $(".btnEditTransaksi").on("click", function() {
                    console.log("oke");
                    const transaksi = $(this).data('transaksi');
                    $('#edit_id').val(transaksi.transaksi_id);
                    // tentukan barang selected berdasarkan transaksi.barang_id, ini pake nya select option

                    $('#edit_barang_id').val(transaksi.barang_id);

                    $('#edit_user_id').val(transaksi.user_id);
                    $('#edit_tanggal').val(transaksi.tanggal);
                    $('#edit_jenis').val(transaksi.jenis);
                    $('#edit_jumlah').val(transaksi.jumlah);
                    $('#edit_catatan').val(transaksi.catatan);
                    $('#editTransaksiForm').attr('action', `/transaksibarang/${transaksi.transaksi_id}`);
                    $('#formTambahTransaksi').slideUp();
                    $('#formEditTransaksi').slideDown();
                })

                $('.btnHapusTransaksi').on('click', function() {
                    const transaksi = $(this).data('transaksi');
                    console.log(transaksi);
                    $('#formHapusTransaksi').attr('action', `/transaksibarang/${transaksi.transaksi_id}`);
                });
            });
        </script>
    @endpush
@endsection
