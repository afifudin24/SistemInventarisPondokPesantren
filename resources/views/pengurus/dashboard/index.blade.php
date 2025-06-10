@extends('layouts.dashboard')
@section('content')

<div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                  <i class="mdi mdi-home"></i>
                </span> Dashboard
              </h3>
             
            </div>
            <div class="row">
               <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                  <div class="card-body">
                    <img  src="{{ asset('images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Total Barang <i class="mdi mdi-package mdi-24px float-end"></i>
                    </h4>
                    <h2 class="mb-5">{{$barangcount}}</h2>
                    <!-- <h6 class="card-text">Decreased by 10%</h6> -->
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-danger card-img-holder text-white">
                  <div class="card-body">
                    <img src="{{ asset('images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Verifikasi Peminjaman <i class="mdi mdi-account mdi-24px float-end"></i>
                    </h4>
                    <h2 class="mb-5">{{$verifikasiPeminjamanCount}}</h2>
                    <!-- <h6 class="card-text">Increased by 60%</h6> -->
                  </div>
                </div>
              </div>
             
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                  <div class="card-body">
                    <img  src="{{ asset('images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Konfirmasi Pengembalian <i class="mdi mdi-swap-horizontal mdi-24px float-end"></i>
                    </h4>
                    <h2 class="mb-5">{{$konfirmasiPengembalianCount}}</h2>
                    <!-- <h6 class="card-text">Increased by 5%</h6> -->
                  </div>
                </div>
              </div>
            </div>
        
            <div class="row">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Verifikasi Peminjaman Barang</h4>
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
                                                    action="{{ route('peminjaman.diambil', $peminjaman->peminjaman_id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-success">Diambil</button>
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
                                              @if ($peminjaman->status == 'Diambil')
                                               -
                                            @endif

                                            @if ($peminjaman->status == 'Selesai')
                                                -
                                            @endif

                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada yang perlu diverifikasi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            {{-- konfirmasi pengembalian --}}
            <div class="row">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Konfirmasi Pengembalian</h4>
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
                                            @if ($pengembalian->status == 'Dikonfirmasi')
                                             
                                                
                                                    <a target="_blank" href="{{ route('pengembalian.cetak', $pengembalian->pengembalian_id) }}" class="btn btn-info "> <i class="mdi mdi-file"></i> </a>
                                         
                                            @else
                                            <button class="btn btn-info btnKonfirmasi" data-bs-toggle="modal"
                                                data-bs-target="#detailModal"
                                                data-pengembalian='@json($pengembalian)'>
                                                Konfirmasi
                                            </button>
                                            @endif
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada yang perlu dikonfirmasi.</td>
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
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->

       

@endsection
