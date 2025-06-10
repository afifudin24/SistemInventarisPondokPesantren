@extends('layouts.dashboard')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title">
                    <span class="page-title-icon bg-gradient-primary text-white me-2">
                        <i class="mdi mdi-note-outline"></i>
                    </span> Catatan Kondisi  Barang
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

            <div class="row">
                    <div class="mb-3">
                             <button id="btnShowForm" class="btn btn-primary">
                    Tambah Catatan Barang
                </button>
                        </div>
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                          {{-- Form Tambah Barang --}}
                        <div id="formTambahBarang" class="card mb-4"
                            style="display: {{ $errors->any() ? 'block' : 'none' }};">
                            <div class="card-body position-relative">
                                <button type="button" class="btn-close position-absolute top-0 end-0 m-3"
                                    aria-label="Close" id="btnCloseForm"></button>
                                <h5 class="card-title">Tambah Catatan Barang</h5>
                                <form action="{{ route('catatan.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="barang_id" class="form-label">Barang</label>
                                        <select name="barang_id" class="form-select" id="">
                                            <option value="">Barang</option>
                                            @foreach($barangs as $barang)
                                            <option value="{{ $barang->barang_id }}">{{ $barang->nama_barang }}</option>
                                            @endforeach
                                        </select>
                                        @error('barang_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="nama_barang" class="form-label">Catatan</label>
                                        <textarea name="catatan" id="" class="form-control" cols="30" rows="10"></textarea>
                                      
                                        @error('catatan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                   
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </form>
                            </div>
                        </div>
                    
                        {{-- Table Data --}}
                        <div class="card-body">
                            <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Catatan Kondisi Barang</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barangs as $index => $barang)
                <tr>
                    <td>{{ $barangs->firstItem() + $index }}</td>
                    <td>{{ $barang->nama_barang }}</td>
                    <td>
                        <button class="btn btn-info btn-sm" data-bs-toggle="collapse" data-bs-target="#catatan-{{ $barang->barang_id }}">
                            Tampilkan
                        </button>
                    </td>
                </tr>
                <tr class="collapse" id="catatan-{{ $barang->barang_id }}">
                    <td colspan="3">
                        @if($barang->catatanKondisi->count() > 0)
                            <ul>
                                @foreach($barang->catatanKondisi as $catatan)
                                    <li class="my-1">
                                        {{ $catatan->catatan }} ({{ $catatan->created_at }})
                                        <form action="{{ route('catatan.destroy', $catatan->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <em>Tidak ada catatan</em>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
                        </div>

                        <div class="d-flex justify-content-end mx-2 my-2">
                            {!! $barangs->links('pagination::bootstrap-5') !!}
                        </div>
                    </div>
                </div>

                {{-- modal detail barang --}}
                <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg"> <!-- Tambahkan modal-lg untuk ukuran lebar -->
                        <div class="modal-content">
                            <!-- Header -->
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Detail Barang</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <!-- Body -->
                            <div class="modal-body">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th style="width: 30%;">Kode Barang</th>
                                            <td id="barang-kode"></td>
                                        </tr>
                                        <tr>
                                            <th>Nama Barang</th>
                                            <td id="barang-nama"></td>
                                        </tr>
                                        <tr>
                                            <th>Jumlah</th>
                                            <td id="barang-jumlah"></td>
                                        </tr>
                                        <tr>
                                            <th>Keterangan</th>
                                            <td>
                                                <div id="barang-catatan"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Kondisi</th>
                                            <td id="barang-catatan-kondisi"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- akhir modal --}}

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
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
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

                        // detail barang
                        $('.btnDetailBarang').on('click', function() {
                            const barang = $(this).data('barang');
                            $('#barang-kode').text(barang.kode_barang);
                            $('#barang-nama').text(barang.nama_barang);
                            $('#barang-jumlah').text(barang.jumlah);
                            $('#barang-catatan').html(barang.keterangan);
                            $('#barang-catatan-kondisi').text(barang.kondisi);
                        })

                    });
                </script>
            @endpush
        </div>
    @endsection
