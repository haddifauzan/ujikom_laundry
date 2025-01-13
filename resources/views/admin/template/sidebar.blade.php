<div class="container-fluid page-body-wrapper">
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item ">
                <a class="nav-link" href="{{route('admin.dashboard')}}">
                <span class="icon-bg"><i class="mdi mdi-cube menu-icon"></i></span>
                <span class="menu-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item nav-category">Menu Utama</li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
                <span class="icon-bg"><i class="mdi mdi-account-multiple menu-icon"></i></span>
                <span class="menu-title">Data Pengguna</span>
                <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="icons">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{route('karyawan.index')}}">Kelola Karyawan</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{route('konsumen.index')}}">Kelola Konsumen</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{route('users.index')}}">Kelola Akun</a></li>
                </ul>
                </div>
            </li>   
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <span class="icon-bg"><i class="mdi mdi-washing-machine menu-icon"></i></span>
                <span class="menu-title">Data Laundry</span>
                <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">          
                    <li class="nav-item"> <a class="nav-link" href="{{route('jenis-laundry.index')}}">Kelola Jenis Laundry</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{route('tarif-laundry.index')}}">Kelola Tarif Laundry</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{route('layanan-tambahan.index')}}">Kelola Layanan</a></li>     
                </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#operational" aria-expanded="false" aria-controls="forms">
                <span class="icon-bg"><i class="mdi mdi-database menu-icon"></i></span>
                <span class="menu-title">Data Master</span>
                <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="operational">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{route('barang.index')}}">Kelola Barang</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{route('supplier.index')}}">Kelola Supplier</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{route('voucher.index')}}">Kelola Voucher</a></li>          
                </ul>
                </div>
            </li>
            <li class="nav-item nav-category">Menu Laporan</li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#reports" aria-expanded="false" aria-controls="reports">
                <span class="icon-bg"><i class="mdi mdi-file-document-multiple menu-icon"></i></span>
                <span class="menu-title">Data Laporan</span>
                <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="reports">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{route('admin.laporan-barang.index')}}">Laporan Barang</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{route('admin.laporan-transaksi.index')}}">Laporan Transaksi</a></li>        
                </ul>
                </div>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="{{route('log-aktivitas.index')}}">
                <span class="icon-bg"><i class="mdi mdi-history menu-icon"></i></span>
                <span class="menu-title">Log Aktivitas</span>
                </a>
            </li>
            <li class="nav-item sidebar-user-actions">
                <div class="user-details">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                    <div class="d-flex align-items-center">
                        <div class="sidebar-profile-img">
                        <img src="{{asset('images/admin.png')}}" alt="image" width="31px" height="31px" class="rounded-circle">
                        </div>
                        <div class="sidebar-profile-text">
                        <p class="mb-1">Admin Master</p>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </li>
            <li class="nav-item sidebar-user-actions">
                <div class="sidebar-user-menu">
                  <a href="{{route('settings.home')}}" class="nav-link"><i class="mdi mdi-cog menu-icon"></i>
                    <span class="menu-title">Pengaturan Aplikasi</span>
                  </a>
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