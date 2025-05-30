@extends('layouts.dashboard')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title">
                    <span class="page-title-icon bg-gradient-primary text-white me-2">
                        <i class="mdi mdi-file"></i>
                    </span> Verifikasi Peminjaman barang
                </h3>
            </div>

            {{-- Tampilkan alert --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between align-items-center"
                    role="alert">
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
                                    <th>Tanggal Peminjaman</th>

                                    <th>Jumlah</th>
                                    <th>Status</th>

                                    <th>Aksi</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($peminjamans as $peminjaman)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>

                                        <td>{{ $peminjaman->barang->nama_barang }}</td>
                                        <td>{{ $peminjaman->user->name }}</td>
                                        <td class="text-capitalize">{{ $peminjaman->tanggal_pinjam }}</td>
                                        <td>{{ $peminjaman->jumlah_pinjam }}</td>

                                        <td>{{ $peminjaman->status }}</td>
                                        <td>
                                            @if ($peminjaman->status == 'Menunggu Verifikasi')
                                                <form
                                                    action="{{ route('peminjaman.updatestatus', $peminjaman->peminjaman_id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="Ditolak">
                                                    <button type="submit" class="btn btn-danger">Tolak</button>
                                                </form>

                                                <form
                                                    action="{{ route('peminjaman.updatestatus', $peminjaman->peminjaman_id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="Diverifikasi">
                                                    <button type="submit" class="btn btn-success">Verifikasi</button>
                                                </form>
                                            @endif

                                            @if ($peminjaman->status == 'Diverifikasi')
                                                <form
                                                    action="{{ route('peminjaman.batalkan', $peminjaman->peminjaman_id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-warning">Batalkan</button>
                                                </form>
                                            @endif

                                            @if ($peminjaman->status == 'Ditolak')
                                                <form
                                                    action="{{ route('peminjaman.updatestatus', $peminjaman->peminjaman_id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="Diverifikasi">
                                                    <button type="submit" class="btn btn-success">Verifikasi</button>
                                                </form>
                                            @endif

                                            @if ($peminjaman->status == 'Dibatalkan')
                                                <button class="btn btn-danger btnHapuspeminjaman"
                                                    data-peminjaman='@json($peminjaman)' data-bs-toggle="modal"
                                                    data-bs-target="#modalHapuspeminjaman">
                                                    Hapus
                                                </button>
                                            @endif

                                            @if ($peminjaman->status == 'Selesai')
                                                -
                                            @endif

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
                        {!! $peminjamans->links('pagination::bootstrap-5') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                    $('#btnShowForm').on('click', function() {
                        $('#formTambahpeminjaman').slideDown();
                    });
                    $('#btnCloseForm').on('click', function() {
                        $('#formTambahpeminjaman').slideUp();
                    });

                    $(".btnEditpeminjaman").on("click", function() {
                        console.log("oke");
                        const peminjaman = $(this).data('peminjaman');
                        $('#edit_id').val(peminjaman.peminjaman_id);
                        // tentukan barang selected berdasarkan peminjaman.barang_id, ini pake nya select option

                        $('#edit_barang_id').val(peminjaman.barang_id);

                        $('#edit_user_id').val(peminjaman.user_id);
                        $('#edit_tanggal').val(peminjaman.tanggal);
                        $('#edit_jenis').val(peminjaman.jenis);
                        $('#edit_jumlah').val(peminjaman.jumlah);
                        $('#edit_catatan').val(peminjaman.catatan);
                        $('#editpeminjamanForm').attr('action', `/peminjamanbarang/${peminjaman.peminjaman_id}`);
                        $('#formTambahpeminjaman').slideUp();
                        $('#formEditpeminjaman').slideDown();
                    })
                    $('#btnCloseEditForm').on('click', function() {
                        $('#formEditpeminjaman').slideUp();
                    });

                    $('.btnHapuspeminjaman').on('click', function() {
                        const peminjaman = $(this).data('peminjaman');
                        console.log(peminjaman);
                        $('#formHapuspeminjaman').attr('action', `/peminjaman/${peminjaman.peminjaman_id}`);
                    });
                });
            </script>
        @endpush
    @endsection
