<div class="container-fluid page-body-wrapper">
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item ">
                <a class="nav-link" href="{{route('karyawan.kasir.dashboard')}}">
                <span class="icon-bg"><i class="mdi mdi-cube menu-icon"></i></span>
                <span class="menu-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#operational" aria-expanded="false" aria-controls="forms">
                <span class="icon-bg"><i class="mdi mdi-database menu-icon"></i></span>
                <span class="menu-title">Menu Kasir</span>
                <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="operational">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{route('pesanan.index')}}">Kelola Pesanan</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{route('riwayat.index')}}">Riwayat Transaksi</a></li>        
                </ul>
                </div>
            </li>
            <hr>
            <li class="nav-item documentation-link">
                <a class="nav-link" href="{{route('transaksi.step1')}}">
                  <span class="icon-bg">
                    <i class="mdi mdi-badge-account menu-icon"></i>
                  </span>
                  <span class="menu-title">KASIR MODE</span>
                </a>
            </li>
            <hr>
            <li class="nav-item documentation-link">
                <a class="nav-link bg-danger" href="{{route('pengambilan.index')}}">
                  <span class="icon-bg">
                    <i class="mdi mdi-badge-account menu-icon"></i>
                  </span>
                  <span class="menu-title">PENGAMBILAN</span>
                </a>
            </li>
            <li class="nav-item sidebar-user-actions">
                <div class="user-details">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                    <div class="d-flex align-items-center">
                        <div class="sidebar-profile-img">
                        <img src="{{asset('uploads/karyawan/' . auth()->user()->karyawan->foto_karyawan)}}" width="31px" height="31px" alt="image" class="rounded-circle">
                        </div>
                        <div class="sidebar-profile-text">
                        <p class="mb-1">{{auth()->user()->karyawan->nama_karyawan}}</p>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </li>
            <li class="nav-item sidebar-user-actions">
                <div class="sidebar-user-menu">
                <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#logoutModal">
                    <i class="mdi mdi-logout menu-icon"></i>
                    <span class="menu-title">Log Out</span>
                </a>
                </div>
            </li>
        </ul>
    </nav>