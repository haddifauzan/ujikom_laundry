<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Wash UP</title>
        <!-- plugins:css -->
        <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendors/flag-icon-css/css/flag-icons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/vertical-light-layout/style.css') }}">
        <!-- End layout styles -->
        <link rel="shortcut icon" href="{{ asset('images/logo_laundry_bg.jpeg') }}" />

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="content-wrapper d-flex align-items-center auth">
                    <div class="row flex-grow">
                        <div class="col-lg-4 mx-auto">
                            <div class="auth-form-light text-left p-5">
                                <div class="d-flex align-items-center justify-content-center flex-row">
                                    <div class="brand-logo mb-2" style="width: 80px; height: 80px;">
                                        <img src="{{ asset('images/logo_laundry.jpeg') }}" class="img-fluid">
                                    </div>
                                    <p class="mb-0 text-dark fs-4 text-dark fw-bold">LAUNDRY</p>
                                </div>
                                <h4 class="mb-4 text-center">Clean, Fast, Practical!</h4>
                                <h6 class="font-weight-light">Sign in to continue.</h6>
                                <form class="pt-3" method="POST" action="{{ route('member.login.submit') }}">
                                    @csrf
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email') }}" required>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group position-relative">
                                        <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" id="password" placeholder="Password" required>
                                        <span toggle="#password" class="mdi mdi-eye-outline field-icon toggle-password position-absolute" style="right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></span>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="mt-3">
                                        <button type="submit" class="btn d-grid btn-info btn-lg font-weight-medium auth-form-btn w-100">SIGN IN</button>
                                    </div>
                                    <div class="my-2 d-flex justify-content-between align-items-center">
                                        <div class="form-check form-check-info">
                                            <label class="form-check-label text-muted">
                                                <input type="checkbox" class="form-check-input" name="remember"> Keep me signed in </label>
                                        </div>
                                    </div>
                                </form>
                                <div class="text-start mt-3">
                                    <a href="{{ route('landing') }}" class="font-weight-medium w-100 text-secondary"><i class="mdi mdi-arrow-left me-2"></i> Back to Home</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
            </div>
            <!-- page-body-wrapper ends -->
            @include('vendor.sweetalert')
        </div>

        <script>
            document.querySelector('.toggle-password').addEventListener('click', function (e) {
                const passwordInput = document.querySelector('#password');
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('mdi-eye-outline');
                this.classList.toggle('mdi-eye-off-outline');
            });
        </script>
        <!-- container-scroller -->
        <!-- plugins:js -->
        <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
        <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
        <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
        <script src="{{ asset('assets/js/misc.js') }}"></script>
        <script src="{{ asset('assets/js/settings.js') }}"></script>
        <script src="{{ asset('assets/js/todolist.js') }}"></script>
        <!-- endinject -->
    </body>
</html>