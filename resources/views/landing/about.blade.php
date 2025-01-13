@extends('landing.layout.master')

@section('title', 'About WashUP Laundry')

@section('content')
<!-- Hero Section -->
<div class="position-relative overflow-hidden bg-secondary-subtle">
    <div class="container py-5 py-md-7">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right" data-aos-duration="1000">
                <h1 class="display-4 fw-bold mb-4">We Care About Your Clothes As Much As You Do</h1>
                <p class="lead mb-4">WashUP Laundry has been providing premium laundry services since 2020. We combine modern technology with exceptional customer service to deliver the best laundry experience.</p>
            </div>
            <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1000">
                <img src="{{ asset('assets-2/img/bg/bg2.jpg') }}" alt="WashUP Laundry Store" class="img-fluid rounded-4 shadow">
            </div>
        </div>
    </div>
    <div class="position-absolute bottom-0 start-0 w-100 bg-secondary" style="height: 4rem; clip-path: ellipse(70% 100% at 50% 100%);"></div>
</div>

<!-- Our Story Section -->
<div class="container py-5">
    <div class="row align-items-center gy-4">
        <div class="col-lg-6" data-aos="fade-up" data-aos-duration="1000">
            <img src="{{ asset('assets-2/img/bg/bg9.jpg') }}" alt="Our Story" class="img-fluid rounded-4 shadow">
        </div>
        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">
            <h2 class="display-6 fw-bold mb-4">Our Story</h2>
            <p class="text-body-success mb-4">Starting from a small family business, WashUP Laundry has grown to become one of the most trusted laundry services in the city. We understand that each garment tells a story, and we're here to help preserve those stories while keeping your clothes fresh and clean.</p>
            <div class="row g-4">
                <div class="col-6">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill text-success fs-4 me-2"></i>
                        <span class="fw-medium">Professional Staff</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill text-success fs-4 me-2"></i>
                        <span class="fw-medium">Eco-Friendly</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill text-success fs-4 me-2"></i>
                        <span class="fw-medium">Fast Service</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill text-success fs-4 me-2"></i>
                        <span class="fw-medium">Quality Guaranteed</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Section -->
<div class="bg-secondary-subtle py-5">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-sm-6 col-lg-3" data-aos="fade-up" data-aos-duration="1000">
                <div class="bg-white p-4 rounded-4 shadow-sm">
                    <h3 class="display-6 fw-bold text-success mb-2">3+</h3>
                    <p class="text-body-secondary mb-0">Years Experience</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                <div class="bg-white p-4 rounded-4 shadow-sm">
                    <h3 class="display-6 fw-bold text-success mb-2">5K+</h3>
                    <p class="text-body-secondary mb-0">Happy Customers</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                <div class="bg-white p-4 rounded-4 shadow-sm">
                    <h3 class="display-6 fw-bold text-success mb-2">15K+</h3>
                    <p class="text-body-secondary mb-0">Orders Completed</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                <div class="bg-white p-4 rounded-4 shadow-sm">
                    <h3 class="display-6 fw-bold text-success mb-2">4.9</h3>
                    <p class="text-body-secondary mb-0">Average Rating</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Values Section -->
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="display-6 fw-bold mb-3">Our Values</h2>
        <p class="text-body-secondary">The principles that guide us in delivering excellence</p>
    </div>
    <div class="row g-4">
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-duration="1000">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="rounded-circle bg-success bg-opacity-10 p-3 d-inline-block mb-3">
                        <i class="bi bi-heart-fill text-success fs-4"></i>
                    </div>
                    <h4 class="fw-semibold mb-2">Care</h4>
                    <p class="text-body-secondary mb-0">We treat every garment with utmost care and attention to detail</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="rounded-circle bg-success bg-opacity-10 p-3 d-inline-block mb-3">
                        <i class="bi bi-star-fill text-success fs-4"></i>
                    </div>
                    <h4 class="fw-semibold mb-2">Quality</h4>
                    <p class="text-body-secondary mb-0">We maintain high standards in every aspect of our service</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="rounded-circle bg-success bg-opacity-10 p-3 d-inline-block mb-3">
                        <i class="bi bi-clock-fill text-success fs-4"></i>
                    </div>
                    <h4 class="fw-semibold mb-2">Punctuality</h4>
                    <p class="text-body-secondary mb-0">We respect your time and deliver as promised</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="rounded-circle bg-success bg-opacity-10 p-3 d-inline-block mb-3">
                        <i class="bi bi-recycle text-success fs-4"></i>
                    </div>
                    <h4 class="fw-semibold mb-2">Sustainability</h4>
                    <p class="text-body-secondary mb-0">We use eco-friendly practices and products</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Team Section -->
<div class="bg-secondary-subtle py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-6 fw-bold mb-3">Our Team</h2>
            <p class="text-body-secondary">Meet the people who make the magic happen</p>
        </div>
        <div class="row g-4">
            @foreach($karyawans as $karyawan)
                <div class="col-sm-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-duration="1000">
                    <div class="card border-0 text-center">
                        <img src="{{ asset('uploads/karyawan/' . $karyawan->foto_karyawan) }}" class="card-img-top rounded-3" alt="{{ $karyawan->nama_karyawan }}">
                        <div class="card-body">
                            <h5 class="fw-bold mb-1">{{ $karyawan->nama_karyawan }}</h5>
                            <p class="text-body-secondary text-capitalize">{{ $karyawan->status_karyawan }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Call to Action -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 text-center">
            <h2 class="display-6 fw-bold mb-4">Ready to Experience Premium Laundry Service?</h2>
            <p class="lead text-body-secondary mb-4">Join thousands of satisfied customers who trust WashUP Laundry with their clothes</p>
            <a href="https://wa.me/81313264584?text=Hello%20WashUP%20Laundry%2C%20I%20would%20like%20to%20know%20more%20about%20your%20services." class="btn btn-success text-white" target="_blank">Contact Us Today</a>
        </div>
    </div>
</div>
@endsection