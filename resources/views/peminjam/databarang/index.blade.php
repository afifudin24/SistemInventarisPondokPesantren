@extends('layouts.dashboard')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title">
                    <span class="page-title-icon bg-gradient-primary text-white me-2">
                        <i class="mdi mdi-package-variant"></i>
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

            <div class="row">
                <div>

                    <a class="btn btn-info my-2" href="/cetakbarang">
                        Cetak PDF
                    </a>
                </div>
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">

                        {{-- Table Data --}}
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah</th>
                                      
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
                                            
                                            <td>
                                                <button data-bs-toggle="modal" data-bs-target="#detailModal"
                                                    class="btn btn-success btnDetailBarang"
                                                    data-barang='@json($barang)'>Detail</button>
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
                                            <td id="barang-catatan-kondisi">

                                            </td>
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
                    function formatTanggal(isoString) {
                        const tanggal = new Date(isoString);

                        const opsi = {
                            day: '2-digit',
                            month: 'long',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit',
                            timeZone: 'Asia/Jakarta',
                            timeZoneName: 'short',
                        };

                        return tanggal.toLocaleString('id-ID', opsi);
                    }
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
                            console.log(barang);
                            $('#barang-kode').text(barang.kode_barang);
                            $('#barang-nama').text(barang.nama_barang);
                            $('#barang-jumlah').text(barang.jumlah);
                            $('#barang-catatan').html(barang.keterangan);
                            $('#barang-catatan-kondisi').empty();
                            $.each(barang.catatan_kondisi, function(index, kondisi) {
                                $('#barang-catatan-kondisi').append(`
                                    <li>${kondisi.catatan} (${formatTanggal(kondisi.created_at)})</li>
                                `);
                            })
                            // $('#barang-catatan-kondisi').append()
                        })

                    });
                </script>
            @endpush
        </div>
    @endsection
