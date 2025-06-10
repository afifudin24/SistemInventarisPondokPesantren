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
                    <h4 class="font-weight-normal mb-3">Jumlah Pinjam <i class="mdi mdi-account mdi-24px float-end"></i>
                    </h4>
                    <h2 class="mb-5">{{$pinjamcount}}</h2>
                    <!-- <h6 class="card-text">Increased by 60%</h6> -->
                  </div>
                </div>
              </div>
             
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                  <div class="card-body">
                    <img  src="{{ asset('images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Jumlah Dikembalikan <i class="mdi mdi-swap-horizontal mdi-24px float-end"></i>
                    </h4>
                    <h2 class="mb-5">{{$kembalikancount}}</h2>
                    <!-- <h6 class="card-text">Increased by 5%</h6> -->
                  </div>
                </div>
              </div>
            </div>
       
          
            <div class="row">
              <div class="col-12 grid">

             
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Peminjaman Belum Dikembalikan</h4>
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
                                @forelse ($peminjamanBelumKembali as $peminjaman)
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
                        {!! $peminjamanBelumKembali->links('pagination::bootstrap-5') !!}
                    </div>
                </div>
              </div>
               </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->

       
</div>
@endsection
