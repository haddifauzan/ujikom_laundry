<!-- header top -->
<header class="navigation position-absolute w-100 bg-body-tertiary shadow border-bottom border-light border-opacity-10 rounded-bottom-3 rounded-bottom-sm-4">
    <nav class="navbar navbar-expand-xl" aria-label="Offcanvas navbar large">
        <div class="container py-1">
            <div class="navbar-brand d-flex align-items-center">
                <img src="{{ asset('images/logo_laundry_bg.jpeg') }}" height="45" alt="logo" class="rounded me-3    ">
                <p class="fw-bold m-0 fs-2">Laundry</p>
            </div>

            <div class="dropdown ms-3 order-last">
                <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
                    <symbol id="check2" viewBox="0 0 16 16">
                        <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                    </symbol>
                    <symbol id="circle-half" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
                    </symbol>
                    <symbol id="moon-stars-fill" viewBox="0 0 16 16">
                        <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z"/>
                        <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z"/>
                    </symbol>
                    <symbol id="sun-fill" viewBox="0 0 16 16">
                        <path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"/>
                    </symbol>
                </svg>

                <button class="btn btn-success text-white btn-sm rounded dropdown-toggle d-flex align-items-center"
                    id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown"
                    aria-label="Toggle theme (auto)">
                    <svg fill="currentColor" class="bi my-1 theme-icon-active" width="1em" height="1em">
                        <use href="#circle-half"></use>
                    </svg>
                    <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
                </button>

                <ul class="p-1 dropdown-menu dropdown-menu-end dropdown-menu-hover end-0 rounded-3 shadow bg-body-tertiary"
                    style="--bs-dropdown-min-width: 9rem;" aria-labelledby="bd-theme-text">

                    <li style="color: var(--bs-tertiary-bg);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="mt-n1 d-inline-block position-absolute top-0 end-0 translate-middle" viewBox="0 0 16 16">
                            <path class="carret-dropdown-path" d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
                        </svg>
                    </li>

                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center rounded-1" data-bs-theme-value="light" aria-pressed="false">
                            <svg fill="currentColor" class="bi me-2 theme-icon" width="1em" height="1em"><use href="#sun-fill"></use></svg>
                            Light
                            <svg fill="currentColor" class="bi ms-auto d-none active-check" width="1em" height="1em"><use href="#check2"></use></svg>
                        </button>
                    </li>

                    <li>
                        <button type="button" class="my-1 dropdown-item d-flex align-items-center rounded-1" data-bs-theme-value="dark" aria-pressed="false">
                            <svg fill="currentColor" class="bi me-2 theme-icon" width="1em" height="1em"><use href="#moon-stars-fill"></use></svg>
                            Dark
                            <svg fill="currentColor" class="bi ms-auto d-none active-check" width="1em" height="1em"><use href="#check2"></use></svg>
                        </button>
                    </li>

                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center rounded-1 active" data-bs-theme-value="auto" aria-pressed="true">
                            <svg fill="currentColor" class="bi me-2 theme-icon" width="1em" height="1em"><use href="#circle-half"></use></svg>
                            Auto
                            <svg fill="currentColor" class="bi ms-auto d-none active-check" width="1em" height="1em"><use href="#check2"></use></svg>
                        </button>
                    </li>
                </ul>
            </div>

            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="offcanvas offcanvas-end border-0 rounded-start-0 rounded-start-sm-4" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
                <div class="offcanvas-header" style="padding: 2rem 2rem 1.5rem 2rem;">
                    <h5 class="offcanvas-title m-0" id="offcanvasNavbar2Label">
                        <a class="navbar-brand" href="javascript:;">
                            <img src="{{ asset('assets-2/logo/logo.png') }}" height="32" alt="logo">
                        </a>
                    </h5>
                    <button type="button" class="btn-close text-body-emphasis" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

                <div class="offcanvas-body">
                    <ul class="navbar-nav align-items-xl-center flex-grow-1 column-gap-4 row-gap-4 row-gap-xl-2">
                        @auth
                        <li class="nav-item ms-xl-auto">
                            <a href="{{route('landing.member')}}" class="px-3 text-body-emphasis bg-body-secondary-hover nav-link rounded-3 text-base leading-6 fw-semibold {{ request()->routeIs('landing.member') ? 'active' : '' }}" aria-current="page">
                                Home
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('landing.services.member')}}" class="px-3 text-body-emphasis bg-body-secondary-hover nav-link rounded-3 text-base leading-6 fw-semibold {{ request()->routeIs('landing.services.member') ? 'active' : '' }}">
                                Services
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('landing.about.member')}}" class="px-3 text-body-emphasis bg-body-secondary-hover nav-link rounded-3 text-base leading-6 fw-semibold {{ request()->routeIs('landing.about.member') ? 'active' : '' }}">
                                About
                            </a>
                        </li>
                        @else
                        <li class="nav-item ms-xl-auto">
                            <a href="{{route('landing')}}" class="px-3 text-body-emphasis bg-body-secondary-hover nav-link rounded-3 text-base leading-6 fw-semibold {{ request()->routeIs('landing') ? 'active' : '' }}" aria-current="page">
                                Home
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('landing.services')}}" class="px-3 text-body-emphasis bg-body-secondary-hover nav-link rounded-3 text-base leading-6 fw-semibold {{ request()->routeIs('landing.services') ? 'active' : '' }}">
                                Services
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('landing.about')}}" class="px-3 text-body-emphasis bg-body-secondary-hover nav-link rounded-3 text-base leading-6 fw-semibold {{ request()->routeIs('landing.about') ? 'active' : '' }}">
                                About
                            </a>
                        </li>
                        @endauth

                        <li class="nav-item">
                            <div class="dropdown">
                                <button class="btn w-100 text-start dropdown-toggle px-3 text-body-emphasis bg-body-secondary-hover nav-link rounded-3 text-base leading-6 fw-semibold {{ request()->routeIs('member.*') ? 'active' : '' }}" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Member Features
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-hover end-0 text-sm shadow bg-body-tertiary">
                                    <li>
                                        <a class="dropdown-item text-body-emphasis bg-body-secondary-hover py-2 text-base leading-6 fw-semibold" 
                                           href="{{ route('member.vouchers') }}" 
                                           data-member-feature>
                                            View Vouchers
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-body-emphasis bg-body-secondary-hover py-2 text-base leading-6 fw-semibold" 
                                           href="{{ route('member.order.tracking') }}"
                                           data-member-feature>
                                            Order Tracking
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-body-emphasis bg-body-secondary-hover py-2 text-base leading-6 fw-semibold" 
                                           href="{{ route('member.transactions') }}"
                                           data-member-feature>
                                            Transaction History
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item ms-xl-auto" id="loginButton">
                            <a href="{{ route('member.login') }}" class="px-3 text-body-emphasis bg-body-secondary-hover border nav-link rounded-3 text-base leading-6 fw-semibold text-center">
                                <i class="mdi mdi-login me-2"></i> Login for Member
                            </a>
                        </li>

                        <li class="nav-item ms-xl-auto border rounded" id="userDropdown" style="display: none; border: 2px solid #007bff; border-radius: 16px; ">
                            <div class="dropdown">
                                <button class="btn w-100 text-start dropdown-toggle px-3 text-body-emphasis bg-body-secondary-hover nav-link rounded-3 text-base leading-6 fw-semibold" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span id="userName"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-hover end-0 text-sm shadow bg-body-tertiary">
                                    <li>
                                        <a class="dropdown-item text-body-emphasis bg-body-secondary-hover py-2 text-base leading-6 fw-semibold" 
                                           href="#" onclick="showProfile(event)">
                                            <i class="mdi mdi-account me-2"></i> Profile
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-body-emphasis bg-body-secondary-hover py-2 text-base leading-6 fw-semibold" 
                                           href="#" data-bs-target="#logoutModal" data-bs-toggle="modal">
                                            <i class="mdi mdi-logout me-2"></i> Logout
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>

