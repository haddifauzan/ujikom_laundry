<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/flag-icon-css/css/flag-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/vertical-light-layout/style.css') }}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset('images/logo_laundry_bg.jpeg') }}" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
    <link href="https://cdn.datatables.net/v/bs5/dt-2.1.7/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/bs5/dt-2.1.7/datatables.min.js"></script>
  </head>
  <body>

    <div class="container-scroller">
        @include('karyawan.pengelola-barang.template.navbar')
        @include('karyawan.pengelola-barang.template.sidebar')
        @include('karyawan.pengelola-barang.template.content')

        @include('vendor.sweetalert')

            <!-- Logout Modal -->
          <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h2 class="modal-title text-dark" id="logoutModalLabel">Confirm Logout</h2>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  Are you sure you want to log out?
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <!-- Logout Form -->
                  <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">Yes</button>
                  </form>
                </div>
              </div>
            </div>
          </div>

            <!-- Tambahkan offcanvas profile -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="profileOffcanvas">
              <div class="offcanvas-header">
                <h5 class="offcanvas-title">Profile Karyawan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
              </div>
              <div class="offcanvas-body">
                <div class="text-center mb-4">
                  <img src="{{asset('uploads/karyawan/' . auth()->user()->karyawan->foto_karyawan)}}" 
                      class="rounded-circle" style="width: 150px; height: 150px;" alt="Profile Picture">
                  <h4 class="mt-3">{{auth()->user()->karyawan->nama_karyawan}}</h4>
                </div>
                
                <div class="profile-info">
                  <form action="{{ route('karyawan.pengelola-barang.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                      <label class="form-label">Nama Karyawan</label>
                      <input type="text" class="form-control" name="nama_karyawan" 
                            value="{{ auth()->user()->karyawan->nama_karyawan }}">
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Email</label>
                      <input type="email" class="form-control" name="email" 
                            value="{{ auth()->user()->email }}">
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Foto Profile</label>
                      <input type="file" class="form-control" name="foto_karyawan">
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Password Baru</label>
                      <input type="password" class="form-control" name="password">
                      <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Konfirmasi Password Baru</label>
                      <input type="password" class="form-control" name="password_confirmation">
                    </div>

                    <button type="submit" class="btn btn-warning w-100">Update Profile</button>
                  </form>
                </div>
              </div>
            </div>
    </div>

    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('assets/vendors/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-circle-progress/js/circle-progress.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.cookie.js') }}"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/js/misc.js') }}"></script>
    <script src="{{ asset('assets/js/settings.js') }}"></script>
    <script src="{{ asset('assets/js/todolist.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <!-- End custom js for this page -->
  </body>
</html>

