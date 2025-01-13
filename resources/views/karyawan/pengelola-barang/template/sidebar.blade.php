<div class="container-fluid page-body-wrapper">
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item ">
                <a class="nav-link" href="{{route('karyawan.pengelola-barang.dashboard')}}">
                <span class="icon-bg"><i class="mdi mdi-cube menu-icon"></i></span>
                <span class="menu-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item nav-category">Menu Utama</li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
                    <span class="icon-bg"><i class="mdi mdi-package-variant-closed menu-icon"></i></span>
                    <span class="menu-title">Kelola Data Barang</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="icons">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{route('karyawan.pengelola-barang.data-barang')}}">Data Barang</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{route('barang-masuk.index')}}">Pembelian Barang</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{route('karyawan.pemakaian-barang.index')}}">Pemakaian Barang</a></li>
                </ul>
                </div>
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