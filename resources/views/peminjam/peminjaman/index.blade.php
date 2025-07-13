@extends('layouts.dashboard')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title">
                    <span class="page-title-icon bg-gradient-primary text-white me-2">
                        <i class="mdi mdi-file-document"></i>
                    </span> Ajuan Peminjaman barang
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
                <button id="btnShowForm" class="btn btn-primary">Ajukan Peminjaman</button>
            </div>

            {{-- Form Tambah peminjaman --}}
            <div id="formTambahpeminjaman" class="card mb-4" style="display: none;">
                <div class="card-body position-relative">
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3" id="btnCloseForm"></button>
                    {{-- <h5 class="card-title">Tambah peminjaman</h5> --}}
                    <form action="{{ route('peminjamanbarang.store') }}" method="POST">
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
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" name="jumlah" id="jumlah">
                        </div>
                          <div class="mb-3">
                            <label for="edit_keperluan" class="form-label">Keperluan</label>
                          <textarea name="keperluan" id="edit_keperluan" class="form-control" cols="30" rows="10"></textarea>
                        </div>

                       
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </form>
                </div>
            </div>

            {{-- form edit peminjaman --}}
            {{-- Form Edit peminjaman --}}
            <div id="formEditpeminjaman" class="card mb-4" style="display: none;">
                <div class="card-body position-relative">
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3"
                        id="btnCloseEditForm"></button>
                    <h5 class="card-title">Edit peminjaman</h5>
                    <form id="editpeminjamanForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="peminjaman_id" id="edit_id">
                        <div class="mb-3">
                            <label for="barang" class="form-label">Barang</label>
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
                            <label for="edit_jumlah" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" name="jumlah" id="edit_jumlah">
                        </div>
                        <div class="mb-3">
                            <label for="edit_keperluan" class="form-label">Keperluan</label>
                          <textarea name="keperluan" id="edit_keperluan" class="form-control" cols="30" rows="10"></textarea>
                        </div>
                      
                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                    </form>
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
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Tutup"></button>
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
            {{-- akhir modal hapus peminjaman --}}

            {{-- Tabel Data peminjaman --}}
            <div class="card">
                <div class="card-body">
                    <form method="GET" class="row g-3 mb-3 align-items-end">
                    
                        <div class="col-auto">
                            <input type="date" name="start_date" class="form-control"
                                value="{{ request('start_date') }}">
                        </div>
                        <div class="col-auto">
                            <input type="date" name="end_date" class="form-control"
                                value="{{ request('end_date') }}">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-filter"></i> Filter
                            </button>
                        </div>
                        {{-- <div class="col-auto">
                            <a href="{{ route('peminjaman.rekap', request()->only(['jenis', 'start_date', 'end_date'])) }}"
                                class="btn btn-success" target="_blank">
                                <i class="mdi mdi-file"></i> Rekap
                            </a>
                        </div> --}}
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Barang</th>
                                    <th>Tanggal Peminjaman</th>
                                    <th>Keperluan</th>

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
                                        <td class="text-capitalize">{{ $peminjaman->tanggal_pinjam }}</td>
                                          <td class="text-capitalize">{{ $peminjaman->keperluan }}</td>
                                        <td>{{ $peminjaman->jumlah_pinjam }}</td>

                                        <td>{{ $peminjaman->status }}</td>
                                        <td>
                                            @if ($peminjaman->status == 'Menunggu Verifikasi')
                                                <button class="btn btn-warning btnEditpeminjaman"
                                                    data-peminjaman='@json($peminjaman)'>
                                                    Edit
                                                </button>
                                                <button class="btn btn-danger btnHapuspeminjaman"
                                                    data-peminjaman='@json($peminjaman)' data-bs-toggle="modal"
                                                    data-bs-target="#modalHapuspeminjaman">
                                                    Hapus
                                                </button>

                                            @elseif ($peminjaman->status == 'Selesai')
                                                -
                                                

                                            @else
                                                <button class="btn btn-secondary btnBatalkanpeminjaman"
                                                    data-peminjaman='@json($peminjaman)' data-bs-toggle="modal"
                                                    data-bs-target="#modalBatalkanpeminjaman">
                                                    Batalkan
                                                </button>
                                                <a href="{{ route('peminjaman.cetak', $peminjaman->peminjaman_id) }}" class="btn btn-info">
                                                    Cetak Bukti Verifikasi
                                                </a>
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
                    $('#edit_keperluan').val(peminjaman.keperluan);
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
