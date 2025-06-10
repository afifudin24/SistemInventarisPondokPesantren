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
                <div class="card bg-gradient-danger card-img-holder text-white">
                  <div class="card-body">
                    <img src="{{ asset('images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Total User <i class="mdi mdi-account mdi-24px float-end"></i>
                    </h4>
                    <h2 class="mb-5">{{$usercount}}</h2>
                    <!-- <h6 class="card-text">Increased by 60%</h6> -->
                  </div>
                </div>
              </div>
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
                <div class="card bg-gradient-success card-img-holder text-white">
                  <div class="card-body">
                    <img  src="{{ asset('images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Total Transaksi <i class="mdi mdi-swap-horizontal mdi-24px float-end"></i>
                    </h4>
                    <h2 class="mb-5">{{$transaksicount}}</h2>
                    <!-- <h6 class="card-text">Increased by 5%</h6> -->
                  </div>
                </div>
              </div>
            </div>
          
            <div class="row">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">User Belum Aktif</h4>
                   <div class="table-responsive">

                                
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($users) && count($users) > 0)
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td> <!-- Ini index dimulai dari 1 -->
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td class="text-capitalize">{{ $user->role }}</td>
                                                    <td>
                                                        @if ($user->is_active == 1)
                                                            <span class="badge bg-success">Aktif</span>
                                                        @else
                                                            <span class="badge bg-danger">Tidak Aktif</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                       <button class="btn btn-success" onclick="aktifkanUser({{ $user->id }})">
                                                        Aktifkan
                                                       </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4">Data Kosong</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                                </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          @push('scripts')
          <script>
            function aktifkanUser(userId) {
              console.log(userId);
              // ajax ke controller
              $.ajax({
                url: "{{ route('admin.aktifkan-user') }}",
                type: "POST",
                data: {
                  _token: "{{ csrf_token() }}",
                  user_id: userId
                },
                success: function(response) {
                  console.log(response);
                  // refresh halaman
                  location.reload();
                },
                 error: function(xhr) {
      console.error("Gagal:", xhr.responseJSON.message);
      alert("Terjadi kesalahan: " + xhr.responseJSON.message);
    }
            })
            }
          </script>
          @endpush 
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->

       

@endsection
