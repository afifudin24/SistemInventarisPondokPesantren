@extends('layouts.dashboard')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title">
                    <span class="page-title-icon bg-gradient-primary text-white me-2">
                        <i class="mdi mdi-file"></i>
                    </span> Konfirmasi Pengembalian barang
                </h3>
            </div>

            {{-- Tampilkan alert --}}
            @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
        <div>{{ session('success') }}</div>
        <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
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

            {{-- Tabel Data peminjaman --}}
            <div class="card">
                <div class="card-body">
                    <form method="GET" class="row g-3 mb-3 align-items-end">

                        <div class="col-auto">
                            <input type="date" name="start_date" class="form-control"
                                value="{{ request('start_date') }}">
                        </div>
                        <div class="col-auto">
                            <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-filter"></i> Filter
                            </button>
                        </div>

                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Barang</th>
                                    <th>Peminjam</th>
                                    <th>Tanggal Pengembalian</th>

                                    <th>Jumlah</th>
                                    <th>Status</th>

                                    <th>Aksi</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pengembalians as $pengembalian)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>

                                        <td>{{ $pengembalian->peminjaman->barang->nama_barang }}</td>
                                        <td>{{ $pengembalian->peminjaman->user->name }}</td>
                                        <td class="text-capitalize">{{ $pengembalian->tanggal_kembali }}</td>
                                        <td>{{ $pengembalian->peminjaman->jumlah_pinjam }}</td>
                                        <td>{{ $pengembalian->status }}</td>

                                        <td>
                                            <button class="btn btn-info btnKonfirmasi" data-bs-toggle="modal"
                                                data-bs-target="#detailModal"
                                                data-pengembalian='@json($pengembalian)'>
                                                Konfirmasi
                                            </button>

                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Belum ada peminjaman.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        {!! $pengembalians->links('pagination::bootstrap-5') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal konfirmasi --}}

   <form method="POST" enctype="multipart/form-data" id="form-update-pengembalian">
    @csrf
    @method('PUT')

    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Pengembalian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Bukti Pengembalian</th>
                                <td>
                                    <img id="bukti-pengembalian" src="" class="rounded-0 col-6 mb-2" alt="">
                                  
                                </td>
                            </tr>
                            <tr>
                                <th>Jumlah Kembali</th>
                                <td>
                                    <input class="form-control" type="number" name="jumlah_kembali" id="jumlah_kembali">
                                </td>
                            </tr>
                            <tr>
                                <th>Kondisi</th>
                                <td>
                                    <input class="form-control" type="text" name="kondisi" id="kondisi">
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <select name="status" class="form-control" id="status">
                                        <option value="Dikonfirmasi">Konfirmasi</option>
                                        <option value="Menunggu Konfirmasi">Menunggu Konfirmasi</option>
                                        <option value="Tidak Sesuai">Tidak Sesuai</option>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>
</form>


    {{-- akhir modal --}}

    {{-- modal hapus peminjaman --}}
    <div class="modal fade" id="modalHapuspeminjaman" tabindex="-1" aria-labelledby="modalHapuspeminjamanLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formHapuspeminjaman" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalHapusUserLabel">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus peminjaman?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>

        @push('scripts')
            <script>
                $(document).ready(function() {
                    $('.btnKonfirmasi').on('click', function() {
                        const pengembalian = $(this).data('pengembalian');
                        console.log(pengembalian);
                        $("#status").val(pengembalian.status);
                        $("#jumlah_kembali").val(pengembalian.jumlah_kembali);
                        $("#kondisi").val(pengembalian.kondisi);
                        const bukti_pengembalian = pengembalian.bukti;
                        const imageUrl = `/storage/${bukti_pengembalian}`;
                        $("#bukti-pengembalian").attr("src", imageUrl);
                        $("#form-update-pengembalian").attr("action", "/pengembalian/update/" + pengembalian.pengembalian_id);

                        //  $("#detailModal").modal('show');
                    })



                });
            </script>
        @endpush
    @endsection