<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login Required</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>You must log in as a member to access this feature.</p>
                <p>Not a member yet? Please register at our laundry service to get a member account.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light text-dark" data-bs-dismiss="modal">Close</button>
                <a href="{{ route('member.login') }}" class="btn btn-info text-white">Login</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin keluar dari akun Anda?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('member.logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger text-white">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="offcanvas offcanvas-end" id="profileOffcanvas" tabindex="-1" aria-labelledby="profileOffcanvasLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="profileOffcanvasLabel">Profil Member</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="text-center mb-4">
            <h4 class="mb-1" id="profileName"></h4>
            <p class="text-muted" id="profileEmail"></p>
        </div>
        <div class="border-bottom pb-3 mb-3">
            <h6 class="mb-3">Informasi Member</h6>
            <div class="row mb-2">
                <div class="col-5">Kode Konsumen</div>
                <div class="col-7" id="consumerCode"></div>
            </div>
            <div class="row mb-2">
                <div class="col-5">No. Telepon</div>
                <div class="col-7" id="memberPhone"></div>
            </div>
            <div class="row mb-2">
                <div class="col-5">Alamat</div>
                <div class="col-7" id="memberAddress"></div>
            </div>
            <div class="row mb-2">
                <div class="col-5">Bergabung Sejak</div>
                <div class="col-7" id="memberJoinDate"></div>
            </div>
        </div>
        <div class="border-bottom pb-3 mb-3">
            <h6 class="mb-3">Statistik</h6>
            <div class="row mb-2">
                <div class="col-8">Total Transaksi</div>
                <div class="col-4 text-end" id="totalTransactions"></div>
            </div>
        </div>
    </div>
</div>

<style>
    .navbar-nav .nav-link.active {
        background: #0090d855;
        border-bottom: 3px solid #00e070f7; /* Border bawah hijau */
        color: #00e070f7; /* Warna teks hijau */
        font-weight: bold; /* Menebalkan teks */
        transition: all 0.3s ease; /* Efek transisi untuk perubahan */
    }

    .navbar-nav .nav-link.active:hover {
        border-bottom: 3px solid #0056b3; /* Border bawah saat hover */
        color: #0056b3; /* Warna teks saat hover */
    }

    /* Dropdown item yang aktif */
    .dropdown-menu .dropdown-item.active {
        border-bottom: 3px solid #004998b5; /* Border bawah biru */
        color: #004998b5; /* Warna teks biru */
        font-weight: bold; /* Menebalkan teks */
        transition: all 0.3s ease; /* Efek transisi */
    }

    .dropdown-menu .dropdown-item.active:hover {
        border-bottom: 3px solid #0056b3; /* Border bawah saat hover */
        color: #0056b3; /* Warna teks saat hover */
    }

</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle member feature links
        const memberFeatureLinks = document.querySelectorAll('[data-member-feature]');
        memberFeatureLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                checkMemberAuth(this.href);
            });
        });
    
        // Check member authentication
        function checkMemberAuth(redirectUrl) {
            fetch('{{ route("member.data") }}')
                .then(response => response.json())
                .then(data => {
                    if (data.authenticated) {
                        window.location.href = redirectUrl;
                    } else {
                        const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                        loginModal.show();
                    }
                });
        }
    
        // Update navigation based on auth status
        fetch('{{ route("member.data") }}')
            .then(response => response.json())
            .then(data => {
                const loginButton = document.querySelector('#loginButton');
                const userDropdown = document.querySelector('#userDropdown');
                
                if (data.authenticated) {
                    loginButton.style.display = 'none';
                    userDropdown.style.display = 'block';
                    document.querySelector('#userName').textContent = data.user.name;
                } else {
                    loginButton.style.display = 'block';
                    userDropdown.style.display = 'none';
                }
            });
    });

    function showProfile(event) {
        event.preventDefault();
        $.ajax({
            url: '{{ route("member.profile.data") }}',  // URL API untuk mengambil data profil
            method: 'GET',
            success: function(data) {
                // Mengupdate elemen dengan data yang diterima dari API
                $('#profileName').text(data.nama_konsumen || 'N/A');
                $('#profileEmail').text(data.email || 'N/A');
                $('#consumerCode').text(data.kode_konsumen || 'N/A');
                $('#memberPhone').text(data.no_hp || 'Tidak ada');
                $('#memberAddress').text(data.alamat || 'Tidak ada');
                $('#memberJoinDate').text(data.tanggal_bergabung || 'Tidak ada');
                $('#totalTransactions').text(data.total_transaksi || '0');

                // Tampilkan offcanvas
                const profileOffcanvas = new bootstrap.Offcanvas(document.querySelector('#profileOffcanvas'));
                profileOffcanvas.show();
            },
            error: function(xhr, status, error) {
                console.error('Error fetching profile data:', error);
                alert('Gagal mengambil data profil.');
            }
        });
    }

    // Close any open dropdowns when opening offcanvas
    $('#profileOffcanvas').on('show.bs.offcanvas', function () {
        // Menutup dropdown-menu yang terbuka
        $('.dropdown-menu.show').each(function () {
            const dropdownButton = $(this).prev()[0]; // Menemukan tombol dropdown yang terkait
            const dropdownInstance = bootstrap.Dropdown.getInstance(dropdownButton); // Mendapatkan instance dropdown
            if (dropdownInstance) {
                dropdownInstance.hide(); // Menutup dropdown jika terbuka
            }
        });
    });

</script>
