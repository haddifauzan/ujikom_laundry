@extends('landing.layout.master')

@section('title', 'Our Services - WashUP Laundry')

@section('content')
<!-- Hero Section -->
<div class="bg-secondary-subtle py-5">
    <div class="container py-5">
        <div class="row min-vh-25 align-items-center">
            <div class="col-12 text-center">
                <h1 class="display-4 fw-bold text-success mb-3">Our Services</h1>
                <p class="lead mb-0">Professional Laundry Services Tailored to Your Needs</p>
            </div>
        </div>
    </div>
</div>

<!-- Main Services Section -->
<div class="py-5">
    <div class="container">
        <div class="row g-4">
            @foreach($jenisLaundry as $jenis)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 border-0 shadow-sm bg-secondary-subtle" data-aos="fade-up">
                    <img src="{{ asset('storage/jenis-laundry/'. $jenis->gambar) }}" 
                         class="card-img-top" 
                         alt="{{ $jenis->nama_jenis }}"
                         style="height: 150px; object-fit: cover;">
                    <div class="card-body">
                        <h3 class="card-title h5 fw-bold">{{ $jenis->nama_jenis }}</h3>
                        <p class="card-text text-muted text-secondary">{{ $jenis->deskripsi }}</p>
                        <p class="card-text">
                            <small class="text-success">
                                <i class="bi bi-clock"></i> 
                                Estimated Time: {{ $jenis->waktu_estimasi }} day
                            </small>
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Pricing Section -->
<div class="bg-secondary-subtle py-5">
    <div class="container">
        <h2 class="text-center mb-5">Our Pricing</h2>

        <div class="d-grid gap-4" style="grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));">
            <!-- Per Kilo Pricing -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-success text-white">
                    <h3 class="h5 mb-0">Price Per Kilo</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Service Type</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tarifPerKilo as $tarif)
                                <tr>
                                    <td>{{ $tarif->jenisLaundry->nama_jenis }}</td>
                                    <td>Rp {{ number_format($tarif->tarif, 0, ',', '.') }}/{{ $tarif->satuan }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Per Item Pricing -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-success text-white">
                    <h3 class="h5 mb-0">Price Per Item</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Item Type</th>
                                    <th>Service</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tarifSatuan as $tarif)
                                <tr>
                                    <td>{{ $tarif->nama_pakaian }}</td>
                                    <td>{{ $tarif->jenisLaundry->nama_jenis }}</td>
                                    <td>Rp {{ number_format($tarif->tarif, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Additional Services -->
<div class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Additional Services</h2>
        <div class="row g-4">
            @foreach($layananTambahan as $layanan)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm" data-aos="fade-up">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-success p-2 text-white me-3 w-10 h-10">
                                <i class="bi bi-plus-lg"></i>
                            </div>
                            <h3 class="card-title h5 mb-0">{{ $layanan->nama_layanan }}</h3>
                        </div>
                        <p class="card-text text-muted">{{ $layanan->deskripsi }}</p>
                        <p class="card-text">
                            <span class="badge bg-success">
                                Rp {{ number_format($layanan->harga, 0, ',', '.') }}/{{ $layanan->satuan }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Membership Benefits -->
<div class="py-5">
    <div class="container">
        <div class="mt-2 pt-8 border-top">
            <div class="row align-items-center">
                <div class="col-12 col-lg-6" data-aos="fade-right" data-aos-duration="1000">
                    <div class="pe-lg-5">
                        <h3 class="text-success-emphasis fs-5 fw-semibold mb-3">
                            Become a Member
                        </h3>
                        <h4 class="display-6 fw-bold mb-4">
                            Join Our Exclusive Membership Program
                        </h4>
                        <p class="text-body-secondary mb-4">
                            Enjoy premium benefits and enhanced laundry services with our lifetime membership for only Rp 100.000. Get access to exclusive features and special perks!
                        </p>
                        
                        <div class="row g-4 mb-4">
                            <div class="col-12 col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-success p-2 me-3">
                                        <i class="bi bi-search text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-semibold mb-1">Order Tracking</h5>
                                        <p class="text-body-secondary small mb-0">Track your laundry status in real-time</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-success p-2 me-3">
                                        <i class="bi bi-clock-history text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-semibold mb-1">Order History</h5>
                                        <p class="text-body-secondary small mb-0">View all your past laundry orders</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-success p-2 me-3">
                                        <i class="bi bi-ticket-perforated text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-semibold mb-1">Special Vouchers</h5>
                                        <p class="text-body-secondary small mb-0">Exclusive discounts and promotions</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-success p-2 me-3">
                                        <i class="bi bi-person-check text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-semibold mb-1">Priority Service</h5>
                                        <p class="text-body-secondary small mb-0">Get prioritized order processing</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @guest
                            <div class="d-flex gap-3">
                                <button type="button" class="btn btn-success text-white" data-bs-toggle="modal" data-bs-target="#registerInfoModal">
                                    Register Now
                                </button>
                                <a href="{{ route('member.login') }}" class="btn btn-outline-secondary text-white">
                                    Member Login
                                </a>
                            </div>
                        @endguest
                    </div>
                </div>

                <div class="col-12 col-lg-6 mt-5 mt-lg-0" data-aos="fade-left" data-aos-duration="1000">
                    <div class="position-relative">
                        <div class="ratio ratio-16x9">
                            <img src="{{ asset('assets-2/img/bg/bg10.jpg') }}" class="rounded-4 object-fit-cover" alt="Membership Benefits">
                        </div>
                        <div class="position-absolute bottom-0 end-0 bg-success text-white p-4 rounded-start-4 mb-4">
                            <h4 class="fw-bold mb-2">Rp 100.000</h4>
                            <p class="mb-0">Lifetime Membership</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Register Modal -->
<div class="modal fade" id="registerInfoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title text-success">Register Member Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="mb-4">
                    <i class="bi bi-info-circle-fill text-success" style="font-size: 3rem;"></i>
                </div>
                <h5 class="fw-bold mb-3">Want to become a member?</h5>
                <p class="text-muted mb-4">
                    Please visit our laundry location to register as a member. Our staff will assist you in creating your member account.
                </p>
                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Close</button>
                    <a href="{{ route('landing') }}#review-form" class="btn btn-success text-white">Find Our Location</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection