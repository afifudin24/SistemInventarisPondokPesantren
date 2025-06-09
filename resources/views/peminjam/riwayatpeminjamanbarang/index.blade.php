@extends('layouts.dashboard')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title">
                    <span class="page-title-icon bg-gradient-primary text-white me-2">
                        <i class="mdi mdi-history"></i>
                    </span> Riwayat Peminjaman barang
                </h3>
            </div>

            {{-- Tampilkan alert --}}
            @if (session('success'))
                <div class="alert alert-success d-flex justify-content-between align-items-center">
                    <span>{{ session('success') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                           <div class="col-auto">
                            <a href="{{ route('riwayatpeminjaman.rekap', request()->only(['start_date', 'end_date'])) }}"
                                class="btn btn-success" target="_blank">
                                <i class="mdi mdi-file"></i> Rekap
                            </a>
                        </div>

                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Barang</th>

                                    <th>Tanggal Peminjaman</th>
                                    <th>Tanggal Pengembalian</th>
                                    <th>Jumlah</th>

                                    <th>Aksi</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($peminjamans as $peminjaman)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>

                                        <td>{{ $peminjaman->barang->nama_barang }}</td>

                                        <td class="text-capitalize">{{ $peminjaman->tanggal_pinjam }}</td>
                                        <td class="text-capitalize">
                                            {{ $peminjaman->pengembalian->tanggal_kembali ?? 'Belum dikembalikan' }}
                                        </td>

                                        <td>{{ $peminjaman->jumlah_pinjam }}</td>

                                        <td>
                                            @if (isset($peminjaman->pengembalian->peminjaman_id))
                                                <button class="btn btn-secondary btnDetailPengembalian"
                                                    data-bs-toggle="modal" data-bs-target="#detailModal"
                                                    data-peminjaman='@json($peminjaman)'>
                                                    <i class="mdi mdi-eye"></i>
                                                </button>
                                                @if($peminjaman->pengembalian->status == 'Dikonfirmasi')
                                                
                                                    <a target="_blank" href="{{ route('pengembalian.cetak', $peminjaman->pengembalian->pengembalian_id) }}" class="btn btn-info "> <i class="mdi mdi-file"></i> </a>
                                                @endif
                                            @else
                                                <button class="btn btn-info btnKembalikan" data-bs-toggle="modal"
                                                    data-bs-target="#modalKembalikan"
                                                    data-peminjaman='@json($peminjaman)'>
                                                    Kembalikan
                                                </button>
                                            @endif
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
                    <div class="d-flex justify-content-end mt-3">
                        {!! $peminjamans->links('pagination::bootstrap-5') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal detail --}}
      <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg"> <!-- Tambahkan modal-lg untuk ukuran lebar -->
                        <div class="modal-content">
                            <!-- Header -->
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Detail Pengembalian</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <!-- Body -->
                            <div class="modal-body">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>Status Pengembalian</th>
                                            <td id="status-pengembalian"></td>
                                        </tr>
                                        <tr>
                                            <th>Jumlah Kembali</th>
                                            <td id="barang-pengembalian"></td>
                                        </tr>
                                        <tr>
                                            <th>Kondisi</th>
                                            <td>
                                                <div id="kondisi-pengembalian"></div>
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
    </div>

    {{-- modal kembalikan barang --}}
    <div class="modal fade" id="modalKembalikan" tabindex="-1" aria-labelledby="modalHapuspeminjamanLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('pengembalian.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalHapusUserLabel">Kembalikan Peminjaman</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        {{-- form kembalikan  --}}
                        <div class="mb-3">
                            <input type="hidden" name="peminjaman_id" id="peminjaman_id">
                            <div class="form-group">
                                <label for="tanggal_kembali">Upload Bukti</label>
                                <input type="file" name="bukti" id="bukti_kembali" class="form-control">

                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" data-bs-dismiss="modal">Kirim</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>

                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('.btnKembalikan').on('click', function() {
                    const peminjaman = $(this).data('peminjaman');
                    $('#peminjaman_id').val(peminjaman.peminjaman_id);
                    console.log(peminjaman);

                })
                $('.btnHapuspeminjaman').on('click', function() {
                    const peminjaman = $(this).data('peminjaman');
                    console.log(peminjaman);

                });

                $('.btnDetailPengembalian').on('click', function() {
                    const peminjaman = $(this).data('peminjaman');
                    console.log(peminjaman);
                   $("#status-pengembalian").text(peminjaman.pengembalian.status);
                   $("#barang-pengembalian").text(
    peminjaman.pengembalian && peminjaman.pengembalian.jumlah_kembali 
        ? peminjaman.pengembalian.jumlah_kembali 
        : '-'
);
                  $("#kondisi-pengembalian").text(
    peminjaman.pengembalian && peminjaman.pengembalian.kondisi 
        ? peminjaman.pengembalian.kondisi 
        : '-'
);

                })
            });
        </script>
    @endpush
@endsection
