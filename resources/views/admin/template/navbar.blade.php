<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
      <a class="navbar-brand brand-logo m-0 p-0" href="{{route('admin.dashboard')}}">
        <img src="{{asset('images/logo_laundry_bg.jpeg')}}" alt="logo" style="width: 40px; height:40px; border-radius: 50%;"/>
        <span class="text-white fw-bold ms-2">ADMIN</span>
      </a>
      <a class="navbar-brand brand-logo-mini" href="{{route('admin.dashboard')}}">
      <img src="{{asset('images/logo_laundry_bg.jpeg')}}" alt="logo" style="width: 30px; height:30px; border-radius: 50%;"/>
      </a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-stretch">
      <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
        <span class="mdi mdi-menu"></span>
      </button>
      <ul class="navbar-nav navbar-nav-right">
        <li class="nav-item nav-profile dropdown">
          <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="nav-profile-img">
              <img src="{{asset('images/admin.png')}}" alt="image">
            </div>
            <div class="nav-profile-text">
              <p class="mb-1 text-black">Admin Master</p>
            </div>
          </a>
          <div class="dropdown-menu navbar-dropdown dropdown-menu-end p-0 border-0 font-size-sm" aria-labelledby="profileDropdown" data-x-placement="bottom-end">
            <div class="p-3 text-center bg-info">
              <img class="img-avatar img-avatar48 img-avatar-thumb" src="{{asset('images/admin.png')}}" alt="">
            </div>
            <div class="p-2">
              <h5 class="dropdown-header text-uppercase ps-2 text-dark">User Options</h5>
              <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSettings" aria-controls="offcanvasSettings">
                <span>Setting Account</span>
                  <span class="p-0">
                      <i class="mdi mdi-account-outline ms-1"></i>
                  </span>
              </a>
              <div role="separator" class="dropdown-divider"></div>
              <h5 class="dropdown-header text-uppercase  ps-2 text-dark mt-2">Actions</h5>
              <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                <span>Log Out</span>
                <i class="mdi mdi-logout ms-1"></i>
              </a>
            </div>
          </div>
        </li>
      </ul>
      <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
        <span class="mdi mdi-menu"></span>
      </button>
    </div>
  </nav>
